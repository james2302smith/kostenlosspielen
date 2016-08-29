<?php
/**
 * Page to handle all Ajax requests for add data.
 * All data will be returned using JSON format
 *
 * General variables:
 *
 * @uses	$_REQUEST['object']			required
 */

// Include code related to users_custom_roles
include WPPostsRateKeys::$plugin_dir . '/pages/ajax/add_data/related_to_users_custom_roles.php';
// Include code related to roles_capabilities
include WPPostsRateKeys::$plugin_dir . '/pages/ajax/add_data/related_to_roles_capabilities.php';
// Include code related to external_cloacked_links
include WPPostsRateKeys::$plugin_dir . '/pages/ajax/add_data/related_to_external_cloacked_links.php';
// Include code related to automatic_internal_links
include WPPostsRateKeys::$plugin_dir . '/pages/ajax/add_data/related_to_automatic_internal_links.php';
// Include code related to posts
include WPPostsRateKeys::$plugin_dir . '/pages/ajax/add_data/related_to_posts.php';
// Include code related to tags
include WPPostsRateKeys::$plugin_dir . '/pages/ajax/add_data/related_to_tags.php';

/**
 * Return data
 *
 * @return	$data_to_return	if JSON format
 * @example	of data to return
 * 		$data_to_return = array(
				array('id'=>'1', 'message'=>'Added successfully', 'type'=>'notification')
		);
		$data_to_return = array( // Used in case of tables that haven't autonumeric fields, like relation tables between Groups and Users
				array('id'=>'TRUE', 'message'=>'Added successfully', 'type'=>'notification')
		);
		$data_to_return = array(
				array('id'=>'0', 'message'=>'Already exists', 'type'=>'error')
		);
 */

if (isset($result)) {
	// Check which is the result and fill the message text and type
	if ($result==='error-duplicates') {
		$message_to_return = __('Already exists.','seo-pressor');
		$type_to_return = 'error';
	}
	elseif ($result==='error-missing-name') {
		$message_to_return = __('The Name is missing.','seo-pressor');
		$type_to_return = 'error';
	}
	elseif ($result==='error-startdt-after-duedt') {
		$message_to_return = __('The Start Time must be less or equal that Due Time.','seo-pressor');
		$type_to_return = 'error';
	}
	elseif ($result==='error-permission-denied') {
		$message_to_return = __("You haven't enough permissions for this action.",'seo-pressor');
		$type_to_return = 'error';
	}
	elseif ($result!==FALSE && isset($id_to_edit)) { // $result!==FALSE because when is updated without change anything will be returned 0 rows affected
		$message_to_return = __('Update successfully.','seo-pressor');
		$type_to_return = 'notification';
	}
	elseif ($result==='custom-message') {
		$message_to_return = $result_custom_message;
		$type_to_return = 'notification';
	}
	elseif ($result) {
		$message_to_return = __('Added successfully.','seo-pressor');
		$type_to_return = 'notification';
	}
	else {
		$message_to_return = __('Error in DB query.','seo-pressor');
		$type_to_return = 'error';
	}
	// Fill the ID of the object, if ocurrs an error the ID=0
	if ($type_to_return=='error') {
		$id_to_return = 0;
	}
	else {
		$id_to_return = (string) $result;
	}

	$data_to_return['id'] = $id_to_return;
	$data_to_return['message'] = $message_to_return;
	$data_to_return['type'] = $type_to_return;

	$json = json_encode($data_to_return);
	echo $json;
	die();
}


