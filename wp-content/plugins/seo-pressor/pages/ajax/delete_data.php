<?php
/**
 * Page to handle all Ajax requests for delete data.
 * All data will be returned using JSON format
 *
 * General variables:
 *
 * @uses	$_REQUEST['object']			required
 */

/** Loads the WordPress Environment */
require(dirname(__FILE__) . '/../../../../../wp-load.php');

// Include code related to roles_capabilities
include WPPostsRateKeys::$plugin_dir . '/pages/ajax/delete_data/related_to_roles_capabilities.php';
// Include code related to users_custom_roles
include WPPostsRateKeys::$plugin_dir . '/pages/ajax/delete_data/related_to_users_custom_roles.php';
// Include code related to external_cloacked_links
include WPPostsRateKeys::$plugin_dir . '/pages/ajax/delete_data/related_to_external_cloacked_links.php';
// Include code related to automatic_internal_links
include WPPostsRateKeys::$plugin_dir . '/pages/ajax/delete_data/related_to_automatic_internal_links.php';

/**
 * Return data
 *
 * @return	$data_to_return	if JSON format
 * @example	of data to return
 * 		$data_to_return = array(
				array('message'=>'Deleted successfully.', 'type'=>'notification')
		);
		$data_to_return = array(
				array('message'=>'Error in DB query.', 'type'=>'error')
		);
 */
if (isset($result)) {
	// Check which is the result and fill the message text and type

	if ($result==='error-permission-denied') {
		$message_to_return = __("You haven't enough permissions for this action.",'seo-pressor');
		$type_to_return = 'error';
	}
	elseif ($result) {
		$message_to_return = __('Deleted successfully.','seo-pressor');
		$type_to_return = 'notification';
	}
	else {
		$message_to_return = __("Wasn't deleted.",'seo-pressor');
		$type_to_return = 'error';
	}

	$data_to_return['message'] = $message_to_return;
	$data_to_return['type'] = $type_to_return;

	$json = json_encode($data_to_return);
	echo $json;
	die();
}


