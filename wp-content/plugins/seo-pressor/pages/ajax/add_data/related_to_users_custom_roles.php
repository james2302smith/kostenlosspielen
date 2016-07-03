<?php
/**
 * Add an Showtimes
 * 
 * @uses	$_REQUEST['id']						if specified and !='', the object must be updated, else must be added
 * @uses	$_REQUEST['user_login']				required
 * @uses	$_REQUEST['role_name']				required
 * 
 * Condition
 * - $_REQUEST['object']=='users_custom_roles'
 */

if ($_REQUEST['object']=='users_custom_roles') {
	if (isset($_REQUEST['user_login'])
		&& isset($_REQUEST['role_name'])
		) {
		
		$data_to_add_update['role_id'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['role_name']);
		$data_to_add_update['user_id'] = WPPostsRateKeys_Validator::parse_int($_REQUEST['user_login']);
		
		// If the ID is defined, set the ID
		if (isset($_REQUEST['id']) && $_REQUEST['id']!='') {
			// the object must be updated
			$id_to_edit = $_REQUEST['id'];
			
			$where['id'] = $id_to_edit;
			$result = WPPostsRateKeys_UsersCustomRoles::update($data_to_add_update,$where);
		}
		else {
			// Add
			$result = WPPostsRateKeys_UsersCustomRoles::add($data_to_add_update);
		}
	}
}
