<?php
/**
 * 
 * @var 	int		$post_id
 */

@set_time_limit(120);

/*
 * Process new field
*/
if (isset($_REQUEST['first_query'])) {
	// This file is used from the call is from Ajax Request
	$is_ajax_request = TRUE;
	
	$first_query = $_REQUEST['first_query'];
}
else {
	// This file is used from the update post action hook
	$is_ajax_request = FALSE;
	
	$first_query = 'false'; // This means that the keywords are passed as part of the $_REQUEST variable
}

if ($first_query==='true') {
	// Get the keywords from database
	if ($post_id!='') {
		$_REQUEST['WPPostsRateKeys_keyword'] = WPPostsRateKeys_WPPosts::get_keyword($post_id);
		$_REQUEST['WPPostsRateKeys_keyword2'] = WPPostsRateKeys_WPPosts::get_keyword2($post_id);
		$_REQUEST['WPPostsRateKeys_keyword3'] = WPPostsRateKeys_WPPosts::get_keyword3($post_id);
		
		$allow_keyword_overriding_in_sentences = WPPostsRateKeys_WPPosts::get_allow_keyword_overriding_in_sentences($post_id);
		$key_in_first_sentence = WPPostsRateKeys_WPPosts::setting_key_first_sentence($post_id);
		$key_in_last_sentence = WPPostsRateKeys_WPPosts::setting_key_last_sentence($post_id);
	}
	else {
		$_REQUEST['WPPostsRateKeys_keyword'] = '';
		$_REQUEST['WPPostsRateKeys_keyword2'] = '';
		$_REQUEST['WPPostsRateKeys_keyword3'] = '';
		
		$allow_keyword_overriding_in_sentences = '0';
		$key_in_first_sentence = '0';
		$key_in_last_sentence = '0';
	}
}
else {
	// The keywords cames in a list, in variable: keywords
	$tmp_keywords_arr = (array) $_REQUEST['seopressor_keywords'];
	if (count($tmp_keywords_arr)>0 && trim($tmp_keywords_arr[0]!='')) {
		$_REQUEST['WPPostsRateKeys_keyword'] = $tmp_keywords_arr[0];
	}
	else {
		// Delete Key1
		WPPostsRateKeys_WPPosts::update_keyword($post_id, '');
	}
	if (count($tmp_keywords_arr)>1 && trim($tmp_keywords_arr[1]!='')) {
		$_REQUEST['WPPostsRateKeys_keyword2'] = $tmp_keywords_arr[1];
	}
	else {
		// Delete Key2
		WPPostsRateKeys_WPPosts::update_keyword2($post_id, '');
	}
	if (count($tmp_keywords_arr)>2 && trim($tmp_keywords_arr[2]!='')) {
		$_REQUEST['WPPostsRateKeys_keyword3'] = $tmp_keywords_arr[2];
	}
	else {
		// Delete Key3
		WPPostsRateKeys_WPPosts::update_keyword3($post_id, '');
	}
	
	if (isset($_REQUEST['allow_keyword_overriding_in_sentences']) && $_REQUEST['allow_keyword_overriding_in_sentences']=='1') {
		$allow_keyword_overriding_in_sentences = '1';
	}
	else {
		$allow_keyword_overriding_in_sentences = '0';
	}
	
	if (isset($_REQUEST['key_in_first_sentence']) && $_REQUEST['key_in_first_sentence']=='1') {
		$key_in_first_sentence = '1';
	}
	else {
		$key_in_first_sentence = '0';
	}
	
	if (isset($_REQUEST['key_in_last_sentence']) && $_REQUEST['key_in_last_sentence']=='1') {
		$key_in_last_sentence = '1';
	}
	else {
		$key_in_last_sentence = '0';
	}
}

