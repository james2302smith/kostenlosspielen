<?php
if (!class_exists('WPPostsRateKeys_Filters')) {
	class WPPostsRateKeys_Filters {
        
		/**
         * Filter Post Slug
         * 
         * When editing a post a slug will be generated and modified by this 
         * removing common words like 'a', 'the', 'in' from post slugs to improve SEO.
         *  
         * If the Post is edited, this won't change it.
         * 
         * @param 	string	$slug
         * @return 	string
         */
        static function filter_post_slug($slug) {
        	// If settings is enable, filter the Slug
        	$settings = WPPostsRateKeys_Settings::get_options();
        	if ($settings['enable_convertion_post_slug']=='1') {
        		// We don't want to change an existing slug
				if ($slug) return $slug;
			
				global $wpdb;
				if (WPPostsRateKeys_Settings::support_multibyte()) {
					$seo_slug = mb_strtolower(stripslashes($_POST['post_title']),'UTF-8');
				}
				else {
					$seo_slug = strtolower(stripslashes($_POST['post_title']));
				}
			
				$seo_slug = preg_replace('/&.+?;/', '', $seo_slug); // kill HTML entities
			    // kill anything that is not a letter, digit, space or apostrophe
			    $seo_slug = preg_replace ("/[^a-zA-Z0-9 \']/", "", $seo_slug);
			    
			    // Turn it to an array and strip common words by comparing against c.w. array
			    $seo_slug_array = array_diff (explode(" ", $seo_slug), WPPostsRateKeys_Settings::get_slugs_stop_words());
			    
			    // Turn the sanitized array into a string
			    $seo_slug = implode("-", $seo_slug_array);
			
				return $seo_slug;
        	}
        	
        	return $slug;
        }
        
		/**
         * 
         * Filter the POST title
         * 
         * @param	string	$title
         * @param	array	$keyword_arr
         * @param	string	$settings
         * @return 	string
         */
        static function filter_post_title($title, $keyword_arr, $settings) {
        	if ($keyword_arr[0]=='' || trim($title)=='')
        		return $title;
        	
        	// If setting allow plugin to add keyword, add if isn't already
        	if (($settings['allow_add_keyword_in_titles']) && !WPPostsRateKeys_Keywords::keyword_in_content($keyword_arr,$title)) {
        		// Add keyword behind the TITLE, like this: title | keyword
        		$new_title = $title . ' | ' . $keyword_arr[0];
        		
        		return $new_title;
        	}
        	else 
        		return $title;
		}
		
        /**
         * Apply bold, italic and underline to a content
         * 
         * Just once for every typeface is enough. If there is less than 3 occurrences,
         * then, priority to bold, then italize, then underline.
         * 
         * @param 	string		$content
         * @param 	array		$keyword
         * @return 	string
         * @access 	public
         */
        static function apply_biu_to_content($content, $keyword_arr) {
        	$settings = WPPostsRateKeys_Central::get_md5_settings(TRUE);
        	
        	$new_content = $content;
        	
        	/*
        	 * Make the same for each keyword
        	 */
        	
        	foreach ($keyword_arr as $keyword_arr_item) {
        	
	        	/*
	        	 * Check for this $already_apply_... because: 
	        	 * if the first keyword is italized, second is underlined,
	        	 * then, we will find the third to bold. If there is no third keyword, then no bold face
	        	 * 
	        	 */
	        	if ($settings['allow_bold_style_to_apply']===1 || $settings['allow_bold_style_to_apply']==='1')
	        		$already_apply_bold = FALSE;
				else
	        		$already_apply_bold = TRUE;
	        	if ($settings['allow_italic_style_to_apply']===1 || $settings['allow_italic_style_to_apply']==='1')
	        		$already_apply_italic = FALSE;
				else
	        		$already_apply_italic = TRUE;      	
	        	if ($settings['allow_underline_style_to_apply']===1 || $settings['allow_underline_style_to_apply']==='1')
	        		$already_apply_underline = FALSE;
				else
	        		$already_apply_underline = TRUE;
				
	        	// Pass through all keyword until ends or until are applied all designs
	        	$how_many_keys = WPPostsRateKeys_Keywords::how_many_keywords(array($keyword_arr_item), $new_content);
	        	
	        	
	        	// To avoid make the request for each keyword: Get pieces by keyword for determine if some has the design applied
	        	$pieces_by_keyword = WPPostsRateKeys_Keywords::get_pieces_by_keyword(array($keyword_arr_item), $new_content,TRUE);
	        	$pieces_by_keyword_matches = $pieces_by_keyword[1];
	        	$pieces_by_keyword = $pieces_by_keyword[0];
	        	
	        	// First, only check for designs already applied
	        	for ($i=1;$i<=$how_many_keys;$i++) {
	        		
	        		// Stop if are already all the design applied
		        	if ($already_apply_bold && $already_apply_italic && $already_apply_underline)
		        		break;
	        		
	        		// Getting the position
	        		$key_pos = WPPostsRateKeys_Keywords::strpos_offset($keyword_arr_item,$new_content,$i,$pieces_by_keyword,$pieces_by_keyword_matches);
	        		
	        		if ($key_pos!==FALSE) {
		        		$already_style = WPPostsRateKeys_HtmlStyles::if_some_style_or_in_tag_attribute($new_content,array($keyword_arr_item),$i);
		        		
		        		if ($already_style) {
		        			if ($already_style[1] == 'bold')
		        				$already_apply_bold = TRUE;
		        			elseif ($already_style[1] == 'italic')
		        				$already_apply_italic = TRUE;
		        			elseif ($already_style[1] == 'underline')
		        				$already_apply_underline = TRUE;
		        		}
		        	}
	        	}
	        	
	        	// Apply designs pendings to apply
	        	for ($i=1;$i<=$how_many_keys;$i++) {
	        		
	        		// Stop if are already all the design applied
		        	if ($already_apply_bold && $already_apply_italic && $already_apply_underline)
		        		break;
	        		
	        		// Getting the position. Here can't be calculate one time ($pieces_by_keyword) and rehuse it because the content changes
	        		$key_pos = WPPostsRateKeys_Keywords::strpos_offset($keyword_arr_item,$new_content,$i);
	        		$pieces_by_keyword_matches_item = $pieces_by_keyword_matches[$i-1];
	        		
	        		/*
	        		// Determine which is the keyword that continues
	        		// Getting this text of keyword, allow us to be aware if a Keyword has any upper case
	        		if (WPPostsRateKeys_Settings::support_multibyte()) {
	        			$text_replace = mb_substr($new_content,$key_pos,mb_strlen($pieces_by_keyword_matches_item,'UTF-8'),'UTF-8');
	        		}
	        		else {
	        			//unused //$piece_with_keyword = substr($new_content,$key_pos);
	        			$text_replace = substr($new_content,$key_pos,strlen($pieces_by_keyword_matches_item));
	        		}
	        		*/
	        		
	        		if ($key_pos!==FALSE) {
		        		$already_style = WPPostsRateKeys_HtmlStyles::if_some_style_or_in_tag_attribute($new_content,array($keyword_arr_item),$i);
		        		
		        		if ($already_style) {
		        			if ($already_style[1] == 'bold')
		        				$already_apply_bold = TRUE;
		        			elseif ($already_style[1] == 'italic')
		        				$already_apply_italic = TRUE;
		        			elseif ($already_style[1] == 'underline')
		        				$already_apply_underline = TRUE;
		        		}
		        		else {
			        		if (!$already_apply_bold) {
			        			$keyword_with_style = WPPostsRateKeys_HtmlStyles::apply_bold_styles($pieces_by_keyword_matches_item);
				        		$already_apply_bold = TRUE;
			        		}
			        		elseif (!$already_apply_italic) {
			        			$keyword_with_style = WPPostsRateKeys_HtmlStyles::apply_italic_styles($pieces_by_keyword_matches_item);
				        		$already_apply_italic = TRUE;
			        		}
			        		elseif (!$already_apply_underline) {
			        			$keyword_with_style = WPPostsRateKeys_HtmlStyles::apply_underline_styles($pieces_by_keyword_matches_item);
				        		$already_apply_underline = TRUE;
			        		}
			        		
			        		if (WPPostsRateKeys_Settings::support_multibyte()) {
			        			$new_content = self::mb_substr_replace($new_content,$keyword_with_style
			        					,$key_pos, ($key_pos+mb_strlen($pieces_by_keyword_matches_item,'UTF-8')-1));
			        		}
			        		else {
			        			$new_content = substr_replace($new_content,$keyword_with_style
			        							,$key_pos,strlen($pieces_by_keyword_matches_item));
			        		}
			        							
			        		// Calculate how many keyword, because in case the keyword is, for example "b" this value will change 
			        		$how_many_keys = WPPostsRateKeys_Keywords::how_many_keywords(array($keyword_arr_item), $new_content);
		        		}
		        	}
	        	}
        	}
        	
        	return $new_content;
        }
        
        static function mb_substr_replace($output, $replace, $posOpen, $posClose) {
        	return mb_substr($output, 0, $posOpen).$replace.mb_substr($output, $posClose+1);
        }

        /**
         * Apply Automatic Internal Links
         * 
         * @param string 	$content
         * @param int 		$post_id
         */
        static private function apply_automatic_internal_links($content,$post_id) {
        	$all_keywords_links = WPPostsRateKeys_AutomaticInternalLinks::get_all();
        	
        	foreach ($all_keywords_links as $all_keywords_links_item) {
        		$how_many = $all_keywords_links_item->how_many;
        		if ($how_many=='' || $how_many<0)
        			$how_many = 0;
        		
        		// For cases of internal links with 0 as the number of ocurrences
        		if ($how_many==0) {
        			break;
        		}
        		
        		if (trim($all_keywords_links_item->keywords)!='') {
        			
	        		$tmp_keywords_arr = explode(',', $all_keywords_links_item->keywords);
	        		$tmp_post_id = $all_keywords_links_item->post_id;
	        		
	        		// If is in the same Post, don't apply internal link
	        		if ($tmp_post_id == $post_id) {
	        			continue;
	        		}
	        		
	        		if (count($tmp_keywords_arr)>0) {
	        			// Get permalink to this Post
	        			$tmp_post_link = get_permalink($tmp_post_id);
	        			
	        			foreach ($tmp_keywords_arr as $tmp_keywords_arr_item) {
	        				
	        				$tmp_keyword_item = trim($tmp_keywords_arr_item);
	        				if ($tmp_keyword_item!='') {
	        					
	        					// To avoid make the request for each keyword: Get pieces by keyword for determine if some has the design applied
	        					$pieces_by_keyword = WPPostsRateKeys_Keywords::get_pieces_by_keyword(array($tmp_keyword_item), $content,TRUE);
	        					$pieces_by_keyword_matches = $pieces_by_keyword[1];
	        					$pieces_by_keyword = $pieces_by_keyword[0];
	        					
	        					// First, only check for designs already applied
	        					for ($i=1;$i<=count($pieces_by_keyword);$i++) {
	        						// Getting the position
	        						$key_pos = WPPostsRateKeys_Keywords::strpos_offset($tmp_keyword_item,$content,$i,$pieces_by_keyword,$pieces_by_keyword_matches);
	        						$pieces_by_keyword_matches_item = $pieces_by_keyword_matches[$i-1];
	        		
	        						if ($key_pos!==FALSE) { 
	        							$ready_to_apply_link = WPPostsRateKeys_HtmlStyles::if_ready_to_apply_internal_link($content,array($tmp_keyword_item),$i);
	        							
	        							if ($ready_to_apply_link) {
		        							// Setting text of keyword, allow us to be aware if a Keyword has any upper case, has characters to omit, etc
	        								$text_replace = '<a href="' . $tmp_post_link . '">'
	        										. $pieces_by_keyword_matches_item
	        										. '</a>';
	        								
	        								if (WPPostsRateKeys_Settings::support_multibyte()) {	
	        									$content = self::mb_substr_replace($content,$text_replace
	        											,$key_pos, ($key_pos+mb_strlen($pieces_by_keyword_matches_item,'UTF-8')-1));
	        								}
	        								else {
	        									$content = substr_replace($content,$text_replace
	        											,$key_pos,strlen($tmp_keyword_item));
	        								}
	        								
		        							$how_many--;
		        							if ($how_many==0) {
		        								break 2; // Go out the per content-keywork foreach, and the keywords-to-link foreach
		        							}
		        							
		        							// If a change was made in the content, take the pieces by keywords again, because the possitions changes
		        							$pieces_by_keyword = WPPostsRateKeys_Keywords::get_pieces_by_keyword(array($tmp_keyword_item), $content,TRUE);
		        							$pieces_by_keyword_matches = $pieces_by_keyword[1];
		        							$pieces_by_keyword = $pieces_by_keyword[0];
	        							}
	        						}
	        					}       					
	        				}
	        			}
	        		}
        		}
        	}
        	
        	return $content;
        }
        
        /**
         * Apply External Cloaked Links
         * 
         * Example of Cloacked link:
         * <a href="http://theirsite.com/recommends/wikipedia" 
         * onclick="javascript:this.href='http://wikipedia.com/';" 
         * rel="nofollow">keyword</a>
         * 
         * @param string $content
         */
        static private function apply_external_cloaked_links($content) {
        	// Get all keywords-links
        	$all_keywords_links = WPPostsRateKeys_ExternalCloackedLinks::get_all();
        	
        	// Get current site url
        	$wp_url = get_bloginfo('wpurl');
        	
        	foreach ($all_keywords_links as $all_keywords_links_item) {
        		$how_many = $all_keywords_links_item->how_many;
        		if ($how_many=='' || $how_many<0)
        			$how_many = 0;
        		
        		// For cases of internal links with 0 as the number of ocurrences
        		if ($how_many==0) {
        			break;
        		}
        		
        		if (trim($all_keywords_links_item->keywords)!='') {
	        		$tmp_keywords_arr = explode(',', $all_keywords_links_item->keywords);
	        		
	        		if (count($tmp_keywords_arr)>0) {
	        			// Get data to build the link
	        			$tmp_cloaking_folder = $all_keywords_links_item->cloaking_folder;
		        		$tmp_external_url = $all_keywords_links_item->external_url;
		        		/*
		        		 * Get main domain from $tmp_external_url
		        		 * Example: 
		        		 * 			from: http://www.wikipedia.org/some/page.php?var1=value1
		        		 * 			we get:  wikipedia
		        		 */
		        		$tmp_external_url_domain = str_replace('http://', '', $tmp_external_url);
		        		$tmp_external_url_domain = str_replace('https://', '', $tmp_external_url_domain);
		        		
		        		// Add http:// if isn't in external Url
		        		if (substr_count($tmp_external_url, 'http://')==0 && substr_count($tmp_external_url, 'https://')==0) {
		        			$tmp_external_url = 'http://' . $tmp_external_url;
		        		}
		        		
		        		if (strpos($tmp_external_url_domain, '/')) {
		        			$tmp_external_url_domain = substr($tmp_external_url_domain, 0, strpos($tmp_external_url_domain, '/'));
		        		}
		        		if (strrpos($tmp_external_url_domain, '.')) {
		        			$tmp_external_url_domain = substr($tmp_external_url_domain, 0, strrpos($tmp_external_url_domain, '.'));
		        		}
		        		if (strrpos($tmp_external_url_domain, '.')) {
		        			$tmp_external_url_domain = substr($tmp_external_url_domain, strrpos($tmp_external_url_domain, '.'));
		        		}
		        		$tmp_external_url_domain = trim($tmp_external_url_domain,'.');
	        			
		        		// For each keyword make the replaces
	        			foreach ($tmp_keywords_arr as $tmp_keywords_arr_item) {
	        				$tmp_keyword_item = trim($tmp_keywords_arr_item);
	        				if ($tmp_keyword_item!='') {
	        					
	        					// To avoid make the request for each keyword: Get pieces by keyword for determine if some has the design applied
	        					$pieces_by_keyword = WPPostsRateKeys_Keywords::get_pieces_by_keyword(array($tmp_keyword_item), $content, TRUE);
	        					$pieces_by_keyword_matches = $pieces_by_keyword[1];
	        					$pieces_by_keyword = $pieces_by_keyword[0];
	        					
	        					// First, only check for designs already applied
	        					for ($i=1;$i<=count($pieces_by_keyword);$i++) {
	        						// Getting the position
	        						$key_pos = WPPostsRateKeys_Keywords::strpos_offset($tmp_keyword_item,$content,$i,$pieces_by_keyword,$pieces_by_keyword_matches);
	        						$pieces_by_keyword_matches_item = $pieces_by_keyword_matches[$i-1];
	        		
	        						if ($key_pos!==FALSE) {
	        							$ready_to_apply_link = WPPostsRateKeys_HtmlStyles::if_ready_to_apply_internal_link($content,array($tmp_keyword_item),$i);
	        					
	        							if ($ready_to_apply_link) {
	        								// Prepare cloacked link
	        								$cloacked_link = '<a href="' . $wp_url . '/' . $tmp_cloaking_folder . '/' . $tmp_external_url_domain 
	        										. '" onclick="javascript:this.href=' . "'$tmp_external_url'" 
	        										. ';" rel="nofollow">' . $pieces_by_keyword_matches_item . '</a>';
	        								
	        								if (WPPostsRateKeys_Settings::support_multibyte()) {
	        									$content = self::mb_substr_replace($content,$cloacked_link
	        											,$key_pos, ($key_pos+mb_strlen($pieces_by_keyword_matches_item,'UTF-8')-1));
	        								}
	        								else {
	        									$content = substr_replace($content,$cloacked_link
	        														,$key_pos,strlen($pieces_by_keyword_matches_item));
	        								}
	        								
	        								$how_many--;
	        								if ($how_many==0) {
	        									break 2; // Go out the per content-keywork foreach, and the keywords-to-link foreach
	        								}
	        								
	        								// If a change was made in the content, take the pieces by keywords again, because the possitions changes
	        								$pieces_by_keyword = WPPostsRateKeys_Keywords::get_pieces_by_keyword(array($tmp_keyword_item), $content, TRUE);
	        								$pieces_by_keyword_matches = $pieces_by_keyword[1];
	        								$pieces_by_keyword = $pieces_by_keyword[0];
	        							}
	        						}
	        					}
	        				}
	        			}
	        		}
        		}
        	}
        	
        	return $content;
        }
        
		/**
         * apply_code_snippets
         * 
         * @param	string	$content
         * @param	int		$post_id
         * @return 	string
         * @access 	public
         */
        public static function apply_code_snippets($content, $post_id) {
        	
        	
        		// Only filter if is Enabled in both Settings
        		$settings = WPPostsRateKeys_Settings::get_options();
        		if ($settings['enable_rich_snippets']!='1'
        				|| WPPostsRateKeys_WPPosts::get_meta_enable_rich_snippets($post_id)!='1') {
        			return $content;
        		}
        		
        		$post = get_post($post_id);
        		
        		$publish_rich_snippets = WPPostsRateKeys_WPPosts::get_meta_publish_rich_snippets($post_id);
        		if ($publish_rich_snippets=='1') {
        			$content = $content . '<style>
				        						#seopressor-structure-data-box {
				  									border:1px solid #B8B2B2;
				  									border-radius: 15px;
													  margin:10px;
													  padding:10px;
				        						}
			        						</style>';
        		}
        		
        		// Add Review, microformat
        		$summary = get_post_meta($post_id, '_google_rich_snippet_summary', true);
        		if ( $summary != '' ){
        			$rating = get_post_meta($post_id, '_google_rich_snippet_rating', true);
        			$title = $post->post_title ;
        			$dateTime = date_create( $post->post_date );
        			$date = $dateTime->format("Y-m-d");
        			$date_only = $dateTime->format("M j");
        			$author = get_post_meta($post_id, '_google_rich_snippet_author', true);
        			$author = ( '' == $author ) ? ucfirst(get_the_author_meta('display_name', $post->post_author)) : $author;
        			$description = get_post_meta($post_id, '_google_rich_snippet_description', true);
        			
        			if ($publish_rich_snippets=='1') {
        				// Visible
        				$output ="<div id=\"seopressor-structure-data-box\" class=\"hreview\">" 
        						. __('Structured Data, Review','seo-pressor') 
        						.'<br>' . "<span class=\"item\">" 
        						. __('Title','seo-pressor') . ": <span class=\"fn entry-title\">$title</span></span>" 
        						. '<br>' . __('Reviewed by','seo-pressor') . " <span class=\"reviewer\">$author</span> " 
        						. __('on','seo-pressor') . " <span class=\"dtreviewed\">$date_only<span class=\"value-title\" title=\"$date\"></span></span>" 
        						. '<br>' . __('Rating','seo-pressor') . ": <span class=\"rating\">$rating</span>" 
        						. '<br>' . __('Summary','seo-pressor') . ": <span class=\"summary\">$summary</span>" 
        						. '<br>' . __('Description','seo-pressor') . ": <span class=\"description\">$description</span></div>";
        			}
        			else {
        				// Hidden
	        			$output = "<div class=\"hreview\" style=\"display:none\">
	        					<span class=\"item\"><span class=\"fn entry-title\">$title</span></span>
	        					Reviewed by <span class=\"reviewer\">$author</span> on <span class=\"dtreviewed\">
	        					$date_only<span class=\"value-title\" title=\"$date\"></span></span>
	        					Rating: <span class=\"rating\">$rating</span>
	        					<span class=\"summary\">$summary</span>
	        					<span class=\"description\">$description</span></div>";
        			}
        			
        			$content = $content . $output;
        		}
        		
        		// Add Event, microformat
        		$seop_grs_event_name = get_post_meta($post_id, '_seop_grs_event_name', true);
        		if ( $seop_grs_event_name != '' ){
        			
        			$seop_grs_event_url = get_post_meta($post_id, '_seop_grs_event_url', TRUE);
					$seop_grs_event_startdate = get_post_meta($post_id, '_seop_grs_event_startdate', TRUE);
					$seop_grs_event_location_name = get_post_meta($post_id, '_seop_grs_event_location_name', TRUE);
					$seop_grs_event_location_address_streetaddress = get_post_meta($post_id, '_seop_grs_event_location_address_streetaddress', TRUE);
					$seop_grs_event_location_address_addresslocality = get_post_meta($post_id, '_seop_grs_event_location_address_addresslocality', TRUE);
					$seop_grs_event_location_address_addressregion = get_post_meta($post_id, '_seop_grs_event_location_address_addressregion', TRUE);
					
					if ($publish_rich_snippets=='1') {
        				// Visible
        				$output ="<div id=\"seopressor-structure-data-box\" class=\"vevent\">" 
        						. __('Structured Data, Event','seo-pressor') 
        						.'<br>' .'<div>' .   __('Name:','seo-pressor') . ' <a href="' . $seop_grs_event_url . '" class="url summary">' . $seop_grs_event_name 
        						. '</a><br><span class="dtstart">' . __('Date and Time:','seo-pressor') . ' ' 
						   		. $seop_grs_event_startdate . '<span class="value-title" title="' . $seop_grs_event_startdate 
						   		. '"></span></span></div>' .  '<div class="location vcard">'.__('Location:','seo-pressor') . ' ' . '<span class="fn org">' 
						   				. $seop_grs_event_location_name 
						   				. '</span><span class="adr"><span class="street-address">' 
						   					. '<br>' . __('Street:','seo-pressor') 
						   				. ' ' . $seop_grs_event_location_address_streetaddress . '</span><br><span class="locality">' 
						   						. __('Locality:','seo-pressor') . ' ' . $seop_grs_event_location_address_addresslocality . '</span>
						         <span class="region">' . __('Region:','seo-pressor') . ' ' . $seop_grs_event_location_address_addressregion . '</span>
						      </span>
						   </div></div>';
        			}
        			else {
        				// Hidden
	        			$output = '<div class="vevent" style="display:none">
							<a href="' . $seop_grs_event_url . '" class="url summary">' . $seop_grs_event_name . '</a>
						   <span class="dtstart">
						      ' . $seop_grs_event_startdate . '<span class="value-title" title="' . $seop_grs_event_startdate . '"></span>
						   </span>
							<div class="location vcard">
						      <span class="fn org">' . $seop_grs_event_location_name . '</span>,
						      <span class="adr">
						         <span class="street-address">' . $seop_grs_event_location_address_streetaddress . '</span>,
						         <span class="locality">' . $seop_grs_event_location_address_addresslocality . '</span>,
						         <span class="region">' . $seop_grs_event_location_address_addressregion . '</span>
						      </span>
						   </div>
         			</div>';
        			}
					
					$content = $content . $output;
        		}
        		
        		// Add People, microformat
        		$seop_grs_people_name_given_name = get_post_meta($post_id, '_seop_grs_people_name_given_name', TRUE);
        		if ( $seop_grs_people_name_given_name != '' ){
        			$seop_grs_people_name_family_name = get_post_meta($post_id, '_seop_grs_people_name_family_name', TRUE);
        			$seop_grs_people_home_url = get_post_meta($post_id, '_seop_grs_people_home_url', TRUE);
        			$seop_grs_people_locality = get_post_meta($post_id, '_seop_grs_people_locality', TRUE);
        			$seop_grs_people_region = get_post_meta($post_id, '_seop_grs_people_region', TRUE);
        			$seop_grs_people_title = get_post_meta($post_id, '_seop_grs_people_title', TRUE);
        			$seop_grs_people_photo = get_post_meta($post_id, '_seop_grs_people_photo', TRUE);
        			
        			if ($publish_rich_snippets=='1') {
        				// Visible
        				$output ="<div id=\"seopressor-structure-data-box\" class=\"vcard\">" 
        						. __('Structured Data, People','seo-pressor') 
        						.'<br>' . '<span class="fn">' . __('Name: ','seo-pressor') . $seop_grs_people_name_given_name . ' ' . $seop_grs_people_name_family_name . '</span>' 
        						.'<br>' . __('Home Url: ','seo-pressor') . '<a href="' . $seop_grs_people_home_url 
        						. '" class="url">' . $seop_grs_people_home_url . '</a>'
        						.'<span class="adr">
						      <span class="locality">' . __('Locality: ','seo-pressor') . $seop_grs_people_locality 
						      . '</span><span class="region">' . __('Region: ','seo-pressor') . $seop_grs_people_region . '</span>
						   </span><span class="title">' . __('Work as: ','seo-pressor') . $seop_grs_people_title . '</span>
						   <span class="photo">' . '<a href="' . $seop_grs_people_photo . '">' 
						   		. __('Photo','seo-pressor') . '</a></span>'
						   . '</div>';
        			}
        			else {
        				// Hidden
	        			$output = '<div class="vcard" style="display:none">
							<span class="fn">' . $seop_grs_people_name_given_name . ' ' . $seop_grs_people_name_family_name . '</span>
						   <a href="' . $seop_grs_people_home_url . '" class="url">' . $seop_grs_people_home_url . '</a>.
						   <span class="adr">
						      <span class="locality">' . $seop_grs_people_locality . '</span>,
						      <span class="region">' . $seop_grs_people_region . '</span>
						   </span>
						   and work as an
						   <span class="title">' . $seop_grs_people_title . '</span>
						   <span class="photo">' . $seop_grs_people_photo . '</span>
         				</div>';
        			}
					
					$content = $content . $output;
        		}
        		
        		// Add Product, NO microformat because doesn't allow multiple Offers
        		$seop_grs_product_name = get_post_meta($post_id, '_seop_grs_product_name', TRUE);
        		if ( $seop_grs_product_name != '' ){
        			$seop_grs_product_image = get_post_meta($post_id, '_seop_grs_product_image', TRUE);
	        		$seop_grs_product_description = get_post_meta($post_id, '_seop_grs_product_description', TRUE);
	        		$seop_grs_product_offers = get_post_meta($post_id, '_seop_grs_product_offers', TRUE);
	        		
	        		if ($publish_rich_snippets=='1') {
        				// Visible
        				$output ='<div id="seopressor-structure-data-box" itemscope="itemscope" itemtype="http://schema.org/Product">'
        						. __('Structured Data, Product','seo-pressor') 
        						. '<br>' .'<img src="' . $seop_grs_product_image . '" title="' . $seop_grs_product_name 
							. '" alt="' . $seop_grs_product_name . '" itemprop="image">'
								.'<div itemprop="description">' 
								. __('Description: ','seo-pressor') . $seop_grs_product_description . '</div>';
        			}
        			else {
        				// Hidden
	        			$output = '<div itemscope="itemscope" itemtype="http://schema.org/Product" style="display:none">
							<img src="' . $seop_grs_product_image . '" title="' . $seop_grs_product_name 
							. '" alt="' . $seop_grs_product_name . '" itemprop="image">
							
							<div itemprop="description">' . $seop_grs_product_description . '</div>';
        			}
	        			
	        		// Add item for each Offer
	        		$seop_grs_product_offers_arr = explode("\n", $seop_grs_product_offers);
	        		foreach ($seop_grs_product_offers_arr as $seop_grs_product_offers_item) {
	        			$seop_grs_product_offers_item = trim($seop_grs_product_offers_item);
	        			$seop_grs_product_offers_item_arr = explode(' ', $seop_grs_product_offers_item);
	        			$seop_grs_product_offers_item_price = $seop_grs_product_offers_item_arr[0];
	        			if (count($seop_grs_product_offers_item_arr)>1) {
	        				$seop_grs_product_offers_item_currency = $seop_grs_product_offers_item_arr[1];
	        			}
	        			else {
	        				// No currency specified
	        				$seop_grs_product_offers_item_currency = '';
	        			}
	        			if ($seop_grs_product_offers_item_price!='') {
	        				
	        				$output .= '<span itemprop="offers" itemscope="itemscope" itemtype="http://schema.org/Offer">'
	        						. '<span itemprop="price">' . __('Price: ','seo-pressor') . $seop_grs_product_offers_item_price 
			        					. '</span><span itemprop="priceCurrency" content="' . $seop_grs_product_offers_item_currency . '">'
			        							. ' ' . $seop_grs_product_offers_item_currency . '</span>
			        					</span>';
	        			}
	        		}
	        		$output .= '</div>';
	        			
	        		$content = $content . $output;
        		}
        		
        		// Add Receipt, microformat
        		$seop_grs_recipe_name = get_post_meta($post_id, '_seop_grs_recipe_name', TRUE);
        		if ( $seop_grs_recipe_name != '' ){
        			$seop_grs_recipe_yield = get_post_meta($post_id, '_seop_grs_recipe_yield', TRUE);
        			$seop_grs_recipe_author = get_post_meta($post_id, '_seop_grs_recipe_author', TRUE);
        			$seop_grs_recipe_photo = get_post_meta($post_id, '_seop_grs_recipe_photo', TRUE);
        			$seop_grs_recipe_nutrition_calories = get_post_meta($post_id, '_seop_grs_recipe_nutrition_calories', TRUE);
        			$seop_grs_recipe_nutrition_sodium = get_post_meta($post_id, '_seop_grs_recipe_nutrition_sodium', TRUE);
        			$seop_grs_recipe_nutrition_fat = get_post_meta($post_id, '_seop_grs_recipe_nutrition_fat', TRUE);
        			$seop_grs_recipe_nutrition_protein = get_post_meta($post_id, '_seop_grs_recipe_nutrition_protein', TRUE);
        			$seop_grs_recipe_nutrition_cholesterol = get_post_meta($post_id, '_seop_grs_recipe_nutrition_cholesterol', TRUE);
        			$seop_grs_recipe_total_time_minutes = get_post_meta($post_id, '_seop_grs_recipe_total_time_minutes', TRUE);
        			$seop_grs_recipe_cook_time_minutes = get_post_meta($post_id, '_seop_grs_recipe_cook_time_minutes', TRUE);
        			$seop_grs_recipe_prep_time_minutes = get_post_meta($post_id, '_seop_grs_recipe_prep_time_minutes', TRUE);
        			$seop_grs_recipe_ingredient = get_post_meta($post_id, '_seop_grs_recipe_ingredient', TRUE);
        			
        			if ($publish_rich_snippets=='1') {
        				// Visible
        				$output ='<div class="hrecipe" id="seopressor-structure-data-box">'
        						. __('Structured Data, Recipe','seo-pressor') 
        						. '<br>' . '<span class="fn">' . $seop_grs_recipe_name . '</span>
						   <img src="' . $seop_grs_recipe_photo . '" class="photo" />'
						   		. '<br>' . __('By','seo-pressor') . ' <span class="author">' . $seop_grs_recipe_author . '</span>'
						   		. '<br>' . __('Prep time','seo-pressor') . ': <span class="preptime">' . $seop_grs_recipe_prep_time_minutes . '</span>'
						   		. '<br>' . __('Cook time','seo-pressor') . ': <span class="cooktime">' . $seop_grs_recipe_cook_time_minutes . '</span>'
						   		. '<br>' . __('Total time','seo-pressor') . ': <span class="duration">' . $seop_grs_recipe_total_time_minutes . '</span>'
						   		. '<br>' . __('Yield','seo-pressor') . ': <span class="yield">' . $seop_grs_recipe_yield . '</span><span class="nutrition">'
						   		. '<br>' . __('Calories per serving','seo-pressor') . ': <span class="calories">' . $seop_grs_recipe_nutrition_calories . '</span>'
						   		. '<br>' . __('Fat per serving','seo-pressor') . ': <span class="fat">' . $seop_grs_recipe_nutrition_fat . '</span>'
						   		. '<br>' . __('Protein per serving','seo-pressor') . ': <span class="protein">' . $seop_grs_recipe_nutrition_protein . '</span>'
						   		. '<br>' . __('Sodium per serving','seo-pressor') . ': <span class="sodium">' . $seop_grs_recipe_nutrition_sodium . '</span>'
						   		. '<br>' . __('Cholesterol per serving','seo-pressor') . ': <span class="cholesterol">' . $seop_grs_recipe_nutrition_cholesterol . '</span>
						   </span>'. __('Ingredients:','seo-pressor') . '<br>';
        			}
        			else {
        				// Hidden
	        			$output = '<div class="hrecipe" style="display:none">
						   <span class="fn">' . $seop_grs_recipe_name . '</span>
						   <img src="' . $seop_grs_recipe_photo . '" class="photo" />
						   <span class="author">' . $seop_grs_recipe_author . '</span>
						   <span class="preptime">' . $seop_grs_recipe_prep_time_minutes . '</span>
						   <span class="cooktime">' . $seop_grs_recipe_cook_time_minutes . '</span>   
						   <span class="duration">' . $seop_grs_recipe_total_time_minutes . '</span>
						   <span class="yield">' . $seop_grs_recipe_yield . '</span>
						   <span class="nutrition">
						      <span class="calories">' . $seop_grs_recipe_nutrition_calories . '</span>
						      <span class="fat">' . $seop_grs_recipe_nutrition_fat . '</span>
						      <span class="protein">' . $seop_grs_recipe_nutrition_protein . '</span>
						      <span class="sodium">' . $seop_grs_recipe_nutrition_sodium . '</span>
						      <span class="cholesterol">' . $seop_grs_recipe_nutrition_cholesterol . '</span>
						   </span>';
        			}
        			
        			// Add item for each Ingredient
        			$seop_grs_recipe_ingredient_arr = explode("\n", $seop_grs_recipe_ingredient);
        			foreach ($seop_grs_recipe_ingredient_arr as $seop_grs_recipe_ingredient_item) {
        				if (trim($seop_grs_recipe_ingredient_item)!='') {
        					$output .= '<span class="ingredient">' . $seop_grs_recipe_ingredient_item . '</span>' . '<br>';
        				}
        			}
        			
        			$output .= '</div>';
					
					$content = $content . $output;
        		}
        	
        	return $content;
        }
        
		/**
         * 
         * Filter the POST content
         * 
         * @param	array	$keyword_arr
         * @param	string	$content		Take in care should be the Post Content to Edit
         * @param	string	$settings
         * @param	int		$post_id
         * @param	string	$current_md5
         * @param	string	$current_content_in_filter
         * @return 	string
         * @access 	public
         */
        static function filter_post_content($keyword_arr, $content, $settings,$post_id,$current_md5='',
        					$current_content_in_filter) {
        	
        	$new_content = $current_content_in_filter;
        	
        	// Apply Automatic Internal Links
        	$new_content = self::apply_automatic_internal_links($new_content,$post_id);

        	// Apply External Cloaked Links
        	$new_content = self::apply_external_cloaked_links($new_content);
        	
        	// Apply settings related to keyword, if keyword is specified
        	if ($keyword_arr[0]!='') {
        		$new_content = self::apply_biu_to_content($new_content, $keyword_arr);
        	}
        	
        	// Decorates all Images Alt and Title attributes
        	$new_content = WPPostsRateKeys_HtmlStyles::decorates_images($new_content, $keyword_arr,$post_id,$settings);
        	
        	// Add of rel="nofollow" to external links
        	$new_content = WPPostsRateKeys_HtmlStyles::add_rel_nofollow_external_links($new_content,$settings);

        	// Add of rel="nofollow" to Image links
        	$new_content = WPPostsRateKeys_HtmlStyles::add_rel_nofollow_image_links($new_content,$settings);
        	
        	// Update the Post Meta with the filtered Data
        	update_post_meta($post_id, WPPostsRateKeys_Central::$cache_filtered_content_new, $new_content);
        	
        	// Update filtered content Md5, since if some of this changes, could change the filtered content too
        	if ($current_md5=='') {
        		$current_md5 = WPPostsRateKeys_Central::get_content_cache_current_md5($post_id,array(),$keyword_arr,$current_content_in_filter);
        	}
        	update_post_meta($post_id, WPPostsRateKeys_Central::$cache_md5_for_filter_content, $current_md5);
        	update_post_meta($post_id, WPPostsRateKeys_Central::$cache_md5_filter_content_last_mod_time, time());
        	
        	return $new_content;
		}
	}
}