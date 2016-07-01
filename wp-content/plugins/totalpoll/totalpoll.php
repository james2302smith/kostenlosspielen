<?php

/*
  Plugin Name: TotalPoll
  Description: Yet another powerful poll plugin!
  Plugin URI: http://wpsto.re/plugins/total-poll
  Author: WPStore
  Author URI: http://wpsto.re
  Version: 2.2
  Text Domain: totalpoll
  Domain Path: languages
 */

if ( !defined('ABSPATH') )
    exit; // Shhh

/**
 * TotalPoll Singleton Bootstraper.
 * 
 * @since 2.0.0
 * @pakcage TotalPoll
 */

class TotalPoll {

    /**
     * Instance container.
     * @since 2.0.0
     * @access private
     * @type instance Instance.
     */
    private static $instance;

    /**
     * Get TotalPoll instance.
     * @since 2.0.0
     * @return instance Current instance.
     */
    public static function getInstance()
    {
        if ( !isset(self::$instance) && !( self::$instance instanceof TotalPoll ) ):
	    
	    if(!isset($_SESSION)):
		session_start();
	    endif;

            self::$instance = new TotalPoll;
            self::$instance->constants();
            self::$instance->includes();
            self::$instance->textdomain();
            self::$instance->hooks();

            self::$instance->request = new TP_Request();
            self::$instance->poll = new TP_Poll();
            self::$instance->addons = new TP_Addons();
            self::$instance->template = new TP_Template();
            self::$instance->logs = new TP_Logs();
            self::$instance->security = new TP_Security();
            
            if ( is_admin() ):
                self::$instance->admin = new TP_Admin();
                self::$instance->customizer = new TP_Poll_Customizer();
                self::$instance->editor = new TP_Poll_Editor();
            endif;

            /**
             * Init
             * Init hook for TotalPoll
             * 
             * @since 2.0.0
             * @action tp_init
             * @param Instance
             */
            do_action('tp_init', self::$instance);

        endif;
        return self::$instance;
    }

    /**
     * Define useful constants.
     * 
     * @since 2.0.0
     * @return void
     */
    private function constants()
    {

        /**
         * Directory separator.
         * 
         * @since 2.0.0
         * @type string
         */
        if ( !defined('DS') )
            define('DS', DIRECTORY_SEPARATOR);

        /**
         * TotalPoll text doamin
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_TD', 'totalpoll');

        /**
         * TotalPoll base directory path.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_PATH', plugin_dir_path(__FILE__));

        /**
         * TotalPoll base directory URL.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_URL', plugin_dir_url(__FILE__));

        /**
         * TotalPoll templates directory path.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_TEMPLATES_PATH', TP_PATH . 'templates' . DS);

        /**
         * TotalPoll templates directory URL.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_TEMPLATES_URL', TP_URL . 'templates/');

        /**
         * TotalPoll root file (this file).
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_ROOT_FILE', __FILE__);

        /**
         * TotalPoll addons directory path.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_ADDONS_PATH', TP_PATH . 'addons' . DS);

        /**
         * TotalPoll addons directory URL.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_ADDONS_URL', TP_URL . 'addons/');

        /**
         * TotalPoll assets directory path.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_ASSETS_PATH', TP_PATH . 'assets' . DS);

        /**
         * TotalPoll assets directory URL.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_ASSETS_URL', TP_URL . 'assets/');

        /**
         * TotalPoll JS assets directory URL.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_JS_ASSETS', TP_ASSETS_URL . 'js/');

        /**
         * TotalPoll CSS assets directory URL.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_CSS_ASSETS', TP_ASSETS_URL . 'css/');

        /**
         * TotalPoll images assets directory URL.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_IMAGES_ASSETS', TP_ASSETS_URL . 'images/');

        /**
         * TotalPoll current version
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_VERSION', '2.2');

        /**
         * TotalPoll store URL
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_WEBSITE', 'http://totalpoll.com');
	
        /**
         * TotalPoll store URL
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_STORE', 'http://wpsto.re/plugins/total-poll?store');

        /**
         * TotalPoll directory name.
         * 
         * @since 2.0.0
         * @type string
         */
        define('TP_DIRNAME', dirname(plugin_basename(__FILE__)));
    }

    /**
     * Load TotalPoll textdomain.
     * 
     * @since 2.0.0
     * @return bool
     */
    public function textdomain()
    {
        return load_plugin_textdomain(TP_TD, false, TP_DIRNAME . '/languages/');
    }

