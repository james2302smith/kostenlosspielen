<?php
/**
 * Specific code for the Setting Tab: Requirements
 * 
 * 
 * Fill requirements
 * $requirement_msg_arr
 * $requirement_msg_arr_item[0]					0- The message is negative
 * $requirement_msg_arr_item[1]					The requirement message
 * 
 * So far we will check:
	- PHP 5
	- WP version
	- Outgoing connection to Central Server
	
	If PHP 5 fails, suggest to the user to update to PHP 5, they can request this from their hosting provider. 
	
	If the WP version fails, ask the user to update their WP version. 
	
	If outgoing connection to Central Server fails, ask them to try again later or contact support desk at http://askdanieltan.com/ask/
 */

$requirement_msg_arr = array();

// WordPress version
global $wp_version;
if (version_compare($wp_version, "3.4.2", "<")) {
	$message = __('This plugin require WordPress 3.4.2 or newer','seo-pressor') . '. <a target="_blank" href="http://codex.wordpress.org/Upgrading_WordPress">' . __('Please update','seo-pressor').'</a>';
	$requirement_msg_arr[] = array(0,$message);
}
else {
	$message = __('You already has a valid WordPress version:','seo-pressor') . ' ' . $wp_version;
	$requirement_msg_arr[] = array(1,$message);
}

// PHP version
$phpversion = phpversion();
if (version_compare($phpversion, "5.3", "<")) {
	$message = __('This plugin require PHP 5.3 or newer. We suggest you request this upgrade from your hosting provider. Your current version is:','seo-pressor') . ' ' . $phpversion;
	$requirement_msg_arr[] = array(0,$message);
}
else {
	$message = __('You already has a valid PHP version:','seo-pressor') . ' ' . $phpversion;
	$requirement_msg_arr[] = array(1,$message);
}

// MultiByte support
if (!function_exists('mb_convert_encoding')) {
	$message = __('For "Support Multibyte character encoding" in Settings/Advanced is needed the <a href="http://php.net/manual/en/book.mbstring.php">PHP Multibyte String extension</a>, that is build in PHP library. To enable it please contact your hosting support','seo-pressor');
	$requirement_msg_arr[] = array(0,$message);
	// Disable the option
	$settings_opts = WPPostsRateKeys_Settings::get_options();
	$settings_opts['support_multibyte'] = '0';
	WPPostsRateKeys_Settings::update_options($settings_opts);
}
else {
	$message = __('You already has <a href="http://php.net/manual/en/book.mbstring.php">PHP Multibyte String extension</a>','seo-pressor');
	$requirement_msg_arr[] = array(1,$message);
}

// Outgoing connections
if (!WPPostsRateKeys_Upgrade::check_for_outgoing_connections(TRUE)) {
	$message = __('Outgoing connection to SEOPressor Central Server fails, try again later or contact the ') . '<a target="_blank" href="http://askdanieltan.com/ask/">' . __('SEOPressor support desk','seo-pressor') . __('.');
	$requirement_msg_arr[] = array(0,$message);
}
else {
	$message = __('Success outgoing connections.','seo-pressor');
	$requirement_msg_arr[] = array(1,$message);
}

// Show the domains for which the plugin is downloaded
$plugin_domains = WPPostsRateKeys_Central::get_clear_domains();

$license = WPPostsRateKeys_Central::get_license_type();
$plugin_license_is_multi = (md5('multi')==$license)?TRUE:FALSE;

$plugin_in_valid_domain = WPPostsRateKeys_Central::is_valid_current_domain();



