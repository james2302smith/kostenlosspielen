<?php
/**
 * Include to show the Settings in the Post add/edit page
 *
 * @uses	int		$post_id
 *
 * @package admin-panel
 *
 */

// Check if user can access
$seopressor_has_permission = TRUE;
if (!WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::SEO_EDIT_BOX)) {
	$seopressor_has_permission = FALSE;
}

$seopressor_is_active = TRUE;
if (!WPPostsRateKeys_Settings::get_active()) {
	$seopressor_is_active = FALSE;
}

// Check is plugin is activated and has permission
if ($seopressor_is_active && $seopressor_has_permission) {
	
	// Fill the Meta Keyword and Description data
	$settings['allow_meta_keyword'] = WPPostsRateKeys_WPPosts::get_allow_meta_keyword($post_id);
	$settings['use_for_meta_keyword'] = WPPostsRateKeys_WPPosts::get_use_for_meta_keyword($post_id);
	$settings['allow_meta_description'] = WPPostsRateKeys_WPPosts::get_allow_meta_description($post_id);
	$settings['meta_description'] = WPPostsRateKeys_WPPosts::get_meta_description($post_id);
	$settings['allow_meta_title'] = WPPostsRateKeys_WPPosts::get_allow_meta_title($post_id);
	$settings['meta_title'] = WPPostsRateKeys_WPPosts::get_meta_title($post_id);
	$settings['allow_keyword_overriding_in_sentences'] = WPPostsRateKeys_WPPosts::get_allow_keyword_overriding_in_sentences($post_id);
	$settings['key_in_first_sentence'] = WPPostsRateKeys_WPPosts::setting_key_first_sentence($post_id);
	$settings['key_in_last_sentence'] = WPPostsRateKeys_WPPosts::setting_key_last_sentence($post_id);
	
	$settings['google_rich_snippet_rating'] = get_post_meta($post_id, '_google_rich_snippet_rating', TRUE);
	$settings['google_rich_snippet_author'] = get_post_meta($post_id, '_google_rich_snippet_author', TRUE);
	$settings['google_rich_snippet_summary'] = get_post_meta($post_id, '_google_rich_snippet_summary', TRUE);
	$settings['google_rich_snippet_description'] = get_post_meta($post_id, '_google_rich_snippet_description', TRUE);
	
	$settings['seop_grs_event_url'] = get_post_meta($post_id, '_seop_grs_event_url', TRUE);
	$settings['seop_grs_event_name'] = get_post_meta($post_id, '_seop_grs_event_name', TRUE);
	$settings['seop_grs_event_startdate'] = get_post_meta($post_id, '_seop_grs_event_startdate', TRUE);
	$settings['seop_grs_event_location_name'] = get_post_meta($post_id, '_seop_grs_event_location_name', TRUE);
	$settings['seop_grs_event_location_address_streetaddress'] = get_post_meta($post_id, '_seop_grs_event_location_address_streetaddress', TRUE);
	$settings['seop_grs_event_location_address_addresslocality'] = get_post_meta($post_id, '_seop_grs_event_location_address_addresslocality', TRUE);
	$settings['seop_grs_event_location_address_addressregion'] = get_post_meta($post_id, '_seop_grs_event_location_address_addressregion', TRUE);
	
	$settings['seop_grs_people_name_given_name'] = get_post_meta($post_id, '_seop_grs_people_name_given_name', TRUE);
	$settings['seop_grs_people_name_family_name'] = get_post_meta($post_id, '_seop_grs_people_name_family_name', TRUE);
	$settings['seop_grs_people_home_url'] = get_post_meta($post_id, '_seop_grs_people_home_url', TRUE);
	$settings['seop_grs_people_locality'] = get_post_meta($post_id, '_seop_grs_people_locality', TRUE);
	$settings['seop_grs_people_region'] = get_post_meta($post_id, '_seop_grs_people_region', TRUE);
	$settings['seop_grs_people_title'] = get_post_meta($post_id, '_seop_grs_people_title', TRUE);
	$settings['seop_grs_people_photo'] = get_post_meta($post_id, '_seop_grs_people_photo', TRUE);
	
	$settings['seop_grs_product_name'] = get_post_meta($post_id, '_seop_grs_product_name', TRUE);
	$settings['seop_grs_product_image'] = get_post_meta($post_id, '_seop_grs_product_image', TRUE);
	$settings['seop_grs_product_description'] = get_post_meta($post_id, '_seop_grs_product_description', TRUE);
	$settings['seop_grs_product_offers'] = get_post_meta($post_id, '_seop_grs_product_offers', TRUE);
	
	$settings['seop_grs_recipe_name'] = get_post_meta($post_id, '_seop_grs_recipe_name', TRUE);
	$settings['seop_grs_recipe_yield'] = get_post_meta($post_id, '_seop_grs_recipe_yield', TRUE);
	$settings['seop_grs_recipe_author'] = get_post_meta($post_id, '_seop_grs_recipe_author', TRUE);
	$settings['seop_grs_recipe_photo'] = get_post_meta($post_id, '_seop_grs_recipe_photo', TRUE);
	$settings['seop_grs_recipe_nutrition_calories'] = get_post_meta($post_id, '_seop_grs_recipe_nutrition_calories', TRUE);
	$settings['seop_grs_recipe_nutrition_sodium'] = get_post_meta($post_id, '_seop_grs_recipe_nutrition_sodium', TRUE);
	$settings['seop_grs_recipe_nutrition_fat'] = get_post_meta($post_id, '_seop_grs_recipe_nutrition_fat', TRUE);
	$settings['seop_grs_recipe_nutrition_protein'] = get_post_meta($post_id, '_seop_grs_recipe_nutrition_protein', TRUE);
	$settings['seop_grs_recipe_nutrition_cholesterol'] = get_post_meta($post_id, '_seop_grs_recipe_nutrition_cholesterol', TRUE);
	$settings['seop_grs_recipe_total_time_minutes'] = get_post_meta($post_id, '_seop_grs_recipe_total_time_minutes', TRUE);
	$settings['seop_grs_recipe_cook_time_minutes'] = get_post_meta($post_id, '_seop_grs_recipe_cook_time_minutes', TRUE);
	$settings['seop_grs_recipe_prep_time_minutes'] = get_post_meta($post_id, '_seop_grs_recipe_prep_time_minutes', TRUE);
	$settings['seop_grs_recipe_ingredient'] = get_post_meta($post_id, '_seop_grs_recipe_ingredient', TRUE);
	
	// Social SEO
	$post_url = get_permalink( $post_id );
	$post_title = get_the_title( $post_id );
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
	$facebook_og_author = get_the_author_meta( 'seopressor_facebook_og_author', $post->post_author );
	
	$settings['og_type'] = 'article';
	$settings['og_url'] = $post_url;
	$settings['og_title_default'] = $post_title;
	$settings['og_title'] = WPPostsRateKeys_WPPosts::get_meta_socialseo_facebook_title($post_id);
	
	$settings['og_publisher'] = WPPostsRateKeys_WPPosts::get_meta_socialseo_facebook_publisher($post_id);
	$settings['og_author'] = WPPostsRateKeys_WPPosts::get_meta_socialseo_facebook_author($post_id);
	$settings['og_author_default'] = $facebook_og_author;
	
	$settings['og_description_default'] = $meta_description;
	$settings['og_description'] = WPPostsRateKeys_WPPosts::get_meta_socialseo_facebook_description($post_id);
	$settings['og_sitename'] = get_bloginfo( 'name' );
	
	// Get featured image URL
	$featured_image = WPPostsRateKeys_WPPosts::get_featured_image_url($post_id);
	if ($featured_image=='') {
		$featured_image = WPPostsRateKeys_WPPosts::get_og_image($post_id);
	}
	
	// Set image
	$settings['og_image'] = $featured_image;
	$settings['og_image_use'] = WPPostsRateKeys_WPPosts::get_og_image_use($post_id);
	
	
	$settings['twitter_creator_site'] = $twitter_card;
	$settings['twitter_url'] = $post_url;
	$settings['twitter_title_default'] = $post_title;
	$settings['twitter_title'] = WPPostsRateKeys_WPPosts::get_meta_socialseo_twitter_title($post_id);
	$settings['twitter_description_default'] = esc_attr( apply_filters( 'meta_description', $meta_description ) );
	$settings['twitter_description'] = WPPostsRateKeys_WPPosts::get_meta_socialseo_twitter_description($post_id);
	
	/*
	 * Add Dublin Core
	*/
	$google_plus_auth_url = get_the_author_meta( 'seopressor_google_plus_auth_url', $post->post_author );
	$settings['dc_title_default'] = $post_title;
	$settings['dc_title'] = WPPostsRateKeys_WPPosts::get_meta_dublincore_title($post_id);
	$settings['dc_creator'] = $google_plus_auth_url;
	$settings['dc_description_default'] = esc_attr( apply_filters( 'meta_description', $meta_description ) );
	$settings['dc_description'] = WPPostsRateKeys_WPPosts::get_meta_dublincore_description($post_id);
	$settings['dc_date'] = $post->post_date;
	$settings['dc_type'] = 'Article';
	
	// Get link to author edit profile page
	$post_data = get_post($post_id);
	$author_profile_edit_page = get_admin_url() . 'user-edit.php?user_id=' . $post_data->post_author;

	// Get Enable/Disable settings
	$settings['publish_rich_snippets'] = WPPostsRateKeys_WPPosts::get_meta_publish_rich_snippets($post_id);
	$settings['enable_rich_snippets'] = WPPostsRateKeys_WPPosts::get_meta_enable_rich_snippets($post_id);
	$settings['enable_socialseo_facebook'] = WPPostsRateKeys_WPPosts::get_meta_enable_socialseo_facebook($post_id);
	$settings['enable_socialseo_twitter'] = WPPostsRateKeys_WPPosts::get_meta_enable_socialseo_twitter($post_id);
	$settings['enable_dublincore'] = WPPostsRateKeys_WPPosts::get_meta_enable_dublincore($post_id);
	
	// Include Html template
	include( WPPostsRateKeys::$template_dir . '/includes/admin/postbox_below.php');
}


