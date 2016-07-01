<?php

if ( !defined('ABSPATH') )
    exit; // Shhh

    /*
      Addon Name: Archive link
      Description: Archive link after results
      Addon URI: #
      Author: WPStore
      Author URI: http://wpsto.re/
      Version: 1.0
      Required: 2.0
     */

/**
 * Archive Link addon.
 * 
 * @version 1.0.0
 * @package TotalPoll\Addons\ArchiveLink
 */
Class TP_Archive_Link {

    /**
     * Register settings and content hooks
     * 
     * @since 1.0.0
     * @return void
     */
    public function __construct()
    {
	// Text domain
	load_plugin_textdomain('tp-archive-link-addon', false, TP_ADDONS_PATH . DS . dirname(__FILE__) . '/languages/');
	add_filter('tp_template_get_part_footer.php', array( $this, 'content' ));
    }

    /**
     * Content override
     * 
     * @since 1.0.0
     * @global object $poll
     * @param string $content
     * @return string
     */
    public function content($content)
    {
	global $poll;
	if ( isset($poll->showing_results) ):
	   $content .= sprintf(__('<div class="buttons"><a href="%s">Polls archive</a></div>','tp-archive-link-addon'), get_post_type_archive_link('poll'));
	endif;
	return $content;
    }

}

// Bootstrap
new TP_Archive_Link();
