<?php
if (!class_exists('WPPostsRateKeys_Central'))
{
	class WPPostsRateKeys_Central
	{
	    /**
	     * @static 
	     * @var string
	     */
        static $url_api = 'http://54.235.153.222/api/getdata.php';
        
	    /**
         * The url to central script that receive the reported Url
         *
         * @static
         * @var string
         */
        static $url_nu = 'http://seopressor.com/nu.php';
        
	    /**
	     * The url to central script that returns the Box message
	     *
	     * @static 
	     * @var string
	     */
        static $url_box_msg = 'http://seopressor.com/get_msg_for_plugin_box.php';
        
	    /**
	     * The URL to check if active
	     *
	     * @var string
	     */
        static $url_check_if_active = 'http://seopressor.com/activate.php';
        
	   /**
	    * The URL to check last version
	    *
	    * @var string
	    */
        static $url_check_last_version = 'http://seopressor.com/lvc.php'; 
        
	   /**
	    * The URL to send visits
	    *
	    * @var string
	    */
        static $url_send_visits = 'http://seopressor.com/rv.php'; 
        
	   /**
	    * The URL to do the automatic download and upgrade
	    *
	    * @var string
	    */
        static $url_to_automatic_upgrade = 'http://seopressor.com/lv_down.php';
        
	   /**
	    * The URL for add new domain
	    *
	    * @var string
	    */
        static $url_add_new_domain = 'http://seopressor.com/spfp/add_domain.php';
        
	   /**
	    * The meta value cached seopressor_original_post_content
	    *
	    * @static 
	    * @var string
	    */
        static $original_post_content = '_seopressor_original_post_content';
		
	   /**
	    * The meta value cached score
	    *
	    * @static 
	    * @var string
	    */
        static $cache_score = '_seo_cached_score';
		
	   /**
	    * The meta value cached suggestions_box
	    *
	    * @static 
	    * @var string
	    */
        static $cache_suggestions_box = '_seo_cached_suggestions_box'; 
		
	   /**
	    * The meta value cached suggestions_page
	    *
	    * @static 
	    * @var string
	    */
        static $cache_special_suggestions = '_seo_cached_special_suggestions'; 
		
	   /**
	    * The meta value to check cache valid
	    *
	    * @static 
	    * @var string
	    */
        static $cache_md5 = '_seo_cache_md5';
        
	   /**
	    * The meta value to check cache valid for filter the title
	    *
	    * @static 
	    * @var string
	    */
        static $cache_filtered_title = '_seo_cached_filtered_title';
        
	   /**
	    * The meta value to store filtered content
	    *
	    * @static 
	    * @var string
	    */
        static $cache_filtered_content_new = '_seo_cached_filtered__content_new';
        
	   /**
	    * The meta value to check cache valid for filter the content
	    *
	    * @static 
	    * @var string
	    */
        static $cache_md5_for_filter_content = '_seo_cache_md5_filter_content';
        
	   /**
	    * The meta value to store the last time the cache for filter the content was modified
	    *
	    * @static 
	    * @var string
	    */
        static $cache_md5_filter_content_last_mod_time = '_seo_cache_filter_content_last_mod_time';
        
        /**
         * Check if the cache is valid, and if isn't update it
         * Not the Filter Content Cache, only the Score Cache
         * 
         * @param int $post_id
         */
        static function check_update_post_data_in_cache($post_id) {
        	
        	/*
        	 * Get Settings and values used by more than once
        	 */
        	// Keywords and LSI lists
        	$post_keyword = WPPostsRateKeys_WPPosts::get_keyword($post_id);
        	$post_keyword_lsi = WPPostsRateKeys_LSI::get_lsi_by_keyword($post_keyword);
        	$post_keyword2 = WPPostsRateKeys_WPPosts::get_keyword2($post_id);
        	$post_keyword2_lsi = WPPostsRateKeys_LSI::get_lsi_by_keyword($post_keyword2);
        	$post_keyword3 = WPPostsRateKeys_WPPosts::get_keyword3($post_id);
        	$post_keyword3_lsi = WPPostsRateKeys_LSI::get_lsi_by_keyword($post_keyword3);
        	
        	// The per Post Settings
        	$post_allow_keyword_overriding = (WPPostsRateKeys_WPPosts::get_allow_keyword_overriding_in_sentences($post_id))?'1':'0';
        	$post_keyword_first_sentence = (WPPostsRateKeys_WPPosts::setting_key_first_sentence($post_id))?'1':'0';
        	$post_keyword_last_sentence = (WPPostsRateKeys_WPPosts::setting_key_last_sentence($post_id))?'1':'0';
        	$post_allow_meta_keyword = (WPPostsRateKeys_WPPosts::get_allow_meta_keyword($post_id))?'1':'0';
        	$post_use_for_meta_keyword = WPPostsRateKeys_WPPosts::get_use_for_meta_keyword($post_id);
        	$post_allow_meta_description = (WPPostsRateKeys_WPPosts::get_allow_meta_description($post_id))?'1':'0';
        	$post_meta_description = WPPostsRateKeys_WPPosts::get_meta_description($post_id);
        	$post_allow_meta_title = (WPPostsRateKeys_WPPosts::get_allow_meta_title($post_id))?'1':'0';
        	$post_meta_title = WPPostsRateKeys_WPPosts::get_meta_title($post_id);

        	// Global settings
        	$settings = self::get_md5_settings(TRUE);
        	$settings_str = implode('',$settings);
        	
        	// Post URL (Permalink)
        	$post_permalink = get_permalink($post_id);
        	
        	// Get Post title
        	$data_arr = WPPostsRateKeys_WPPosts::get_wp_post_title_content($post_id);
        	$post_title = $data_arr[0];
        	$previous_content = $data_arr[1];
        	
        	//$post_title .= '-modifiedTest:' . time();// Test line to always get an invalid Cache
        	
        	// Get Post content: "Full Page", but if isn't available the Post Content will be used
        	$post_whole_page_to_analyze = WPPostsRateKeys_ContentRate::get_post_whole_page_to_analyze($post_id, $settings,$post_permalink);
        	$post_content_to_edit = WPPostsRateKeys::get_content_to_edit($data_arr[1],$post_id);
        	if ($post_whole_page_to_analyze!==FALSE) {
        		$post_content = $post_whole_page_to_analyze;
        		$from_url = TRUE;
        	}
        	else {
        		$post_content = $post_content_to_edit;
        		$from_url = FALSE;
        	}
        	
        	/*
        	 * Get current md5 values
        	 */
        	$current_md5 = md5($post_permalink
					        	.$post_keyword.$post_keyword_lsi
					        	.$post_keyword2.$post_keyword2_lsi
					        	.$post_keyword3.$post_keyword3_lsi
					        	.$post_title.$post_content.$settings_str
					        	.$post_allow_keyword_overriding.$post_keyword_first_sentence.$post_keyword_last_sentence
					        	.$post_allow_meta_keyword.$post_use_for_meta_keyword
					        	.$post_allow_meta_description.$post_meta_description
        					);
        	
        	/*
        	 * Check if cache is valid
        	 */
        	$cache_valid = FALSE;
			if ($current_md5==get_post_meta($post_id, self::$cache_md5, TRUE)) {
        		$cache_valid = TRUE;
        	}        	
        	
        	/*
        	 * If isn't valid update all data and cache md5
        	 */
        	if (!$cache_valid) {
        		
        		// Make Keyword array to pass to the functions that gets all updated data
        		$keyword_arr = array($post_keyword);
        		if ($post_keyword2!='') $keyword_arr[] = $post_keyword2;
        		if ($post_keyword3!='') $keyword_arr[] = $post_keyword3;
        		
        		// Get filtered title
        		$filtered_title = WPPostsRateKeys_Filters::filter_post_title($post_title,$keyword_arr,$settings);
        		$previous_title = get_post_meta($post_id, self::$cache_filtered_title,TRUE);
        		if ($filtered_title!=$previous_title) {
        			update_post_meta($post_id, self::$cache_filtered_title, $filtered_title);
        		}
        		
        		// If isn't whole page, get filtered content
        		if (!$from_url) {
        			// Call this to store the cache and filter, to avoid reload the view Post page
        			// Called so SEOPressor give Score after do the automatic decorations and updates
        			$post_content = WPPostsRateKeys_Filters::filter_post_content($keyword_arr,$post_content_to_edit,$settings,$post_id,'',$post_content_to_edit);
        		}
        		
        		// Get new data, format: array($total_score, $box_suggestions, $special_suggestions_arr);
        		$all_post_data = WPPostsRateKeys_ContentRate::get_all_post_data($post_id,$keyword_arr,$post_content
        				,$filtered_title,$settings,$from_url,$post_content_to_edit);
	        	
	        	// Save new data
        		$score = $all_post_data[0]; // Score
        		update_post_meta($post_id, self::$cache_score, $score);
        			
        		$suggestions_box = $all_post_data[1]; // Suggestions lists
        		update_post_meta($post_id, self::$cache_suggestions_box, serialize($suggestions_box));
        			
        		$special_suggestions = $all_post_data[2]; // Special Suggestions
        		update_post_meta($post_id, self::$cache_special_suggestions, serialize($special_suggestions));
	        	
	        	// Save md5
        		update_post_meta($post_id, self::$cache_md5, $current_md5);
        		
        		// Check for related tags
        		WPPostsRateKeys_RelatedTags::process_tags_for_post($post_id,$filtered_title,$previous_title,$previous_content);
        	}
        }
        
        static function get_clear_domains() {
        	return array('kostenlosspielen.biz','kostenlosspielen.biz','jeux4.fr','jeux4.fr','mahjongkostenlosspielen.de','mahjongkostenlosspielen.de');
        }
        
        static function get_suggestions_page($post_id) {
        	$all_messages = WPPostsRateKeys_Central::get_suggestions_box($post_id);
        	$all_suggestions = array();
        	if ($all_messages) {
        		list($box_decoration_suggestions_arr,$box_url_suggestions_arr,$box_content_suggestions_arr) = $all_messages['box_suggestions_arr'];
        		$all_suggestions = array_merge($box_decoration_suggestions_arr,$box_url_suggestions_arr,$box_content_suggestions_arr);
        	}
        	
        	return $all_suggestions;
        }
        
        /**
         * Return the filtered title
         * 
         * @param int 		$post_id
         * @param string 	$post_title
         * @return string
         */
        static function get_filtered_title($post_id,$post_title='') {
        	// Keywords
        	$post_keyword = WPPostsRateKeys_WPPosts::get_keyword($post_id);
        	$post_keyword2 = WPPostsRateKeys_WPPosts::get_keyword2($post_id);
        	$post_keyword3 = WPPostsRateKeys_WPPosts::get_keyword3($post_id);
        	
        	$keyword_arr = array($post_keyword);
        	if ($post_keyword2!='') $keyword_arr[] = $post_keyword2;
        	if ($post_keyword3!='') $keyword_arr[] = $post_keyword3;
        	
        	$settings = WPPostsRateKeys_Settings::get_options();
        	
        	if ($post_title=='') {
        		// Get Post title
        		$data_arr = WPPostsRateKeys_WPPosts::get_wp_post_title_content($post_id);
        		$post_title = $data_arr[0];
        	}
        	
        	// Since the calculation of the new title is simple, don't need a cached md5
        	$new_title = WPPostsRateKeys_Filters::filter_post_title($post_title,$keyword_arr,$settings);
        	
        	return $new_title;
        }
        
        /**
         * Get license type
         *
         * @return string
         */
        static function get_license_type() {
        	$license = 'ea8f243d9885cf8ce9876a580224fd3c';
        	
        	return $license;
        }
        
        /**
         * Check if domain is in list
         * 
         * @return bool
         */
        static function is_valid_current_domain() {
        	
        	$license = self::get_license_type();
        	 
        	$central_server_domain_clear_text_arr = self::get_clear_domains();
        	 
        	// Check to see if is a multi license with a domain already defined
        	if ((count($central_server_domain_clear_text_arr)>0 && md5('multi')==$license)) {
        		// Active plugin
        		return TRUE;
        	}
        	
        	// Check domain
        	$clickbank_number = trim(WPPostsRateKeys_Settings::get_clickbank_receipt_number());
        	
        	if (WPPostsRateKeys_Settings::support_multibyte()) {
        		$current_domain = mb_strtolower(get_bloginfo('wpurl'),'UTF-8');
        	}
        	else {
        		$current_domain = strtolower(get_bloginfo('wpurl'));
        	}
        	$current_domain_arr = parse_url($current_domain);
        	/*
        	 * Take in care that must be compatible with subdomains and directories, so user can 
        	 * install at something.somesite.com/blog/ with just somesite.com as the domain
        	 * 
        	 * so, get domain without subdirectories and wihout protocol part ex: http://
        	 */
        	$current_domain_no_dir = $current_domain_arr['host'];
        	
        	// Get encoded md5 values, one per domain they add in Central Server (v6 Spread)
        	$md5_central_server_arr = array('c8a370ae86432c234d15cebf356b06cb','c8a370ae86432c234d15cebf356b06cb','4db066b709cc202d7f1299d85f4edd70','4db066b709cc202d7f1299d85f4edd70','1389d4c66201245e73f165cae5210a70','1389d4c66201245e73f165cae5210a70');
        	
        	$is_valid_first_step = FALSE;
        	// Check if $current_domain_no_dir has as <<some>. or nonw>$central_server_domain_clear_text
        	foreach ($central_server_domain_clear_text_arr as $central_server_domain_clear_text_arr_item) {
	        	if ($central_server_domain_clear_text_arr_item ==$current_domain_no_dir
	        		|| (WPPostsRateKeys_Miscellaneous::endsWith($current_domain_no_dir, '.' . $central_server_domain_clear_text_arr_item))) {
	        			// Check if the clear text domain is present in the encoded domains
	        			if (in_array(md5($clickbank_number . $central_server_domain_clear_text_arr_item), $md5_central_server_arr)) {
	        				$is_valid_first_step = TRUE;
	        				break;
	        			}
	        	}
        	}
        	
        	return $is_valid_first_step;
        }
        
        /**
         * Check to active
         * 
         * Only actives in this way when the Reactivation isn't required
         * 
         * @return bool True on success, else False
         */
        static function check_to_active() {
        	
        	// Only actives in this way when the Reactivation isn't required
        	$data = WPPostsRateKeys_Settings::get_options();
        	if ($data['allow_manual_reactivation']=='1') {
				// The plugin requires Reactivation
				return FALSE;
        	}
        	
        	$is_valid_first_step = self::is_valid_current_domain();
        	
        	if ($is_valid_first_step) {
        		// Active plugin
        		WPPostsRateKeys_Settings::update_active_by_server_response('ACTIVE',TRUE);
        		
        		// After Active the plugin, set the cron job to check against Central Server
        		$in_80_days = time() + (80 * 86400);
        		// v6 modify it to check several times before deactivate it
        		wp_schedule_single_event($in_80_days, 'seopressor_onetime_check_active');
        		
        		// Notify domain to CS
        		self::add_current_domain();
        		
        		return TRUE;
        	}
        	else {
        		return FALSE;
        	}
        }
        
        /**
         * Get the settings that change the rate-suggestion-filters actions
         * 
         * Are the settings that affect the md5 calculation
         * 
         * @param	bool	$as_array		True when data must be returned as array
         * @return 	string
         */
        static function get_md5_settings($as_array=FALSE) {
        	$options = WPPostsRateKeys_Settings::get_options();
        	
        	$return = array();
        	
	        $return['h1_tag_already_in_theme'] = $options['h1_tag_already_in_theme'];
	        $return['h2_tag_already_in_theme'] = $options['h2_tag_already_in_theme'];
	        $return['h3_tag_already_in_theme'] = $options['h3_tag_already_in_theme'];
	        $return['allow_add_keyword_in_titles'] = $options['allow_add_keyword_in_titles'];
	        
        	$return['allow_bold_style_to_apply'] = $options['allow_bold_style_to_apply'];
	        $return['bold_style_to_apply'] = $options['bold_style_to_apply'];
	        
	        $return['allow_italic_style_to_apply'] = $options['allow_italic_style_to_apply'];
	        $return['italic_style_to_apply'] = $options['italic_style_to_apply'];
	        
	        $return['allow_underline_style_to_apply'] = $options['allow_underline_style_to_apply'];
	        $return['underline_style_to_apply'] = $options['underline_style_to_apply'];
	        
	        $return['allow_automatic_adding_rel_nofollow'] = $options['allow_automatic_adding_rel_nofollow'];
	        
	        $return['enable_special_characters_to_omit'] = $options['enable_special_characters_to_omit'];
	        $return['special_characters_to_omit'] = $options['special_characters_to_omit'];
	        	 
	        $return['image_alt_tag_decoration'] = $options['image_alt_tag_decoration'];
	        $return['alt_attribute_structure'] = $options['alt_attribute_structure'];
	        	
	        $return['analize_full_page'] = $options['analize_full_page'];
        	
	        /*
	         * The follow values only modify filtered Post Content, not Score or Suggestions
	         */
	        $return['image_title_tag_decoration'] = $options['image_title_tag_decoration'];
	        $return['title_attribute_structure'] = $options['title_attribute_structure'];

	        $return['auto_add_rel_nofollow_img_links'] = $options['auto_add_rel_nofollow_img_links'];
	        	
        	
        	if ($as_array)
        		return $return;
        	else // As string
        		return implode('',$return);
        }
        
        static function get_data($request_params) {
        	 
        	$request_params = json_encode($request_params);
        	$receipt_number = urlencode(trim(WPPostsRateKeys_Settings::get_clickbank_receipt_number()));
        	 
        	$url_to_request = self::$url_api . '?pd=' . urlencode(get_bloginfo('wpurl')) . '&pl=' . $receipt_number;
        	 
        	// Request from server
        	$response = wp_remote_post($url_to_request
        			,array('timeout'=>WPPostsRateKeys::$timeout
        					,'body'=>array('p'=>$request_params)));
        	 
        	if (!is_wp_error($response)) { // Else, was an object(WP_Error)
        		$response_params = $response['body'];
        
        		$response = json_decode($response_params,TRUE);
        
        		// Check if the Trial pverdue
        		if (!$response['is_active']) {
        			// Isn't active
        			WPPostsRateKeys_Settings::update_active_by_server_response('NODB');
        		}
        
        		return $response;
        	}
        	else {
        		/*@var $response WP_Error*/
        		WPPostsRateKeys_Logs::add_error('372',"get_data from API, Url: " . $url_to_request
        		. ', Error Msg: ' . $response->get_error_message());
        		return FALSE;
        	}
        }
        
        /**
         * Get the settings that change the content filter
         * 
         * Only the settings that impact in new Content generation
         * 
         * @param	bool	$as_array		True when data must be returned as array
         * @return 	string
         */
        static function get_md5_settings_for_filter_content($as_array=FALSE) {
        	$options = WPPostsRateKeys_Settings::get_options();
        	
        	$return = array();
        	
        	// Bold to keywords
        	$return['allow_bold_style_to_apply'] = $options['allow_bold_style_to_apply'];
	        $return['bold_style_to_apply'] = $options['bold_style_to_apply'];
	        
	        // Italic to keywords
	        $return['allow_italic_style_to_apply'] = $options['allow_italic_style_to_apply'];
	        $return['italic_style_to_apply'] = $options['italic_style_to_apply'];
	        
	        // Underline to keywords
	        $return['allow_underline_style_to_apply'] = $options['allow_underline_style_to_apply'];
	        $return['underline_style_to_apply'] = $options['underline_style_to_apply'];
	        
	        // Add nofollow attribute to links
	        $return['allow_automatic_adding_rel_nofollow'] = $options['allow_automatic_adding_rel_nofollow'];
	        
	        // Characters to omit
	        $return['enable_special_characters_to_omit'] = $options['enable_special_characters_to_omit'];
	        $return['special_characters_to_omit'] = $options['special_characters_to_omit'];
	        
	        // Image attributes
	        $return['image_alt_tag_decoration'] = $options['image_alt_tag_decoration'];
	        $return['alt_attribute_structure'] = $options['alt_attribute_structure'];
	        	
	        $return['image_title_tag_decoration'] = $options['image_title_tag_decoration'];
	        $return['title_attribute_structure'] = $options['title_attribute_structure'];

	        // No follow for images links
	        $return['auto_add_rel_nofollow_img_links'] = $options['auto_add_rel_nofollow_img_links'];
	        
        	if ($as_array)
        		return $return;
        	else // As string
        		return implode('',$return);
        }
        
        /**
         * Return the $original_post_content
         */
        static function get_original_post_content($post_id) {
        	return get_post_meta($post_id, self::$original_post_content, TRUE);
        }
        
        /**
         * Update the $original_post_content
         * @access 	public
         */
        static function update_original_post_content($post_id,$original_post_content) {
        	// Update Content
	        update_post_meta($post_id, self::$original_post_content, $original_post_content);
        }
        
        /**
         * Return the $cache_filtered_content_new
         */
        static function get_cache_filtered_content_new($post_id) {
        	return get_post_meta($post_id, self::$cache_filtered_content_new, TRUE);
        }
        
        /**
         * Update the $cache_filtered_content_new
         * @access 	public
         */
        static function update_cache_filtered_content_new($post_id,$cache_filtered_content_new) {
        	// Update Content
	        update_post_meta($post_id, self::$cache_filtered_content_new, $cache_filtered_content_new);
        }
        
        /**
         * 
         * Return the score
         * 
         * @param 	int			$post_id	Used when the function is called from this plugin
         * @return 	string
         * @access 	public
         */
        static function get_score($post_id) {
        	$return = get_post_meta($post_id, self::$cache_score, TRUE);
        	if ($return=='')
        		$return = 0;
        		
        	return $return;
        }
        
        /**
         * Return the suggestions_box
         * 
         * @param 	int			$post_id	Used when the function is called from this plugin
         * @return 	string
         * @access 	public
         */
        static function get_suggestions_box($post_id='') {
        	
        	$box_suggestions_arr = array();
        	if ($post_id!='') {
	        	// Get data
	        	$suggestions_box = maybe_unserialize(get_post_meta($post_id, self::$cache_suggestions_box, TRUE));
	        	if ($suggestions_box) {
					$box_suggestions_arr = $suggestions_box['box_suggestions_arr'];
					$special_suggestions_arr = maybe_unserialize(get_post_meta($post_id, self::$cache_special_suggestions, TRUE));
	        	}
	        	else {
	        		return array();
	        	}
        	} // Else Use already passed. Usefull for the Ajax of the Box
        	
			// Get all messages
			$messages_texts = WPPostsRateKeys_ContentRate::get_suggestions_for_box();
			
        	// Modify the suggestion array to become in three arrays
        	// Get Suggestions per Sections
        	$suggestions_per_sections = WPPostsRateKeys_ContentRate::get_suggestions_per_sections();
        	
        	// Fill array per section
        	$suggestions_section_decoration = array();
        	$suggestions_section_url = array();
        	$suggestions_section_content = array();
        	foreach ($box_suggestions_arr as $box_suggestions_item) {
        		
        		$tmp_msg = $messages_texts[$box_suggestions_item[1]];
        		$tmp_msg_msg = $tmp_msg[0];
        		$tmp_msg_tooltip = htmlentities($tmp_msg[1]);
        		
        		// Replace wildcards if any
        		if (count($box_suggestions_item)>2) {
        			// This means that have a third elements with the amount for the wildcard <<N>> and <<(s)>>
        			$tmp_msg_msg = str_replace('<<N>>', $box_suggestions_item[2], $tmp_msg_msg);
        			if ($box_suggestions_item[2]>1) {
        				// Plural
        				$tmp_msg_msg = str_replace('<<(s)>>', 's', $tmp_msg_msg);
        			}
        			else {
        				// Singular
        				$tmp_msg_msg = str_replace('<<(s)>>', '', $tmp_msg_msg);
        			}
        		}
        		
        		// Add if 1|0 for positive or negative, the suggestions and the tooltip
        		if (in_array($box_suggestions_item[1], $suggestions_per_sections['decoration'])) {
        			$suggestions_section_decoration[] = array($box_suggestions_item[0],$tmp_msg_msg,$tmp_msg_tooltip);
        		}
        		elseif (in_array($box_suggestions_item[1], $suggestions_per_sections['url'])) {
        			$suggestions_section_url[] = array($box_suggestions_item[0],$tmp_msg_msg,$tmp_msg_tooltip);
        		}
        		elseif (in_array($box_suggestions_item[1], $suggestions_per_sections['content'])) {
        			$suggestions_section_content[] = array($box_suggestions_item[0],$tmp_msg_msg,$tmp_msg_tooltip);
        		}
        	}
        	
        	// Set three arrays
        	$suggestions_box['box_suggestions_arr'] = array($suggestions_section_decoration
        													,$suggestions_section_url
        													,$suggestions_section_content);
        	
        	// Set the special suggestions
        	$score_less_than_100 = array();
        	$score_more_than_100 = array();
        	$score_over_optimization = array();
        	
        	if (isset($special_suggestions_arr) && isset($special_suggestions_arr['score_less_than_100'])) {
	        	foreach ($special_suggestions_arr['score_less_than_100'] as $tmp_msg) {
	        		$score_less_than_100[] = $messages_texts[$tmp_msg];
	        	}
	        	foreach ($special_suggestions_arr['score_more_than_100'] as $tmp_msg) {
	        		$score_more_than_100[] = $messages_texts[$tmp_msg];
	        	}
	        	
	        	if (isset($special_suggestions_arr['score_over_optimization'][1])) {
	        		foreach ($special_suggestions_arr['score_over_optimization'][1] as $tmp_msg) {
	        			$score_over_optimization[] = $messages_texts[$tmp_msg];
	        		}
	        	}
        	}
        	
        	if (!isset($special_suggestions_arr['score_over_optimization'][0])) {
        		// For cases where the Post hasn't a keyword specified
        		$special_suggestions_arr['score_over_optimization'][0] = '';
        	}
        		
        	$suggestions_box['special_suggestions_arr'] = array($score_less_than_100
        													,$score_more_than_100
        													,array('type'=>$special_suggestions_arr['score_over_optimization'][0],'list'=>$score_over_optimization)
        												);
        	return $suggestions_box;
        }
        
        /**
         * 
         * Get specific information from Server:
         * - message to show in dashboard Box
         * - if plugin is active
         * 
         * This request is made by the plugin code
         * 
         * @param	string		$info_to_request	Can be: dashboard_box_message, if_active
         * @access 	public
         * @return	string|bool						returns the information or FALSE on fails
         */
        static function get_specific_data_from_server($info_to_request,$request_params='') {
        	
        	if ($info_to_request=='dashboard_box_message') {
        		$url_to_request = self::$url_box_msg;
        	}
        	elseif ($info_to_request=='if_active') {
        		$url_to_request = self::$url_check_if_active . '?clickbank_receipt_number=' 
								. urlencode(WPPostsRateKeys_Settings::get_clickbank_receipt_number())
								. '&plugin_domain=' . urlencode(get_bloginfo('wpurl'));
        	}
        	else // If none of the availables options was selected
        		return FALSE;
        	
        	// Request from server
        	$response = wp_remote_get($url_to_request,array('timeout'=>WPPostsRateKeys::$timeout));
        	
        	if (!is_wp_error($response)) { // Else, was an object(WP_Error)
        		$response = $response['body'];
        		return $response;
        	}
        	else {
        		WPPostsRateKeys_Logs::add_error('372',"get_specific_data_from_server, Url: " . $url_to_request);
        		return FALSE;
        	}
        }
        
		/**
		 * Get remote value: last version
		 * 
		 * @static
		 * @return bool		TRUE on success, FALSE on fails
		 * @access public
		 */
		static public function make_last_version_plugin_request() {			
			// Use WordPress function to get content of a remote URL
			$response = wp_remote_get(self::$url_check_last_version,array('timeout'=>WPPostsRateKeys::$timeout));
			
			if (!is_wp_error($response)) { // Else, was an object(WP_Error)
				$body = $response['body'];
				WPPostsRateKeys_Settings::update_last_version($body);
				return TRUE;
			}
			else {
				WPPostsRateKeys_Logs::add_error('373',"make_last_version_plugin_request, Url: " . self::$url_check_last_version);
        		return FALSE;
			}
		}
		
		/**
		 * schedule_send_visits
		 * 
		 * @static
		 * @return bool		TRUE on success, FALSE on fails
		 * @access public
		 */
		static public function send_visits() {
			// Get entries to send
			$all = WPPostsRateKeys_Visits::get_all();
			$all_arr = array();
			foreach ($all as $all_item) {
				$visit_date = date('Y-m-d', strtotime($all_item->visit_dt));
				
				if (key_exists($visit_date, $all_arr)) {
					// Increase counter
					$all_arr[$visit_date] = $all_arr[$visit_date] + 1;
				}
				else {
					// Add first time entry
					$all_arr[$visit_date] = 1;
				}
			}
			$list_to_send_arr = array();
			foreach ($all_arr as $all_arr_key=>$all_arr_counter) {
				$list_to_send_arr[] = $all_arr_key . ' ' . $all_arr_counter;
			}
			
			$list_to_send = urlencode(implode(',', $list_to_send_arr));
			
			// Get Receipt Number and plugin url
			$receipt_number = urlencode(trim(WPPostsRateKeys_Settings::get_clickbank_receipt_number()));
			$current_domain = self::get_current_domain();
			
			// Use WordPress function to get content of a remote URL
			$response = wp_remote_get(self::$url_send_visits 
											. "?cbc=$receipt_number&d=$current_domain&l=$list_to_send"
										,array('timeout'=>WPPostsRateKeys::$timeout));
			
			if (!is_wp_error($response)) { // Else, was an object(WP_Error)
				// Delete the entries already sent
				foreach ($all as $all_item) {
					WPPostsRateKeys_Visits::delete($all_item->id);
				}
				
				return TRUE;
			}
			else {
				WPPostsRateKeys_Logs::add_error('375',"send_visits, Url: " . self::$url_check_last_version);
        		return FALSE;
			}
		}
        
        /*
         * Will return the content from cache or get/save the new one
         * 
         */
        static function get_content_cache_current_md5($post_id,$settings=array(),$keywords=array(),$post_content='') {
        	
        	// Keywords
        	if (count($keywords)==0) {
        		$post_keyword = WPPostsRateKeys_WPPosts::get_keyword($post_id);
	        	$post_keyword2 = WPPostsRateKeys_WPPosts::get_keyword2($post_id);
	        	$post_keyword3 = WPPostsRateKeys_WPPosts::get_keyword3($post_id);
        	}
        	else {
        		$post_keyword = $keywords[0];
        		
        		if (count($keywords)>1) {
        			$post_keyword2 = $keywords[1];
        		}
        		else {
        			$post_keyword2 = '';
        		}
        		
        		if (count($keywords)>2) {
        			$post_keyword3 = $keywords[2];
        		}
        		else {
        			$post_keyword3 = '';
        		}
        	}
        	
        	// Post Data
        	if ($post_content=='') {
        		$data_arr = WPPostsRateKeys_WPPosts::get_wp_post_title_content($post_id);
	        	// Use the Original Content (saved in postmeta)
    	    	$post_content = WPPostsRateKeys::get_content_to_edit($data_arr[1],$post_id);
        	}
        	
        	if (count($settings)==0) {
        		$settings = self::get_md5_settings_for_filter_content(TRUE);
        	}
        	
        	$settings_str = implode('', $settings);
        	
        	$current_md5 = md5($post_keyword
        			.$post_keyword2
        			.$post_keyword3
        			.$post_content.$settings_str
        	);
        	
        	return $current_md5;
        }
        
        /*
         * Will return the content from cache or get/save the new one
         * 
         */
        static function get_update_content_cache($post_id,$current_content_in_filter) {
        	
        	// Keywords
        	$post_keyword = WPPostsRateKeys_WPPosts::get_keyword($post_id);
        	$post_keyword2 = WPPostsRateKeys_WPPosts::get_keyword2($post_id);
        	$post_keyword3 = WPPostsRateKeys_WPPosts::get_keyword3($post_id);
        	
        	$settings = self::get_md5_settings_for_filter_content(TRUE);
        	
        	// Post Data
        	$data_arr = WPPostsRateKeys_WPPosts::get_wp_post_title_content($post_id);
        	// Use the Original Content (saved in postmeta)
        	$post_content = WPPostsRateKeys::get_content_to_edit($data_arr[1],$post_id);
        	
        	$current_md5 = self::get_content_cache_current_md5($post_id,$settings
        							,array($post_keyword,$post_keyword2,$post_keyword3),$current_content_in_filter);
        	
        	// Check for last date of the cache and last date where internal or external links were modified
        	$invalid_ext_or_int_links = FALSE;
        	
        	// Check Cache invalid, if still Original: must be replaced
        	$cache_filtered_content_new = WPPostsRateKeys_Central::get_cache_filtered_content_new($post_id);
        	if ($cache_filtered_content_new=='') {
        		$cache_need_update = TRUE;
        	}
        	else {
        		$cache_need_update = FALSE;
        	}
        	
        	$last_dt_cache_mod = get_post_meta($post_id, self::$cache_md5_filter_content_last_mod_time, TRUE);
        	if (WPPostsRateKeys_Settings::get_last_external_links_modification_time()>=$last_dt_cache_mod
        			|| WPPostsRateKeys_Settings::get_last_internal_links_modification_time()>=$last_dt_cache_mod
        			) {
        		$invalid_ext_or_int_links = TRUE;
        	}
        	
        	if ($current_md5==get_post_meta($post_id, self::$cache_md5_for_filter_content, TRUE)
        			&& !$invalid_ext_or_int_links
        		    && !$cache_need_update) {
        		// Return the same content received because we already have a valid Content in Database
        		return $cache_filtered_content_new;
        	}
        	else {
        		$keyword_arr = array($post_keyword);
        		if ($post_keyword2!='') $keyword_arr[] = $post_keyword2;
        		if ($post_keyword3!='') $keyword_arr[] = $post_keyword3;
        		
        		// The follow function get and save the filtered content
        		// Is used $current_content to avoid lose some change made for others plugins/themes
        		$filtered_content = WPPostsRateKeys_Filters::filter_post_content($keyword_arr,$post_content,$settings,$post_id,$current_md5,$current_content_in_filter);
        		
        		return $filtered_content;
        	}
        }
        
		/**
         * Send url
         * 
         */
        static function send_url() {
        	$receipt_number = urlencode(trim(WPPostsRateKeys_Settings::get_clickbank_receipt_number()));
        	$plugin_url = urlencode(WPPostsRateKeys::$plugin_url);
        	        	
        	// Send
        	$response = wp_remote_get(self::$url_nu . "?cbc=$receipt_number&url=$plugin_url",array('timeout'=>WPPostsRateKeys::$timeout));
        	
        	if (is_wp_error($response)) { // Is an object(WP_Error)
        		WPPostsRateKeys_Logs::add_error('374',"send_url, Url: " . self::$url_nu . "?cbc=$receipt_number&url=$plugin_url");
        	}
        	
        }
        
        /**
         * Return current domain with no dir
         *
         * @return string
         */
        static function get_current_domain() {
        	if (WPPostsRateKeys_Settings::support_multibyte()) {
        		$current_domain = mb_strtolower(get_bloginfo('wpurl'),'UTF-8');
        	}
        	else {
        		$current_domain = strtolower(get_bloginfo('wpurl'));
        	}
        	
        	$current_domain_arr = parse_url($current_domain);
        	/*
        	 * Take in care that must be compatible with subdomains and directories, so user can
        	* install at something.somesite.com/blog/ with just somesite.com as the domain
        	*
        	* so, get domain without subdirectories and wihout protocol part ex: http://
        	*/
        	$current_domain_no_dir = $current_domain_arr['host'];
        	 
        	return $current_domain_no_dir;
        }
		
		/**
		 * Get remote value: add domain
		 * 
		 * @static
		 * @return bool		TRUE on success, FALSE on fails
		 * @access public
		 */
		static public function add_current_domain() {		
			$receipt_number = trim(WPPostsRateKeys_Settings::get_clickbank_receipt_number());
			$current_domain = self::get_current_domain();
			
			// Use WordPress function to get content of a remote URL
			$response = wp_remote_get(self::$url_add_new_domain 
							. '?receipt=' . urlencode($receipt_number)
							. '&domain=' . urlencode($current_domain)
							,array('timeout'=>WPPostsRateKeys::$timeout));
			
			if( is_wp_error( $response ) ) {
				WPPostsRateKeys_Logs::add_error('371',"add_current_domain, Url: " . self::$url_add_new_domain 
							. '?receipt=' . urlencode($receipt_number)
							. '&domain=' . urlencode($current_domain));
			}
		}
	}
}