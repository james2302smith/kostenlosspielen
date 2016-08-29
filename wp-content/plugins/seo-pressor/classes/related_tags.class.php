<?php
/**
 * Manage all functions for Related Tags feature
 * and the Settings per Post to get suggested Tags from third services
 * 
 * ====== Per POST Settings =======
 * 
 * Supported Service:
 * - Yahoo
 * 
 * ====== Global Settings ======= 
 * 
 * This is done in depends on the settings selected for the Related Tags feature
 * in the Tags tab on Settings:
 * 
 * enable_tagging_using_google
 * max_number_tags
 * append_tags
 * to_retrieve_keywords_use_post_title
 * to_retrieve_keywords_use_post_content
 * blacklisted_tags
 * generic_tags
 * 
 */
if (!class_exists('WPPostsRateKeys_RelatedTags'))
{
	class WPPostsRateKeys_RelatedTags
	{
		/**
		 * Get Tags from Yahoo service
		 * 
		 * Using: http://developer.yahoo.com/search/content/V1/termExtraction.html
		 * 
		 * @param 	int		$post_id
		 * @param 	string	$content
		 * 
		 * @return 	array	Each element is a suggested Tag	
		 */
		static private function get_tags_from_yahoo($post_id,$content) {
			// Get data
			$content = stripslashes($content);
			$content = trim($content);
			
			if ( empty($content) ) {
				return array();
			}
			else {
				//$param = 'appid=6_D_hJjV34HZKlSaTOWWZwH3D2IIpQUby.U1N5NGu.IH1XpxBvFWRIoHGppQm_C00KI-'; // Yahoo ID
				$param = 'format=json'; // Get PHP Array !
				$param .= '&q=' . urlencode("select * from contentanalysis.analyze where text='$content'"); // Get PHP Array !
				
                                $data = array();
				$reponse = wp_remote_get( 'http://query.yahooapis.com/v1/public/yql?' . $param);
				
                                if( !is_wp_error($reponse) && $reponse != null ) {
					if ( wp_remote_retrieve_response_code($reponse) == 200 ) {
						$data =  json_decode(wp_remote_retrieve_body($reponse));
					}
				}
				
				if ( empty($data) || is_wp_error($data) || is_null($data->query->results) ) {
					return array();
				}
				
				// Remove Tags already added in POST
				$post_tags = wp_get_post_tags($post_id,array('fields'=>'names'));
				
				$to_return = array();
				foreach($data->query->results->yctCategories->yctCategory as $term) {
					$term = trim($term->content);
					if ($term!='' && !in_array($term, $post_tags)) {
						$to_return[] = $term;
					}
				}
				
				return $to_return;
			}
		}
		
		/**
		 * Get from service the Suggested Tags
		 * 
		 * @param 	string	$content
		 * @param 	string	$service_id		Can be: yahoo
		 * 
		 * @return 	array	Each element is a suggested Tag	
		 */
		static function get_suggested_tags($post_id,$content,$service_id) {
			if ($service_id=='yahoo') {
				return self::get_tags_from_yahoo($post_id,$content);
			}
			else {
				return array();
			}
		}
		
		/**
		 * Add tags based on how the visitor find the site
		 * 
		 * SEOPressor will process the Google Search query that brings the 
		 * user to a Post page and will save the search terms per Post as Tags
		 * 
		 * Per search will be added up to the amount of tags defined in Settings.
		 * No problem with duplications because WP function will manage it.
		 * 
		 * @param 	int		$post_id
		 */
		static function add_tags_based_on_google_search($post_id) {
			
			$page_referer_url = wp_get_referer();
			
			//$page_referer_url = 'google.com?q=term1%20term2%20term3%20term2other&frfr=';// This is a test line
			if(strpos($page_referer_url,"google")!==FALSE) {
			
				// Check first if the Setting is checked by user
				$settings = WPPostsRateKeys_Settings::get_options();
				
				if ($settings['enable_tagging_using_google']=='1') {
					// Check for current amount of tags
					if($settings['append_tags']=='1') {
						$current_amount = count(wp_get_post_tags($post_id));
					}
					else {
						// If the option is replace, the current total is 0
						$current_amount = 0;
					}
					$max_number_tags_to_be_added = $settings['max_number_tags'];
					
					// Only proceed if there is some pending Tag to be added
					if ($current_amount<$max_number_tags_to_be_added) {
						$terms_start = strpos($page_referer_url,"q=");
						$terms_end = strpos($page_referer_url,"&",$terms_start);
						if($terms_start && $terms_end) {
							$terms_text= substr($page_referer_url,$terms_start+2,($terms_end-$terms_start-2));
							$terms_text= urldecode($terms_text);
							$terms_text_arr_all = explode(' ', $terms_text);
							
							// Remove the tags that are in black list
							$terms_text_arr = array();
							foreach ($terms_text_arr_all as $terms_text_arr_all_item) {
								if (!self::is_in_blacklist($terms_text_arr_all_item)) {
									$terms_text_arr[] = $terms_text_arr_all_item;
								}
							}
							
							// Only the max number selected by User and Up to the max number
							$max_number_tags_to_be_added_diff = $max_number_tags_to_be_added-$current_amount;
							
							if(count($terms_text_arr)>$max_number_tags_to_be_added_diff) {
								$terms_text_arr = array_rand(array_flip($terms_text_arr),$max_number_tags_to_be_added_diff);
							}
							
							if (!is_array($terms_text_arr)) {
								$terms_text_arr = array($terms_text_arr);
							}
							
							$terms_text_for_tags = implode(',', $terms_text_arr);
							
							if($settings['append_tags']=='1') {
								wp_set_post_tags($post_id,$terms_text_for_tags,true);
							}
							else {
								wp_set_post_tags($post_id,$terms_text_for_tags,false);
							}
						}
					}
				}
			}
		}
		
		/**
		 * Generate and process the tags of the Post
		 * 
		 * Get Related Tags for the new Content, IF some of the relevant data changes
         * in depends on the Settings that specify which data must be taken in care
		 * 
		 * @param 	int		$post_id
		 * @param 	string	$filtered_title
		 * @param 	string	$previous_title
		 */
		static function process_tags_for_post($post_id,$new_title,$previous_title,$previous_content) {
			
			$settings = WPPostsRateKeys_Settings::get_options();
			
			// The part where tags are get from Google
			if ($settings['enable_tagging_using_google']=='1') {
			
				// Check for current amount of tags
				if($settings['append_tags']=='1') {
					$current_tags = wp_get_post_tags($post_id, array( 'fields' => 'names' ));
					$current_amount = count($current_tags);
				}
				else {
					// If the option is replace, the current total is 0
					$current_amount = 0;
				}
				$max_number_tags_to_be_added = $settings['max_number_tags'];
				// Only the max number selected by User and Up to the max number
				$max_number_tags_to_be_added_diff = $max_number_tags_to_be_added-$current_amount;
				
				// Check if with the Generic Tag there is no need for request more
				$generic_tags = explode(',', $settings['generic_tags']);
				// Remove the tags already there if we are Append
				if($settings['append_tags']=='1') {
					$generic_tags_new = array();
					foreach ($generic_tags as $generic_tags_item) {
						if (!in_array(trim($generic_tags_item), $current_tags)) {
							$generic_tags_new[] = trim($generic_tags_item);
						}
					}
					$generic_tags = $generic_tags_new;
				}
				
				if (count($generic_tags)>=$max_number_tags_to_be_added_diff) {
					$tags_to_add = array_slice($generic_tags, 0, $max_number_tags_to_be_added_diff);
				}
				else {
					$tags_to_add = $generic_tags;
				}
			
				// Pending Diff taking ni care generic tags
				$pending_max_number_tags_to_be_added_diff = $max_number_tags_to_be_added_diff - count($tags_to_add);
					
				// Take in care the number of tags to Add to avoid made requets more than required
				// Only proceed if there is some pending Tag to be added
				if ($pending_max_number_tags_to_be_added_diff>0) {
				
					/*
					 * Determine if we should proceed with the action of get the tags
					 * - At least shoul be selected the title of content
					 * - In depends on what was selected, should be a variation
					 * between old and new value
					 */
					$proceed = FALSE;
					if($settings['to_retrieve_keywords_use_post_title']=='1') {
						if ($previous_title!=$new_title) {
							$proceed = TRUE;
						}
					}
					
					if($settings['to_retrieve_keywords_use_post_content']=='1') {
						
						// Get filtered content, after the filter is applied
						$data_arr = WPPostsRateKeys_WPPosts::get_wp_post_title_content($post_id);
						$new_content = $data_arr[1];
							
						// Compare after we remove Html that aren't used for get the tags
						$previous_content = strip_tags($previous_content);
						$new_content = strip_tags($new_content);
						
						if ($previous_content!=$new_content) {
							$proceed = TRUE;
						}
					}
					
					if ($proceed) {
						$content = '';
						if($settings['to_retrieve_keywords_use_post_title']=='1') {
							$content .= $new_title;
						}
						$content .= ' ';
						if($settings['to_retrieve_keywords_use_post_content']=='1') {
							$content .= $new_content;
						}
						
						if (trim($content)!='') {
							
							// Get new keywords
							$keywords = self::get_keywords($post_id,$content,$settings,$pending_max_number_tags_to_be_added_diff);
							
							// Ignore Words to omit from $keywords
							$keywords_without_words_to_omit = array();
							$words_to_omit = WPPostsRateKeys_Settings::get_slugs_stop_words();
							foreach ($keywords as $keywords_item) {
								if (!in_array($keywords_item, $words_to_omit)) {
									$keywords_without_words_to_omit[] = $keywords_item;
								}
							}
							
							// Joing new tags with already defined
							$tags_to_add = array_merge($tags_to_add, $keywords_without_words_to_omit);
						}
					}
				}
				
				if(count($tags_to_add)>$max_number_tags_to_be_added_diff && $max_number_tags_to_be_added_diff>=1) {
					$tags_to_add = array_rand(array_flip($tags_to_add),$max_number_tags_to_be_added_diff);
				}
				$tags_to_add = implode(',', $tags_to_add);
				
				if($settings['append_tags']=='1') {
					wp_set_post_tags($post_id,$tags_to_add,true);
				}
				else {
					// Only "reset" the tags if $proceed isn't False: 
					// because if is False is because the values doesn't change, so no need of update tags
					if (!isset($proceed) || $proceed==TRUE) {
						wp_set_post_tags($post_id,$tags_to_add,false);
					}
					else {
						// Add but no replace, add only the pending to add up to max amount
						$current_tags = wp_get_post_tags($post_id, array( 'fields' => 'names' ));
						$current_amount = count($current_tags);
						$tmp_to_be_appened = $max_number_tags_to_be_added - $current_amount;
						
						if ($tmp_to_be_appened<$tags_to_add) {
							// Remove
							$tags_to_add = array_slice($tags_to_add, 0, $tmp_to_be_appened);
						}
						
						wp_set_post_tags($post_id,$tags_to_add,true);
					}
				}	
			}
		}
		
		/**
		 * Get the Keywords using Yahoo service and Google Suggestions
		 * 
		 * @param 	int		$post_id
		 * @param 	string	$content
		 * 
		 * @return	array
		 */
		private static function get_keywords($post_id,$content,$settings,$max_number_tags_to_be_added_diff) {
			return self::googlesuggest(self::get_tags_from_yahoo($post_id,$content),$settings,$max_number_tags_to_be_added_diff);
		}
		
		/**
		 * Get Google Suggests for the Keywords
		 * 
		 * @param 	array $keywords		Keywords found in the title/content using Yahoo service
		 * @param 	array $settings
		 * @return 	array
		 */
		static function googlesuggest($keywords,$settings,$max_number_tags_to_be_added_diff) {
			
			$new_keywords = array();
			
			foreach($keywords as $keyword) {
				$url = 'http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl=en&q=' . urlencode($keyword);
				$data = self::request_get($url);
				$words_arr = array();
				if ($data) {
					$data = json_decode($data, true);
					$words_arr = $data[1];
				}
				foreach($words_arr as $words_arr_item) {
					if (!self::is_in_blacklist($words_arr_item)) {
						$new_keywords[]= $words_arr_item;
						
						if (count($new_keywords)>=$max_number_tags_to_be_added_diff) {
							// Don't proceed and return values
							return $new_keywords;
						}
					}
				}
			}
		
			if(count($new_keywords)>0) {
				return $new_keywords;
			}
			else {
				// If no new was found, returns Keywords
				return $keywords;
			}
		}
		
		/**
		 * Get Remote Content from Url
		 * 
		 * @param string $url
		 */
		static function request_get($url) {
			$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'; 
			$headers[] = 'Connection: Keep-Alive'; 
			$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8'; 
			$user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
			$referer = 'http://domain/'.rand(1,100000);
			
			$process = curl_init($url); 
			curl_setopt($process, CURLOPT_HTTPHEADER, $headers); 
			curl_setopt($process, CURLOPT_HEADER, 0); 
			curl_setopt($process, CURLOPT_USERAGENT, $user_agent); 
			curl_setopt($process, CURLOPT_ENCODING , 'gzip'); 
			curl_setopt($process, CURLOPT_TIMEOUT, 30);  
			curl_setopt($process, CURLOPT_RETURNTRANSFER, 1); 
			@curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
			
			curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
			
			$return = curl_exec($process);

			// Check for possible errors
			if ($return === false) {
				WPPostsRateKeys_Logs::add_error('381',"request_get Error: " 
										. curl_error($process) . ', Url: ' . $url);
			}
			
			curl_close($process); 
			return $return;
		}
		
		/**
		 * Check if a Tag is in the black list
		 * 
		 * Will return true when:
		 * - the tag is a blank listed tag
		 * - the tag has a word that is backlisted
		 * Example:
		 * - $a = 'some textual content';
		 * - $b = 'some text inside';
		 * - $c = 'text';
		 * 
		 * If $c is the tag in black list, the tag $a will be added, but $b will not.
		 * 
		 * @param string $tag
		 */
		static function is_in_blacklist($tag) {
			$settings = WPPostsRateKeys_Settings::get_options();
			$blacklist = explode(",",$settings['blacklisted_tags']);
			
			$tag = trim($tag);
			
			if (is_array($blacklist) && !empty($blacklist)) {
				foreach($blacklist as $black) {
					$black = trim($black);
					if ($black !='') {
						// Search if $black is inside $tag, used the same function that determines keywords in content
						
						if (WPPostsRateKeys_Settings::support_multibyte()) {
							$black = mb_strtolower($black,'UTF-8');
							$tag = mb_strtolower($tag,'UTF-8');
						}
						else {
							$black = strtolower($black);
							$tag = strtolower($tag);
						}						
						
						if ($black==$tag 
								|| WPPostsRateKeys_Keywords::keyword_in_content(array($black), $tag)) {
							return TRUE;
						}
					}
				}
			}
			
			return false;
		}
	}
}