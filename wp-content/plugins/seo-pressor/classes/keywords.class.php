<?php
if (!class_exists('WPPostsRateKeys_Keywords')) {
	class WPPostsRateKeys_Keywords
	{
		/**
		 * If used to prepare Keyword to be used in regular expressions 
		 * 
		 * This is usefull when for example: the keyword "somekey" must match with:
		 * - "somekey"
		 * - "some(key)"
		 * - etc, with all the characters user select to ignore in Settings
		 * 
		 * @param 	string $keyword
		 * @return 	string
		 */
		static function prepare_for_regexp($keyword) {
			$settings = WPPostsRateKeys_Settings::get_options();
			if ($settings['enable_special_characters_to_omit']!=='1') {
				return str_replace('/', '\/', preg_quote($keyword));
			}
			
			// Get all characters to ignore
			$chars_list = WPPostsRateKeys_Settings::get_special_characters_to_omit();
			if (count($chars_list)==0) {
				return str_replace('/', '\/', preg_quote($keyword));
			}
			
			// Obtain the common expression for characters to omit
			$str_chars_to_omit_arr = array();
			foreach ($chars_list as $char) {
				if ($char!='') { // If isn't empty
					// add slashes to special symbols that would interfere with a regular expression (i.e., . \ + * ? [ ^ ] $ ( ) { } = ! < > | :)
					$str_chars_to_omit_arr[] = preg_quote($char);
				}
			}
			
			if (count($str_chars_to_omit_arr)==0) {
				return $keyword;
			}
			
			$str_chars_to_omit = implode('|', $str_chars_to_omit_arr);
			
			// Get each keyword letter
			
			$keyword_arr = array();
			
			if (WPPostsRateKeys_Settings::support_multibyte()) {
				$keyword = utf8_decode($keyword);
				for ($i=0;$i<mb_strlen($keyword,'UTF-8');$i++) {
					$keyword_arr[] = $keyword[$i];
				}
			}
			else {
				for ($i=0;$i<strlen($keyword);$i++) {
					$keyword_arr[] = $keyword[$i];
				}
			}
			
			// Per each letter in keyword, add the possibility of presence of characters to omit
			$keyword_exp_arr = array(); // Will be like this: (k|\:)[(\:)]*(e|\:)[(\:)]*(y|\:)
			foreach ($keyword_arr as $keyword_char) {
				if (WPPostsRateKeys_Settings::support_multibyte()) {
					$keyword_char = utf8_encode($keyword_char);
				}
				$keyword_char_quoted = preg_quote($keyword_char);
				$keyword_exp_arr[] = "($keyword_char_quoted|$str_chars_to_omit)";
			}
			$glue = "[($str_chars_to_omit)]*";
			$keyword_exp = implode($glue, $keyword_exp_arr);
			
			// Seems this is needed (?)
			$keyword_exp = str_replace('/', '\/', $keyword_exp);
			
			return $keyword_exp;
		}
		
		/**
		 * Get array of text searated by keyword
		 *
		 * @param 	array	$keyword_arr
		 * @param 	string 	$content
		 * @param 	bool 	$return_matches		True when want the matches returnes, for example when is needed determine how the keyword was found
		 * @return 	array
		 */
		static function get_pieces_by_keyword($keyword_arr, $content, $return_matches=FALSE) {
			// To avoid return an array with one value when the keyword isn't in text
			if (!self::keyword_in_content($keyword_arr, $content))
				return array();
			
			// (?<!\pL) and (?!\pL) for match whole keyword, u for unicode, i for case insensitive
			// No used \b because does not work with UTF8: http://stackoverflow.com/questions/4781898/regex-word-boundary-does-not-work-in-ut8-on-some-servers
			
			// Used for old versions of PCRE // $arr = preg_split('/\b' . $keyword . '\b/iu', $content);
			// Used for some users with content malformed // $content = utf8_encode($content);
			
			$first_keyword = self::prepare_for_regexp($keyword_arr[0]);
			$reg_exp = '/(?<!\pL)' . $first_keyword . '(?!\pL)';
			$keyword_arr_sliced = array_slice($keyword_arr, 1);
			
			foreach ($keyword_arr_sliced as $keyword) {
				// Prepare keyword for Reg Exp
				$keyword = self::prepare_for_regexp($keyword);
				$reg_exp .= '|(?<!\pL)' . $keyword . '(?!\pL)';
			}
			$reg_exp .= '/iu';
			
			// (?<!\pL) and (?!\pL) for match whole keyword, u for unicode, i for case insensitive
			$arr = preg_split($reg_exp, $content);
		    
		    if ($return_matches) {
		    	preg_match_all($reg_exp, $content, $arr_keys);
		    	$arr_keys = $arr_keys[0];
		    	
		    	return array($arr,$arr_keys);
		    }
		    else {
		    	return $arr;
		    }
		}
		
		/**
		 * Check if any keyword in text
		 *
		 * @param 	array $keyword_arr
		 * @param 	string $content
		 * @return 	bool
		 */
		static function keyword_in_content($keyword_arr, $content) {
			
			// Used for some users with content malformed // 
			//$content = utf8_encode($content); 
			// Used for old versions of PCRE //return preg_match('/\b' . $keyword . '\b/iu', $content);
			
			$first_keyword = self::prepare_for_regexp($keyword_arr[0]);
			
			$reg_exp = '/(?<!\pL)' . $first_keyword . '(?!\pL)';
			$keyword_arr_sliced = array_slice($keyword_arr, 1);
			
			foreach ($keyword_arr_sliced as $keyword) {
				
				// Prepare keyword for Reg Exp
			    $keyword = self::prepare_for_regexp($keyword);
			    $reg_exp .= '|(?<!\pL)' . $keyword . '(?!\pL)';
			}
			$reg_exp .= '/iu';
		    
			return preg_match($reg_exp, $content);
		}
		
		/**
		 * Get how many keywords in text
		 *
		 * @param 	array $keyword_arr
		 * @param 	string $content
		 * @return 	bool
		 */
		static function how_many_keywords($keyword_arr, $content) {
			
			// Used for some users with content malformed // $content = utf8_encode($content);
			// Used for old versions of PCRE //$return = preg_match_all('/\b' . $keyword . '\b/iu',$content,$matches); 
			
			$first_keyword = self::prepare_for_regexp($keyword_arr[0]);
			$reg_exp = '/(?<!\pL)' . $first_keyword . '(?!\pL)';
			$keyword_arr_sliced = array_slice($keyword_arr, 1);
			
			foreach ($keyword_arr_sliced as $keyword) {
				// Prepare keyword for Reg Exp
			    $keyword = self::prepare_for_regexp($keyword);
			    $reg_exp .= '|(?<!\pL)' . $keyword . '(?!\pL)';
			}
			$reg_exp .= '/iu';
		    
		    return preg_match_all($reg_exp,$content,$matches);
		}
		
		/**
		 * Delete keywords from content
		 *
		 * @param 	array $keyword_arr
		 * @param 	string $content
		 * @return 	bool
		 */
		static function delete_keywords($keyword_arr, $content) {
			
			// Used for some users with content malformed // $content = utf8_encode($content);
			// Used for old versions of PCRE //$return = preg_match_all('/\b' . $keyword . '\b/iu',$content,$matches); 
			
			$first_keyword = self::prepare_for_regexp($keyword_arr[0]);
			$reg_exp = '/(?<!\pL)' . $first_keyword . '(?!\pL)';
			$keyword_arr_sliced = array_slice($keyword_arr, 1);
			
			foreach ($keyword_arr_sliced as $keyword) {
				// Prepare keyword for Reg Exp
			    $keyword = self::prepare_for_regexp($keyword);
			    $reg_exp .= '|(?<!\pL)' . $keyword . '(?!\pL)';
			}
			$reg_exp .= '/iu';
		    
		    return preg_replace($reg_exp,'',$content);
		}
		
		
        /**
		 *
		 * Find position of Nth occurance of search string
		 *
		 * @param string 	$keyword 					The search string
		 * @param string 	$content 					The string to seach
		 * @param int 		$offset 					The Nth occurance of string
		 * @param array		$pieces_by_keyword			The pieces by keyword
		 * @param array		$pieces_by_keyword_matches	The matches of the keyword
		 *
		 * @return int or false if not found
		 *
		 */
		static function strpos_offset($keyword, $content, $offset, $pieces_by_keyword=array(), $pieces_by_keyword_matches=array())
		{
			if (count($pieces_by_keyword)==0) {
		    	$pieces_by_keyword = self::get_pieces_by_keyword(array($keyword), $content,TRUE);
		    	$pieces_by_keyword_matches = $pieces_by_keyword[1];
		    	$pieces_by_keyword = $pieces_by_keyword[0];
			}
		    
			/*** check the search is not out of bounds ***/
		    switch( $offset )
		    {
		        case $offset == 0:
			        return false;
			        break;
		    
		        case $offset > max(array_keys($pieces_by_keyword)):
			        return false;
			        break;
		
		        default:
		        	if (WPPostsRateKeys_Settings::support_multibyte()) {
		        		$to_return = mb_strlen(implode('', array_slice($pieces_by_keyword, 0, $offset)),'UTF-8');
		        		// Add keywords lenght, taking in care possible special characters
		        		if ($offset>1) {
		        			$to_return += mb_strlen(implode('', array_slice($pieces_by_keyword_matches, 0, $offset-1)),'UTF-8');
		        		}
		        	}
		        	else {
		        		$to_return = strlen(implode('', array_slice($pieces_by_keyword, 0, $offset)));
		        		// Add keywords lenght, taking in care possible special characters
		        		if ($offset>1) {
		        			$to_return += strlen(implode('', array_slice($pieces_by_keyword_matches, 0, $offset-1)));
		        		}
		        	}
		        	return $to_return;
		    }
		}
	}
}