<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nttuyen
 * Date: 2/10/14
 * Time: 11:04 PM
 * To change this template use File | Settings | File Templates.
 */

require_once(dirname(dirname(dirname(dirname((__FILE__))))) . '/wp-load.php');
require_once dirname(__FILE__).'/KosFavorites.php';
require_once dirname(__FILE__).'/constants.php';

$return = array(
    'code' => 404,
    'status' => 'not found',
    'message' => ''
);

ob_end_clean();
header('Content-Type: application/json');

$action=$_REQUEST['action'];
if(empty($action)) {
	$action = 'favorite';
}
$game = $_REQUEST['game'];
if(empty($game)) {
    $return['code'] = '503';
    $return['message'] = 'GameID is required!';
    
    echo json_encode($return);
    die;
} else {
    $kosFavorites = KosFavorites::getInstance();
    $result = false;
    if($action == 'unfavorite') {
        $result = $kosFavorites->removeFromFavorite($game);
    } else {
        $result = $kosFavorites->addToFavorite($game);
    }

    if($result) {
        $return = array(
            'code' => 200,
            'status' => 'success',
            'message' => 'successfully'
        );
    } else {
        global $wpdb;
        $return = array(
            'code' => 500,
            'status' => "error",
            'message' => $wpdb->last_error
        );
    }
}

echo json_encode($return);
die;