// Will be processed the temporal keyword, title and content that user doesn't Update yet
$keyword = trim($_REQUEST['WPPostsRateKeys_keyword']);
$title = (isset($_REQUEST['post_title']))?$_REQUEST['post_title']:$_REQUEST['title'];
$content = $_REQUEST['content'];
$post_name = $_REQUEST['post_name'];

// Possible Keyword 2
if (isset($_REQUEST['WPPostsRateKeys_keyword2']) && trim($_REQUEST['WPPostsRateKeys_keyword2'])!='') {
	$keyword2 = trim($_REQUEST['WPPostsRateKeys_keyword2']);
}

// Possible Keyword 3
if (isset($_REQUEST['WPPostsRateKeys_keyword3']) && trim($_REQUEST['WPPostsRateKeys_keyword3'])!='') {
	$keyword3 = trim($_REQUEST['WPPostsRateKeys_keyword3']);
}

/*
 * Save meta keywords and description settings
 * Only If $post_id is specified: not save the values in case the Post isn't saved yet
 */
if ($post_id!='' && $first_query!=='true') {
	
	// Save first and last sentence Settings
	WPPostsRateKeys_WPPosts::update_allow_keyword_overriding_in_sentences($post_id, $allow_keyword_overriding_in_sentences);
	WPPostsRateKeys_WPPosts::update_setting_key_first_sentence($post_id, $key_in_first_sentence);
	WPPostsRateKeys_WPPosts::update_setting_key_last_sentence($post_id, $key_in_last_sentence);
	
	/*
	 * Process the Settings of the below box only if we receive the fields
	 */
	if (isset($_REQUEST['meta_title'])) {
		if (isset($_REQUEST['allow_meta_keyword']) && $_REQUEST['allow_meta_keyword']=='1') {
			// Selected by user
			WPPostsRateKeys_WPPosts::update_allow_meta_keyword($post_id, '1');
		}
		else {
			// Not selected
			WPPostsRateKeys_WPPosts::update_allow_meta_keyword($post_id, '0');
		}
			
		if (isset($_REQUEST['use_for_meta_keyword'])) {
			WPPostsRateKeys_WPPosts::update_use_for_meta_keyword($post_id, $_REQUEST['use_for_meta_keyword']);
		}
			
		if (isset($_REQUEST['allow_meta_description']) && $_REQUEST['allow_meta_description']=='1') {
			// Selected by user
			WPPostsRateKeys_WPPosts::update_allow_meta_description($post_id, '1');
		}
		else {
			// Not selected
			WPPostsRateKeys_WPPosts::update_allow_meta_description($post_id, '0');
		}
		if (isset($_REQUEST['meta_description'])) {
			WPPostsRateKeys_WPPosts::update_meta_description($post_id, $_REQUEST['meta_description']);
		}
		
		if (isset($_REQUEST['allow_meta_title']) && $_REQUEST['allow_meta_title']=='1') {
			// Selected by user
			WPPostsRateKeys_WPPosts::update_allow_meta_title($post_id, '1');
		}
		else {
			// Not selected
			WPPostsRateKeys_WPPosts::update_allow_meta_title($post_id, '0');
		}
		if (isset($_REQUEST['meta_title'])) {
			WPPostsRateKeys_WPPosts::update_meta_title($post_id, $_REQUEST['meta_title']);
		}
	}
		
	/*
	 * Save Google Rich Snippet values
	*/
	if (isset($_REQUEST['seopressor_google_rich_snippet_rating'])) {
		// Selected by user
		update_post_meta($post_id, '_google_rich_snippet_rating', $_REQUEST['seopressor_google_rich_snippet_rating']);
		update_post_meta($post_id, '_google_rich_snippet_author', $_REQUEST['seopressor_google_rich_snippet_author']);
		update_post_meta($post_id, '_google_rich_snippet_summary', $_REQUEST['seopressor_google_rich_snippet_summary']);
		update_post_meta($post_id, '_google_rich_snippet_description', $_REQUEST['seopressor_google_rich_snippet_description']);

		update_post_meta($post_id, '_seop_grs_event_url', $_REQUEST['seop_grs_event_url']);
		update_post_meta($post_id, '_seop_grs_event_name', $_REQUEST['seop_grs_event_name']);
		update_post_meta($post_id, '_seop_grs_event_startdate', $_REQUEST['seop_grs_event_startdate']);
		update_post_meta($post_id, '_seop_grs_event_location_name', $_REQUEST['seop_grs_event_location_name']);
		update_post_meta($post_id, '_seop_grs_event_location_address_streetaddress', $_REQUEST['seop_grs_event_location_address_streetaddress']);
		update_post_meta($post_id, '_seop_grs_event_location_address_addresslocality', $_REQUEST['seop_grs_event_location_address_addresslocality']);
		update_post_meta($post_id, '_seop_grs_event_location_address_addressregion', $_REQUEST['seop_grs_event_location_address_addressregion']);

		update_post_meta($post_id, '_seop_grs_people_name_given_name', $_REQUEST['seop_grs_people_name_given_name']);
		update_post_meta($post_id, '_seop_grs_people_name_family_name', $_REQUEST['seop_grs_people_name_family_name']);
		update_post_meta($post_id, '_seop_grs_people_home_url', $_REQUEST['seop_grs_people_home_url']);
		update_post_meta($post_id, '_seop_grs_people_locality', $_REQUEST['seop_grs_people_locality']);
		update_post_meta($post_id, '_seop_grs_people_region', $_REQUEST['seop_grs_people_region']);
		update_post_meta($post_id, '_seop_grs_people_title', $_REQUEST['seop_grs_people_title']);
		update_post_meta($post_id, '_seop_grs_people_photo', $_REQUEST['seop_grs_people_photo']);

		update_post_meta($post_id, '_seop_grs_product_name', $_REQUEST['seop_grs_product_name']);
		update_post_meta($post_id, '_seop_grs_product_image', $_REQUEST['seop_grs_product_image']);
		update_post_meta($post_id, '_seop_grs_product_description', $_REQUEST['seop_grs_product_description']);
		update_post_meta($post_id, '_seop_grs_product_offers', $_REQUEST['seop_grs_product_offers']);

		update_post_meta($post_id, '_seop_grs_recipe_name', $_REQUEST['seop_grs_recipe_name']);
		update_post_meta($post_id, '_seop_grs_recipe_yield', $_REQUEST['seop_grs_recipe_yield']);
		update_post_meta($post_id, '_seop_grs_recipe_author', $_REQUEST['seop_grs_recipe_author']);
		update_post_meta($post_id, '_seop_grs_recipe_photo', $_REQUEST['seop_grs_recipe_photo']);
		update_post_meta($post_id, '_seop_grs_recipe_nutrition_calories', $_REQUEST['seop_grs_recipe_nutrition_calories']);
		update_post_meta($post_id, '_seop_grs_recipe_nutrition_sodium', $_REQUEST['seop_grs_recipe_nutrition_sodium']);
		update_post_meta($post_id, '_seop_grs_recipe_nutrition_fat', $_REQUEST['seop_grs_recipe_nutrition_fat']);
		update_post_meta($post_id, '_seop_grs_recipe_nutrition_protein', $_REQUEST['seop_grs_recipe_nutrition_protein']);
		update_post_meta($post_id, '_seop_grs_recipe_nutrition_cholesterol', $_REQUEST['seop_grs_recipe_nutrition_cholesterol']);
		update_post_meta($post_id, '_seop_grs_recipe_total_time_minutes', $_REQUEST['seop_grs_recipe_total_time_minutes']);
		update_post_meta($post_id, '_seop_grs_recipe_cook_time_minutes', $_REQUEST['seop_grs_recipe_cook_time_minutes']);
		update_post_meta($post_id, '_seop_grs_recipe_prep_time_minutes', $_REQUEST['seop_grs_recipe_prep_time_minutes']);
		update_post_meta($post_id, '_seop_grs_recipe_ingredient', $_REQUEST['seop_grs_recipe_ingredient']);
		
		/*
		 * Save enabled/disable Settings
		*/
		if (isset($_REQUEST['seop_publish_rich_snippets']) && $_REQUEST['seop_publish_rich_snippets']=='1') {
			WPPostsRateKeys_WPPosts::update_meta_publish_rich_snippets($post_id,'1');
		}
		else {
			WPPostsRateKeys_WPPosts::update_meta_publish_rich_snippets($post_id,'0');
		}
		if (isset($_REQUEST['seop_enable_rich_snippets']) && $_REQUEST['seop_enable_rich_snippets']=='1') {
			WPPostsRateKeys_WPPosts::update_meta_enable_rich_snippets($post_id,'1');
		}
		else {
			WPPostsRateKeys_WPPosts::update_meta_enable_rich_snippets($post_id,'0');
		}
		if (isset($_REQUEST['seop_enable_socialseo_facebook']) && $_REQUEST['seop_enable_socialseo_facebook']=='1') {
			WPPostsRateKeys_WPPosts::update_meta_enable_socialseo_facebook($post_id,'1');
		}
		else {
			WPPostsRateKeys_WPPosts::update_meta_enable_socialseo_facebook($post_id,'0');
		}
		if (isset($_REQUEST['seop_enable_socialseo_twitter']) && $_REQUEST['seop_enable_socialseo_twitter']=='1') {
			WPPostsRateKeys_WPPosts::update_meta_enable_socialseo_twitter($post_id,'1');
		}
		else {
			WPPostsRateKeys_WPPosts::update_meta_enable_socialseo_twitter($post_id,'0');
		}
		if (isset($_REQUEST['seop_enable_dublincore']) && $_REQUEST['seop_enable_dublincore']=='1') {
			WPPostsRateKeys_WPPosts::update_meta_enable_dublincore($post_id,'1');
		}
		else {
			WPPostsRateKeys_WPPosts::update_meta_enable_dublincore($post_id,'0');
		}
		
		// New fields
		WPPostsRateKeys_WPPosts::update_meta_socialseo_facebook_title($post_id, $_REQUEST['seopressor_og_title']);
		WPPostsRateKeys_WPPosts::update_meta_socialseo_facebook_publisher($post_id, $_REQUEST['seopressor_og_publisher']);
		WPPostsRateKeys_WPPosts::update_meta_socialseo_facebook_author($post_id, $_REQUEST['seopressor_og_author']);
		WPPostsRateKeys_WPPosts::update_meta_socialseo_facebook_description($post_id, $_REQUEST['seopressor_og_description']);
		WPPostsRateKeys_WPPosts::update_meta_socialseo_twitter_title($post_id, $_REQUEST['seopressor_twitter_title']);
		WPPostsRateKeys_WPPosts::update_meta_socialseo_twitter_description($post_id, $_REQUEST['seopressor_twitter_description']);
		WPPostsRateKeys_WPPosts::update_meta_dublincore_title($post_id, $_REQUEST['seopressor_dc_title']);
		WPPostsRateKeys_WPPosts::update_meta_dublincore_description($post_id, $_REQUEST['seopressor_dc_description']);
		
		/*
		 * Save the OpenGraph Tags / Image
		*
		* Only if there isn't a Featured Image already
		*/
		if (isset($_REQUEST['og_image']) && $_REQUEST['og_image']!=''
				&& (isset($_REQUEST['og_image_use']) && $_REQUEST['og_image_use']=='1')) {
			$featured_image = WPPostsRateKeys_WPPosts::get_featured_image_url($post_id);
			if ($featured_image=='') {
				$featured_image_from_request = str_ireplace('-wxw-', 'x', $_REQUEST['og_image']);
				WPPostsRateKeys_WPPosts::update_og_image($post_id, urldecode($featured_image_from_request));
			}
		}
		else {
			WPPostsRateKeys_WPPosts::update_og_image($post_id,'');
		}
		if (isset($_REQUEST['og_image_use']) && $_REQUEST['og_image_use']=='1') {
			WPPostsRateKeys_WPPosts::update_og_image_use($post_id,'1');
		}
		else {
			WPPostsRateKeys_WPPosts::update_og_image_use($post_id,'0');
		}
		
	}
}

