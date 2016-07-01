<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nttuyen
 * Date: 2/10/14
 * Time: 11:07 PM
 * To change this template use File | Settings | File Templates.
 */

if( !defined( 'KOS_COMMENT_PLUGIN_URL' )) {
    define( 'KOS_COMMENT_PLUGIN_URL', plugins_url() . '/' . basename( dirname( __FILE__ )));
}
define('KOS_COMMENT_AJAX_URL', KOS_COMMENT_PLUGIN_URL.'/ajax.php');
define('KOS_COMMENT_VOTE_URL', KOS_COMMENT_PLUGIN_URL.'/vote.php');