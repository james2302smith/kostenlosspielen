<?php
if (!class_exists('WPPostsRateKeys_Capabilities')) {
	class WPPostsRateKeys_Capabilities
	{
		/**
		 * Identifier of the Capability 
		 * of see SeoPressor features of the Page that list Posts and Pages
		 * 
		 * @var string
		 */
		const PAGES_POSTS = 'pages_and_posts';
		
		/**
		 * Identifier of the Capability 
		 * of see SeoPressor Score and Suggestions Box
		 * 
		 * @var string
		 */
		const SEO_EDIT_BOX = 'seo_box_on_edit';
		
		/**
		 * Identifier of the Capability 
		 * of SeoPressor admin, this means: full access
		 * 
		 * @var string
		 */
		const ADMIN = 'admin';
		
		/**
		 * Identifier of the Capability 
		 * of change the minimum score required to publish a Post
		 * If the score is less that specified in setting the Post will be Draft
		 * This will imply permission to access Global Settings too 
		 * 
		 * @var string
		 */
		const SET_MIN_SCORE = 'set_min_score';
		
		/**
		 * Identifier of the Capability 
		 * of access Global Settings, excluding Min Score Setting
		 * 
		 * @var string
		 */
		const SET_NOT_MIN_SCORE = 'setting_not_min_score';
		
		/**
		 * Identifier of the Capability 
		 * of access Settings Tab
		 * 
		 * @var string
		 */
		const SETTINGS_TAB = 'settings_tab';
		
		/**
		 * Definition of capabilities
		 * Are all the capabilities/permissions that must been taken in care
		 * 
		 * @return	array
		 */
		static function get_all() {
			return array(
				self::PAGES_POSTS => array(__('Access List of Posts','seo-pressor'),__('Access to the list of Posts and Pages with SEOPressor information','seo-pressor'))
				, self::SEO_EDIT_BOX => array(__('Access Score Box','seo-pressor'),__('Access to SEOPressor Box in Post add and edit page','seo-pressor'))
				, self::ADMIN => array(__('Full Access','seo-pressor'),__('Full Access, including administrative options','seo-pressor'))
				, self::SET_MIN_SCORE => array(__('Access Settings and set Minimum Score','seo-pressor'),__('Permission to access to global Settings including the access to set the Minimum Score on Advanced Settings tab','seo-pressor'))
				, self::SET_NOT_MIN_SCORE => array(__('Access Settings without access to set Minimum Score','seo-pressor'),__('Permission to access to global Settings without permission to set the Minimum Score on Advanced Settings tab','seo-pressor'))
				, self::SETTINGS_TAB => array(__('Access SEOPressor Menu','seo-pressor'),__('Permission to access SEOPressor menu in backend','seo-pressor'))
			);
		}
		
		/**
		 * Get Capability name by ID
		 * 
		 * @param	int		$id
		 * @return	string
		 */
		static function get_name($id) {
			if (trim($id)=='') {
				return '';
			}
			
			$all = self::get_all();
			return $all[$id][0];
		}
		
		/**
		 * To check where a user can set the minimun score
		 * 
		 * This can be done if:
		 * - User is WordPress administrator
		 * - Is enable the "Enable Roles Support" of the plugin and the user has this capability
		 * 
		 * @param 	int 		$user_id
		 * @return 	bool
		 */
		static function user_can_set_minimun_score($user_id='') {
			// Check for settings: only use if "Enable Roles Support" is selected
			return self::user_can(self::SET_MIN_SCORE);
		}
		
		/**
		 * Get the status of this setting
		 * 
		 * @return	bool	True when is enabled, else False
		 */
		static function enable_role_settings() {
			$settings = WPPostsRateKeys_Settings::get_options();
			
			if ($settings['enable_role_settings']=='0') {
				return FALSE;
			}
			else {
				return TRUE;
			}
		}
		
		/**
		 * To check where a user can do some action in depends on the capabilities he has
		 * 
		 * If the $user_id parameter isn't passed, the current logged user will be the one checked 
		 * 
		 * @param string 	$capability
		 * @param int 		$user_id
		 */
		static function user_can($capability,$user_id='') {
			// First check if the "Enable Roles Support" is checked
			
			// If isn't all users can access data
			if (!self::enable_role_settings()) {
				return TRUE;
			}
			else {
				// If is checked: only users with the campability can access
				if ($user_id=='') {
					$user_id = WPPostsRateKeys_Users::get_current_user_id();
				}
				
				// Get list of Custom Roles
				$custom_roles = WPPostsRateKeys_UsersCustomRoles::get_all($user_id,'user_id');
				
				// Check if some of the roles has the $capability
				foreach ($custom_roles as $custom_roles_item) {
					$custom_roles_id = $custom_roles_item->role_id;
					
					// Get list of capabilities
					$tmp_role_data = WPPostsRateKeys_RolesCapabilities::get($custom_roles_id);
					if ($tmp_role_data) {
						$tmp_capabilities_arr = explode(',', $tmp_role_data->capabilities);
					}
					else {
						$tmp_capabilities_arr = array();
					}
					
					// Check if user has the capability passed by parameter or the Admin capability
					if (in_array($capability, $tmp_capabilities_arr) || in_array(self::ADMIN, $tmp_capabilities_arr)) {
						return TRUE;
					}
				}
				
				// Get user WordPress Role
				// When WP create it, use the function: wp_get_user_role()
				// When WP create it, use the function: wp_get_user_role()
				if (!function_exists('get_user_to_edit')) {
					include WPPostsRateKeys::$plugin_dir . '../../../wp-admin/includes/user.php';
				}
				$profileuser = get_user_to_edit($user_id);
				$user_roles = $profileuser->roles;
				$wp_role = array_shift($user_roles);
				
				$tmp_role_data = WPPostsRateKeys_RolesCapabilities::get($wp_role,'role_name','%s');
				$tmp_capabilities_arr = explode(',', $tmp_role_data->capabilities);
				
				// Check if user has the capability passed by parameter or the Admin capability
				if (in_array($capability, $tmp_capabilities_arr) || in_array(self::ADMIN, $tmp_capabilities_arr)) {
					return TRUE;
				}
				
				// If none match
				return FALSE;
			}
		}
	}
}