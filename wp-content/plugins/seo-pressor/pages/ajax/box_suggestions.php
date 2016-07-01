<?php
/**
 * Page to handle all Ajax requests from the Suggestions Box
 * All data will be returned using JSON format
 * 
 * General variables:
 * 
 * @uses	$_REQUEST['object']			required
 * 
 * Return data
 * 
 * @return	$data_to_return	if JSON format
 * @example	of data to return
 * 		$data_to_return = array(
				array('message'=>'Deleted successfully.', 'type'=>'notification')
		);
		$data_to_return = array(
				array('message'=>'Error in DB query.', 'type'=>'error')
		);
	
	http://<server test>/wp-content/plugins/seo-pressor/pages/ajax/box_suggestions.php?WPPostsRateKeys_keyword=seopressor&WPPostsRateKeys_keyword2=&WPPostsRateKeys_keyword3=&allow_keyword_overriding_in_sentences=&allow_meta_description=&allow_meta_keyword=&content=soy%20lety%0A&key_in_first_sentence=&key_in_last_sentence=&meta_description=&object=box&post_id=72&title=lety
	
 */

/** Loads the WordPress Environment */
if (!class_exists('WPPostsRateKeys')) {
	require(dirname(__FILE__) . '/../../../../../wp-load.php');
}

