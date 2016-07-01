<?php
/**
 * Page to handle all Ajax requests for update Settings
 *
 */

/*
 * General Tab of Settings
 */
if (isset($_REQUEST['submit_general'])) {
	$settings = WPPostsRateKeys_Settings::get_options();

	$settings['locale'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['locale']);

	WPPostsRateKeys_Settings::update_options($settings);

	// Show message
	$msg = __('The Settings were successfully updated.','seo-pressor');
	$msg_type = 'notification';
}

/*
 * Validate Bing API Key
 */
if (isset($_REQUEST['submit_advanced_validate_api_key'])) {

	$lsi_bing_api_key_to_test = trim($_REQUEST['lsi_bing_api_key']);

	// Show message By Default
	$msg = __('The Bing API Key is valid. Click "Save Settings" if you want save it.','seo-pressor');
	$msg_type = 'notification';

	// Check if the API Key is valid and set value is isn't
	if ($lsi_bing_api_key_to_test!='') {
		if (!WPPostsRateKeys_LSI::check_apikey_is_valid($lsi_bing_api_key_to_test)) {
			// Check first if we have network connection
			if (!WPPostsRateKeys_Upgrade::check_for_outgoing_connections()) {
				// Maybe isn't the Keyword wrong
				$msg = __("The Bing API Key can't be validated due to outgoing network connection problem. Could be a temporary problem, please try again and if this persist contact yout hosting support.",'seo-pressor');
			}
			else {
				$msg = __('The Bing API Key is invalid.','seo-pressor');
			}
			$msg_type = 'error';
			WPPostsRateKeys_Logs::add_error('314',"API validation fails: $msg");
		}
	}
	else {
		$msg = __('The Bing API Key must be specified.','seo-pressor');
		$msg_type = 'error';
		WPPostsRateKeys_Logs::add_error('313',"API validation fails: $msg");
	}
}

/*
 * Advanced Tab in Settings
 */
if (isset($_REQUEST['submit_advanced'])) {
	/*
	 * h1_tag_already_in_theme
	 * h2_tag_already_in_theme
	 * h3_tag_already_in_theme
	 * special_characters_to_omit
	 * minimum_score_before_allow_to_publish
	 */

	$settings = WPPostsRateKeys_Settings::get_options();

	if (isset($_REQUEST['h1_tag_already_in_theme']))
		$settings['h1_tag_already_in_theme'] = '1';
	else
		$settings['h1_tag_already_in_theme'] = '0';
	if (isset($_REQUEST['h2_tag_already_in_theme']))
		$settings['h2_tag_already_in_theme'] = '1';
	else
		$settings['h2_tag_already_in_theme'] = '0';
	if (isset($_REQUEST['h3_tag_already_in_theme']))
		$settings['h3_tag_already_in_theme'] = '1';
	else
		$settings['h3_tag_already_in_theme'] = '0';

	if (isset($_REQUEST['enable_special_characters_to_omit']))
		$settings['enable_special_characters_to_omit'] = '1';
	else
		$settings['enable_special_characters_to_omit'] = '0';

	// Save it as array
	$settings['special_characters_to_omit'] = implode(WPPostsRateKeys_Settings::SPEC_CHARS_DELIMITER,
													explode("\n", trim($_REQUEST['special_characters_to_omit'])));

	// LSI settings
	$previous_key = $settings['lsi_bing_api_key'];
	$settings['lsi_bing_api_key'] = trim($_REQUEST['lsi_bing_api_key']);
	$settings['lsi_language'] = trim($_REQUEST['lsi_language']);

	// Advanced / Misc
	$settings['analize_full_page'] = $_REQUEST['analize_full_page'];
	$settings['locale'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['locale']);
	// For minimum_score_to_publish: Check permission
	if (WPPostsRateKeys_Capabilities::user_can_set_minimun_score()) {
		$settings['minimum_score_to_publish'] = trim($_REQUEST['minimum_score_to_publish']);
	}
	if (isset($_REQUEST['multibyte'])) {
		$settings['support_multibyte'] = '1';
	}
	else {
		$settings['support_multibyte'] = '0';
	}

	WPPostsRateKeys_Settings::update_options($settings);

	// Show message
	$msg = __('The Settings were successfully updated.','seo-pressor');
	$msg_type = 'notification';

	// Check if the API Key is valid and set value is isn't
	//if ($previous_key!=trim($_REQUEST['lsi_bing_api_key'])) {
		if (!WPPostsRateKeys_LSI::check_apikey_is_valid()) {
			if ($settings['lsi_bing_api_key_is_valid']!='0') {
				$settings['lsi_bing_api_key_is_valid'] = '0';
				WPPostsRateKeys_Settings::update_options($settings);
			}

			// Show this message only when some value is specified
			if (trim($_REQUEST['lsi_bing_api_key'])!='') {
				// Check first if we have network connection
				if (!WPPostsRateKeys_Upgrade::check_for_outgoing_connections()) {
					// Maybe isn't the Keyword wrong
					$msg = __("The Settings were successfully updated but note that the Bing API Key can't be validated due to outgoing network connection problem. If this persist contact yout hosting support.",'seo-pressor');
				}
				else {
					$msg = __('The Settings were successfully updated but note that the Bing API Key seems to be invalid.','seo-pressor');
				}
				$msg_type = 'error';
				WPPostsRateKeys_Logs::add_error('312',"API validation fails: $msg");
			}
		}
		else {
			if ($settings['lsi_bing_api_key_is_valid']!='1') {
				$settings['lsi_bing_api_key_is_valid'] = '1';
				WPPostsRateKeys_Settings::update_options($settings);
			}
		}
	//}
}

