<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nttuyen
 * Date: 2/10/14
 * Time: 11:04 PM
 * To change this template use File | Settings | File Templates.
 */

require_once(dirname(dirname(dirname(dirname((__FILE__))))) . '/wp-load.php');
require_once dirname(__FILE__).'/KosComments.php';
require_once dirname(__FILE__).'/constants.php';

$return = array(
    'code' => 404,
    'status' => 'not found',
    'message' => ''
);

$postId = $_REQUEST['postid'];
$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;

ob_end_clean();
header('Content-Type: application/json');
if(!$postId) {
    $return['message'] = 'Post id is required';
    echo json_encode($return);
    die;
}

$kosComments = KosComments::getInstance($postId);
$kosComments->init($page);

if($kosComments->hasComments()) {
    $return['code'] = 200;
    $return['status'] = 'success';
    $return['htmlLists'] = $kosComments->htmlListComments();
    $return['htmlPaging'] = $kosComments->htmlPaging();
    $return['htmlPagingInfo'] = $kosComments->pagingDescription();

} else {
    $return['code'] = 404;
    $return['status'] = 'not-found';
    $return['message'] = 'There is no comment of this post';
}

echo json_encode($return);
die;