<?php
/**
 *
 */
add_action('comment_post', 'kos_comment_post_hook');
add_action('edit_comment', 'kos_edit_comment_hook');
add_action('deleted_comment', 'kos_deleted_comment_hook');
add_action('trashed_comment', 'kos_trashed_comment_hook');
add_action('wp_set_comment_status', 'kos_wp_set_comment_status_hook');

/**
 *
 */
function kos_comment_post_hook($commentId) {
    $comment = get_comment($commentId);
    if(empty($comment)) {
        return;
    }

    //If this is not a normal comment
    if(!empty($comment->comment_type)) {
        return;
    }

    //If comment is not approved, we don't need process any more
    if($comment->comment_approved != 1) {
        return;
    }

    //TODO: we should process this in background
    $feed = new CommentFeed();
    $feed->addFeedForComment($comment);
}

/**
 * When comment is edited
 * @param $commentId
 */
function kos_edit_comment_hook($commentId) {
    //TODO: Not implement yet
}

/**
 * When comment is Deleted
 * @param $commentId
 */
function kos_deleted_comment_hook($commentId) {
//    $feed = new CommentFeed();
//    $feed->deleteFeedOfComment($commentId);
}

/**
 * When comment is Trashed
 * @param $commentId
 */
function kos_trashed_comment_hook($commentId) {
//    $feed = new CommentFeed();
//    $feed->deleteFeedOfComment($commentId);
}

function kos_wp_set_comment_status_hook($commentId) {
    $comment = get_comment($commentId);
    if(empty($comment)) {
        return;
    }

    $feed = new CommentFeed();
    if($comment->comment_approved == 1) {
        $feed->addFeedForComment($comment);
    } else {
        $feed->deleteFeedOfComment($commentId);
    }

}