/*
 * Automatic Decoration Tab in Settings
 */
if (isset($_REQUEST['submit_automatic_decorations'])) {
	$settings = WPPostsRateKeys_Settings::get_options();

	// Post Title
	if (isset($_REQUEST['allow_add_keyword_in_titles']))
		$settings['allow_add_keyword_in_titles'] = '1';
	else
		$settings['allow_add_keyword_in_titles'] = '0';

	// Bold, Italic, Underline
	if (isset($_REQUEST['allow_bold_style_to_apply']))
		$settings['allow_bold_style_to_apply'] = '1';
	else
		$settings['allow_bold_style_to_apply'] = '0';
	$settings['bold_style_to_apply'] = WPPostsRateKeys_Validator::parse_int($_REQUEST['bold_style_to_apply']);
	if (isset($_REQUEST['allow_italic_style_to_apply']))
		$settings['allow_italic_style_to_apply'] = '1';
	else
		$settings['allow_italic_style_to_apply'] = '0';
	$settings['italic_style_to_apply'] = WPPostsRateKeys_Validator::parse_int($_REQUEST['italic_style_to_apply']);
	if (isset($_REQUEST['allow_underline_style_to_apply']))
		$settings['allow_underline_style_to_apply'] = '1';
	else
		$settings['allow_underline_style_to_apply'] = '0';
	$settings['underline_style_to_apply'] = WPPostsRateKeys_Validator::parse_int($_REQUEST['underline_style_to_apply']);

	// Images
	$settings['image_alt_tag_decoration'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['image_alt_tag_decoration']);
	$settings['alt_attribute_structure'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['alt_attribute_structure']);
	$settings['image_title_tag_decoration'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['image_title_tag_decoration']);
	$settings['title_attribute_structure'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['title_attribute_structure']);

	// Links
	if (isset($_REQUEST['allow_automatic_adding_rel_nofollow']))
		$settings['allow_automatic_adding_rel_nofollow'] = '1';
	else
		$settings['allow_automatic_adding_rel_nofollow'] = '0';
	// Nofollow for Images
	if (isset($_REQUEST['auto_add_rel_nofollow_img_links']))
		$settings['auto_add_rel_nofollow_img_links'] = '1';
	else
		$settings['auto_add_rel_nofollow_img_links'] = '0';

	// Slugs
	if (isset($_REQUEST['enable_convertion_post_slug']))
		$settings['enable_convertion_post_slug'] = '1';
	else
		$settings['enable_convertion_post_slug'] = '0';
	
	// Per Post settings
	if (isset($_REQUEST['enable_rich_snippets']))
		$settings['enable_rich_snippets'] = '1';
	else
		$settings['enable_rich_snippets'] = '0';
	if (isset($_REQUEST['enable_socialseo_facebook']))
		$settings['enable_socialseo_facebook'] = '1';
	else
		$settings['enable_socialseo_facebook'] = '0';
	if (isset($_REQUEST['enable_socialseo_twitter']))
		$settings['enable_socialseo_twitter'] = '1';
	else
		$settings['enable_socialseo_twitter'] = '0';
	if (isset($_REQUEST['enable_dublincore']))
		$settings['enable_dublincore'] = '1';
	else
		$settings['enable_dublincore'] = '0';

	WPPostsRateKeys_Settings::update_options($settings);

	// Update special setting for Slugs Stop words
	WPPostsRateKeys_Settings::update_slugs_stop_words($_REQUEST['post_slugs_stop_words']);

	// Show message
	$msg = __('The Settings were successfully updated.','seo-pressor');
	$msg_type = 'notification';
}


