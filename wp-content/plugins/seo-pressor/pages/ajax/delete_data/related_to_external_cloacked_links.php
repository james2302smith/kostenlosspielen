<?php
/**
 * Delete a roles_capabilities
 * 
 * @uses	$_REQUEST['id']			required, the Object id

 * Condition
 * - $_REQUEST['object']=='external_cloacked_links'
 */

if ($_REQUEST['object']=='external_cloacked_links') {
	if (isset($_REQUEST['id'])) {
		$result = WPPostsRateKeys_ExternalCloackedLinks::delete($_REQUEST['id']);
	}
}
