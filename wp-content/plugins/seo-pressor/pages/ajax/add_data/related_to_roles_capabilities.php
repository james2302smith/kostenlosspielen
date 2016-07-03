<?php
/**
 * Add an roles_capabilities
 * 
 * @uses	$_REQUEST['id']						if specified and !='', the object must be updated, else must be added
 * @uses	$_REQUEST['role_type']				required
 * @uses	$_REQUEST['role_name']				required
 * @uses	$_REQUEST['capabilities']			
 * 
 * Condition
 * - $_REQUEST['object']=='roles_capabilities'
 */

if ($_REQUEST['object']=='roles_capabilities') {
	if (isset($_REQUEST['role_type'])
		&& ($_REQUEST['role_type']=='wp' || isset($_REQUEST['role_name']))
		) {
		
		$data_to_add_update['role_type'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['role_type']);
		if ($data_to_add_update['role_type']!='wp') {
			$data_to_add_update['role_name'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['role_name']);
		}
		$data_to_add_update['capabilities'] = WPPostsRateKeys_Validator::parse_string(
						implode(',', (array) $_REQUEST['capabilities']));
		
		// If the ID is defined, set the ID
		if (isset($_REQUEST['id']) && $_REQUEST['id']!='') {
			// the object must be updated
			$id_to_edit = $_REQUEST['id'];
			
			$where['id'] = $id_to_edit;
			$result = WPPostsRateKeys_RolesCapabilities::update($data_to_add_update,$where);
		}
		else {
			// Add
			$result = WPPostsRateKeys_RolesCapabilities::add($data_to_add_update);
		}
	}
}