/*
 * Activation in Requirement Tab of Settings
 */
if (isset($_REQUEST['submit_activation']) || isset($_REQUEST['submit_reactivation'])) {
	
	$data = WPPostsRateKeys_Settings::get_options();

	if (isset($_REQUEST['submit_reactivation'])) {
		// Manual rectivation
		// Check if is filled clickbank_receipt_number
		if ($data['clickbank_receipt_number']!='') {
			// Check if already in Central Database
			$response = WPPostsRateKeys_Central::get_specific_data_from_server('if_active');

        	if ($response) { // Else, was a problem in connection
				$msg = WPPostsRateKeys_Settings::update_active_by_server_response($response, TRUE);
				if (substr_count($msg, 'not active')>0) {
					$msg_type = 'error';
					WPPostsRateKeys_Logs::add_error('235',"submit_reactivation fails: $msg");
				}
				else {
					$msg_type = 'notification';
					
					// Show message
					$msg = __('Successful Reactivation.','seo-pressor');
					$msg_type = 'notification';
				}
			}
			else {
				$msg = __('A problem occurs when try to Re-Activate the plugin. Check your network connection.','seo-pressor');
				$msg_type = 'error';
				WPPostsRateKeys_Logs::add_error('234',"submit_reactivation fails: $msg");
			}
		}
		else {
			$msg = __('The ClickBank Receipt Number must be filled for Re-Activation.','seo-pressor');
			$msg_type = 'error';
			WPPostsRateKeys_Logs::add_error('233',"submit_reactivation fails: $msg");
		}
	}

	/*
	 * Activation Code
	 */
	if (isset($_REQUEST['submit_activation'])) {
		// Check is isn't already activated
		if (WPPostsRateKeys_Settings::get_active()==1) {
			$msg = __('The plugin is active.','seo-pressor');
			$msg_type = 'notification';
			WPPostsRateKeys_Settings::set_last_activation_message($msg);
		}
		elseif ($data['allow_manual_reactivation']=='1') {
			$msg = __('The plugin requires Reactivation.','seo-pressor');
			$msg_type = 'notification';
		}
		else {
			// Check if is filled clickbank_receipt_number
			if ($data['clickbank_receipt_number']!='') {
				// Check against embebed code, not against Central Server
				$response = WPPostsRateKeys_Central::check_to_active();

        		if ($response) { // Else, was a problem in connection
        			$msg = __('SEOPressor was activated successfully.','seo-pressor');
					$msg_type = 'notification';
        			WPPostsRateKeys_Settings::set_last_activation_message($msg);
				}
				else {
					$msg = __("Activation failed. Either your receipt number is invalid or current domain name isn't registered. <a target='_blank' href='http://seopressor.com/download/download.php'>Please add your domain to your license and try again.</a> Contact support at ",'seo-pressor') . '<a target="_blank" href="http://askdanieltan.com/ask/">http://askdanieltan.com/ask/</a>' . __(' with your receipt number.','seo-pressor');
					$msg_type = 'error';
					WPPostsRateKeys_Settings::set_last_activation_message($msg);
					WPPostsRateKeys_Logs::add_error('232',"submit_activation fails: $msg");
				}
			}
			else {
				$msg = __('The ClickBank Receipt Number must be filled for activation.','seo-pressor');
				$msg_type = 'error';
				WPPostsRateKeys_Settings::set_last_activation_message($msg);
				WPPostsRateKeys_Logs::add_error('231',"submit_activation fails: $msg");
			}
		}
	}
}

