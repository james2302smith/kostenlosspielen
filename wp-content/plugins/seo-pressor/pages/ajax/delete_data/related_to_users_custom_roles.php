<?php
/**
 * Delete a users_custom_roles
 * 
 * @uses	$_REQUEST['id']			required, the Object id

 * Condition
 * - $_REQUEST['object']=='users_custom_roles'
 */

if ($_REQUEST['object']=='users_custom_roles') {
	if (isset($_REQUEST['id'])) {
		$result = WPPostsRateKeys_UsersCustomRoles::delete($_REQUEST['id']);
	}
}