if (isset($_REQUEST['object'])) {
	/*
	 * Return the data that will be shown in the Box Content 
	 */
	if ($_REQUEST['object']=='box') {
		
		$post_id = $_REQUEST['post_id'];
		
		// Include to process the request and store to database
		include(WPPostsRateKeys::$plugin_dir . '/includes/internal/process_post_data.php');
		
		/*
		 * Return Data
		 */
		$data_to_return = array();
		$data_to_return['message'] = __('Data retrieved successfully','seo-pressor');
		$data_to_return['type'] = 'notification';
		
		// Return the LSI values
		$lsi_arr = array();
		// Check first if the API key is valid
		if ($settings['lsi_bing_api_key_is_valid']=='1') {
			$lsi_message = '';
			
			if ($keyword!='') {
				$tmp_arr = WPPostsRateKeys_LSI::get_lsi_by_keyword($keyword);
				if (count($tmp_arr)==0) {
					$tmp_msg = __('There is no LSI related to the keyword.','seo-pressor');
				}
				else {
					$tmp_msg = '';
				}
				
				$lsi_arr[WPPostsRateKeys_Validator::parse_output($keyword)] = array('message'=>$tmp_msg,'list'=>$tmp_arr);
			}
			if (isset($keyword2)) {
				$tmp_arr = WPPostsRateKeys_LSI::get_lsi_by_keyword($keyword2);
				if (count($tmp_arr)==0) {
					$tmp_msg = __('There is no LSI related to the keyword.','seo-pressor');
				}
				else {
					$tmp_msg = '';
				}
				$lsi_arr[WPPostsRateKeys_Validator::parse_output($keyword2)] = array('message'=>$tmp_msg,'list'=>$tmp_arr);
			}
			if (isset($keyword3)) {
				$tmp_arr = WPPostsRateKeys_LSI::get_lsi_by_keyword($keyword3);
				if (count($tmp_arr)==0) {
					$tmp_msg = __('There is no LSI related to the keyword.','seo-pressor');
				}
				else {
					$tmp_msg = '';
				}
				$lsi_arr[WPPostsRateKeys_Validator::parse_output($keyword3)] = array('message'=>$tmp_msg,'list'=>$tmp_arr);
			}
		}
		else {
			if ($keyword!='') {
				$lsi_message = __('In order to get the LSI you should go to ','seo-pressor') 
						. '<a href="' . get_admin_url() . 'admin.php?page=seo-pressor.php' 
						. '" target="_blank" >Settings/Advanced/LSI Settings</a>'
						. __(' tab and specify a valid Bing API Key.','seo-pressor');
			}
			else {
				$lsi_message = '';
			}
		}
		
		$data_to_return['lsi'] = array(
					'message' => $lsi_message
					,'list' => $lsi_arr
				);
		
		// Return numbers with two decimal points only if there is any decimal value
		$score_value = number_format($score_value,2);
		$score_value = str_replace('.00', '', $score_value);
		$keyword_density_value  = number_format($keyword_density_value,2);
		$keyword_density_value = str_replace('.00', '', $keyword_density_value);
		
		$data_to_return['score'] = array('type'=>$score_pos_neg,'value'=>$score_value);
		$data_to_return['keyword_density'] = array('type'=>$keyword_density_pos_neg,'value'=>$keyword_density_value);
		$data_to_return['suggestions'] = array('decoration'=>$box_decoration_suggestions_arr
												,'url'=>$box_url_suggestions_arr
												,'content'=>$box_content_suggestions_arr
												,'score_less_than_100'=>$score_less_than_100_arr
												,'score_more_than_100'=>$score_more_than_100_arr
												,'score_over_optimization'=>$score_over_optimization_arr
				);

		$keywors_arr = array($keyword);
		if (isset($keyword2)) {
			$keywors_arr[] = $keyword2;
		}
		if (isset($keyword3)) {
			$keywors_arr[] = $keyword3;
		}
		
		if ($first_query==='true') {
			
			// Social SEO
			$post_url = get_permalink( $post_id );
			$post_title = get_the_title( $post_id );
			
			if (!isset($post)) {
				$post = get_post($post_id);
			}
			
			if ( has_excerpt( $post_id ) ) {
				$meta_description = strip_tags( get_the_excerpt( ) );
			} else {
				if (WPPostsRateKeys_Settings::support_multibyte()) {
					$meta_description = str_replace( "\r\n", ' ' , mb_substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, 160,'UTF-8' ) );
				}
				else {
					$meta_description = str_replace( "\r\n", ' ' , substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, 160 ) );
				}
				$meta_description .= '(...)';
			}
			$twitter_card = get_the_author_meta( 'seopressor_twitter_user_card', $post->post_author );
			
			$data_to_return['settings'] = array(
				'settings' => array(
					'allow_meta_keyword'=>WPPostsRateKeys_WPPosts::get_allow_meta_keyword($post_id)
					,'use_for_meta_keyword'=>WPPostsRateKeys_WPPosts::get_use_for_meta_keyword($post_id)
					,'allow_meta_description'=>WPPostsRateKeys_WPPosts::get_allow_meta_description($post_id)
					,'meta_description'=>WPPostsRateKeys_WPPosts::get_meta_description($post_id)
					,'allow_meta_title'=>WPPostsRateKeys_WPPosts::get_allow_meta_title($post_id)
					,'meta_title'=>WPPostsRateKeys_WPPosts::get_meta_title($post_id)
					,'allow_keyword_overriding_in_sentences'=>WPPostsRateKeys_WPPosts::get_allow_keyword_overriding_in_sentences($post_id)
					,'key_in_first_sentence'=>WPPostsRateKeys_WPPosts::setting_key_first_sentence($post_id)
					,'key_in_last_sentence'=>WPPostsRateKeys_WPPosts::setting_key_last_sentence($post_id)
				),
				'rich-snippets' => array(
					'google_rich_snippet_rating'=>get_post_meta($post_id, '_google_rich_snippet_rating', TRUE)
					,'google_rich_snippet_author'=>get_post_meta($post_id, '_google_rich_snippet_author', TRUE)
					,'google_rich_snippet_summary'=>get_post_meta($post_id, '_google_rich_snippet_summary', TRUE)
					,'google_rich_snippet_description'=>get_post_meta($post_id, '_google_rich_snippet_description', TRUE)

					,'seop_grs_event_url'=>get_post_meta($post_id, '_seop_grs_event_url', TRUE)
					,'seop_grs_event_name'=>get_post_meta($post_id, '_seop_grs_event_name', TRUE)
					,'seop_grs_event_startdate'=>get_post_meta($post_id, '_seop_grs_event_startdate', TRUE)
					,'seop_grs_event_location_name'=>get_post_meta($post_id, '_seop_grs_event_location_name', TRUE)
					,'seop_grs_event_location_address_streetaddress'=>get_post_meta($post_id, '_seop_grs_event_location_address_streetaddress', TRUE)
					,'seop_grs_event_location_address_addresslocality'=>get_post_meta($post_id, '_seop_grs_event_location_address_addresslocality', TRUE)
					,'seop_grs_event_location_address_addressregion'=>get_post_meta($post_id, '_seop_grs_event_location_address_addressregion', TRUE)

					,'seop_grs_people_name_given_name'=>get_post_meta($post_id, '_seop_grs_people_name_given_name', TRUE)
					,'seop_grs_people_name_family_name'=>get_post_meta($post_id, '_seop_grs_people_name_family_name', TRUE)
					,'seop_grs_people_home_url'=>get_post_meta($post_id, '_seop_grs_people_home_url', TRUE)
					,'seop_grs_people_locality'=>get_post_meta($post_id, '_seop_grs_people_locality', TRUE)
					,'seop_grs_people_region'=>get_post_meta($post_id, '_seop_grs_people_region', TRUE)
					,'seop_grs_people_title'=>get_post_meta($post_id, '_seop_grs_people_title', TRUE)
					,'seop_grs_people_photo'=>get_post_meta($post_id, '_seop_grs_people_photo', TRUE)

					,'seop_grs_product_name'=>get_post_meta($post_id, '_seop_grs_product_name', TRUE)
					,'seop_grs_product_image'=>get_post_meta($post_id, '_seop_grs_product_image', TRUE)
					,'seop_grs_product_description'=>get_post_meta($post_id, '_seop_grs_product_description', TRUE)
					,'seop_grs_product_offers'=>get_post_meta($post_id, '_seop_grs_product_offers', TRUE)

					,'seop_grs_recipe_name'=>get_post_meta($post_id, '_seop_grs_recipe_name', TRUE)
					,'seop_grs_recipe_yield'=>get_post_meta($post_id, '_seop_grs_recipe_yield', TRUE)
					,'seop_grs_recipe_author'=>get_post_meta($post_id, '_seop_grs_recipe_author', TRUE)
					,'seop_grs_recipe_photo'=>get_post_meta($post_id, '_seop_grs_recipe_photo', TRUE)
					,'seop_grs_recipe_nutrition_calories'=>get_post_meta($post_id, '_seop_grs_recipe_nutrition_calories', TRUE)
					,'seop_grs_recipe_nutrition_sodium'=>get_post_meta($post_id, '_seop_grs_recipe_nutrition_sodium', TRUE)
					,'seop_grs_recipe_nutrition_fat'=>get_post_meta($post_id, '_seop_grs_recipe_nutrition_fat', TRUE)
					,'seop_grs_recipe_nutrition_protein'=>get_post_meta($post_id, '_seop_grs_recipe_nutrition_protein', TRUE)
					,'seop_grs_recipe_nutrition_cholesterol'=>get_post_meta($post_id, '_seop_grs_recipe_nutrition_cholesterol', TRUE)
					,'seop_grs_recipe_total_time_minutes'=>get_post_meta($post_id, '_seop_grs_recipe_total_time_minutes', TRUE)
					,'seop_grs_recipe_cook_time_minutes'=>get_post_meta($post_id, '_seop_grs_recipe_cook_time_minutes', TRUE)
					,'seop_grs_recipe_prep_time_minutes'=>get_post_meta($post_id, '_seop_grs_recipe_prep_time_minutes', TRUE)
					,'seop_grs_recipe_ingredient'=>get_post_meta($post_id, '_seop_grs_recipe_ingredient', TRUE)

					// Social SEO
					,'og_type'=>'article'
					,'og_url'=>$post_url
					,'og_title'=>$post_title
					,'og_author'=>''
					,'og_publisher'=>''
					,'twitter_creator_site'=>$twitter_card
					,'twitter_url'=>$post_url
					,'twitter_title'=>$post_title
					,'twitter_description'=>esc_attr( apply_filters( 'meta_description', $meta_description ) )

					// Enable / Disable Settings
					,'seop_publish_rich_snippets'=>WPPostsRateKeys_WPPosts::get_meta_publish_rich_snippets($post_id)
					,'seop_enable_rich_snippets'=>WPPostsRateKeys_WPPosts::get_meta_enable_rich_snippets($post_id)
					,'seop_enable_socialseo_facebook'=>WPPostsRateKeys_WPPosts::get_meta_enable_socialseo_facebook($post_id)
					,'seop_enable_socialseo_twitter'=>WPPostsRateKeys_WPPosts::get_meta_enable_socialseo_twitter($post_id)
					,'seop_enable_dublincore'=>WPPostsRateKeys_WPPosts::get_meta_enable_dublincore($post_id)
					
				)
			);
		
			$data_to_return['seopressor_keywords'] = $keywors_arr;
		}
		
		$json = json_encode($data_to_return);
		echo $json;
		exit();
	}
}
