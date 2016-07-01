<?php
/**
 * File for upgrade directives 
 */

/*
 * Call all code in plugin "install" function
 */

if (!function_exists('deactivate_plugins')) {
	include( WPPostsRateKeys::$plugin_dir . '../../../wp-admin/includes/plugin.php');
}

$plugin_name = 'seo-pressor/seo-pressor.php';
deactivate_plugins($plugin_name);
activate_plugin($plugin_name);