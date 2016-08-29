<?php
/**
 * Edit Post Keyword
 * 
 * @uses	$_REQUEST['id']						required	is the Post ID to edit
 * @uses	$_REQUEST['keyword']				required
 * 
 * Condition
 * - $_REQUEST['object']=='posts'
 */

if ($_REQUEST['object']=='posts') {
	if (isset($_REQUEST['id']) && $_REQUEST['id']!=''
		&& isset($_REQUEST['keyword'])) { // Removed: && $_REQUEST['keyword']!='' because the keyword can be empty
		
		$result = TRUE;
		
		$post_id = WPPostsRateKeys_Validator::parse_int($_REQUEST['id']);
		$new_keyword = WPPostsRateKeys_Validator::parse_string($_REQUEST['keyword']);
		WPPostsRateKeys_WPPosts::update_keyword($post_id, $new_keyword);
		
		// If the keyword is empty, all keywords must be deleted
		if ($new_keyword=='') {
			$result = 'custom-message';
			$result_custom_message = __('The Keywords were deleted.','seo-pressor');
			
			WPPostsRateKeys_WPPosts::update_keyword($post_id, '');
			WPPostsRateKeys_WPPosts::update_keyword2($post_id, '');
			WPPostsRateKeys_WPPosts::update_keyword3($post_id, '');
		}
		else {
			// Explode by comma and save keywords
			$new_keyword_arr = explode(',', $new_keyword);
			if (count($new_keyword_arr)>=3) {
				WPPostsRateKeys_WPPosts::update_keyword3($post_id, $new_keyword_arr[2]);
			}
			else {
				// Delete Key 3 if any
				WPPostsRateKeys_WPPosts::update_keyword3($post_id, '');
			}
			if (count($new_keyword_arr)>=2) {
				WPPostsRateKeys_WPPosts::update_keyword2($post_id, $new_keyword_arr[1]);
			}
			else {
				WPPostsRateKeys_WPPosts::update_keyword2($post_id, '');
				WPPostsRateKeys_WPPosts::update_keyword3($post_id, '');
			}
			if (count($new_keyword_arr)>=1) {
				WPPostsRateKeys_WPPosts::update_keyword($post_id, $new_keyword_arr[0]);
			}
			else {
				WPPostsRateKeys_WPPosts::update_keyword($post_id, '');
				WPPostsRateKeys_WPPosts::update_keyword2($post_id, '');
				WPPostsRateKeys_WPPosts::update_keyword3($post_id, '');
			}				
		}
		
		// Update Cached values
		WPPostsRateKeys_Central::check_update_post_data_in_cache($post_id);
		
		// Suggestion column
		$post_suggestions = WPPostsRateKeys_Central::get_suggestions_page($post_id);
		$post_suggestions_count = 0;
		foreach ($post_suggestions as $post_suggestions_item) {
			// Only negatives
			if ($post_suggestions_item[0]=='0') {
				$post_suggestions_count++;
			}
		}
		
		if ($post_suggestions_count>0) {
			$data_to_return['suggestions'] = '<a href="' . admin_url( 'admin-ajax.php?action=seopressor_list&object=suggestions&post_id=' . $post_id)
					. '" title="Suggestions" class="thickbox" onclick="return false;">'
							.  __('Click to view','seo-pressor') . ' ' . $post_suggestions_count
							. ' ' . __('suggestions','seo-pressor')
							. '</a>';
		}
		else {
			$data_to_return['suggestions'] = __('No suggestions','seo-pressor');
		}
		$data_to_return['score'] = number_format(WPPostsRateKeys_Central::get_score($post_id),2);
		// Delete the ".00" of present
		$data_to_return['score'] = str_replace('.00', '', $data_to_return['score']);
	}
}
