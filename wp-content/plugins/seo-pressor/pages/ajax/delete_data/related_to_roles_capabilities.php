<?php
/**
 * Delete a roles_capabilities
 * 
 * @uses	$_REQUEST['id']			required, the Object id

 * Condition
 * - $_REQUEST['object']=='roles_capabilities'
 */

if ($_REQUEST['object']=='roles_capabilities' || $_REQUEST['object']=='roles') {
	if (isset($_REQUEST['id'])) {
		$result = WPPostsRateKeys_RolesCapabilities::delete($_REQUEST['id']);
	}
}
