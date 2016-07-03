<?php
/**
 * Add an automatic_internal_links
 * 
 * @uses	$_REQUEST['id']						if specified and !='', the object must be updated, else must be added
 * @uses	$_REQUEST['keywords']				required
 * @uses	$_REQUEST['post_id']				required
 * @uses	$_REQUEST['times_to_link']
 * 
 * Condition
 * - $_REQUEST['object']=='automatic_internal_links'
 */

if ($_REQUEST['object']=='automatic_internal_links') {
	if (isset($_REQUEST['keywords'])
		&& isset($_REQUEST['post_id'])
		) {
		
		if (!isset($_REQUEST['times_to_link'])) {
			$_REQUEST['times_to_link'] = 1;
		}
		
		$data_to_add_update['keywords'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['keywords']);
		$data_to_add_update['post_id'] = WPPostsRateKeys_Validator::parse_int($_REQUEST['post_id']);
		$data_to_add_update['how_many'] = WPPostsRateKeys_Validator::parse_int($_REQUEST['times_to_link']);
		
		// If the ID is defined, set the ID
		if (isset($_REQUEST['id']) && $_REQUEST['id']!='') {
			// the object must be updated
			$id_to_edit = $_REQUEST['id'];
			
			$where['id'] = $id_to_edit;
			$result = WPPostsRateKeys_AutomaticInternalLinks::update($data_to_add_update,$where);
		}
		else {
			// Add
			$result = WPPostsRateKeys_AutomaticInternalLinks::add($data_to_add_update);
		}
	}
}
