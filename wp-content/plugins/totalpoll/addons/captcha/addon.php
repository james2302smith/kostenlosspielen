<?php

if ( !defined('ABSPATH') )
    exit; // Shhh

    /*
      Addon Name: Captcha
      Description: More credible polls with Captcha.
      Addon URI: http://wpsto.re/addons/downloads/captcha/
      Author: WPStore
      Author URI: http://wpsto.re/
      Version: 1.0
      Required: 2.0
     */

/**
 * Captcha addon.
 * 
 * @version 1.0.0
 * @package TotalPoll\Addons\Captcha
 */
Class TP_Captcha_Addon {

    /**
     * Register some hooks
     * 
     * @since 1.0.0
     * @return void
     */
    public function __construct()
    {
	// Load textdomain
	load_plugin_textdomain('tp-captcha-addon', false, TP_ADDONS_PATH . DS . dirname(__FILE__) . '/languages/');
	// Menu
	add_action('admin_menu', array( $this, 'menus' ), 99);
	// Settings
	add_action('admin_init', array( $this, 'settings' ));
	// Poll settings
	add_action('tp_admin_editor_after_limitations_content', array( $this, 'poll_settings' ));
	// Buttons
	add_action('tp_poll_other_buttons', array( $this, 'captcha' ));
	// Assets
	add_action('tp_poll_enqueue_assets', array( $this, 'assets' ));
	// Vote ability
	add_filter('tp_security_vote_ability', array( $this, 'ability' ));
    }

    /**
     * Check vote ability
     * 
     * @global object $poll
     * @param bool $ability
     * @return bool
     */
    public function ability($ability)
    {
	global $poll;
	// Check if captcha is enabled for this poll and there's a captcha field
	if ( isset($poll->limitations->captcha) && isset($_POST['recaptcha_response_field']) ):

	    /**
	     * Include reCaptcha library
	     */
	    if ( !defined('RECAPTCHA_API_SERVER') ):
		require_once('recaptchalib.php');
	    endif;

	    $publickey = get_option('tp_captcha_public_key', '');
	    $privatekey = get_option('tp_captcha_private_key', '');

	    $response = recaptcha_check_answer(
		    $privatekey, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']
	    );

	    if ( !$response->is_valid ):

		// Render vote.php
		add_filter_to_current_poll('tp_poll_render_file', array( $this, 'render_vote' ));
		// Message
		add_filter_to_current_poll('tp_template_get_part_header.php', array( $this, 'message' ));
		// Error
		$poll->recaptcha_error = $resp->error;
		// Disable ability
		$ability = false;

	    endif;
	    unset($_POST['recaptcha_response_field']);

	endif;

	return $ability;
    }

    /**
     * Register menus
     * 
     * @since 1.0.0
     * @return void
     */
    public function menus()
    {
	add_submenu_page('edit.php?post_type=poll', __('Captcha', 'tp-captcha-addon'), __('Captcha', 'tp-captcha-addon'), 'install_themes', 'tp-captcha', array( $this, 'global_settings' ));
    }

    /**
     * Register settings
     * 
     * @since 1.0.0
     * @return void
     */
    public function settings()
    {
	register_setting('tp-captcha-settings', 'tp_captcha_only_for_guests');
	register_setting('tp-captcha-settings', 'tp_captcha_public_key');
	register_setting('tp-captcha-settings', 'tp_captcha_private_key');
	register_setting('tp-captcha-settings', 'tp_captcha_theme');
    }

    /**
     * Settings page
     * 
     * @since 1.0.0
     * @return void
     */
    public function global_settings()
    {
	include_once('settings.php');
    }

    /**
     * Poll editor special settings
     * 
     * @since 1.0.0
     * @return void
     */
    public function poll_settings($options)
    {
	include_once('poll-settings.php');
    }

    /**
     * Enqueue assets
     */
    public function assets()
    {
	wp_enqueue_script('recaptcha-ajax', '//www.google.com/recaptcha/api/js/recaptcha_ajax.js', array( 'totalpoll' ));
    }

    /**
     * Captcha field
     * 
     * @since 1.0.0
     * @global object $poll
     * @return void
     */
    public function captcha()
    {
	global $poll;
	if ( isset($poll->limitations->captcha) &&
	    (has_tp_filter('tp_template_get_part_header.php', array( $this, 'message' )) || isset($poll->showing_vote)) ):

	    /**
	     * Include reCaptcha library
	     */
	    if ( !defined('RECAPTCHA_API_SERVER') ):
		require_once('recaptchalib.php');
	    endif;

	    $publickey = get_option('tp_captcha_public_key', '');
	    $theme = get_option('tp_captcha_theme', 'clean');

	    echo recaptcha_get_html($publickey, isset($poll->recaptcha_error) ? $poll->recaptcha_error : null, is_ssl(), $theme);
	endif;
    }

    /**
     * Render vote.php
     * 
     * @since 1.0.0
     * @return string
     */
    public function render_vote($file)
    {
	return 'vote.php';
    }

    /**
     * Display incorrect code message
     * 
     * @since 1.0.0
     * @param string $content
     * @return string
     */
    public function message($content)
    {
	global $poll;

	unset($poll->showing_results);

	$message = sprintf('<p class="warning">%s</p>', __('The verification code was incorrect!', 'tp-captcha-addon'));

	return $message . $content;
    }

}

// Bootstrap
new TP_Captcha_Addon();
