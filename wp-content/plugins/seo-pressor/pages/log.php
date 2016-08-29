<?php
/**
 * Include to show the plugin logs
 *
 * @package admin-panel
 * 
 */

try {
	/** Loads the WordPress Environment */
	require(dirname(__FILE__) . '/../../../../wp-load.php');
	
	if ( current_user_can('manage_options')) {
		
		// Check if user click on Download button
		if (isset($_REQUEST['download'])) {
			
			$to_download = '';
			
			// Global Information
			$to_download .= 'Server datetime: ' . date('Y-m-d H:i:s') . "\n";
			$to_download .= 'PHP version: ' . phpversion() . "\n";
			global $wp_version;
			$to_download .= 'WP version: ' . $wp_version . "\n";
			if (function_exists('mb_convert_encoding')) {
				$to_download .= 'Functions mb_: supported' . "\n";
			}
			else {
				$to_download .= 'Functions mb_: NOT supported' . "\n";
			}
			if (WPPostsRateKeys_Upgrade::check_for_outgoing_connections(TRUE)) {
				$to_download .= 'Outgoing connection: to CS OK' . "\n";
			}
			else {
				$to_download .= 'Outgoing connection: to CS Fails' . "\n";
			}
			$license = WPPostsRateKeys_Central::get_license_type();
			$plugin_license_is_multi = (md5('multi')==$license)?TRUE:FALSE;
			if ($plugin_license_is_multi) {
				$to_download .= 'License: Multi-Site' . "\n";
			}
			else {
				$plugin_domains = WPPostsRateKeys_Central::get_clear_domains();
				$to_download .= 'License: Single-Site, Domain: ' . implode(',', $plugin_domains) . "\n";
			}
			
			// Settings
			$options = WPPostsRateKeys_Settings::get_options();
			$to_download .= "\n" . "\n" . 'SETTINGS:' . "\n";
			$to_download .= print_r($options,TRUE);
			
			// Error log
			$to_download .= "\n" . "\n" . 'LOG:' . "\n";
			$all_log = WPPostsRateKeys_Logs::get_all();
			foreach ($all_log as $all_log_item) {
				$to_download .= $all_log_item->dt . '-- ' . $all_log_item->type . ',-- ' 
						. $all_log_item->msg_code . ':-- ' . $all_log_item->message . "\n";
			}
			
			// phpinfo
			ob_start();
			phpinfo();
			$variable_phpinfo = ob_get_contents();
			ob_get_clean();
			
			$to_download .= "\n" . "\n" . 'PHP INFO:' . "\n";
			$to_download .= $variable_phpinfo;
			
			header('Content-disposition: attachment; filename=seopressor-logs.txt');
			header('Content-type: text/plain');
			header("Content-Length: " . strlen($to_download));
			echo $to_download;
			exit();
		}
		
		include( WPPostsRateKeys::$template_dir . '/pages/log.php');
	}
	else {
		// Log
		WPPostsRateKeys_Logs::add_notification('431',"Page log.php, Forbidden unauthorized access.");
	}
	
} catch (Exception $e) {
	/**@var $e Exception*/
	// Log possible problem in this include
	WPPostsRateKeys_Logs::add_error('351',"Page log.php, Error: " . $e->getMessage());
}