<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nttuyen
 * Date: 2/10/14
 * Time: 11:07 PM
 * To change this template use File | Settings | File Templates.
 */

if( !defined( 'KOS_FAVORITES_PLUGIN_URL' )) {
    define( 'KOS_FAVORITES_PLUGIN_URL', plugins_url() . '/' . basename( dirname( __FILE__ )));
}
define('KOS_FAVORITES_AJAX_URL', KOS_FAVORITES_PLUGIN_URL.'/ajax.php');
define('KOS_FAVORITES_PAGE', 'favoriten-spiele');
define('KOS_FAVORITES_PAGE_URL', SITE_ROOT_URL.'/'.KOS_FAVORITES_PAGE);
define('KOS_RECENT_GAME_SESSION_KEY', 'KOS_RECENT_GAMES');
define('KOS_RECENT_GAME_MAX', 5);

$FAVORITES_ORDER_PARAMS = array(
    //'mostview' => 'view',
    'am-neuesten-spiele' => 'new',
    'best-bewertete-spiele' => 'best',
    'meist-bewertete-spiele'  => 'vote'
);
$FAVORITES_ORDER_PARAMS_INVERSE = array(
    //'mostview' => 'view',
    'new' => 'am-neuesten-spiele',
    'best' => 'best-bewertete-spiele',
    'vote'  => 'meist-bewertete-spiele'
);

if(!defined('PAGE')) {
    define('PAGE', 'seite');
}

