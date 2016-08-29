<?php
/**
 * Include to show the plugin Make Money page
 *
 * @package admin-panel
 * @version	v5.0
 * 
 */
// Check if user can access the list of Posts/Pages
$seopressor_has_permission = TRUE;
if (!WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::ADMIN)) {
	$msg_error[] = __('SEOPressor permission denied. You can check this with WordPress or SEOPressor plugin administrator.','seo-pressor');
	$seopressor_has_permission = FALSE;
}

$seopressor_is_active = TRUE;
if (!WPPostsRateKeys_Settings::get_active()) {
	$msg_error[] = __('SEOPressor needs to be activated.','seo-pressor');
	$seopressor_is_active = FALSE;
}

if ($seopressor_is_active && $seopressor_has_permission) {
	// Settings data
	$data = WPPostsRateKeys_Settings::get_options();
	
	// Prepare Html data for appears without broke the design
	$data['footer_tags_before'] = htmlentities($data['footer_tags_before']);
	$data['footer_tags_after'] = htmlentities($data['footer_tags_after']);
}

include( WPPostsRateKeys::$template_dir . '/includes/admin/handle_make_money.php');