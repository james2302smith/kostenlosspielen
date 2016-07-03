<?php
/**
 * Include to show the Suggestions
 *
 * @uses	int		$post_id
 *
 * @package admin-panel
 *
 */
// Check if user can access
$seopressor_has_permission = TRUE;
if (!WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::SEO_EDIT_BOX)) {
	$msg_error[] = __('SEOPressor permission denied. You can check this with WordPress or SEOPressor plugin administrator.','seo-pressor');
	$seopressor_has_permission = FALSE;
}

$seopressor_is_active = TRUE;
if (!WPPostsRateKeys_Settings::get_active()) {
	$msg_error[] = __('SEOPressor needs to be activated.','seo-pressor');
	$seopressor_is_active = FALSE;
}

// Check if user can access the Score/Suggestions box
if ($seopressor_is_active && $seopressor_has_permission) {
	// Initialization of elements and variables, just in case the keywords aren't defined
	$all_in_box_item_1 = array();
	$box_score = 0;
	$box_keyword_density = 0;
	$box_keyword_density_status = 0;
	$box_keyword_density_message = '';
	$box_decoration_suggestions_arr = array();
	$box_url_suggestions_arr = array();
	$box_content_suggestions_arr = array();
	$score_less_than_100_arr = array();
	$score_more_than_100_arr = array();
	$score_over_optimization_arr = array();

	/*
	 * Fill related with Keyword 1,2 and 3 (now are all together)
	 */

	// Get Score
	$box_score = WPPostsRateKeys_Central::get_score($post_id);
	$box_suggestions_arr = array();

	// Get Keyword
	$box_keyword = WPPostsRateKeys_WPPosts::get_keyword($post_id);

	// Get data for suggestion Box
	if ($box_keyword!='') {
		$all_messages = WPPostsRateKeys_Central::get_suggestions_box($post_id);

		if ($all_messages) {
			// About Density
			$box_keyword_density = $all_messages['box_keyword_density'];
			$box_keyword_density_status = 0;

			if ($box_keyword_density<1) {
				$box_keyword_density_message = __('Your keyword density is too low','seo-pressor');
			}
			elseif ($box_keyword_density>6) {
				$box_keyword_density_message = __('Your keyword density is too high','seo-pressor');
			}
			else {
				$box_keyword_density_message = '';
				$box_keyword_density_status = 1;
			}

			// Fill box-suggestions
			list($box_decoration_suggestions_arr,$box_url_suggestions_arr,$box_content_suggestions_arr) = $all_messages['box_suggestions_arr'];
			list($score_less_than_100_arr,$score_more_than_100_arr,$score_over_optimization_arr) =  $all_messages['special_suggestions_arr'];
		}
	}
	else {
		$box_score = 0;
		$box_keyword_density = 0;
	}
	if ($box_score=='')
		$box_score = 0;

	$all_in_box_item_1['keyword_id'] = 1;
	$all_in_box_item_1['keyword_tab_title'] = __('Main','seo-pressor');

	$all_in_box_item_1['box_score'] = number_format($box_score,2);
	$all_in_box_item_1['box_score'] = str_replace('.00', '', $all_in_box_item_1['box_score']);
	$all_in_box_item_1['box_keyword_density'] = number_format($box_keyword_density,2);
	$all_in_box_item_1['box_keyword_density'] = str_replace('.00', '', $all_in_box_item_1['box_keyword_density']);

	$all_in_box_item_1['box_keyword'] = $box_keyword;
	$all_in_box_item_1['box_keyword_density_status'] = $box_keyword_density_status;
	$all_in_box_item_1['box_keyword_density_message'] = $box_keyword_density_message;
	$all_in_box_item_1['box_decoration_suggestions_arr'] = $box_decoration_suggestions_arr;
	$all_in_box_item_1['box_url_suggestions_arr'] = $box_url_suggestions_arr;
	$all_in_box_item_1['box_content_suggestions_arr'] = $box_content_suggestions_arr;
	// Get the setting where user can explicitly specify if keyword is in First or Last sentence
	$all_in_box_item_1['key_in_first_sentence'] = WPPostsRateKeys_WPPosts::setting_key_first_sentence($post_id);
	$all_in_box_item_1['key_in_last_sentence'] = WPPostsRateKeys_WPPosts::setting_key_last_sentence($post_id);
	$all_in_box_item_1['score_less_than_100_arr'] = $score_less_than_100_arr;
	$all_in_box_item_1['score_more_than_100_arr'] = $score_more_than_100_arr;
	$all_in_box_item_1['score_over_optimization_arr'] = $score_over_optimization_arr;

	// Fill the array used in Box with elements of the three keywords
	$all_in_box = array($all_in_box_item_1);

	// Get settings
	$settings = WPPostsRateKeys_Settings::get_options();
}

// Include Html template
include( WPPostsRateKeys::$template_dir . '/includes/admin/postbox.php');

