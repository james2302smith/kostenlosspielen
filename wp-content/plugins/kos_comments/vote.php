<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nttuyen
 * Date: 2/12/14
 * Time: 9:15 PM
 * To change this template use File | Settings | File Templates.
 */
require_once(dirname(dirname(dirname(dirname((__FILE__))))) . '/wp-load.php');
require_once dirname(__FILE__).'/KosComments.php';
require_once dirname(__FILE__).'/constants.php';

ob_end_clean();
header('Content-Type: application/json');
$ACTIONS = array('like', 'dislike');

$result = array(
    'code' => 400,
    'message' => 'error'
);

$action = $_REQUEST['action'];
$commentId = $_REQUEST['id'];
$USERID = get_current_user_id();

if(empty($action) || empty($commentId) || !in_array($action, $ACTIONS)) {
    $result['message'] = 'action and id param is required';
    echo json_encode($result);
    die;
}
if(!$USERID) {
    $result['message'] = 'You need login to vote!';
    echo json_encode($result);
    die;
}
//TODO: process if is guest vote

global $table_prefix;
$sql = '';
$sql .= ' SELECT cmt.*, vote.meta_value as vote_value, vote.meta_id as vote_id';
if($USERID) {
    $sql .= ', vote_author.meta_value as vote_author';
}
$sql .= ' FROM '.$table_prefix.'comments as cmt';
$sql .= '     LEFT JOIN '.$table_prefix.'commentmeta as vote ON vote.comment_id = cmt.comment_ID AND vote.meta_key = \'vote_total\'';
if($USERID) {
    $sql .= ' LEFT JOIN '.$table_prefix.'commentmeta as vote_author ON vote_author.comment_id = cmt.comment_ID AND vote_author.meta_key LIKE \'vote_author%\' AND vote_author.meta_value = \''.(int)$USERID.'\'';
}
$sql .= ' WHERE cmt.comment_ID = '.(int)$commentId;
$sql .= "       AND cmt.comment_type = ''";
$sql .= "       AND cmt.comment_approved = '1'";
$sql .= ' LIMIT 0,1';


global $wpdb;
$comments = $wpdb->get_results($sql);
$comment = $comments[0];

if(empty($comment)) {
    $result['message'] = 'could not load the comment';
    echo json_encode($result);
    die;
}
$voteId = $comment->vote_id;
$vote = (int)$comment->vote_value;
$author = $comment->vote_author;

if(!empty($author)) {
    $result['code'] = 200;
    $result['vote'] = $vote;
    $result['message'] = 'You are voted for this comment!';
    echo json_encode($result);
    die;
}

if($action == 'dislike') {
    $vote--;
} else {
    $vote++;
}

if($voteId) {
    $wpdb->update($table_prefix.'commentmeta', array('meta_value' => $vote), array('meta_id' => $voteId), array('%s'), array('%d'));
} else {
    $wpdb->insert($table_prefix.'commentmeta', array('comment_id' => $commentId, 'meta_key' => 'vote_total', 'meta_value' => ''.$vote), array('%d', '%s', '%s'));
}
$wpdb->insert($table_prefix.'commentmeta', array('comment_id' => $commentId, 'meta_key' => 'vote_author_'.$action, 'meta_value' => ''.$USERID), array('%d', '%s', '%s'));

$result['code'] = 200;
$result['vote'] = $vote;
$result['message'] = 'Vote successfully';

echo json_encode($result);
die;




