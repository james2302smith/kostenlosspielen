<?php

if ( !defined('ABSPATH') )
    exit; // Shhh

    /*
      Addon Name: Cache Compatibility
      Description: Make TotalPoll works with popular cache plugins (W3TC, WP SuperCache and Quick Cache).
      Addon URI: http://wpsto.re/addons/downloads/cache-compatibility/ 
      Author: WPStore
      Author URI: http://wpsto.re/
      Version: 1.0
      Required: 2.0
     */

/**
 * Cache compatible addons.
 * 
 * @version 1.0.0
 * @package TotalPoll\Addons\CacheCompatibility
 */
Class TP_Cache_Compatible {

    /**
     * Register some hooks.
     * 
     * @since 1.0.0
     * @return void
     */
    public function __construct()
    {
	add_filter('tp_poll_rendered', array( $this, 'render' ));
	// WP Super Cache
	if ( function_exists('add_cacheaction') ):
	    add_cacheaction('add_cacheaction', array( $this, '_wpsc_dynamic_output_buffer_init' )); // First generation
	    add_cacheaction('wpsc_cachedata', array( $this, '_wpsc_output_buffer' )); // After generation
	endif;
    }

    /**
     * Compatibility per-plugin.
     * 
     * @since 1.0.0
     * @global object $poll
     * @param string $content
     * @return string
     */
    public function render($content)
    {
	global $poll;
	// W3TC
	if ( defined('W3TC') ):
	    define('DONOTCACHEPAGE', true);
	endif;

	// Quick cache plugin
	if ( class_exists('\\quick_cache\\plugin') ):
	    define('QUICK_CACHE_ALLOWED', FALSE);
	endif;

	// WP Super Cache
	if ( function_exists('add_cacheaction') ):
	    add_cacheaction('wpsc_cachedata_safety', array( $this, '_wpsc_dynamic_output_buffer_safety' )); // Safety first :)
	    $content = "<!-- TotalPoll({$poll->id}) -->";
	endif;

	return $content;
    }

    /**
     * WP Super Cache buffer output initializing
     * 
     * @since 1.0.0
     */
    public function _wpsc_dynamic_output_buffer_init()
    {
	add_action('wp_footer', array( $this, '_wpsc_output_buffer' ));
    }

    /**
     * Make dynamic content tags safe.
     * 
     * @since 1.0.0
     * @param int $safety
     * @return int
     */
    public function _wpsc_dynamic_output_buffer_safety($safety)
    {
	return 1;
    }

    /**
     * WP Super Cache output callback.
     * 
     * @since 1.0.0
     * @param string $output
     * @return string
     */
    public function _wpsc_output_buffer($output = 0)
    {
	return preg_replace_callback('/\<\!\-\-\s*TotalPoll\(([0-9]+)\)\s*\-\-\>/sim', array( $this, '_wpsc_replace_polls' ), $output);
    }

    /**
     * preg_replace callback.
     * 
     * @global array $cached_rendered_polls
     * @param array $matches
     * @return string
     */
    public function _wpsc_replace_polls($matches)
    {
	global $cached_rendered_polls;
	TotalPoll()->poll->load($matches[1]);
	TotalPoll()->poll->get_render();
	return isset($cached_rendered_polls[$matches[1]]) ? $cached_rendered_polls[$matches[1]] : '';
    }

}

// Bootstrap it
new TP_Cache_Compatible();