    /**
     * Load required files (modules, addons, templates ..).
     * 
     * @since 2.0.0
     * @global string $wp_version
     * @return void
     */
    private function includes()
    {
        global $wp_version;
        require_once( TP_PATH . 'includes/post-type.php' );
        require_once( TP_PATH . 'includes/poll.helpers.php' );
        require_once( TP_PATH . 'includes/helpers.php' );
        require_once( TP_PATH . 'includes/template-tags.php' );

        require_once( TP_PATH . 'includes/class-request.php' );
        require_once( TP_PATH . 'includes/class-addons.php' );
        require_once( TP_PATH . 'includes/class-template.php' );
        require_once( TP_PATH . 'includes/class-logs.php' );
        require_once( TP_PATH . 'includes/class-security.php' );
        require_once( TP_PATH . 'includes/class-poll.php' );
        require_once( TP_PATH . 'includes/class-widget.php' );

        if ( is_admin() ):

            require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

            if ( version_compare($wp_version, '3.7', '>') ):
                require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader-skins.php' );
            endif;

            require_once( TP_PATH . 'includes/class-installer.php' );
            require_once( TP_PATH . 'includes/class-installer-skin.php' );
            require_once( TP_PATH . 'includes/class-poll-customizer.php' );
            require_once( TP_PATH . 'includes/class-poll-customizer-fields.php' );
            require_once( TP_PATH . 'includes/class-poll-editor.php' );
            require_once( TP_PATH . 'includes/class-admin.php' );

        endif;
    }

    /**
     * Register TotalPol wigets.
     * 
     * @since 2.0.0
     * @return void
     */
    public function widgets()
    {
        register_widget('TP_Widget');
    }

    /**
     * Register hooks (actions & filters).
     * 
     * @since 2.0.0
     * @return void
     */
    private function hooks()
    {
        // Activation
        register_activation_hook(__FILE__, array( $this, 'activate' ));
        add_action('admin_init', array( $this, 'redirect_about_page' ), 1);
        // Widget
        add_action('widgets_init', array( $this, 'widgets' ));
        // Capture actions
        add_action('wp', array( $this, 'capture_action' ), 11);
        // Post-type
        add_action('init', 'tp_register_post_type');
        add_filter('post_updated_messages', 'tp_update_messages');
    }

    /**
     * Capture actions from POST, GET and AJAX
     * 
     * @since 2.0.0
     * @return void
     */
    public function capture_action()
    {
        /**
         * AJAX
         */
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ):
            if ( isset($_REQUEST['tp_action']) ):
                /**
                 * TotalPoll Ajax request
                 * 
                 * @since 2.0.0
                 * @type string
                 */
                define('TP_AJAX', true);
                /**
                 * Capture ajax requests
                 * 
                 * @since 2.0.0
                 * @action tp_capture_ajax_{$_REQUEST['tp_action']}
                 */
                do_action("tp_capture_ajax_{$_REQUEST['tp_action']}");
            endif;
        endif;

        /**
         * POST & GET
         */
        if ( isset($_POST['tp_action']) ):
            /**
             * Capture post requests
             * 
             * @since 2.0.0
             * @action tp_capture_ajax_{$_POST['tp_action']}
             */
            do_action("tp_capture_post_{$_POST['tp_action']}");
        endif;
        if ( isset($_GET['tp_action']) ):
            /**
             * Capture get requests
             * 
             * @since 2.0.0
             * @action tp_capture_ajax_{$_GET['tp_action']}
             */
            do_action("tp_capture_get_{$_GET['tp_action']}");
        endif;
    }

    /**
     * Activation.
     * 
     * @since 2.0.0
     * @return void
     */
    public function activate()
    {
        tp_register_post_type();
        flush_rewrite_rules();
        set_transient('totalpoll_about_page_activated', 1, 30);
    }

    /**
     * Redirect to about page if is a fresh installation
     * 
     * @since 2.0.0
     * @return void
     */
    public function redirect_about_page()
    {
        if ( !current_user_can('manage_options') )
            return;

        if ( !get_transient('totalpoll_about_page_activated') )
            return;

        delete_transient('totalpoll_about_page_activated');
        wp_safe_redirect(admin_url('edit.php?post_type=poll&page=tp-about'));
        exit;
    }

}

/**
 * Get instance.
 * 
 * @package TotalPoll
 * @since 2.0.0
 * @return instance Current instance of TotalPoll.
 */
function TotalPoll()
{
    return TotalPoll::getInstance();
}

/**
 * Bootstrap, and let the fun begin.
 */
TotalPoll();
