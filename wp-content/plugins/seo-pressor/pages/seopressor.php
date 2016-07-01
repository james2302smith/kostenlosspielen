<?php
/**
 * Page to handle requests from Central Server
 * 
 */	

/** Loads the WordPress Environment */
require(dirname(__FILE__) . '/../../../../wp-load.php');

// Check for deactivation
if (isset($_REQUEST['set_status'])) {
	if ($_REQUEST['set_status']=='inactive' && isset($_REQUEST['secret_key'])) {
		$secret_key = $_REQUEST['secret_key'];

		$data = WPPostsRateKeys_Settings::get_options();
		if ($secret_key==$data['clickbank_receipt_number']) {
			// Deactive plugin
			$data['allow_manual_reactivation'] = '1';
        	$data['active'] = '0';
        	$data['last_activation_message'] = __('Reactivation required.','seo-pressor');
        	WPPostsRateKeys_Settings::update_options($data);
        	
        	echo 'deactivated';
        	exit();
		}
		else {
			echo 'wrong secret key';
			exit();
		}
	}
}

echo 'wrong request';