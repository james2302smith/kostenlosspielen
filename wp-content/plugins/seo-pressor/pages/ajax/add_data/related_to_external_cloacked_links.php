<?php
/**
 * Add an roles_capabilities
 * 
 * @uses	$_REQUEST['id']						if specified and !='', the object must be updated, else must be added
 * @uses	$_REQUEST['keywords']				required
 * @uses	$_REQUEST['cloaking_folder']		required
 * @uses	$_REQUEST['external_url']			required
 * 
 * Condition
 * - $_REQUEST['object']=='external_cloacked_links'
 */

if ($_REQUEST['object']=='external_cloacked_links') {
	if (isset($_REQUEST['keywords'])
		&& isset($_REQUEST['cloaking_folder'])
		&& isset($_REQUEST['external_url'])
		) {
		
		$data_to_add_update['keywords'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['keywords']);
		$data_to_add_update['cloaking_folder'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['cloaking_folder']);
		$data_to_add_update['external_url'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['external_url']);
		$data_to_add_update['how_many'] = WPPostsRateKeys_Validator::parse_int($_REQUEST['times_to_link']);
				
		// If the ID is defined, set the ID
		if (isset($_REQUEST['id']) && $_REQUEST['id']!='') {
			// the object must be updated
			$id_to_edit = $_REQUEST['id'];
			
			$where['id'] = $id_to_edit;
			$result = WPPostsRateKeys_ExternalCloackedLinks::update($data_to_add_update,$where);
		}
		else {
			// Add
			$result = WPPostsRateKeys_ExternalCloackedLinks::add($data_to_add_update);
		}
	}
}
