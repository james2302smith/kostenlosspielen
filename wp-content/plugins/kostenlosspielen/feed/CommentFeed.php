<?php
/**
 * Created by PhpStorm.
 * User: nttuyen
 * Date: 7/27/14
 * Time: 10:01 AM
 */

class CommentFeed {
    public function addFeedForComment($comment) {
        global $wpdb;
        global $table_prefix;
        if(empty($comment)) {
            return;
        }
        $users = $this->getAllUserIdCommentedInPost($comment->comment_post_ID, $comment->user_id);
        if(empty($users)) {
            return;
        }
        //Delete old feed message to avoid duplicate
        $this->deleteOldFeedMessage($comment, $users);
        $message = $this->buildNotificationMessage($comment);
        $message = esc_sql($message);

        $table = $table_prefix.'feeds (user_id, type, status, from_user_id, time, object_id, target_id, message)';
        $tubles = array();
        foreach($users as $key => $user) {
            $tub = "('$user', 'comment', '0', '$comment->user_id', '$comment->comment_date', '$comment->comment_post_ID', '$comment->comment_ID', '$message')";
            array_push($tubles, $tub);
        }
        $values = implode(',', $tubles);
        $query = 'INSERT INTO '.$table.' VALUES '.$values;

        $result = $wpdb->query($query);
        var_dump($result);
    }

    public function updateFeedForComment($comment) {
        var_dump($comment);
    }

    public function deleteFeedOfComment($commentId) {
        if(empty($commentId)) {
            return;
        }

        global $wpdb;
        global $table_prefix;

        $query = 'DELETE FROM '.$table_prefix.'feeds WHERE type = \'comment\' AND target_id = '.(int)$commentId;
        $result = $wpdb->query($query);
    }

    public function markFeedIsRead($userId, $commendId) {
        global $wpdb;
        global $table_prefix;

        $query = 'UPDATE '.$table_prefix.'feeds SET status = 1 WHERE user_id = '.(int)$userId.' AND type = \'comment\' AND target_id = '.(int)$commendId;
        $result = $wpdb->query($query);
    }

    private function getAllUserIdCommentedInPost($postId, $excludes) {
        global $wpdb;
        global $table_prefix;

        $notIn = '';
        if(!empty($excludes)) {
            if(!is_array($excludes)) {
                $excludes = array($excludes);
            }
            $notIn = ' AND user_id NOT IN ('.implode(',', $excludes).')';
        }

        $query = 'SELECT distinct user_id FROM '.$table_prefix.'comments where comment_post_ID = '.(int)$postId.' AND user_id > 0 and comment_type = \'\' and comment_approved = 1 '.$notIn;

        $users = array();
        $result = $wpdb->get_results($query);
        foreach($result as $key => $value) {
            array_push($users, $value->user_id);
        }

        return $users;
    }

    private function buildNotificationMessage($comment) {
        $format = '<span class="author">%s</span> hat in das Spiel <a href="%s" class="post-link">%s</a>, wo du gespielt hast, kommentiert: <span class="comment-content">"%s"</span>';

        $postId = $comment->comment_post_ID;
        $post = get_post($postId);
        $postLink = SITE_ROOT_URL.'/'.$post->post_name.'.html?notice-cmt='.$comment->comment_ID;
        $postName = $post->post_title;
        $message = sprintf($format, $comment->comment_author, $postLink, $postName, $comment->comment_content);

        return $message;
    }

    private function deleteOldFeedMessage($comment, $users) {
        if(empty($comment) || empty($users)) {
            return;
        }

        if(!is_array($users)) {
            $users = array($users);
        }

        global $wpdb;
        global $table_prefix;

        $query = 'DELETE FROM '.$table_prefix.'feeds WHERE type = \'comment\' AND target_id = '.(int)$comment->comment_ID.' AND user_id IN ('.implode(',', $users).')';
        $result = $wpdb->query($query);
    }
} 