/*
 * Get settings
*/
$settings = WPPostsRateKeys_Settings::get_options();

/*
 * Save Post Title and Content
*/
if ($post_id!='' && $is_ajax_request) {
	// Save title and content only if WordPress doesn't did already, this means that we only should save if is an Ajax request
	global $wpdb;
	
	if ($post_name!='') {
		// Update all, including Post name
		$post_name = sanitize_title($post_name);// WP same processing
		$query_seo_post = "update $wpdb->posts set post_title='$title',post_content='$content',post_name='$post_name' where ID=$post_id";
	}
	else {
		// Don't update the Post name
		$query_seo_post = "update $wpdb->posts set post_title='$title',post_content='$content' where ID=$post_id";
	}
	
	$wpdb->query($query_seo_post); // Query instead of wp_update_post to avoid call the hook that cause recursive loop
		
	// Save Post meta as empty because we already have the value stored
	WPPostsRateKeys_Central::update_original_post_content($post_id,'');
}

/*
 * Save Keyword 1
*/
if ($keyword!='') {
	if ($post_id!='') { // Editing already existing Post (internal WP draft, draft or published): use common update mechanism
		// Save Keyword
		WPPostsRateKeys_WPPosts::update_keyword($post_id, $keyword);
		
		// Save Keyword2
		if (isset($keyword2)) {
			WPPostsRateKeys_WPPosts::update_keyword2($post_id, $keyword2);
		}

		// Save Keyword3
		if (isset($keyword3)) {
			WPPostsRateKeys_WPPosts::update_keyword3($post_id, $keyword3);
		}

		if ($is_ajax_request) { // Only checks if is Ajax Request because when the button is submited is called Ajax again to show the box
			// Update Cached values
			WPPostsRateKeys_Central::check_update_post_data_in_cache($post_id);
		}	

		$suggestions_box = WPPostsRateKeys_Central::get_suggestions_box($post_id);
		$score_value = WPPostsRateKeys_Central::get_score($post_id);
	}
		
	// Score
	if ($score_value<=85 || $score_value>100) {
		$score_pos_neg = 'negative';
	}
	else {
		$score_pos_neg = 'positive';
	}
	
	// Keyword Density
	$keyword_density_value = $suggestions_box['box_keyword_density'];
	if ($keyword_density_value<1 || $keyword_density_value>4) {
		$keyword_density_pos_neg = 'negative';
	}
	else {
		$keyword_density_pos_neg = 'positive';
	}
	
		
	// Three types suggestions
	list($box_decoration_suggestions_arr,$box_url_suggestions_arr,$box_content_suggestions_arr) = $suggestions_box['box_suggestions_arr'];
	// Special suggestions
	list($score_less_than_100_arr,$score_more_than_100_arr,$score_over_optimization_arr) =  $suggestions_box['special_suggestions_arr'];
}
else {
	// Three types suggestions
	$box_decoration_suggestions_arr = array();
	$box_url_suggestions_arr = array();
	$box_content_suggestions_arr = array();
		
	// Special suggestions
	$score_less_than_100_arr = array();
	$score_more_than_100_arr = array();
	$score_over_optimization_arr = array();
		
	$score_value = 0;
	$score_pos_neg = 'negative';
	$keyword_density_value = 0;
	$keyword_density_pos_neg = 'negative';
}

@set_time_limit(30);
