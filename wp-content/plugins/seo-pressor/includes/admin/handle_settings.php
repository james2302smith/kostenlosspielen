<?php
/**
 * Include to show the plugin settings
 *
 * @package admin-panel
 * 
 */
// Check if user can access the list of Posts/Pages
$seopressor_has_permission = TRUE;
if (!WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::ADMIN)
		&& !WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::SET_MIN_SCORE) 
		&& !WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::SET_NOT_MIN_SCORE) 
		) {
	$msg_error[] = __('SEOPressor permission denied. You can check this with WordPress or SEOPressor plugin administrator.','seo-pressor');
	$seopressor_has_permission = FALSE;
}

$seopressor_is_active = TRUE;
if (!WPPostsRateKeys_Settings::get_active()) {
	$msg_error[] = __('SEOPressor needs to be activated.','seo-pressor');
	$seopressor_is_active = FALSE;
}

// Check only the permission because in this page the plugin is activated :D so can't be hidden this option
if ($seopressor_has_permission) {

	// Get the data of the Plugin Options
	$data = WPPostsRateKeys_Settings::get_options();
	// Replace the characters to omit with the data returned by the specific function
	$data['special_characters_to_omit'] = implode("\n", explode(WPPostsRateKeys_Settings::SPEC_CHARS_DELIMITER, $data['special_characters_to_omit'])); 
	$data['post_slugs_stop_words'] = implode("\n", WPPostsRateKeys_Settings::get_slugs_stop_words());
	
	// Fix name putted in templates
	$data['multibyte'] = $data['support_multibyte'];
	
	// Get all type of Bold
	$bold_arr = WPPostsRateKeys_HtmlStyles::get_bold_styles();
	// Get all type of Italic
	$italic_arr = WPPostsRateKeys_HtmlStyles::get_italic_styles();
	// Get all type of Underline
	$underline_arr = WPPostsRateKeys_HtmlStyles::get_underline_styles();
	
	// Show activation Status
	$msg_status = $data['last_activation_message'];
	if ($msg_status=='' && $data['active']==0) {
		$msg_status = __('The plugin is Inactive.','seo-pressor');
	}
	if ($data['active']==1) {
		$msg_status = __('The plugin is Active.','seo-pressor');
	}
	
	/*
	 * Get available languages:
	 * 	all locales in files at /lang/ 
	 */
	$all_locales = array();
	$lang_dir = WPPostsRateKeys::$plugin_dir . '/lang/';
	if ($handle = opendir($lang_dir) ) {
	    while (false !== ($file = readdir($handle))) {
	    	if (!is_dir($lang_dir . $file) && $file!='.' && $file!='..' && substr_count($file,'.mo')>0 && $file!='default.mo') { // Only .mo files
	        	$domain = str_ireplace('seo-pressor-','',$file);
	        	$domain = str_ireplace('.mo','',$domain);
	        	
	        	$all_locales[] = $domain;
	    	}
	    }
	    closedir($handle);
	}
	
	// The tag list for the Images decoration in the Automatic Decoration Tab
	$tags_desc_arr = array_values(WPPostsRateKeys_HtmlStyles::get_tags_for_images_decoration());
	
	/*
	 * Check Requirements to Auto-Upgrade
	 */
	// Check if is needed the upgrade
	$current_options = WPPostsRateKeys_Settings::get_options(); 
	$need_upgrade = TRUE;
	if (!version_compare($current_options['current_version'], $current_options['last_version'], "<")) {
		$need_upgrade = FALSE;
	}
	
	// Check if plugin is activated
	$plugin_is_active = TRUE;
	if (WPPostsRateKeys_Settings::get_active()==0) {
		$plugin_is_active = FALSE;
	}
	
	// Check if Class ZipArchive exists
	$zip_archive_requirement = TRUE;
	if (!WPPostsRateKeys_Upgrade::check_for_ziparchive_class()) {
		$zip_archive_requirement = FALSE;
	}
	
	// Check if allowed outgoing connection
	$outgoing_connection_requirement = TRUE;
	if (!WPPostsRateKeys_Upgrade::check_for_outgoing_connections()) {
		$outgoing_connection_requirement = FALSE;
	}
	
	// Check write permission
	$write_permission_requirement = TRUE;
	$check_for_write_permission = WPPostsRateKeys_Upgrade::check_for_write_permission();
	$file_list_msg = __('Write permission on Plugin folder.','seo-pressor');
	$file_list = array();
	if (!$check_for_write_permission[0]) {
		$file_list_msg .= ' ' . __("Write permission is required to update SEOPressor. Please contact your hosting provider to compile your PHP handler to SuPHP or enable permissions to the following folders:",'seo-pressor');
		foreach ($check_for_write_permission[1] as $msg_item) {
			$file_list[] = $msg_item;
		}
		$write_permission_requirement = FALSE;
	}
	
	// Check if plugin is active in CS => not in CS, in plugin
	$cs_active_requirement = TRUE;
	$check_for_active_in_cs = WPPostsRateKeys_Settings::get_active();
	if (!$check_for_active_in_cs) {
		$cs_active_requirement = FALSE;	
	}

}

if (isset($need_upgrade) && $need_upgrade) {
	$msg_error[] = __("New SEOPressor version is available. You can go to 'Plugin Update' tab or <a href='http://seopressor.com/download/download.php' target='_blank'>download latest version</a> and manually update it.",'seo-pressor');
}

// Specify code for Requirements tab
include( WPPostsRateKeys::$plugin_dir . '/includes/admin/tab_requirements.php');

// Include template file
include( WPPostsRateKeys::$template_dir . '/includes/admin/handle_settings.php');
