<?php
/**
 * Delete a automatic_internal_links
 * 
 * @uses	$_REQUEST['id']			required, the Object id

 * Condition
 * - $_REQUEST['object']=='automatic_internal_links'
 */

if ($_REQUEST['object']=='automatic_internal_links') {
	if (isset($_REQUEST['id'])) {
		$result = WPPostsRateKeys_AutomaticInternalLinks::delete($_REQUEST['id']);
	}
}
