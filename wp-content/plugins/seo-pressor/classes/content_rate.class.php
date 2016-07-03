<?php
if (!class_exists('WPPostsRateKeys_ContentRate')) {
	class WPPostsRateKeys_ContentRate
	{
		/**
		 * Retrieve the list of Suggestions IDs per section
		 * 
		 * The sections are: decoration, url and content
		 * 
		 * @return 	array
		 */
		static function get_suggestions_per_sections() {
			return array(
				'decoration'=>array('msg_101','msg_102','msg_103','msg_104','msg_105','msg_106'
									,'msg_119','msg_120','msg_121','msg_122','msg_123','msg_124'
								)
				,'url'=>array('msg_112', 'msg_113','msg_114','msg_115','msg_130','msg_131','msg_132'
									,'msg_133','msg_134'
								)
				,'content'=>array('msg_107', 'msg_108', 'msg_109', 'msg_110', 'msg_111' 
									, 'msg_116', 'msg_117','msg_118'
									, 'msg_125', 'msg_126', 'msg_127', 'msg_128'
									, 'msg_129', 'msg_135', 'msg_136', 'msg_137'
									, 'msg_149', 'msg_150', 'msg_151', 'msg_152'
								)
			);
		}
		
		/**
		 * Retrieve the list of Suggestions for the Box
		 * 
		 * @return array
		 */
		static function get_suggestions_for_box() {
			return array(
					// Positives
					/* translators: <<N>> and <<(s)>> should be ignored when translate */
					'msg_101' => array(__('You have <<N>> keyword<<(s)>> in bold.','seo-pressor')
									,__('Keywords decorations are important. It tells search engines what your content is all about. Bold your keywords few times but do not overdo it.','seo-pressor')
							)
					, 'msg_102' => array(__('You have <<N>> keyword<<(s)>> in italic.','seo-pressor')
									,__('Keywords decorations are important. It tells search engines what your content is all about. Italize your keywords few times but do not overdo it.','seo-pressor')
							)
					, 'msg_103' => array(__('You have <<N>> keyword<<(s)>> in underline.','seo-pressor')
									,__('Keywords decorations are important. It tells search engines what your content is all about. Underline your keywords few times but do not overdo it.','seo-pressor')
							)
					, 'msg_104' => array(__('You have keyword in <<N>> H1 tag<<(s)>>.','seo-pressor')
									,__('Most themes have H1 tag on the title. If not, always make sure you have a H1 tag in your content. An example is: <h1>Your title here</h1>','seo-pressor')
							)
					, 'msg_105' => array(__('You have keyword in <<N>> H2 tag<<(s)>>.','seo-pressor')
									,__('You should always section your content with sub-headings. An example of the tag in HTML: <h2>Your sub-heading</h2>','seo-pressor')
							)
					, 'msg_106' => array(__('You have keyword in <<N>> H3 tag<<(s)>>.','seo-pressor')
									,__('You should always section your content with sub-headings. An example of the tag in HTML: <h3>Your sub-heading</h3>','seo-pressor')
							)
					, 'msg_107' => array(__('You have keyword in <<N>> image ALT<<(s)>>.','seo-pressor')
									,__("ALT tag describes what an image is about. It's good to have keyword in your image's ALT tag. An example in HTML: " . '"<img src="http://yoursite.com/image.jpg" ALT="YOUR KEYWORD" />"','seo-pressor')
							)
					, 'msg_108' => array(__('You have keyword in first 100 words.','seo-pressor')
									,''
							)
					, 'msg_109' => array(__('You have keyword in last 100 words.','seo-pressor')
									,''
							)
					, 'msg_110' => array(__('You have keyword in the first sentence.','seo-pressor')
									,''
							)
					, 'msg_111' => array(__('You have keyword in the last sentence.','seo-pressor')
									,''
							)
					, 'msg_112' => array(__('Keyword in anchor text of an internal link.','seo-pressor')
									,__('Add a link to your other pages within the same website using your keyword as the anchor text. An example in HTML: <a href="http://yoursite.com/anotherpage/" >YOUR KEYWORD</a>','seo-pressor')
							)
					, 'msg_113' => array(__('Keyword in anchor text of an external link.','seo-pressor')
									,__('Add a link to another reputable source of information with your keyword as the anchor text. An example in HTML: <a href="http://wikipedia.org/relatedtopic">YOUR KEYWORD</a>','seo-pressor')
							)
					, 'msg_114' => array(__('Keyword found in domain name.','seo-pressor')
									,__('Your domain name is found to contain your keyword which is a good boost to your scoring.','seo-pressor')
							)
					, 'msg_115' => array(__('Keyword found in Post/Page URL.','seo-pressor')
									,__('Your main keyword should always appear in the URL of this content.','seo-pressor')
							)
					, 'msg_116' => array(__('<<N>> LSI Keyword<<(s)>> found.','seo-pressor')
									,__('Using more LSI keywords will help you rank better. Click on the LSI tab to see what other words you should include in your content. Include the ones which are most relevant to your content.','seo-pressor')
							)
					, 'msg_117' => array(__('Keyword density is OK.','seo-pressor')
									,__('The best keyword density is between 2% to 4%. There is no rule on this. Having less than 2%, your content will most likely be unfocused. Having it higher than 4% will most probably make your content unreadable. Try to adjust accordingly, focus on pleasing the readers, not the search engine.','seo-pressor')
							)
					
					// Negatives
					, 'msg_118' => array(__('Increase the length of the content.','seo-pressor')
									,__('Longer content tends to rank better. The reason is that longer content is perceived to contain more useful information. Try to increase the length of your content and make sure they are useful to the readers and not fillers.','seo-pressor')
							)
					, 'msg_119' => array(__('You do not have keyword(s) in bold.','seo-pressor')
									,__('Keywords decorations are important. It tells search engines what your content is all about. Bold your keywords few times but do not overdo it.','seo-pressor')
							)
					, 'msg_120' => array(__('You do not have keyword(s) in italic.','seo-pressor')
									,__('Keywords decorations are important. It tells search engines what your content is all about. Italize your keywords few times but do not overdo it.','seo-pressor')
							)
					, 'msg_121' => array(__('You do not have keyword(s) in underline.','seo-pressor')
									,__('Keywords decorations are important. It tells search engines what your content is all about. Underline your keywords few times but do not overdo it.','seo-pressor')
							)
					, 'msg_122' => array(__('You do not have keyword in H1 tag.','seo-pressor')
									,__('Most themes have H1 tag on the title. If not, always make sure you have a H1 tag in your content. An example is: <h1>Your title here</h1>','seo-pressor')
							)
					, 'msg_123' => array(__('You do not have keyword in H2 tag.','seo-pressor')
									,__('You should always section your content with sub-headings. An example of the tag in HTML: <h2>Your sub-heading</h2>','seo-pressor')
							)
					, 'msg_124' => array(__('You do not have keyword in H3 tag.','seo-pressor')
									,__('You should always section your content with sub-headings. An example of the tag in HTML: <h3>Your sub-heading</h3>','seo-pressor')
							)
					, 'msg_125' => array(__('You do not have keyword in Image ALT tag.','seo-pressor')
									,__("ALT tag describes what an image is about. It's good to have keyword in your image's ALT tag. An example in HTML: " . '"<img src="http://yoursite.com/image.jpg" ALT="YOUR KEYWORD" />"','seo-pressor')
							)
					, 'msg_126' => array(__('Keyword not found in first 100 words.','seo-pressor')
									,''
							)
					, 'msg_127' => array(__('Keyword not found in last 100 words.','seo-pressor')
									,''
							)
					, 'msg_128' => array(__('Keyword not found in first sentence.','seo-pressor')
									,''
							)
					, 'msg_129' => array(__('Keyword not found in last sentence.','seo-pressor')
									,''
							)
					, 'msg_130' => array(__('Link pointing to an internal page not found.','seo-pressor')
									,__('Add a link to your other pages within the same website using your keyword as the anchor text. An example in HTML: <a href="http://yoursite.com/anotherpage/" >YOUR KEYWORD</a>','seo-pressor')
							)
					, 'msg_131' => array(__('Keyword not found in anchor text of internal link.','seo-pressor')
									,__('Add a link to your other pages within the same website using your keyword as the anchor text. An example in HTML: <a href="http://yoursite.com/anotherpage/" >YOUR KEYWORD</a>','seo-pressor')
							)
					, 'msg_132' => array(__('Link pointing to an external reputable source not found.','seo-pressor')
									,__('Add a link to another reputable source of information with your keyword as the anchor text. An example in HTML: <a href="http://wikipedia.org/relatedtopic">YOUR KEYWORD</a>','seo-pressor')
							)
					, 'msg_133' => array(__('keyword not found in anchor text of an external link.','seo-pressor')
									,__('Add a link to another reputable source of information with your keyword as the anchor text. An example in HTML: <a href="http://wikipedia.org/relatedtopic">YOUR KEYWORD</a>','seo-pressor')
							)
					, 'msg_134' => array(__('Keyword not found in Post/Page URL.','seo-pressor')
									,__('Your main keyword should always appear in the URL of this content.','seo-pressor')
							)
					, 'msg_135' => array(__('No LSI Keyword used.','seo-pressor')
									,__('Using more LSI keywords will help you rank better. Click on the LSI tab to see what other words you should include in your content. Include the ones which are most relevant to your content.','seo-pressor')
							)
					, 'msg_136' => array(__('Keyword density is high.','seo-pressor')
									,__('The best keyword density is between 2% to 4%. There is no rule on this. Having less than 2%, your content will most likely be unfocused. Having it higher than 4% will most probably make your content unreadable. Try to adjust accordingly, focus on pleasing the readers, not the search engine.','seo-pressor')
							)
					, 'msg_137' => array(__('Keyword density is too low.','seo-pressor')
									,__('The best keyword density is between 2% to 4%. There is no rule on this. Having less than 2%, your content will most likely be unfocused. Having it higher than 4% will most probably make your content unreadable. Try to adjust accordingly, focus on pleasing the readers, not the search engine.','seo-pressor')
							)
					
					// Related to meta values
					, 'msg_149' => array(__('Keyword is found in META Keyword.','seo-pressor')
									,''
							)
					, 'msg_150' => array(__('Keyword is found in META description.','seo-pressor')
									,''
							)
					, 'msg_151' => array(__('You need to have Keyword in Meta Keywords.','seo-pressor')
									,''
							)
					, 'msg_152' => array(__('You need to have Keywords in META Description.','seo-pressor')
									,''
							)
					
					// If not 100%, suggest: Get your 100% easily:
					, 'msg_138' => __('Use more LSI keywords.','seo-pressor')
					, 'msg_139' => __('Add more images with ALT tag.','seo-pressor')
					, 'msg_140' => __('Section your content using more headings.','seo-pressor')
					, 'msg_141' => __('Longer content ranks better.','seo-pressor')
					, 'msg_153' => __('You can target up to 3 keywords per content.','seo-pressor')
					
					// If more than 100%, suggest:
					, 'msg_142' => __('Your score may be too high, try to reduce to 100% by adjusting decorated keywords, keyword density and LSIs or increase your content length.','seo-pressor')
					
					// Over-Optimization Warning:
					, 'msg_143' => __('You are safe. No over-optimization is detected.','seo-pressor')
					, 'msg_144' => __('Keywords are bolded too many times.','seo-pressor')
					, 'msg_145' => __('Keywords are italized too many times.','seo-pressor')
					, 'msg_146' => __('Keywords are underlined too many times.','seo-pressor')
					, 'msg_147' => __('Keyword density is too high. Try replace some of your keywords with LSI keywords.','seo-pressor')
					, 'msg_148' => __('Too many LSI keywords are used.','seo-pressor')

					, 'msg_154' => __('Too many H1 tags contain your keyword.','seo-pressor')
					, 'msg_155' => __('Too many H2 tags contain your keyword.','seo-pressor')
					, 'msg_156' => __('Too many H3 tags contain your keyword.','seo-pressor')
					, 'msg_157' => __('Keyword appear in image ALTs too many times.','seo-pressor')
					, 'msg_158' => __('Keywords are used too many times as anchor text in links.','seo-pressor')
				);
		}
		
		
		static function get_post_whole_page_to_analyze($post_id,$settings,$post_permalink) {
			// For drafts (or pending) we return False to analyze only the Post Content
			if ($post_id!='' && $settings['analize_full_page']=='1') {
				
				// Add "internal_call" parameter to avoid recursive call
				if (substr_count($post_permalink, '?')>0) {
					$post_permalink .= '&internal_call=true';
				}
				else {
					$post_permalink .= '?internal_call=true';
				}
				
				if (get_post_status($post_id) == 'publish') {
					$response = wp_remote_get($post_permalink,array('timeout'=>WPPostsRateKeys::$timeout));
					if (!is_wp_error($response)) { // Else, was an object(WP_Error) and the Post Content is used
						$whole_post_page = $response['body'];
							
						return $whole_post_page;
					}
					else {
						$error_msg = $response->get_error_message($response->get_error_code());
						WPPostsRateKeys_Logs::add_error('391',"get_post_whole_page_to_analyze Published, error: " . $error_msg);
					}
				}
				else {
					$preview_link = set_url_scheme( $post_permalink );
					$preview_link = esc_url( apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', $preview_link ) ) );
					$cookies      = array();
					
					foreach ( $_COOKIE as $name => $value ) {
						$cookies[] = new WP_Http_Cookie( array( 'name' => $name, 'value' => $value ) );
					}
					
					$response = wp_remote_get( $preview_link, array( 'cookies' => $cookies ) );
					if (!is_wp_error($response)) { // Else, was an object(WP_Error) and the Post Content is used
						$body    = wp_remote_retrieve_body( $response );
						return $body;
					}
					else {
						$error_msg = $response->get_error_message($response->get_error_code());
						WPPostsRateKeys_Logs::add_error('392',"get_post_whole_page_to_analyze Preview, error: " . $error_msg);
					}
				}
			}
			
			return FALSE;
		}
		
        /**
         * Function to the get all the POST data
         * 
         * This return:
         *  the Scrore in percet
         *  the Suggestions for the page 
         *  and the Suggestion box data 
         * 
         * @param	int		$post_id
         * @param	array	$keyword_arr
         * @param	string	$content_to_analize			is the whole page content or the filtered content
         * @param	string	$filtered_title
         * @param	array	$settings
         * @param	string	$from_url
         * @param	string	$post_content_filtered		Only Post Content to Edit: used for first and last sentence detection
         * @return 	array
         * @static 
         */
        static function get_all_post_data($post_id,$keyword_arr,$new_content,$filtered_title
        									,$settings,$from_url,$post_content_filtered) {
        	
        	$total_score = 0;
        	$box_suggestions = array('box_keyword_density'=>0,'box_suggestions_arr'=>array());
        	$special_suggestions_arr = array();
        	$box_suggestions_arr = array();
        	$keyword_density_pointer = 0;
        	
        	if ($keyword_arr[0]!='') { // Only checks if is some keyword defined
        		/*
        		 * Processing/Preparing Post Content
        		 * 
        		 * For example, when the Content is getted from Url, the WP returns the ' characters
        		 * as &#039; or &#8217;
        		 */
        		$new_content = str_replace('&#039;', "'", $new_content);
        		$new_content = str_replace('&#8217;', "'", $new_content);
        		// Removing Html
        		if (WPPostsRateKeys_Settings::support_multibyte()) {
        			
        			// Avoid problem of converting &lt; into <, Part 1
        			$new_content = str_replace('&lt;', 'A&A-*lAtA;', $new_content);
        			$post_content_filtered = str_replace('&lt;', 'A&A-*lAtA;', $post_content_filtered);
        			
        			// Convert html entities
        			$new_content = html_entity_decode($new_content,ENT_COMPAT,"UTF-8");
        			$post_content_filtered = html_entity_decode($post_content_filtered,ENT_COMPAT,"UTF-8");
        			
        			// Avoid problem of converting &lt; into <, Part 2
        			$new_content = str_replace( 'A&A-*lAtA;','&lt;', $new_content);
        			$post_content_filtered = str_replace('A&A-*lAtA;','&lt;',  $post_content_filtered);
        		}
        		
        		$settings_options = WPPostsRateKeys_Settings::get_options();
        		$post_all_meta = get_post_meta($post_id);
        		$post_url = WPPostsRateKeys_WPPosts::get_permalink($post_id);
        		
        		$lsi_keywords = array();
        		foreach ($keyword_arr as $keyword_arr_item) {
        			$lsi_keywords = array_merge($lsi_keywords, WPPostsRateKeys_LSI::get_lsi_by_keyword($keyword_arr_item));
        		}
        		
        		$post_tags = wp_get_post_tags($post_id, array( 'fields' => 'names' ));
        		$post_categories = wp_get_post_categories($post_id, array( 'fields' => 'names' ));
        		$wp_url = get_bloginfo('wpurl');
        		
        		// Call Central Server
	        	$request_params = compact('keyword_arr','new_content'
	        					,'filtered_title','settings_options'
	        					,'post_content_filtered','from_url'
	        					,'post_all_meta','post_url'
	        					,'lsi_keywords','post_tags'
	        					,'post_categories','post_id'
	        					,'wp_url');
	        	
	        	$response_params = WPPostsRateKeys_Central::get_data($request_params);
	        	extract($response_params);
	        	
	        	$special_suggestions_arr['score_less_than_100'] = $suggestions_score_less_than_100;
	        	$special_suggestions_arr['score_more_than_100'] = $suggestions_score_more_than_100;
	        	$special_suggestions_arr['score_over_optimization'] = array($over_optimization_flag,$suggestions_score_over_optimization);
        	}
        	
        	$box_suggestions = array('box_keyword_density'=>$keyword_density_pointer,'box_suggestions_arr'=>$box_suggestions_arr);
        	
        	return array($total_score, $box_suggestions, $special_suggestions_arr);
        }
        
		/**
		 * Check if string ends with some letters
		 * 
		 * Check if $string ends with $ends_to_test
		 * 
		 * @param 	string $string
		 * @param 	string $ends_to_test
		 * @return	string
		 */
		static private function endswith($string, $ends_to_test) {
			if (WPPostsRateKeys_Settings::support_multibyte()) {
				$strlen = mb_strlen($string,'UTF-8');
				$testlen = mb_strlen($ends_to_test,'UTF-8');
			}
			else {
				$strlen = strlen($string);
			    $testlen = strlen($ends_to_test);
			}
		    
		    if ($testlen > $strlen) return false;
		    return substr_compare($string, $ends_to_test, -$testlen) === 0;
		}
        
		/**
		 * Get the first sentence in a text
		 * 
		 * Take in care that the end characters must be followed by:
		 * - an space
		 * - a return
		 * - a new line
		 * The HTML is stripped by the callers of this function 
		 * 
		 * @param 	string 	$string will not containd HTML
		 * @return	string
		 */
		static function get_first_sentence($string) {
			
			preg_match('/\A(.+?)[.?!]( |\r|\n)/s', $string, $matches);
		    if (count($matches)>0) {
		    	return $matches[0];
		    }
			else {
				return $string;
			}
		}

		/**
		 * Remove HTML tags, including invisible text such as style and
		 * script code, and embedded objects.  Add line breaks around
		 * block-level tags to prevent word joining after tag removal.
		 */
		static function strip_html_tags( $text )
		{
			$text = str_replace('<?php', 'mphpB', $text);
			$text = str_replace( '?>', 'mphpE',$text);
			
			$text = preg_replace(
					array(
							// Remove invisible content
							'@<head[^>]*?>.*?</head>@siu',
							'@<style[^>]*?>.*?</style>@siu',
							'@<script[^>]*?.*?</script>@siu',
							'@<object[^>]*?.*?</object>@siu',
							'@<embed[^>]*?.*?</embed>@siu',
							'@<applet[^>]*?.*?</applet>@siu',
							'@<noframes[^>]*?.*?</noframes>@siu',
							'@<noscript[^>]*?.*?</noscript>@siu',
							'@<noembed[^>]*?.*?</noembed>@siu',
							// Add line breaks before and after blocks
							'@</?((address)|(blockquote)|(center)|(del))@iu',
							'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
							'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
							'@</?((table)|(th)|(td)|(caption))@iu',
							'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
							'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
							'@</?((frameset)|(frame)|(iframe))@iu',
					),
					array(
							' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
							"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
							"\n\$0", "\n\$0",
					),
					$text );
			return strip_tags( $text );
		}
		
		/**
		 * Function to check how_many_lsi_keywords_in_use
		 *
		 * @param 	int		$post_id
		 * @param 	string	$content
		 * @param 	array	$keyword_arr
		 *
		 * @return 	int
		 * @static
		 */
		static function how_many_lsi_keywords_in_use($post_id,$content,$keyword_arr) {
			
			$lsi_keywords = array();
			// Get all the lsi keyword for all the keywords defined by user
			foreach ($keyword_arr as $keyword_arr_item) {
				$lsi_keywords = array_merge($lsi_keywords, WPPostsRateKeys_LSI::get_lsi_by_keyword($keyword_arr_item));
			}
			$lsi_keywords_keys = array();
			foreach ($lsi_keywords as $lsi_keywords_item) {
				$lsi_keywords_keys[] = $lsi_keywords_item['lsi'];
			}
			
			// Before use the content, strip the tags
			$content = self::strip_html_tags($content);
			
			$to_return = 0;
			foreach ($lsi_keywords_keys as $tmp_keyword) {
				if (WPPostsRateKeys_Keywords::keyword_in_content(array($tmp_keyword), $content)) {
					$to_return++;
				}
			}
			
			return $to_return;
		}
		
		/**
		 * Function to check if: Keyword in the Last 100 words
		 *
		 * @param 	array	$keyword_arr
		 * @param 	string	$content
		 *
		 * @return 	bool
		 * @static
		 */
		static function keyword_in_last_100_words($keyword_arr,$content) {
		
			/*
			 * If isn't: check in Post Content
			*/
			$content_no_html = self::strip_html_tags($content);
			$content_no_html_arr = explode(' ', $content_no_html);
			
			// Only get the slice of the array if they are more than 100 items
			$count = count($content_no_html_arr);
			if ($count>100) {
				$begin_in = $count-100;
				$content_no_html_last_100_words_arr = array_slice($content_no_html_arr, $begin_in);
				$content_no_html_last_100_words = implode(' ', $content_no_html_last_100_words_arr);
			}
			else {
				// Get all the words
				$content_no_html_last_100_words = implode(' ', $content_no_html_arr);
			}
			
			return WPPostsRateKeys_Keywords::keyword_in_content($keyword_arr, $content_no_html_last_100_words);
		}
		
		/**
         * Function to check if: Keyword in the First Sentence
         * 
         * @param 	array	$keyword_arr
         * @param 	string	$content
         * @param 	int		$post_id	used to check if user declare this explicity
         * 
         * @return 	bool
         * @static 
         */
        static function keyword_in_first_sentence($keyword_arr,$content,$post_id) {
        	
        	/*
        	 * First check if user declare this explicity
        	 */
        	$post_allow_keyword_overriding = WPPostsRateKeys_WPPosts::get_allow_keyword_overriding_in_sentences($post_id);
        	if ($post_allow_keyword_overriding==='1') { // This mean that user wants to use the value he set
        		$post_keyword_first_sentence = WPPostsRateKeys_WPPosts::setting_key_first_sentence($post_id);
        		if ($post_keyword_first_sentence==='1') {
        			return TRUE;
        		}
        		else {
        			return FALSE;
        		}
        	}
        	
        	/*
        	 * If isn't specified by user: check in Post Content
        	 */
        	$content_no_html = self::strip_html_tags($content);
        	$first_sentence = self::get_first_sentence($content_no_html);
        	
        	if (WPPostsRateKeys_Keywords::keyword_in_content($keyword_arr, $first_sentence)) {
        		return TRUE;
        	}
			
			return FALSE;
        }
        
	    /**
         * Function to check if is a keyword inside a H<some> tag
         * 
         * @param 	array	$keyword_arr
         * @param 	string	$content
         * @param 	string	$title
         * @param 	string	$h			can be H1, H2 or H3
         * @return 	int
         * @static 
         */
        static function how_many_keyword_inside_some_h($keyword_arr,$content,$title,$h) {
        	
        	// Set the array of styles that define the current check
        	$arrays_to_check = WPPostsRateKeys_HtmlStyles::get_h_styles($h);
        	
        	// Check in title and content, for that join both before analysis
        	$title_content = $title . ' ' . $content;
        	
        	$pieces = WPPostsRateKeys_Keywords::get_pieces_by_keyword($keyword_arr,$title_content);
        	
        	// Checks for each piece of code, is needed the total
        	$to_return = 0;
        	
        	for ($i=0;$i<(count($pieces)-1);$i++) {
        		
        		$result = WPPostsRateKeys_HtmlStyles::if_some_style_in_pieces($pieces, $i, $arrays_to_check, $keyword_arr);
        		if ($result && strpos($result[1],'H')===0) {
        			$to_return++;
        		}
        	}
        	
        	return $to_return;
        }
        
	    private function sanitize_words($string) {
        	preg_match_all("/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u",$string,$matches,PREG_PATTERN_ORDER);
        	return $matches[0];
        }
        
	    /**
         * Function to the get the: Post Word Count
         * 
         * @param 	string	$new_content	the content to search in (after changes made by our filter)
         * @return 	int
         * @static 
         */
        static function get_post_word_count($new_content) {
        	// Remove tags html to not be counted as words
        	$content_no_html = self::strip_html_tags($new_content);
        	
        	return count(self::sanitize_words($content_no_html));// Done to suport Greek
        	
        	// How many words
        	$how_many_words = str_word_count($content_no_html);
        	
        	return $how_many_words;
        }
        
        
        
	    /**
         * Function to the get the: Keyword Density Pointer
         * 
         * @param 	string	$new_content	the content to search in (after changes made by our filter)
         * @param 	array	$keyword_arr
         * @return 	double					return the percent of keywords in the text
         * @static 
         */
        static function get_keyword_density_pointer($new_content, $keyword_arr) {
        	
        	// Remove tags html to not be counted as words or keywords
        	$content_no_html = self::strip_html_tags($new_content);
        	$content_no_html = str_replace("&nbsp;",' ',$content_no_html);
        	
        	// How many words: this method allow don't fails when keyword is a phrase
        	$post_content_no_keywords = $content_no_html;
        	$post_content_no_keywords = WPPostsRateKeys_Keywords::delete_keywords($keyword_arr, $post_content_no_keywords);
			
        	$how_many_words = self::get_post_word_count($post_content_no_keywords);
        	
        	// How many times is the key in content
        	$how_many_keys = WPPostsRateKeys_Keywords::how_many_keywords($keyword_arr, $content_no_html);
        	
        	// Update keyword count: this allow don't fails when keyword is a phrase
        	$how_many_words += $how_many_keys;
        	
        	if ($how_many_words>0)
        		$percent = $how_many_keys * 100 / $how_many_words;
        	else
        		$percent = 0;
        	
        	return $percent;
        }
	}
}