// Upgrade Tab in Settings
if (isset($_REQUEST['submit_upgrade'])) {
	// Check if plugin is activated
	if (WPPostsRateKeys_Settings::get_active()==0) {
		$msg = __("The Plugin isn't Active.",'seo-pressor');
		$msg_type = 'error';
		WPPostsRateKeys_Logs::add_error('229',"Automatic Update fails: $msg");
	}
	else {
		$current_options = WPPostsRateKeys_Settings::get_options();
		/*
		if (!version_compare($current_options['current_version'], $current_options['last_version'], "<")) {
			$msg = __("You don't need upgrade. You already has the last version.",'seo-pressor');
			$msg_type = 'notification';
		}
		*/
		if (!WPPostsRateKeys_Upgrade::check_for_ziparchive_class()) {
			$msg = __("ZipArchive class is required. Please request your hosting provider to install this for your server",'seo-pressor');
			$msg_type = 'error';
			WPPostsRateKeys_Logs::add_error('228',"Automatic Update fails: $msg");
		}
		elseif (!WPPostsRateKeys_Upgrade::check_for_outgoing_connections()) {
			$msg = __("The server where the Plugin is installed is blocking outgoing connections. Please check with your hosting provider to allow outgoing connections to SEOPressor.com",'seo-pressor');
			$msg_type = 'error';
			WPPostsRateKeys_Logs::add_error('227',"Automatic Update fails: $msg");
		}
		else {
			$check_for_write_permission = WPPostsRateKeys_Upgrade::check_for_write_permission();
			if (!$check_for_write_permission[0]) {
				$msg = __('Write permission is required to update SEOPressor.','seo-pressor');
				$msg_type = 'error';
				WPPostsRateKeys_Logs::add_error('226',"Automatic Update fails: $msg");
			}
			else { // Proceed with Upgrade

				// Set path to file
				$file_name = WPPostsRateKeys::$plugin_dir . '/seo_pressor_last_ver.zip';

				// Download last version
				$last_ver_url = WPPostsRateKeys_Central::$url_to_automatic_upgrade . '?cbc=' . $current_options['clickbank_receipt_number'];
				$response = wp_remote_get($last_ver_url,array('timeout'=>WPPostsRateKeys::$timeout));

				if (!is_wp_error($response)) { // Else, was an object(WP_Error)
		        	$zip_content = $response['body'];
		        	if ($zip_content=='INVALID_LICENSE') {
		        		$msg = __('Your license is invalid.','seo-pressor');
						$msg_type = 'error';
						WPPostsRateKeys_Logs::add_error('225',"Automatic Update fails: $msg");
		        	}
		        	else {
		        		if (file_put_contents($file_name, $zip_content)) {
		        			// Unzip the files
							$zip = new ZipArchive;
							if ($zip->open($file_name) === TRUE) {
								@$zip->extractTo(WPPostsRateKeys::$plugin_dir . '..');

								// Used because extractTo can return True if one file could be extracted but other not!
								$last_error = error_get_last();
								if (key_exists('message',$last_error)) {
									if (substr_count($last_error['message'],'failed to open stream: Permission denied')>0
										&& substr_count($last_error['message'],'ZipArchive::extractTo') >0
										) {

										$msg = __('The upgrade fails. Check the Web Server user have permission to rewrite the content on the plugin folder ','seo-pressor')
								    		. WPPostsRateKeys::$plugin_dir
								    		. '<br><br>'
									        . __(' Details: ','seo-pressor')
									        . $last_error['message'];
										$msg_type = 'error';
										WPPostsRateKeys_Logs::add_error('224',"Automatic Update fails: $msg");
									}
								}

							    $zip->close();

							    // Delete Zip
							    @unlink($file_name);
							} else {
								$msg = __('The upgrade fails. Check the permission to rewrite the content of the plugin folder ','seo-pressor')
							    		. WPPostsRateKeys::$plugin_dir;
								$msg_type = 'error';
								WPPostsRateKeys_Logs::add_error('223',"Automatic Update fails: $msg");
							}
		        		}
		        		else {
		        			$msg = __('Your plugin folder needs to have write permission.','seo-pressor');
							$msg_type = 'error';
							WPPostsRateKeys_Logs::add_error('222',"Automatic Update fails: $msg");
		        		}
		        	}
		        }
		        else {
		        	/*@var WP_Error $response*/
		        	$msg = __('Connection to download last version fails. Error: ','seo-pressor')
								. $response->get_error_message($response->get_error_code());
					$msg_type = 'error';
					WPPostsRateKeys_Logs::add_error('221',"Automatic Update fails: $msg");
		        }

				if (!isset($msg_type)) { // In this case all cases for not empty $msg_type imply that the upgrade fails
					// Deactivate and Activate the plugin calling the upgrade script
					include( WPPostsRateKeys::$plugin_dir . '/includes/upgrade.php');

					// If successfully, notification user
					$msg = __('The upgrade was successfully. Now you can remove write access to your Plugin files.','seo-pressor');
					$msg_type = 'notification';
				}
			}
		}
	}
}



