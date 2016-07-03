<?php

if ( !defined('ABSPATH') )
    exit; // Shhh

/**
 * Load and manage addons.
 * 
 * @since 2.0.0
 * @package TotalPoll\Addons
 */

Class TP_Addons {

    /**
     * Available addons.
     * 
     * @access public
     * @since 2.0.0
     * @type array
     */
    public $available;

    /**
     * Activated addons.
     * 
     * @since 2.0.0
     * @access public
     * @type array
     */
    public $activated;

    /**
     * Fetch and load addons.
     * 
     * @since 2.0.0
     * @return void
     */
    public function __construct()
    {
	// Fetch
	$this->fetch();

	// Then launch
	$this->load();
    }

    /**
     * Fetch addons.
     * Get a list of installed and activated addons.
     * @since 2.0.0
     * @return void
     */
    public function fetch()
    {
	/**
	 * Filter activated addons.
	 * 
	 * @since 2.0.0
	 * @filter tp_addons_get_activated
	 * @param array Activated addons.
	 */
	$this->activated = apply_filters('tp_addons_get_activated', get_site_option('tp_addons', array()));

	// Fetch addons directory
	$addons = glob(TP_ADDONS_PATH . '*', GLOB_ONLYDIR);
	$this->available = array();

	// Addon headers defaults
	$defaults = array(
	    'name' => 'Addon Name',
	    'website' => 'Addon URI',
	    'version' => 'Version',
	    'required' => 'Required',
	    'description' => 'Description',
	    'author' => 'Author',
	    'authorURI' => 'Author URI'
	);

	// Make a list of available addons
	foreach ( $addons as $addon_dir ):
	    // Check if 'addon.php' exists
	    $addon_root_file = $addon_dir . DS . 'addon.php';
	    if ( file_exists($addon_root_file) ):
		// Read addon headers
		$addon_info = get_file_data($addon_root_file, $defaults);
		// Add it to available list
		$this->available[basename($addon_dir)] = (object) $addon_info;
		// Check if this addon is currently activated
		$this->available[basename($addon_dir)]->compatible = version_compare($addon_info['required'], TP_VERSION, '<=');
		$this->available[basename($addon_dir)]->activated = $this->available[basename($addon_dir)]->compatible &&
			in_array(basename($addon_dir), $this->activated);
	    endif;
	endforeach;
    }

    /**
     * Load activated addons.
     * 
     * @since 2.0.0
     * @return void
     */
    private function load()
    {
	foreach ( $this->activated as $addon_dir ):
	    if ( !isset($this->available[$addon_dir]) )
		break;
	    // Incompatible
	    if ( !$this->available[$addon_dir]->compatible ):
		unset($this->activated[$addon_dir]);
		break;
	    endif;
	    // Check if 'addon.php' exists
	    $addon_root_file = TP_ADDONS_PATH . $addon_dir . DS . 'addon.php';
	    if ( file_exists($addon_root_file) ):
		/**
		 *  Include addon functionalities.
		 */
		include_once( $addon_root_file );
	    endif;
	endforeach;

	/**
	 * Fired when all activated addons are loaded.
	 * 
	 * @since 2.0.0
	 * @action tp_addons_loaded
	 * @param array Activated and laoded addons.
	 */
	do_action('tp_addons_loaded', $this->activated);
    }

    /**
     * Install an addon.
     * 
     * @since 2.0.0
     * @return void
     */
    public function install()
    {
	// Init a File_Upload_Upgrader
	$file_upload = new File_Upload_Upgrader('addonzip', 'package');

	// Setup
	$title = __('Upload Addon', TP_TD);
	$parent_file = 'edit.php?post_type=poll';
	$submenu_file = 'edit.php?post_type=poll&page=tp-addons-manager';

	// Settings for TP_Installer_Skin
	$title = sprintf(__('Installing Addon from uploaded file: %s', TP_TD), esc_html(basename($file_upload->filename)));
	$nonce = 'upload-addon';
	$url = add_query_arg(array( 'package' => $file_upload->id ), 'edit.php?post_type=poll&page=tp-addons-manager');
	$type = 'upload';

	// Init a TP_Installer
	$upgrader = new TP_Installer(new TP_Installer_Skin(compact('type', 'title', 'nonce', 'url')), 'addon');
	// Capture results
	$result = $upgrader->install($file_upload->package);

	// Check if there is an error
	if ( $result || is_wp_error($result) )
	    $file_upload->cleanup(); // Remove the uploaded file

	exit;
    }

    /**
     * Delete addon.
     * 
     * @since 2.0.0
     * @global type $wp_filesystem
     * @param string $addon addon directory name
     * @param string $redirect redirection after deletion
     * @see WP_Theme/delete
     * @return \WP_Error|bool Deletion result
     */
    public function delete($addon, $redirect = '')
    {
	global $wp_filesystem;

	if ( empty($addon) )
	    return false;

	ob_start();

	// Redirect to addons manager
	if ( empty($redirect) )
	    $redirect = wp_nonce_url('edit.php?post_type=poll&page=tp-addons-manager', 'delete-addon_' . $addon);

	// Request Filesystem crendentials
	if ( false === ($credentials = request_filesystem_credentials($redirect)) ) {
	    $data = ob_get_contents();
	    ob_end_clean();
	    if ( !empty($data) ) {
		include_once( ABSPATH . 'wp-admin/admin-header.php');
		echo $data;
		include( ABSPATH . 'wp-admin/admin-footer.php');
		exit;
	    }
	    return;
	}

	// Request again if there is a problem
	if ( !WP_Filesystem($credentials) ) {
	    request_filesystem_credentials($redirect, '', true); // Failed to connect, Error and request again
	    $data = ob_get_contents();
	    ob_end_clean();
	    if ( !empty($data) ) {
		include_once( ABSPATH . 'wp-admin/admin-header.php');
		echo $data;
		include( ABSPATH . 'wp-admin/admin-footer.php');
		exit;
	    }
	    return;
	}

	// Filesystem Failure
	if ( !is_object($wp_filesystem) )
	    return new WP_Error('fs_unavailable', __('Could not access filesystem.'));

	if ( is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->get_error_code() )
	    return new WP_Error('fs_error', __('Filesystem error.', TP_TD), $wp_filesystem->errors);

	//Get the base addon folder
	$addons_dir = TP_ADDONS_PATH;
	if ( empty($addons_dir) )
	    return new WP_Error('fs_no_addons_dir', __('Unable to locate TotalPoll addons directory.', TP_TD));

	// Prepare addon for deletion
	$addons_dir = trailingslashit($addons_dir);
	$addon_dir = trailingslashit($addons_dir . $addon);

	// Bratatatata!
	$deleted = $wp_filesystem->delete($addon_dir, true);

	// Bulletproof :)
	if ( !$deleted )
	    return new WP_Error('could_not_remove_addon', sprintf(__('Could not fully remove the addon %s.', TP_TD), $addon));

	return true;
    }

}
