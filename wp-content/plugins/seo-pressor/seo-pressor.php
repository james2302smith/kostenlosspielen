<?php
/*
Plugin Name: SEOPressor
Plugin URI: http://www.seopressor.com
Description: SEOPressor the Mandatory SEO Wordpress Plugin now optimizes your Wordpress better for top SEO ranking. Now powering more than 128K unique domains and 15 million Wordpress pages. <a href="admin.php?page=seopressor-make-money">Make Money</a> with SEOPressor now. Join our <a href="http://seopressor.com/affiliate-invite/">affiliate program</a>.
Version: 5.1
Author: SEOPressor on Facebook
Author URI: https://www.facebook.com/SEOPressorOfficial
*/

//error_reporting(E_ALL);

// Avoid name collisions.
if (!class_exists('WPPostsRateKeys')) {
	class WPPostsRateKeys
    {
       /**
	    * The Plugin version
	    * @var string
	    */
        const VERSION = '5.1';

       /**
    	 * Determine if the actions must been Logged
    	 *
    	 * @var bool
    	 */
    	const LOG_ENABLE = FALSE;

       /**
    	 * Determine if the errors must been Logged
    	 *
    	 * @var bool
    	 */
    	const ERROR_LOG_ENABLE = TRUE;

       /**
	    * The url to the plugin
	    *
	    * @static
	    * @var string
	    */
        static $plugin_url;

       /**
	    * The path to the plugin
	    *
	    * @static
	    * @var string
	    */
        static $plugin_dir;

       /**
	    * The prefix to the Database tables
	    *
	    * @static
	    * @var string
	    */
        static $db_prefix;

       /**
	    * The path to the plugin templates files
	    *
	    * @static
	    * @var string
	    */
        static $template_dir;

       /**
	    * The Plugin settings
	    *
	    * @static
	    * @var string
	    */
        static $settings;

        /**
	    * Timeout for requests (in seconds)
	    *
	    * @static
	    * @var int
	    */
        static $timeout;
        
        /**
         * Post types to ignore
         *
         * @static
         * @var array
         */
        static $post_types_to_ignore;

       /**
         * Executes all initialization code for the plugin.
         *
         * @return void
         * @access public
		 */
        function WPPostsRateKeys() {

        	if (isset($_GET['page']) && $_GET['page']=='seopressor-support') {
        		// Allow redirect
        		ob_start();
        	}
        	
        	// Add Post types to ignore
        	self::$post_types_to_ignore = array('thirstylink');

        	// Define static values
        	$dir_name = dirname( plugin_basename(__FILE__) );
        	self::$plugin_url = trailingslashit( plugins_url() . '/' . $dir_name);
        	self::$plugin_dir = trailingslashit( WP_PLUGIN_DIR . '/' . $dir_name);
        	
        	self::$template_dir = self::$plugin_dir . 'templates';
        	self::$db_prefix = 'seopressor_';
        	self::$timeout = 50; // By default is 5

        	// Include all classes
        	include(self::$plugin_dir . '/includes/all_classes.php');

        	// Check for old values of metadata
        	WPPostsRateKeys_WPPosts::update_non_hidden_metadata();
        	
        	// Schedule jobs
			self::add_actions_for_schedule_jobs();

			self::update_main_options (FALSE);

        	add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'));
			
			// Check is plugin is activated
			if (WPPostsRateKeys_Settings::get_active()) {
				// Add filter to show original content when editing POST content
	        	add_filter('content_edit_pre', array(&$this, 'get_content_to_edit'), 1);

	        	// Add filter for POST content
	        	add_filter('the_content', array(&$this, 'filter_post_content'), 1, 2);

	        	// Add filter for POST title
	        	add_filter('the_title', array(&$this, 'filter_post_title'), 10, 2);

	        	// Add actions to handle the Update of a POST or PAGE, in order to store the keyword
	           	add_action('save_post',  array(&$this, 'handle_update_post_form'),11,2);
	           	add_action('save_page',  array(&$this, 'handle_update_post_form'),11,2);

	           	// Actions when post is published, usefull to compare score with minimum in settings
	           	add_action('publish_post',  array(&$this, 'handle_publish_post'),11,2);
	           	add_action('publish_page',  array(&$this, 'handle_publish_post'),11,2);

	           	// Filter the Posts Slugs
	           	add_filter('name_save_pre', array('WPPostsRateKeys_Filters','filter_post_slug'),0);

	           	// Add link in WP footer if user allow it
	           	if (WPPostsRateKeys_Settings::get_allow_seopressor_footer())
	           		add_action('wp_footer', array(&$this, 'handle_add_to_footer'));

	           	// Add action to modify WordPress head
	           	add_action('wp_head', array(&$this, 'wp_head'));

	           	// Add new user profile fields
	           	add_action( 'user_contactmethods', array(&$this, 'add_user_contactmethods') );

			}

			// Add AJAX support through native WP admin-ajax action
			add_action('wp_ajax_seopressor_list', array(&$this, 'ajax_list'));
			add_action('wp_ajax_seopressor_add', array(&$this, 'ajax_add'));
			add_action('wp_ajax_seopressor_del', array(&$this, 'ajax_del'));
			add_action('wp_ajax_seopressor_update', array(&$this, 'ajax_update'));
			add_action('wp_ajax_seopressor_box', array(&$this, 'ajax_box'));
			
			add_action('wp_ajax_seopressor_posts_select', array(&$this, 'ajax_html_posts_select'));
			add_action('wp_ajax_seopressor_html_posts_select', array(&$this, 'ajax_html_posts_select'));
			add_action('wp_ajax_seopressor_capabilities_select', array(&$this, 'ajax_html_capabilities_select'));
			add_action('wp_ajax_seopressor_users_select', array(&$this, 'ajax_html_users_select'));
			add_action('wp_ajax_seopressor_roles_select', array(&$this, 'ajax_html_roles_select'));
			
			// Add Menu Box in Admin Panel
           	add_action('admin_menu', array(&$this, 'admin_menu'));

           	// If the plugin isn't activated by Aweber or can be upgrade, show message
           	add_action('admin_notices', array(&$this, 'show_admin_notice'));

           	// If plugin can be upgrade, show message
			add_action("after_plugin_row", array(&$this, 'show_notice_plugins_page'), 10, 2);

			// Add the widget in dashboard
			add_action('wp_dashboard_setup', array(&$this, 'add_dashboard_widget'));

			// Update box suggestions data on rich text editor changes
			add_filter('tiny_mce_before_init', array(&$this, 'update_box_suggestions_data'));

			// Init actions
			add_filter('init', array(&$this, 'wp_init'));
			
			// Translations for plugin
			self::handle_load_domain();
        }
        
        function admin_enqueue_scripts_common() {
        	wp_enqueue_style('jquery');
        	wp_enqueue_style('seop_jquery-ui', self::$plugin_url . 'templates/js/lib/ui/css/jquery-ui.css');
        	 
        	wp_register_script('seop_begin_isolation', self::$plugin_url . 'templates/js/begin_isolation.js');
        	
        	// Determine protocol
        	global $wp_version;
        	if (version_compare($wp_version,'3.5','<')) {
        		// If less than 3.5
        		if (is_ssl()) {
        			$protocol = 'https://';
        		}
        		else {
        			$protocol = 'http://';
        		}
        	}
        	else {
        		// Use it protocol-agnostic URL
        		$protocol = '//';
        	}
        	
        	wp_register_script('seop_jQuery', $protocol . 'ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', array('seop_begin_isolation'), '1.8.3');
        	wp_register_script('seop_jQuery-UI', $protocol . 'ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js', array('seop_begin_isolation'), '1.9.2');
        	//Include: jquery.ui.core.js, jquery.ui.widget.js, jquery.ui.mouse.js, jquery.ui.draggable.js, jquery.ui.droppable.js, jquery.ui.resizable.js, jquery.ui.selectable.js, jquery.ui.sortable.js, jquery.ui.effect.js, jquery.ui.accordion.js, jquery.ui.autocomplete.js, jquery.ui.button.js, jquery.ui.datepicker.js, jquery.ui.dialog.js, jquery.ui.effect-blind.js, jquery.ui.effect-bounce.js, jquery.ui.effect-clip.js, jquery.ui.effect-drop.js, jquery.ui.effect-explode.js, jquery.ui.effect-fade.js, jquery.ui.effect-fold.js, jquery.ui.effect-highlight.js, jquery.ui.effect-pulsate.js, jquery.ui.effect-scale.js, jquery.ui.effect-shake.js, jquery.ui.effect-slide.js, jquery.ui.effect-transfer.js, jquery.ui.menu.js, jquery.ui.position.js, jquery.ui.progressbar.js, jquery.ui.slider.js, jquery.ui.spinner.js, jquery.ui.tabs.js, jquery.ui.tooltip.js
        	wp_register_script('seop_global', self::$plugin_url . 'templates/js/global-min.js');
        	wp_register_script('seop_end_isolation', self::$plugin_url . 'templates/js/end_isolation.js');
        	
        	wp_enqueue_script('seop_begin_isolation');
        	wp_enqueue_script('seop_jQuery');
        	wp_enqueue_script('seop_jQuery-UI');
        	
        	wp_localize_script(
        	'seop_jQuery'
        			, 'WPPostsRateKeys'
        			, array(
        			'plugin_url' => self::$plugin_url
        			)
        	);
        }
        
        /*
         * Load admin JS and CSS
         * 
         * Only if we are in any of the SEOPressor pages
         */
        function admin_enqueue_scripts() {
        	
        	/*
        	 * In add/edit Post/Page page
        	 */
        	global $pagenow;
        	if (in_array( $pagenow, array( 'post.php', 'post-new.php' ))) {
        		
        		self::admin_enqueue_scripts_common();
        		
	        	/*
	        	 * Show Post Box
	        	*/
	        	// Load needed styles.
	        	wp_enqueue_style('thickbox'); //WordPress resource
                //wp_enqueue_style('jquery-ui', self::$plugin_url . 'templates/js/lib/ui/css/jquery-ui.css');
	        	wp_enqueue_style('jquery-uniform', self::$plugin_url . 'templates/js/lib/uniform/css/uniform.default.css');
	        	wp_enqueue_style('jquery-chosen', self::$plugin_url . 'templates/js/lib/chosen/chosen.css');
	        	wp_enqueue_style('jquery-iCheckbox', self::$plugin_url . 'templates/js/lib/iCheckbox/css/iCheckbox.css');
	        	wp_enqueue_style('jquery-ui-datetimepicker', self::$plugin_url . 'templates/js/lib/timepicker/css/jquery-ui-timepicker-addon.css');
	        	wp_enqueue_style('jquery-prettyPhoto', self::$plugin_url . 'templates/js/lib/prettyPhoto/css/prettyPhoto.css');
	        	wp_enqueue_style('seopressor-global', self::$plugin_url . 'templates/css/global.css');
	        	wp_enqueue_style('seopressor-postbox', self::$plugin_url . 'templates/css/postbox.css');
	        	
	        	// Load needed script libraries.
	        	wp_enqueue_script('thickbox');  //WordPress resource
	        	//wp_enqueue_script('jquery-effects-blind');
	        	//wp_enqueue_script('jquery-ui-tabs');
	        	//wp_enqueue_script('jquery-ui-slider');
	        	//wp_enqueue_script('jquery-ui-button');
	        	//wp_enqueue_script('jquery-ui-datepicker');


	        	wp_enqueue_script('jquery-ui-datetimepicker', self::$plugin_url . 'templates/js/lib/timepicker/js/jquery-ui-timepicker-addon-min.js');
	        	wp_enqueue_script('jquery-infieldlabel', self::$plugin_url . 'templates/js/lib/jquery.infieldlabel-min.js');
	        	wp_enqueue_script('jquery-cookie', self::$plugin_url . 'templates/js/lib/jquery-cookie-min.js');
	        	wp_enqueue_script('jquery-uniform', self::$plugin_url . 'templates/js/lib/uniform/jquery.uniform-min.js');
	        	wp_enqueue_script('seop-jquery-chosen', self::$plugin_url . 'templates/js/lib/chosen/chosen-min.js');
	        	wp_enqueue_script('jquery-iCheckbox', self::$plugin_url . 'templates/js/lib/iCheckbox/jquery.iCheckbox-min.js');
	        	wp_enqueue_script('jquery-prettyPhoto', self::$plugin_url . 'templates/js/lib/prettyPhoto/js/jquery.prettyPhoto-min.js');
                wp_enqueue_script('seop_end_isolation');
                wp_enqueue_script('seop_global');
	        	wp_enqueue_script('seopressor-postbox', self::$plugin_url . 'templates/js/postbox-min.js');
	        	
	        	/*
	        	 * Box Below
	        	 */
	        	// Load needed script libraries.
	        	//wp_enqueue_script('jquery-ui-tabs');
        	}
        	elseif (isset($_REQUEST['page'])
        			&& $_REQUEST['page']=='seo-pressor.php') {
        		
        		/*
        		 * Settings
        		*/
        		
        		self::admin_enqueue_scripts_common();
        		
	        	// Load needed styles.
	        	//wp_enqueue_style('jquery-ui', self::$plugin_url . 'templates/js/lib/ui/css/jquery-ui.css');
	        	wp_enqueue_style('jquery-uniform', self::$plugin_url . 'templates/js/lib/uniform/css/uniform.default.css');
	        	wp_enqueue_style('jquery-prettyPhoto', self::$plugin_url . 'templates/js/lib/prettyPhoto/css/prettyPhoto.css');
	        	wp_enqueue_style('jquery-iCheckbox', self::$plugin_url . 'templates/js/lib/iCheckbox/css/iCheckbox.css');
	        	wp_enqueue_style('jquery-chosen', self::$plugin_url . 'templates/js/lib/chosen/chosen.css');
	        	wp_enqueue_style('seopressor-global', self::$plugin_url . 'templates/css/global.css');
	        	wp_enqueue_style('seopressor-settings', self::$plugin_url . 'templates/css/settings.css');
	        	
	        	// Load needed script libraries.
	        	//wp_enqueue_script('jquery-ui-tabs');
	        	//wp_enqueue_script('jquery-ui-button');
	        	//wp_enqueue_script('jquery-effects-highlight');
	        	wp_enqueue_script('jquery-cookie', self::$plugin_url . 'templates/js/lib/jquery-cookie-min.js');
	        	wp_enqueue_script('jquery-uniform', self::$plugin_url . 'templates/js/lib/uniform/jquery.uniform-min.js');
	        	wp_enqueue_script('seop_jquery-form', self::$plugin_url . 'templates/js/lib/jquery.form-min.js');
	        	wp_enqueue_script('jquery-prettyPhoto', self::$plugin_url . 'templates/js/lib/prettyPhoto/js/jquery.prettyPhoto-min.js');
	        	wp_enqueue_script('jquery-iCheckbox', self::$plugin_url . 'templates/js/lib/iCheckbox/jquery.iCheckbox-min.js');
	        	wp_enqueue_script('seop-jquery-chosen', self::$plugin_url . 'templates/js/lib/chosen/chosen-min.js');
	        	wp_enqueue_script('jquery-scrollTo', self::$plugin_url . 'templates/js/lib/jquery.scrollTo-min.js');
                wp_enqueue_script('seop_end_isolation');
                wp_enqueue_script('seop_global');
	        	wp_enqueue_script('seopressor-settings', self::$plugin_url . 'templates/js/settings-min.js', null, '5.0.2.1');
        	}
        	elseif (isset($_REQUEST['page'])
        			&& $_REQUEST['page']=='seopressor-score') {
        		
        		/*
        		 * Handle Score
        		*/
        		
        		self::admin_enqueue_scripts_common();
        		
	        	// Load needed styles.
	        	wp_enqueue_style('thickbox'); //WordPress resource
				//wp_enqueue_style('jquery-ui', self::$plugin_url . 'templates/js/lib/ui/css/jquery-ui.css');
				wp_enqueue_style('jquery-jqgrid', self::$plugin_url . 'templates/js/lib/jqGrid/css/ui.jqgrid.css');
				wp_enqueue_style('seopressor-global', self::$plugin_url . 'templates/css/global.css');
				wp_enqueue_style('seopressor-settings', self::$plugin_url . 'templates/css/settings.css');
	
				// Load needed script libraries.
	        	wp_enqueue_script('thickbox'); //WordPress resource
	        	//wp_enqueue_script('jquery-effects-highlight');
	        	//wp_enqueue_script('jquery-ui-datepicker');
	        	//wp_enqueue_script('jquery-ui-dialog');
                wp_enqueue_script('jquery-cookie', self::$plugin_url . 'templates/js/lib/jquery-cookie-min.js');
	        	wp_enqueue_script('jquery-jqgrid-locale', self::$plugin_url . 'templates/js/lib/jqGrid/js/i18n/grid.locale-en.js');
	        	wp_enqueue_script('jquery-jqgrid', self::$plugin_url . 'templates/js/lib/jqGrid/js/jquery.jqGrid-min.js');
                wp_enqueue_script('seop_end_isolation');
                wp_enqueue_script('seop_global');
	        	wp_enqueue_script('seopressor-score', self::$plugin_url . 'templates/js/score-min.js');
        	}
        	elseif (isset($_REQUEST['page'])
        			&& $_REQUEST['page']=='seopressor-automatic-internal-link') {
        		/*
        		 * Handle automatic Internal links
        		*/
        		
        		self::admin_enqueue_scripts_common();
        		
	        	// Load needed styles.
	        	wp_enqueue_style('thickbox'); //WordPress resource
				//wp_enqueue_style('jquery-ui', self::$plugin_url . 'templates/js/lib/ui/css/jquery-ui.css');
				wp_enqueue_style('jquery-jqgrid', self::$plugin_url . 'templates/js/lib/jqGrid/css/ui.jqgrid.css');
				wp_enqueue_style('jquery-chosen', self::$plugin_url . 'templates/js/lib/chosen/chosen.css');
				wp_enqueue_style('seopressor-global', self::$plugin_url . 'templates/css/global.css');
				wp_enqueue_style('seopressor-settings', self::$plugin_url . 'templates/css/settings.css');
	
				// Load needed script libraries.
	        	wp_enqueue_script('thickbox'); //WordPress resource
	        	//wp_enqueue_script('jquery-ui-button');
	        	wp_enqueue_script('jquery-cookie', self::$plugin_url . 'templates/js/lib/jquery-cookie-min.js');
	        	wp_enqueue_script('jquery-jqgrid-locale', self::$plugin_url . 'templates/js/lib/jqGrid/js/i18n/grid.locale-en-min.js');
	        	wp_enqueue_script('jquery-jqgrid', self::$plugin_url . 'templates/js/lib/jqGrid/js/jquery.jqGrid-min.js');
	        	wp_enqueue_script('seop-jquery-chosen', self::$plugin_url . 'templates/js/lib/chosen/chosen-min.js');
                wp_enqueue_script('seop_end_isolation');
                wp_enqueue_script('seop_global');
	        	wp_enqueue_script('seopressor-automatic-internal-link', self::$plugin_url . 'templates/js/automatic_internal_link-min.js');
        	}
        	elseif (isset($_REQUEST['page'])
        			&& $_REQUEST['page']=='seopressor-external-cloaked') {
        		
        		/*
        		 * External cloaked
        		*/
        		
        		self::admin_enqueue_scripts_common();
        		
	        	// Load needed styles.
	        	wp_enqueue_style('thickbox'); //WordPress resource
				//wp_enqueue_style('jquery-ui', self::$plugin_url . 'templates/js/lib/ui/css/jquery-ui.css');
				wp_enqueue_style('jquery-jqgrid', self::$plugin_url . 'templates/js/lib/jqGrid/css/ui.jqgrid.css');
				wp_enqueue_style('jquery-chosen', self::$plugin_url . 'templates/js/lib/chosen/chosen.css');
				wp_enqueue_style('seopressor-global', self::$plugin_url . 'templates/css/global.css');
				wp_enqueue_style('seopressor-settings', self::$plugin_url . 'templates/css/settings.css');
	
				// Load needed script libraries.
	        	wp_enqueue_script('thickbox'); //WordPress resource
	        	//wp_enqueue_script('jquery-ui-button');
	        	wp_enqueue_script('jquery-cookie', self::$plugin_url . 'templates/js/lib/jquery-cookie-min.js');
	        	wp_enqueue_script('jquery-jqgrid-locale', self::$plugin_url . 'templates/js/lib/jqGrid/js/i18n/grid.locale-en-min.js');
	        	wp_enqueue_script('jquery-jqgrid', self::$plugin_url . 'templates/js/lib/jqGrid/js/jquery.jqGrid-min.js');
	        	wp_enqueue_script('seop-jquery-chosen', self::$plugin_url . 'templates/js/lib/chosen/chosen-min.js');
                wp_enqueue_script('seop_end_isolation');
                wp_enqueue_script('seop_global');
	        	wp_enqueue_script('seopressor-external-cloaked', self::$plugin_url . 'templates/js/external_cloaked-min.js');
        	}
        	elseif (isset($_REQUEST['page'])
        			&& $_REQUEST['page']=='seopressor-role-settings') {
        		
        		/*
        		 * Handle Role Settings
        		*/
        		
        		self::admin_enqueue_scripts_common();
        		
	        	// Load needed styles.
	        	wp_enqueue_style('thickbox'); //WordPress resource
				//wp_enqueue_style('jquery-ui', self::$plugin_url . 'templates/js/lib/ui/css/jquery-ui.css');
				wp_enqueue_style('jquery-jqgrid', self::$plugin_url . 'templates/js/lib/jqGrid/css/ui.jqgrid.css');
				wp_enqueue_style('jquery-iCheckbox', self::$plugin_url . 'templates/js/lib/iCheckbox/css/iCheckbox.css');
				wp_enqueue_style('jquery-chosen', self::$plugin_url . 'templates/js/lib/chosen/chosen.css');
				wp_enqueue_style('seopressor-global', self::$plugin_url . 'templates/css/global.css');
				wp_enqueue_style('seopressor-settings', self::$plugin_url . 'templates/css/settings.css');
	
				// Load needed script libraries.
	        	wp_enqueue_script('thickbox'); //WordPress resource
	        	//wp_enqueue_script('jquery-ui-tabs');
	        	//wp_enqueue_script('jquery-ui-button');
	        	//wp_enqueue_script('jquery-effects-highlight');
	        	wp_enqueue_script('jquery-cookie', self::$plugin_url . 'templates/js/lib/jquery-cookie-min.js');
	        	wp_enqueue_script('seop_jquery-form', self::$plugin_url . 'templates/js/lib/jquery.form-min.js');
	        	wp_enqueue_script('jquery-iCheckbox', self::$plugin_url . 'templates/js/lib/iCheckbox/jquery.iCheckbox-min.js');
	        	wp_enqueue_script('jquery-jqgrid-locale', self::$plugin_url . 'templates/js/lib/jqGrid/js/i18n/grid.locale-en-min.js');
	        	wp_enqueue_script('jquery-jqgrid', self::$plugin_url . 'templates/js/lib/jqGrid/js/jquery.jqGrid-min.js');
	        	wp_enqueue_script('seop-jquery-chosen', self::$plugin_url . 'templates/js/lib/chosen/chosen-min.js');
                wp_enqueue_script('seop_end_isolation');
                wp_enqueue_script('seop_global');
	        	wp_enqueue_script('seopressor-role-settings', self::$plugin_url . 'templates/js/role_settings-min.js');
        	}
        	elseif (isset($_REQUEST['page'])
        			&& $_REQUEST['page']=='seopressor-make-money') {
        		
        		/*
        		 * Handle Make Money
        		*/
        		
        		self::admin_enqueue_scripts_common();
        		
	        	// Load needed styles.
				wp_enqueue_style('farbtastic');  //WordPress resource
				//wp_enqueue_style('jquery-ui', self::$plugin_url . 'templates/js/lib/ui/css/jquery-ui.css');
				wp_enqueue_style('jquery-iCheckbox', self::$plugin_url . 'templates/js/lib/iCheckbox/css/iCheckbox.css');
				wp_enqueue_style('seopressor-global', self::$plugin_url . 'templates/css/global.css');
				wp_enqueue_style('seopressor-settings', self::$plugin_url . 'templates/css/settings.css');
	
				// Load needed script libraries.
	        	//wp_enqueue_script('farbtastic'); //WordPress resource
	        	//wp_enqueue_script('jquery-ui-button');
	        	//wp_enqueue_script('jquery-effects-highlight');
                wp_enqueue_script('seop_farbtastic', self::$plugin_url . 'templates/js/lib/wordpress/farbtastic-min.js');
	        	wp_enqueue_script('jquery-cookie', self::$plugin_url . 'templates/js/lib/jquery-cookie-min.js');
	        	wp_enqueue_script('seop_jquery-form', self::$plugin_url . 'templates/js/lib/jquery.form-min.js');
	        	wp_enqueue_script('jquery-iCheckbox', self::$plugin_url . 'templates/js/lib/iCheckbox/jquery.iCheckbox-min.js');
                wp_enqueue_script('seop_end_isolation');
                wp_enqueue_script('seop_global');
	        	wp_enqueue_script('seopressor-make-money', self::$plugin_url . 'templates/js/make_money-min.js');
        	}
        }
        
        /**
         * Handles the AJAX action for list objects
         *
         * @version	v5.0
         */
        function ajax_list() {
        	// This is how you get access to the database
        	global $wpdb;
        		
        	include(self::$plugin_dir . 'pages/ajax/list_data.php');
        }
        	
        /**
         * Handles the AJAX action for list objects
         *
         * @version	v5.0
         */
        function ajax_add() {
        	// This is how you get access to the database
        	global $wpdb;
        		
        	include(self::$plugin_dir . 'pages/ajax/add_data.php');
        }
        	
        /**
         * Handles the AJAX action for del objects
         *
         * @version	v5.0
         */
        function ajax_del() {
        	// This is how you get access to the database
        	global $wpdb;
        		
        	include(self::$plugin_dir . 'pages/ajax/delete_data.php');
        }
        	
        /**
         * Handles the AJAX action for update settings
         *
         * @version	v5.0
         */
        function ajax_update() {
        	// This is how you get access to the database
        	global $wpdb;
        		
        	include(self::$plugin_dir . 'pages/ajax/update_settings.php');
        }
        	
        /**
         * Handles the AJAX action for postbox settings
         *
         * @version	v5.0
         */
        function ajax_box() {
        	// This is how you get access to the database
        	global $wpdb;
        		
        	include(self::$plugin_dir . 'pages/ajax/box_suggestions.php');
        }
        	
        /**
         * Handles the AJAX action for HTML dropdown posts_select
         *
         * @version	v5.0
         */
        function ajax_html_posts_select() {
        	// This is how you get access to the database
        	global $wpdb;
        		
        	include(self::$plugin_dir . 'pages/ajax/html/posts_select.php');
        }
        	
        /**
         * Handles the AJAX action for HTML dropdown capabilities_select
         *
         * @version	v5.0
         */
        function ajax_html_capabilities_select() {
        	// This is how you get access to the database
        	global $wpdb;
        		
        	include(self::$plugin_dir . 'pages/ajax/html/capabilities_select.php');
        }
        	
        /**
         * Handles the AJAX action for HTML dropdown users_select
         *
         * @version	v5.0
         */
        function ajax_html_users_select() {
        	// This is how you get access to the database
        	global $wpdb;
        		
        	include(self::$plugin_dir . 'pages/ajax/html/users_select.php');
        }
        	
        /**
         * Handles the AJAX action for HTML dropdown roles_select
         *
         * @version	v5.0
         */
        function ajax_html_roles_select() {
        	// This is how you get access to the database
        	global $wpdb;
        		
        	include(self::$plugin_dir . 'pages/ajax/html/roles_select.php');
        }

        function add_user_contactmethods( $user_contactmethods ) {

        	$facebook_icon = '<div style="position:relative"><img style="position:absolute;top:0.24em;right:-26.5em;" src="' . self::$plugin_url . 'templates/images/icons/social/facebook.png" alt="Facebook" height="16" />';
        	$user_contactmethods['seopressor_facebook_og_author'] = $facebook_icon . __( 'Facebook Profile URL', 'seopressor' ) . '</div>';
        	
        	$twitter_icon = '<div style="position:relative"><img style="position:absolute;top:0.24em;right:-26.5em;" src="' . self::$plugin_url . 'templates/images/icons/social/twitter.png" alt="Twitter" height="16" />';
        	$user_contactmethods['seopressor_twitter_user_card'] = $twitter_icon . __( 'Twitter ID', 'seopressor' ) . '</div>';

        	$google_icon = '<div style="position:relative"><img style="position:absolute;top:0.24em;right:-26.5em;" src="' . self::$plugin_url . 'templates/images/icons/social/googleplus.png" alt="Google Plus" height="16" />';
        	$user_contactmethods['seopressor_google_plus_auth_url'] = $google_icon . __( 'Google Plus Profile URL', 'seopressor' ) . '</div>';
        	
        	return $user_contactmethods;
        }

        /**
         * Init actions
         *
         */
    	function wp_init() {
    		$settings = WPPostsRateKeys_Settings::get_options();
    		// Check for advertisement setting
    		$allow_advertising_program = $settings['allow_advertising_program'];
    		if ($allow_advertising_program=='1') {
    			// Check visits, only when visits in front end
    			// Only if user choose participate
    			WPPostsRateKeys_Visits::check();
    		}
    	}

        /**
         * Change the header of the Pages
         *
         * For meta keywords and description
         */
    	function wp_head() {

    		// Only to add the head in Single page where Post is shown
			if (is_single() || is_page()) {
				$post_id = get_the_ID();

				$allow_meta_keyword_metadata = WPPostsRateKeys_WPPosts::get_allow_meta_keyword($post_id);
				if ($allow_meta_keyword_metadata=='1') {
					// Can be: seopressor_keywords, tags, categories
					$use_for_meta_keyword_metadata = WPPostsRateKeys_WPPosts::get_use_for_meta_keyword($post_id);

					$meta_value = '';
					if ($use_for_meta_keyword_metadata=='tags') {
						$tags_arr = wp_get_post_tags($post_id,array('fields'=>'names'));

						if (count($tags_arr)>0) {
							$meta_value = implode(',', $tags_arr);
						}
					}
					elseif ($use_for_meta_keyword_metadata=='categories') {
						$categories_arr = wp_get_post_categories($post_id,array('fields'=>'names'));

						if (count($categories_arr)>0) {
							$meta_value = implode(',', $categories_arr);
						}
					}
					else {
						// This is the default option: ($use_for_meta_keyword_metadata=='seopressor_keywords')
						// Get keywords 1, 2 and 3
						$keys = array();
						$key1 = WPPostsRateKeys_WPPosts::get_keyword($post_id);
						if ($key1!='') {
							$keys[] = $key1;
						}
						$key2 = WPPostsRateKeys_WPPosts::get_keyword2($post_id);
						if ($key2!='') {
							$keys[] = $key2;
						}
						$key3 = WPPostsRateKeys_WPPosts::get_keyword3($post_id);
						if ($key3!='') {
							$keys[] = $key3;
						}

						if (count($keys)>0) {
							$meta_value = implode(',', $keys);
						}
					}

					if (trim($meta_value)!='') {
						echo '<meta name="keywords" content="' . $meta_value . '" />';
					}
				}

				$allow_meta_description_metadata = WPPostsRateKeys_WPPosts::get_allow_meta_description($post_id);
				if ($allow_meta_description_metadata=='1') {
					$meta_description_metadata = WPPostsRateKeys_WPPosts::get_meta_description($post_id);

					if (trim($meta_description_metadata)!='') {
						echo '<meta name="description" content="' . $meta_description_metadata . '" />';
					}
				}

				$allow_meta_title_metadata = WPPostsRateKeys_WPPosts::get_allow_meta_title($post_id);
				if ($allow_meta_title_metadata=='1') {
					$meta_title_metadata = WPPostsRateKeys_WPPosts::get_meta_title($post_id);

					if (trim($meta_title_metadata)!='') {
						echo '<meta name="title" content="' . $meta_title_metadata . '" />';
					}
				}

				/*
				 * Get general information for meta tags
				 */
				$post = get_post($post_id);

				/* Permalink of the content */
				$url = get_permalink( $post->ID );

				if ( has_excerpt( $post->ID ) ) {
					$meta_description = strip_tags( get_the_excerpt( ) );
				} else {
					if (WPPostsRateKeys_Settings::support_multibyte()) {
						$meta_description = str_replace( "\r\n", ' ' , mb_substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, 160,'UTF-8' ) );
					}
					else {
						$meta_description = str_replace( "\r\n", ' ' , substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, 160 ) );
					}
					$meta_description .= '(...)';
				}

				if (WPPostsRateKeys_WPPosts::get_og_image_use($post_id)=='1') {
					$meta_image = WPPostsRateKeys_WPPosts::get_featured_image_url($post_id);
					if ($meta_image=='') {
						$meta_image = WPPostsRateKeys_WPPosts::get_og_image($post_id);
					}
				}
				else {
					$meta_image = '';
				}
				
				$meta_title = get_the_title();

				/*
				 * Add Open Graph meta data
				 */
				$settings = WPPostsRateKeys_Settings::get_options();
				if ($settings['enable_socialseo_facebook']=='1'
						&& WPPostsRateKeys_WPPosts::get_meta_enable_socialseo_facebook($post_id)=='1') {
					
					// Get author, publisher, title and description
					$og_author_tmp = WPPostsRateKeys_WPPosts::get_meta_socialseo_facebook_author($post_id);
					if ($og_author_tmp=='') {
						$og_author_tmp = get_the_author_meta( 'seopressor_facebook_og_author', $post->post_author );
					}
					$og_publisher_tmp = WPPostsRateKeys_WPPosts::get_meta_socialseo_facebook_publisher($post_id);
					$og_title_tmp = WPPostsRateKeys_WPPosts::get_meta_socialseo_facebook_title($post_id);
					if ($og_title_tmp=='') {
						$og_title_tmp = $meta_title;
					}
					$og_description_tmp = WPPostsRateKeys_WPPosts::get_meta_socialseo_facebook_description($post_id);
					if ($og_description_tmp=='') {
						$og_description_tmp = $meta_description;
					}
					
					echo '<!-- Open Graph from SEOPressor -->' . "\r\n";
					echo '<meta property="og:type"   content="article" />' . "\r\n";
					echo '<meta property="og:url"    content="' . esc_url( $url ) . '" />' . "\r\n";
					if (get_bloginfo() != '') echo '<meta property="og:site_name"    content="' . get_bloginfo() . '" />' . "\r\n";
					if ($og_title_tmp != '') echo '<meta property="og:title"  content="' . esc_attr( $og_title_tmp ) . '" />' . "\r\n";
					if ($og_author_tmp != '') echo '<meta property="article:author"  content="' . esc_attr( $og_author_tmp ) . '" />' . "\r\n";
					if ($og_publisher_tmp != '') echo '<meta property="article:publisher"  content="' . esc_attr( $og_publisher_tmp ) . '" />' . "\r\n";
					if ($og_description_tmp != '')	echo '<meta property="og:description"  content="' . esc_attr( $og_description_tmp ) . '" /> ' . "\r\n";
					if ($meta_image != '') echo '<meta property="og:image"  content="' . esc_url( $meta_image ) . '" />' . "\r\n";
				}

				/*
				 * Add Twitter Hcard HCard
				 */
				if ($settings['enable_socialseo_twitter']=='1'
						&& WPPostsRateKeys_WPPosts::get_meta_enable_socialseo_twitter($post_id)=='1') {
					
					// Get title and description
					$twitter_title_tmp = WPPostsRateKeys_WPPosts::get_meta_socialseo_twitter_title($post_id);
					if ($twitter_title_tmp=='') {
						$twitter_title_tmp = $meta_title;
					}
					$twitter_description_tmp = WPPostsRateKeys_WPPosts::get_meta_socialseo_twitter_description($post_id);
					if ($twitter_description_tmp=='') {
						$twitter_description_tmp = apply_filters( 'meta_description', $meta_description );
					}
					
					$twitter_card = get_the_author_meta( 'seopressor_twitter_user_card', $post->post_author );
					echo '<meta name="twitter:card" content="summary">' . "\n";
					echo '<meta name="twitter:site" content="' . esc_attr( $twitter_card ) . '">' . "\n";
					echo '<meta name="twitter:creator" content="' . esc_attr( $twitter_card ) . '">' . "\n";
					echo '<meta name="twitter:url" content="' . esc_url( $url ) . '">' . "\n";
					echo '<meta name="twitter:title" content="' . esc_attr( $twitter_title_tmp ) . '">' . "\n";
					echo '<meta name="twitter:description" content="' . esc_attr( $twitter_description_tmp ) . '">' . "\n";
					//echo '<meta name="twitter:image" content="' . esc_url( $meta_image ) . '">' . "\n";
				}
				/*
				 * Add Google authorship
				 */
				$google_plus_auth_url = trim(get_the_author_meta( 'seopressor_google_plus_auth_url', $post->post_author ));
				if ($google_plus_auth_url!='') {
					echo '<link rel="author" href="' . $google_plus_auth_url . '"/>' . "\n";
					echo '<link rel="publisher" href="' . $google_plus_auth_url . '"/>' . "\n";
				}
				/*
				 * Add Dublin Core
				 */
				if ($settings['enable_dublincore']=='1'
						&& WPPostsRateKeys_WPPosts::get_meta_enable_dublincore($post_id)=='1') {
					
					// Get title and description
					$dublincore_title_tmp = WPPostsRateKeys_WPPosts::get_meta_dublincore_title($post_id);
					if ($dublincore_title_tmp=='') {
						$dublincore_title_tmp = $meta_title;
					}
					$dublincore_description_tmp = WPPostsRateKeys_WPPosts::get_meta_dublincore_description($post_id);
					if ($dublincore_description_tmp=='') {
						$dublincore_description_tmp = $meta_description;
					}
					
					echo '<meta name="DC.Title" content="' . esc_attr( $dublincore_title_tmp ) . '" >';
					echo '<meta name="DC.Creator" content="' . esc_attr( $google_plus_auth_url ) . '" >';
					echo '<meta name="DC.Description" content="' . esc_attr( $dublincore_description_tmp ) . '" >';
					echo '<meta name="DC.Date" content="' . $post->post_date . '" >';
					echo '<meta name="DC.Type" content="Article" >';
				}
			}

			// Add the AdRoll pixel if user choose participate
			$settings = WPPostsRateKeys_Settings::get_options();
			// Check for advertisement setting
			$allow_advertising_program = $settings['allow_advertising_program'];
			if ($allow_advertising_program=='1') { ?>
				<script type="text/javascript">
					adroll_adv_id = "KPFFS77YXJC2VE35CIKS6J";
					adroll_pix_id = "PZJGTLAQ6NGUVNYS442KQ3";
					(function () {
						var oldonload = window.onload;
						window.onload = function(){
						   __adroll_loaded=true;
						   var scr = document.createElement("script");
						   var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
						   scr.setAttribute('async', 'true');
						   scr.type = "text/javascript";
						   scr.src = host + "/j/roundtrip.js";
						   ((document.getElementsByTagName('head') || [null])[0] ||
						    document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
						   if(oldonload){oldonload()}};
						}());
						</script>
			<?php
			}
    	}

        /**
         * Update box suggestions data on rich text editor changes
         * @param array $initArray
         */
        function update_box_suggestions_data($initArray){
			$initArray['setup'] = <<<JS
[function(ed) {
    ed.onChange.add(function(ed, e) {
		// Update HTML view textarea (that is the one used to send the data to server).
		ed.save();
	});
}][0]
JS;

			return $initArray;
		}

        /**
         * Add the widget in dashboard
         *
         * @return void
         * @access public
         */
        function add_dashboard_widget() {

        	$message_from_server = WPPostsRateKeys_Central::get_specific_data_from_server('dashboard_box_message');
        	// Compare after strip tags to avoid show empty box to users
        	if (strip_tags($message_from_server)!='') {
	        	$_SESSION['seopressor_message_from_server'] = $message_from_server;
	        	wp_add_dashboard_widget('seopressor_dashboard_widget', 'SEOPressor', array(&$this, 'show_dashboard_widget'));

	        	// Globalize the metaboxes array, this holds all the widgets for wp-admin
				global $wp_meta_boxes;

				// Get the regular dashboard widgets array
				// (which has our new widget already but at the end)

				$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

				// Backup and delete our new dashbaord widget from the end of the array
				$seopressor_dashboard_widget_backup = array('seopressor_dashboard_widget' => $normal_dashboard['seopressor_dashboard_widget']);
				unset($normal_dashboard['seopressor_dashboard_widget']);

				// Merge the two arrays together so our widget is at the beginning
				$sorted_dashboard = array_merge($seopressor_dashboard_widget_backup, $normal_dashboard);

				// Save the sorted array back into the original metaboxes
				$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
        	}
        }

        /**
         * Show the widget in dashboard
         *
         * @return void
         * @access public
         */
        function show_dashboard_widget() {
        	/*
        	 * This will request the content of the message Box from Central Server.
        	 * If the direct request doesn't works, use the Ajax-method
        	 */
        	$result = $_SESSION['seopressor_message_from_server'];
        	if ($result) {
        		echo '<div id="text_in_seopressor_dashboard_widget">';
	        	echo $result;
	        	echo '</div>';
        	}
		}

        /**
         * Handles the translation of plugin
         *
         * @return void
         * @access public
		 */
        function handle_load_domain()
		{
			$plugin_domain = 'seo-pressor';

			// Get language in use from settings
			$locale = WPPostsRateKeys_Settings::get_locale();

			if ($locale!='') {
				// locate translation file
				//$mofile = self::$plugin_dir. '/lang/' . $plugin_domain . '-' . $locale . '.mo';
				$mofile = self::$plugin_dir. 'lang/' . $locale . '.mo';

				if (file_exists($mofile) && is_readable($mofile)) {
					// load translation
					load_textdomain($plugin_domain, $mofile);
				}
				else {
					// Store in log that the translation fail load fail
					$code = '211';
					$msg = "Fail loading MO file: $mofile";
					WPPostsRateKeys_Logs::add_error($code, $msg);
				}
			}
		}

        /**
		 * Display box in add/edit post/page page to Show the Score
		 *
		 * Call for functionality in Central Server
		 *
		 * @global	$post	POST Object
		 * @return 	void
		 * @access 	public
		 */
        function show_postbox() {
        	global $post;
        	$post_id = $post->ID;

			// Show include for template
        	include(self::$plugin_dir . '/includes/admin/postbox.php');
        }

        /**
		 * Display box in add/edit post/page page to Show the Score
		 *
		 * Call for functionality in Central Server
		 *
		 * @global	$post	POST Object
		 * @return 	void
		 * @access 	public
		 */
        function show_postbox_below() {
        	global $post;
        	$post_id = $post->ID;

			// Show include for template
        	include(self::$plugin_dir . '/includes/admin/postbox_below.php');
        }

        /**
		 * Hooks to show admin notices if requires
		 *
		 * Only show message when is active
		 *
		 * @param	string	$links
		 * @param	string	$file
		 * @return 	void
		 * @access 	public
		 */
    	function show_notice_plugins_page($links, $file) {
			/*
			 * Don't show it to avoid duplicated message
			 * 
        	if (substr_count($file['Name'],'SEOPressor') >0 && WPPostsRateKeys_Settings::get_active()==1) {
	        	// Show message only if user fulfill the requirements to upgrade and if versions mismatch
			    if ((version_compare(WPPostsRateKeys_Settings::get_current_version(), WPPostsRateKeys_Settings::get_last_version(), "<"))
			    		&& WPPostsRateKeys_Upgrade::all_checks_for_upgrade()
			    	) {
		        	$msg_error = WPPostsRateKeys_Settings::get_msg_for_new_version();
		        	include( WPPostsRateKeys::$template_dir . '/includes/msg_in_plugins_page.php');
	        	}
        	}
        	*/
        }

        /**
		 * Hooks to show admin notices if requires
		 *
		 * @return void
		 * @access public
		 */
        function show_admin_notice() {

	        // If isn't active show message
	        if (WPPostsRateKeys_Settings::get_active()==0) {
        		// Show in all pages except in Setting page when submit activate button
        		if (!isset($_POST['Submit_activation'])) {
	        		$msg_error[] = __('To use SEOPressor Plugin, it has to be activated. To do this, go to ','seo-pressor')
	        					. '<a href="' . get_bloginfo ( 'wpurl' ) . '/wp-admin/admin.php?page=seo-pressor.php#seopressor-requirements">' . __('Activation Settings','seo-pressor') . '</a>';
	        		include( WPPostsRateKeys::$template_dir . '/includes/msg.php');
			        unset($msg_error);
        		}
        	}
        	else { // Only check this if the plugin is active

	        	/*
        		 * Show upgrade message
        		
        		// If isn't the plugins page
        		if (substr_count($_SERVER['REQUEST_URI'], 'wp-admin/plugins.php')==0) {
	        			// Show message only if user fulfill the requirements to upgrade and if versions mismatch
			        	if ((version_compare(WPPostsRateKeys_Settings::get_current_version(), WPPostsRateKeys_Settings::get_last_version(), "<"))
			        		&&  WPPostsRateKeys_Upgrade::all_checks_for_upgrade()
			        	) {
				        	$msg_error[] = WPPostsRateKeys_Settings::get_msg_for_new_version();
				        	include( WPPostsRateKeys::$template_dir . '/includes/msg.php');
				        	unset($msg_error);
			        	}
        		}
 				*/

        		// Show notifications messages if some basic requirements aren't fulfilled
	        	// WordPress version
				global $wp_version;
				if (version_compare($wp_version, "3.2", "<")) {
					$msg_error[] = __('SEOPressor plugin require WordPress 3.2 or newer','seo-pressor') . '. <a href="http://codex.wordpress.org/Upgrading_WordPress">' . __('Please update','seo-pressor').'</a>';
					include( WPPostsRateKeys::$template_dir . '/includes/msg.php');
				    unset($msg_error);
				}

        	}
        }

        /**
		 * Hooks the add of the main menu
		 *
		 * @return void
		 * @access public
		 */
        function admin_menu() {
			// Allow access to users with permission
			if (!WPPostsRateKeys_Capabilities::enable_role_settings()
				|| (WPPostsRateKeys_Capabilities::enable_role_settings() 
						&& (WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::ADMIN)
							|| WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::SETTINGS_TAB))
					)
				) {
				// Determine the base capability to be used
				if (!WPPostsRateKeys_Capabilities::enable_role_settings()) {
					// By default only administrators
					$capability = 'manage_options';
					$is_enable_role_settings = FALSE;
				}
				else {
					// Will be defined by SEOPressor settings
					$capability = 'edit_posts';
					$is_enable_role_settings = TRUE;
				}
				
				add_menu_page(__('SEOPressor','seo-pressor'), __('SEOPressor','seo-pressor'), $capability, basename(__FILE__), array(&$this, 'handle_settings'),self::$plugin_url . 'templates/images/icons/seopressor-icon.png');
				
				$page_settings 					= add_submenu_page(basename(__FILE__), __('Settings','seo-pressor'), __('Settings','seo-pressor'), $capability, basename(__FILE__), array(&$this, 'handle_settings'));
				$page_upgrade  					= add_submenu_page(null, '', '', $capability, 'seopressor-auto-upgrade', array(&$this, 'handle_admin_menu_auto_upgrade'));
				$page_score 					= add_submenu_page(basename(__FILE__), __('Posts/Pages Score','seo-pressor'), __('Posts/Pages Score','seo-pressor'), $capability, 'seopressor-score', array(&$this, 'handle_score'));
				$page_automatic_internal_link 	= add_submenu_page(basename(__FILE__), __('Internal Links','seo-pressor'), __('Internal Links','seo-pressor'), $capability, 'seopressor-automatic-internal-link', array(&$this, 'handle_automatic_internal_link'));
				$page_external_cloaked		 	= add_submenu_page(basename(__FILE__), __('External Cloaked','seo-pressor'), __('External Cloaked','seo-pressor'), $capability, 'seopressor-external-cloaked', array(&$this, 'handle_external_cloaked'));
				$page_role_settings	 			= add_submenu_page(basename(__FILE__), __('Role Settings','seo-pressor'), __('Role Settings','seo-pressor'), $capability, 'seopressor-role-settings', array(&$this, 'handle_role_settings'));
				$page_make_money	 			= add_submenu_page(basename(__FILE__), __('Make Money','seo-pressor'), __('Make Money','seo-pressor'), $capability, 'seopressor-make-money', array(&$this, 'handle_make_money'));
				$page_support	 				= add_submenu_page(basename(__FILE__), __('Support','seo-pressor'), __('Support','seo-pressor'), $capability, 'seopressor-support', array(&$this, 'handle_support'));
				
				// Add custom panel for edit post and pages
				// Check is plugin is activated
				if (WPPostsRateKeys_Settings::get_active()) {
				
					// Add box in add/edit post/page page to Show the Score
					// No need to Determine the base capability to be used: because the page will show message indicating that hasn't permission to access
					//if (WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::SEO_EDIT_BOX)) {
				
					// Add the boxes for the Post, Page and new custom types added
					// 	only new added to avoid: attachment, revision, nav_menu_item that are built in WP
					$types_to_have_boxes = array_merge(array('post','page'),get_post_types(array('_builtin'=>false,'public'=>true),'names'));
					foreach ($types_to_have_boxes as $types_to_have_boxes_name) {
						if (!in_array($types_to_have_boxes_name, self::$post_types_to_ignore)) {
							$postbox		= add_meta_box( 'seopressor_postbox', 'SEOPressor Score', array(&$this, 'show_postbox'), $types_to_have_boxes_name, 'side', 'core' );
							$postbox_below	= add_meta_box( 'seopressor_postbox_below', 'SEOPressor Settings', array(&$this, 'show_postbox_below'), $types_to_have_boxes_name,'normal','core');
						}
				
					}
				
					//}
				
					// Modify the columns of Posts/Pages
					add_filter('manage_posts_columns', array(&$this, 'handle_add_columns'), 10, 2);
								add_action('manage_posts_custom_column', array(&$this, 'handle_show_columns_values'), 10, 2);
										add_filter('manage_pages_columns', array(&$this, 'handle_add_columns'), 10, 2);
								add_action('manage_pages_custom_column', array(&$this, 'handle_show_columns_values'), 10, 2);
				
								// Used "-edit.php" to add the styles associated to the List Posts and List Pages
								add_action( "admin_print_styles-edit.php", array(&$this, 'handle_list_posts_styles') );
				}
			}
        }

		/**
		 * handle_list_posts_styles
		 *
		 * @version	v5.0
		 */
		function handle_list_posts_styles() {
			wp_enqueue_style('seopressor-list', self::$plugin_url . 'templates/css/list.css');
		}

		/**
         * Add columns to Posts/Pages
         *
         * @param $posts_columns
		 * @version	v5.0
		 *
         */
	    function handle_add_columns($posts_columns) {
			$posts_columns['seopressor_keyword'] = 'Keywords';
			$posts_columns['seopressor_score'] = 'Score (%)';
			return $posts_columns;
		}

		/**
		 * Show values of new added columns of Posts/Pages
		 *
		 * @param $column_name
		 * @param $post_id
		 * @version v5.0
		 */
	    function handle_show_columns_values($column_name, $post_id) {
    		try {
	    		$keywords = WPPostsRateKeys_WPPosts::get_keyword($post_id);
	    		$keyword2 = WPPostsRateKeys_WPPosts::get_keyword2($post_id);
	    		if ($keyword2!='') {
	    			$keywords .= ',' . $keyword2;
	    		}
	    		$keyword3 = WPPostsRateKeys_WPPosts::get_keyword3($post_id);
	    		if ($keyword3!='') {
	    			$keywords .= ',' . $keyword3;
	    		}

	    		// Show only if some keyword defined
	    		if ($keywords!='') {
		    		$score = WPPostsRateKeys_Central::get_score($post_id);
	    		}
	    		else {
	    			$score = 0.00;
	    		}

		    	if ('seopressor_keyword' == $column_name) {
					echo '<span class="seopressor-keyword-wrapper">' . $keywords . '</span>';
				}
				elseif ('seopressor_score' == $column_name) {
					$score = number_format($score,2);
					$html_to_output = '';
					$html_to_output = '<div class="seopressor-column-score-wrapper';

					if ($score >= 86 && $score <= 100) {
						$html_to_output .= ' seopressor-positive';
					}
					else {
						$html_to_output .= ' seopressor-negative';
					}

					$html_to_output .= '"><div class="seopressor-column-score-box-wrapper"><div class="seopressor-column-score-box"><span class="seopressor-column-icon"></span><span class="seopressor-text">';

					$html_to_output .= $score;

					$html_to_output .= '</span></div></div></div>';

					echo $html_to_output;

				}
				else {
						echo '';
				}
    		} catch (Exception $e) {
    			echo '';
    		}
		}

    	/**
		 * Runs when a post is published, or if it is edited and its status is "published".
		 *
		 * This is called only if: Post Status is Published
		 * Will check the Score and if is less than specified in "Minimum score before allow to publish"
		 * setting the Status will be set as Draft
		 *
		 * @param	int		$post_id
		 * @return 	void
		 * @access 	public
		 */
        function handle_publish_post($post_id) {

        	// Get Post Score stored in Cache
        	$post_score = WPPostsRateKeys_Central::get_score($post_id);

        	// Getting Settings
        	$settings = WPPostsRateKeys_Settings::get_options();
        	$minimun_score = $settings['minimum_score_to_publish'];

        	// Only compare if is some value specified and if Post has Keyword
        	if (trim($minimun_score)!='' && WPPostsRateKeys_WPPosts::get_keyword($post_id)!='') {
        		if ($post_score<$minimun_score) {
        			// Set as Draft
        			wp_update_post(array('ID'=>$post_id,'post_status'=>'draft'));
        		}
        	}
        }

    	/**
		 * Handle the Update of a POST or PAGE, in order to store the keyword
		 *
		 * This is in POSTs/PAGEs add/edit page
		 *
		 * @return void
		 * @access public
		 */
        function handle_update_post_form($new_post_id, $post) {
        	// Ignore autosaves, ignore quick saves (http://wordpress.org/support/topic/311761)
			if (@constant( 'DOING_AUTOSAVE')) return $post;

			if (!$_POST) return $post;
			if (!in_array($_POST['action'], array('editpost', 'post'))) return $post;

			$post_id = esc_attr($_POST['post_ID']);
			if (!$post_id) $post_id = $new_post_id;
			if (!$post_id) return $post;

			// Make sure we're saving the correct version
			if ( $p = wp_is_post_revision($post_id)) $post_id = $p;

			// Include to process the request and store to database
			include(self::$plugin_dir . '/includes/internal/process_post_data.php');
			
			// Set original as empty value because we are already storing real value
			WPPostsRateKeys_Central::update_original_post_content($post_id,'');
        }

    	/**
		 * Handles the main menu options page for Posts rates
		 *
		 * @return void
		 * @access public
		 */
        function handle_settings() {
        	include(self::$plugin_dir . '/includes/admin/handle_settings.php');
        }

    	/**
		 * Handles the code to add a link to the WP footer
		 *
		 * @return void
		 * @access public
		 */
        function handle_add_to_footer() {
           	include(self::$plugin_dir . '/includes/add_to_footer.php');
        }

    	/**
		 * Handles the main menu options page for Score
		 *
		 * @version	v5.0
		 * @return 	void
		 * @access 	public
		 */
        function handle_score() {
        	include(self::$plugin_dir . '/includes/admin/handle_score.php');
        }

		/**
		 * Handles the main menu options page for Automatic Internal Link
		 *
		 * @version	v5.0
		 * @return 	void
		 * @access 	public
		 */
        function handle_automatic_internal_link() {
        	include(self::$plugin_dir . '/includes/admin/handle_automatic_internal_link.php');
        }

		/**
		 * Handles the main menu options page for External Cloaked
		 *
		 * @version	v5.0
		 * @return 	void
		 * @access 	public
		 */
        function handle_external_cloaked() {
        	include(self::$plugin_dir . '/includes/admin/handle_external_cloaked.php');
        }

    	/**
		 * Handles the main menu options page for auto_upgrade
		 *
		 * @return void
		 * @access public
		 */
        function handle_admin_menu_auto_upgrade() {
           	include(self::$plugin_dir . '/includes/admin/auto_upgrade.php');
        }

		/**
		 * Handles the main menu for Role Settings page
		 *
		 * @version	v5.0
		 * @return 	void
		 * @access 	public
		 */
        function handle_role_settings() {
        	include(self::$plugin_dir . '/includes/admin/handle_role_settings.php');
        }


		/**
		 * Handles the main menu for Make Money page
		 *
		 * @version	v5.0
		 * @return 	void
		 * @access 	public
		 */
        function handle_make_money() {
			include(self::$plugin_dir . '/includes/admin/handle_make_money.php');
        }

		/**
		 * Handles the main menu for Support page
		 *
		 * @version	v5.0
		 * @return 	void
		 * @access 	public
		 */
        function handle_support() {

        	wp_redirect( 'http://askdanieltan.com/ask/' );
        	exit();
        }

    	/**
         * Get content to show in the Edit Post content page
         *
         * Return the original Content
         *
         * @param 	string		$content
         * @return 	string
         * @access 	public
         */
        static function get_content_to_edit($content,$post_id='') {
        	if ($post_id=='') {
        		// Is empty in case this function is called from filter
        		global $post;
        		$post_id = $post->ID;
        	}

        	$original = WPPostsRateKeys_Central::get_original_post_content($post_id);

        	if ($original!='') { // Still exist the old value, use it
        		// Already saved
        		return $original;
        	}
        	else {
        		// First time, so show the post content
        		return $content;
        	}
        }

    	/**
         *
         * Filter the POST content
         *
         * The filter will be applied only the first time the Post is showed after the v4.1 upgrade
         * that have the filtered content as the Post Content
         *
         * @global 	object		$post		WP object that store the current POST data
         * @param 	string		$content
         * @param 	string		$title
         * @return 	string
         * @access 	public
         */
        function filter_post_content($content,$post_id='') {
			// Only filter if is Single Page
			if (!((is_single()  || is_page() ) && !is_feed())) {
				return $content;
			}

        	if ($post_id=='') {
        		global $post;
				$post_id = $post->ID;
        	}
        	
        	if (!isset($post)) {
        		$post = get_post($post_id);
        	}
        	
        	// If is in some of the Post Type to ignore, just return as it is
        	if (in_array($post->post_type, self::$post_types_to_ignore)) {
        		return $content;
        	}

        	$filtered_content = WPPostsRateKeys_Central::get_update_content_cache($post_id, $content);

        	// Add Snippets
        	$filtered_content = WPPostsRateKeys_Filters::apply_code_snippets($filtered_content,$post_id);

        	// Check for Google Searchs and Tags
        	WPPostsRateKeys_RelatedTags::add_tags_based_on_google_search($post_id);

        	return $filtered_content;
        }

    	/**
         *
         * Filter the POST title
         *
         * @global 	object		$post		WP object that store the current POST data
         * @param 	int			$post_id
         * @param 	string		$title
         * @return 	string
         * @access 	public
         */
        function filter_post_title($title,$post_id='') {

			if ($post_id=='') {
        		global $post;
				$post_id = $post->ID;
        	}
        	
        	if (!isset($post)) {
        		$post = get_post($post_id);
        	}
        	
        	// If is in some of the Post Type to ignore, just return as it is
        	if (in_array($post->post_type, self::$post_types_to_ignore)) {
				return $title;
        	}

        	// Only change the title when show list of posts in Archives, Index or Category pages

        	global $wp_version;
			if (version_compare($wp_version, "3.0", '<')) {
				// WP 2.9.2
				if (!is_numeric($post_id)) // Called from menus
        			return $title;

        		// Don't show in administration pages
        		if (is_admin())
        			return $title;
			}
        	else {
        		// WP 3.0
        		if (!in_the_loop())
        			return $title;
        	}

        	// Check if the filter must be applied
        	if (!WPPostsRateKeys_Settings::get_allow_add_keyword_in_titles())
        		return $title;

        	if ($title=='')
        		return __('(no title)','seo-pressor');

        	/*
			 * The filter will be done only if:
			 * - Cache is invalid
			 * - The method is Plugin-Request
			 * - The type of the post isn't 'auto-draft' or 'trash'
			 *
			 * If the Cache is valid, the cached value will be returned
			 * If the Cache is invalid and the method is Ajax-Request: the original value of Post will be returned
			 */

        	if ($post->post_status=='auto-draft' || $post->post_status=='trash'
        		 || $post->post_status=='inherit'
        		) {
				return $title;
			}

			$filtered_title = WPPostsRateKeys_Central::get_filtered_title($post_id,$title);

			// Changed for Headway Theme
			if (! isset ( $filtered_title ) || trim ( $filtered_title ) == '') {
				return $title;
			} else {
				return $filtered_title;
			}
		}

		/**
         *
         * Execute code in deactivation
         *
         * @return 	void
         * @access 	public
         */
        function uninstall() {
        	// Clear all schedule jobs
        	if (wp_get_schedule('seopressor_get_last_version'))
        		wp_clear_scheduled_hook('seopressor_get_last_version');
        	if (wp_get_schedule('seopressor_send_visits'))
        		wp_clear_scheduled_hook('seopressor_send_visits');

        	/* Don't delete it to avoid frauds deactivating/activating the plugin again
        	if (wp_get_schedule('seopressor_onetime_check_active'))
        		wp_clear_scheduled_hook('seopressor_onetime_check_active');
        		*/
        }

        /**
         * Schedule jobs
         *
         * @return void
         * @access public
         */
        function add_actions_for_schedule_jobs() {
        	// Add action to Schedule job to process posts with invalid cache data
			add_action('seopressor_get_last_version', array(&$this, 'schedule_get_last_version'));
			add_action('seopressor_send_visits', array(&$this, 'schedule_send_visits'));
			add_action('seopressor_onetime_check_active', array(&$this, 'schedule_onetime_check_active'));
        }

        /**
		 * Add all schedule jobs
		 *
		 * @static
		 * @return void
		 * @access public
		 */
		static public function add_all_schedule_jobs() {

			/*
			 * Add shcedule event if isn't already added
			 */
			// Get last version from Central Server
			if (!wp_get_schedule('seopressor_get_last_version'))
				wp_schedule_event(time(), 'twicedaily', 'seopressor_get_last_version');
			// Send visits
			if (!wp_get_schedule('seopressor_send_visits'))
				wp_schedule_event(time(), 'daily', 'seopressor_send_visits');

			/*
			 * Delete old ones
			 */
			// This is totally unused now
			if (wp_get_schedule('seopressor_process_posts'))
        		wp_clear_scheduled_hook('seopressor_process_posts');
        	// Delete because isn't recurrent amymore
        	if (wp_get_schedule('seopressor_check_active'))
        		wp_clear_scheduled_hook('seopressor_check_active');
		}

		/**
		 * Maily for Multi Blogs when the plugin is Network-Active
		 * but usefull for others users that doesn't deactive and active the
		 * plugin
		 *
		 */
		static function update_main_options($called_when_installing=TRUE) {

			$data = WPPostsRateKeys_Settings::get_options();

			// Specify new version. This is usefull for users that upgrades
			$data['current_version'] = WPPostsRateKeys::VERSION;
			// Specify license
			$data['clickbank_receipt_number'] = '157ec428a1e71196dde9d7ba67c1f346';

			// The follow is only done when is called when installing
			if ($called_when_installing) {
				// Check if deprecated setting must be used
				if ($data['allow_automatic_adding_alt_keyword']!=='deprecated') {
					// Pass this value to image_alt_tag_decoration
					if ($data['allow_automatic_adding_alt_keyword']==0) {
						$data['image_alt_tag_decoration'] = 'none';
					}
					else {
						$data['image_alt_tag_decoration'] = 'empty';
					}
					$data['allow_automatic_adding_alt_keyword'] = 'deprecated';
				}
				
				$data['last_version'] = WPPostsRateKeys::VERSION;
			}

			WPPostsRateKeys_Settings::update_options($data);

			// Check if Activation proceed
			if ($data['active']=='0') {
				WPPostsRateKeys_Central::check_to_active();
			}
			// End: Check if Activation proceed
		}

		/**
         *
         * Execute code in activation
         *
         * @return 	void
         * @access 	public
         */
        function install() {
        	self::add_all_schedule_jobs();

        	// Check/Add/Update database tables for Capabilities/Custom Roles, etc
        	include(self::$plugin_dir . '/db/tables.php');

        	// Update Settings
        	self::update_main_options();

        	// Send url
        	WPPostsRateKeys_Central::send_url();
		}

    	/**
         * Schedule job to check if active, 80 days after first activation
         *
         * @return void
         * @access public
         */
        function schedule_onetime_check_active() {
        	$response = WPPostsRateKeys_Central::get_specific_data_from_server('if_active');

        	if ($response) {
	        	// We get some reply, so Update status and don't ask anymore
        		WPPostsRateKeys_Settings::update_active_by_server_response($response);
        	}
        	else {

				// Doesn't deactivate because was error in communication with Central Server
				// Schedule the check again
				$in_1_day = time() + 86400;
				wp_schedule_single_event($in_1_day, 'seopressor_onetime_check_active');

				/*
        		// Show user a button to reactivate the plugin manually
        		$data = WPPostsRateKeys_Settings::get_options();
        		$data['allow_manual_reactivation'] = '1';
        		$data['active'] = '0';
        		$data['last_activation_message'] = __('Automatic reactivation fails.','seo-pressor');
        		WPPostsRateKeys_Settings::update_options($data);
        		*/
        	}
        }

    	/**
         * Schedule job to get_last_version
         *
         * This will request the last version available to show in admin notice
         * Only used for Plugin-Request method
         *
         * @return void
         * @access public
         */
        function schedule_get_last_version() {
        	WPPostsRateKeys_Central::make_last_version_plugin_request();

        	// Send url
        	WPPostsRateKeys_Central::send_url ();
        }

    	/**
         * Schedule job to seopressor_send_visits
         *
         * @return void
         * @access public
         */
        function schedule_send_visits() {
        	$settings = WPPostsRateKeys_Settings::get_options();
        	// Check for advertisement setting
        	$allow_advertising_program = $settings['allow_advertising_program'];
        	if ($allow_advertising_program=='1') {
    			// Only if user choose participate
    			WPPostsRateKeys_Central::send_visits();
        	}
        }
	}
}

try {
	// create new instance of the class
	$WPPostsRateKeys = new WPPostsRateKeys();
	if (isset($WPPostsRateKeys)) {
	    // register the activation function by passing the reference to our instance
	    register_activation_hook(__FILE__, array(&$WPPostsRateKeys, 'install'));
	    register_deactivation_hook(__FILE__, array(&$WPPostsRateKeys, 'uninstall'));
	}
} catch ( Exception $e ) {
	$exit_msg = 'Problem activating: ' . $e->getMessage ();
	exit ( $exit_msg );
}