// Make Money page
if (isset($_REQUEST['submit_make_money'])) {
	/*
	 * allow_seopressor_footer
	 * footer_text_color
	 * clickbank_id
	 * footer_tags_before
	 * footer_tags_after
	 */
	$settings = WPPostsRateKeys_Settings::get_options();

	if (isset($_REQUEST['allow_seopressor_footer']))
		$settings['allow_seopressor_footer'] = '1';
	else
		$settings['allow_seopressor_footer'] = '0';
	$settings['footer_text_color'] = trim($_REQUEST['footer_text_color']);
	$settings['clickbank_id'] = trim($_REQUEST['clickbank_id']);
	$settings['footer_tags_before'] = trim($_REQUEST['footer_tags_before']);
	$settings['footer_tags_after'] = trim($_REQUEST['footer_tags_after']);
	$settings['allow_advertising_program'] = trim($_REQUEST['allow_advertising_program']);

	WPPostsRateKeys_Settings::update_options($settings);

	// Show message
	$msg = __('The Settings were successfully updated.','seo-pressor');
	$msg_type = 'notification';
}

// Roles page
if (isset($_REQUEST['submit_role_settings'])) {
	$settings = WPPostsRateKeys_Settings::get_options();
	if (isset($_REQUEST['enable_role_settings'])) {
		$settings['enable_role_settings'] = '1';
	}
	else {
		$settings['enable_role_settings'] = '0';
	}
	WPPostsRateKeys_Settings::update_options($settings);

	// Show message
	$msg = __('The Setting was successfully updated.','seo-pressor');
	$msg_type = 'notification';
}

// Tags Tab in Settings
if (isset($_REQUEST['submit_tags'])) {
	$settings = WPPostsRateKeys_Settings::get_options();

	if (isset($_REQUEST['enable_tagging_using_google'])) {
		$settings['enable_tagging_using_google'] = '1';
	}
	else {
		$settings['enable_tagging_using_google'] = '0';
	}

	$settings['max_number_tags'] = WPPostsRateKeys_Validator::parse_int($_REQUEST['max_number_tags']);
	$settings['append_tags'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['append_tags']);

	if (isset($_REQUEST['to_retrieve_keywords_use_post_title'])) {
		$settings['to_retrieve_keywords_use_post_title'] = '1';
	}
	else {
		$settings['to_retrieve_keywords_use_post_title'] = '0';
	}
	if (isset($_REQUEST['to_retrieve_keywords_use_post_content'])) {
		$settings['to_retrieve_keywords_use_post_content'] = '1';
	}
	else {
		$settings['to_retrieve_keywords_use_post_content'] = '0';
	}

	$settings['blacklisted_tags'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['blacklisted_tags']);
	$settings['generic_tags'] = WPPostsRateKeys_Validator::parse_string($_REQUEST['generic_tags']);

	WPPostsRateKeys_Settings::update_options($settings);

	// Show message
	$msg = __('The Setting was successfully updated.','seo-pressor');
	$msg_type = 'notification';
}

if (!isset($msg)) {
	$msg = __('Wrong Request','seo-pressor');
	$msg_type = 'error';
}

// Show message
$data_to_return = array();
$data_to_return['message'] = $msg;
$data_to_return['type'] = $msg_type;

$json = json_encode($data_to_return);
echo $json;
die();