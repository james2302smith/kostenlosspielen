<?php
/**
 * Include to show the posts
 *
 * @package admin-panel
 *
 */
// Check if user can access the list of Posts/Pages

$seopressor_has_permission = TRUE;
if (!WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::PAGES_POSTS)) {
	$msg_error[] = __('SEOPressor permission denied. You can check this with WordPress or SEOPressor plugin administrator.','seo-pressor');
	$seopressor_has_permission = FALSE;
}

$seopressor_is_active = TRUE;
if (!WPPostsRateKeys_Settings::get_active()) {
	$msg_error[] = __('SEOPressor needs to be activated.','seo-pressor');
	$seopressor_is_active = FALSE;
}

include( WPPostsRateKeys::$template_dir . '/includes/admin/handle_score.php');
