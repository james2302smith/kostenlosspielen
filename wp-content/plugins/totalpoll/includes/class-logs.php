<?php

if ( !defined('ABSPATH') )
    exit; // Shhh

/**
 * Logs.
 * 
 * @since 2.0.0
 * @package TotalPoll\Logs
 */

Class TP_Logs {

    /**
     * Logs container.
     * 
     * @since 2.0.0
     * @access private
     * @type array
     */
    private $logs = array();

    /**
     * Save logs.
     * 
     * @since 2.0.0
     * @return void
     */
    public function __construct()
    {
	add_action('shutdown', array( $this, 'save' ));
    }

    /**
     * Log message.
     * 
     * @since 2.0.0
     * @param string $message Message to log
     * @return void
     */
    public function log($message)
    {
	$this->logs[] = array( time(), $message );
    }

    /**
     * Reset logs.
     * 
     * @since 2.0.0
     * @return void
     */
    public function reset()
    {
	$this->logs = array();
    }

    /**
     * Clear logs.
     * 
     * @since 2.0.0
     * @global object $poll Current poll object
     * @return bool
     */
    public function clear($poll_id)
    {
	return delete_post_meta($poll_id, '_tp_logs');
    }

    /**
     * Get logs.
     * 
     * @since 2.0.0
     * @global $poll Current poll object
     * @return array logs messages
     */
    public function get($poll_id)
    {
	if ( $logs = get_post_meta($poll_id, '_tp_logs', true) )
	    return $logs;

	return array();
    }

    /**
     * Save logs.
     * 
     * @since 2.0.0
     * @global object $poll
     * @return bool
     */
    public function save()
    {
	global $poll;

	if ( empty($this->logs) || !isset($poll->id) ):
	    return;
	endif;

	return update_post_meta($poll->id, '_tp_logs', array_merge($this->get($poll->id), $this->logs));
    }

    /**
     * Download logs.
     * 
     * @since 2.0.0
     * @return void
     */
    public function download($poll_id)
    {

	// Give a name
	$filename = 'poll-logs-' . time() . '.txt';

	// Send download headers
	header('Content-type: application/text');
	header("Content-Disposition: attachment; filename=$filename");
	header('Pragma: no-cache');
	header('Expires: 0');

	// Get logs
	$logs = $this->get($poll_id);

	foreach ( $logs as $log ):
	    printf("%s - %s\r\n", date(get_site_option('date_format') . ' ' . get_option('time_format'), $log[0]), $log[1]);
	endforeach;

	// That's all, folks
	exit;
    }

}
