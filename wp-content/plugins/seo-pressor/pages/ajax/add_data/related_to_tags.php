<?php
/**
 * Add an automatic_internal_links
 * 
 * @uses	$_REQUEST['post_id']		Post ID to which add the Tags 
 * @uses	$_REQUEST['tags']			array of tags to add
 * 
 * Condition
 * - $_REQUEST['object']=='tag'
 */

if ($_REQUEST['object']=='tag') {
	if (isset($_REQUEST['post_id'])
		&& isset($_REQUEST['tags'])
		) {
		
		$post_id = $_REQUEST['post_id'];
		
		$tags_to_add = implode(',', (array) $_REQUEST['tags']);
		wp_set_post_tags($post_id,$tags_to_add,true);
		
		$result = true;
	}
}
