<?php
if (!class_exists('WPPostsRateKeys_Validator')) {
	class WPPostsRateKeys_Validator
	{
		/**
		 * Parse a data to be shown in templates
		 *
		 * @static 
		 * @param 	string 	$string	text to be parsed
		 * @return 	string
		 * @access 	public
		 */
		static function parse_output($string) {
			$string = trim($string);
			
			if (is_string($string)) {
	    		return stripcslashes($string);
			}
			elseif (is_array($string)) {
				self::parse_array_output($string);
			}
			else {
				return $string;
			}
	    }
	    
		/**
		 * Parse an array of data to be shown in templates
		 *
		 * @static 
		 * @param array $array with text to be parsed
		 * @return string
		 * @access public
		 */
		static function parse_array_output($array) {
			// TODO invest, if ( get_magic_quotes_gpc() )
	    	return stripslashes_deep($array);
	    }
	    
	/**
		 * Parse a string and return a safe value
		 *
		 * @static 
		 * @param string $string text to be parsed
		 * @return string
		 * @access public
		 */
		static function parse_string($string) {
	    	return esc_html(trim($string));
	    }
	
		/**
		 * Parse an integer and return a safe value
		 *
		 * @static 
		 * @param 	int 	$int 			integer to be parsed
		 * @param 	bool 	$must_positive 	if TRUE, ensures that the result is nonnegative
		 * @return 	int
		 * @access 	public
		 */
		static function parse_int($int, $must_positive=FALSE) {
			if ($int=='')
				return '';
			
			preg_match('{(\d+)}', $int, $m);
			$first_number = $m[1];
			
			if ($must_positive)
	    		return abs(intval($first_number));
	    	else
	    		return intval($first_number);
	    }
	}
}