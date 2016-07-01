<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nttuyen
 * Date: 1/22/14
 * Time: 10:06 PM
 * To change this template use File | Settings | File Templates.
 */

class KosComments {
    private $perPage = 2;
    private $currentPage = 1;
    private $total = 0;

    private $comments;

    private $postId;

    private function __construct($postId) {
        $this->postId = $postId;
    }

    private static $instances = array();

    /**
     * @param int $postId
     * @return KosComments
     */
    public static function getInstance($postId = 0) {
        if(empty($postId)) {
            $postId = get_the_ID();
        }

        if(empty(self::$instances[$postId])) {
            self::$instances[$postId] = new KosComments($postId);
        }

        return self::$instances[$postId];
    }

    public function init($currentPage = 1, $perPage = 10) {
        if($currentPage < 1) {
            $currentPage = 1;
        }
        if($perPage < 1) {
            $perPage = 1;
        }
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;

        $start = ($this->currentPage - 1) * $this->perPage;
        $limit = $perPage;

        $USERID = get_current_user_id();
        global $table_prefix;

        $sql = '';
        $sql .= ' SELECT SQL_CALC_FOUND_ROWS cmt.*, COALESCE(vote.meta_value, 0) as vote_value, vote.meta_id as vote_id';
        if($USERID) {
            $sql .= ', vote_author.meta_value as vote_author';
        }
        $sql .= ' FROM '.$table_prefix.'comments as cmt';
        $sql .= '     LEFT JOIN '.$table_prefix.'commentmeta as vote ON vote.comment_id = cmt.comment_ID AND vote.meta_key = \'vote_total\'';
        if($USERID) {
            $sql .= ' LEFT JOIN '.$table_prefix.'commentmeta as vote_author ON vote_author.comment_id = cmt.comment_ID AND vote_author.meta_key LIKE \'vote_author%\' AND vote_author.meta_value = \''.(int)$USERID.'\'';
        }
        $sql .= ' WHERE cmt.comment_post_ID = '.(int)$this->postId;
        $sql .= "       AND cmt.comment_type = ''";
        $sql .= "       AND cmt.comment_approved = '1'";
        $sql .= ' GROUP BY cmt.comment_ID';
        $sql .= ' ORDER BY vote_value DESC, cmt.comment_date DESC';
        $sql .= ' LIMIT '.(int)$start.', '.(int)$limit;

        global $wpdb;
        $this->comments = $wpdb->get_results($sql);

        $countQuery = 'SELECT FOUND_ROWS() as count';
        $countResult = $wpdb->get_results($countQuery, ARRAY_A);
        $this->total = $countResult[0]['count'];
    }
    public function hasComments() {
        if(empty($this->comments)) {
            $this->init();
        }
        return count($this->comments) > 0;
    }

    /**
     * @return array
     */
    public function getComments() {
        if(empty($this->comments)) {
            $this->init();
        }
        return $this->comments;
    }
    public function getTotal() {
        if(empty($this->total)) {
            $this->init();
        }
        return $this->total;
    }

    public function getCurrentPage() {
        return $this->currentPage > 1 ? $this->currentPage : 1;
    }
    public function getNoPage() {
        if($this->perPage > 0 && $this->total > 0) {
            return ceil($this->total / $this->perPage);
        } else {
            return $this->total;
        }
    }

    public function htmlListComments($htmlTag = 'li', $return = true, $ignore = 0, $max = 0) {
        $html = array();

        if($this->hasComments()) {
            $ignored = 0;
            $displayed = 0;
            foreach($this->getComments() as $comment) {
                if($ignored < $ignore) {
                    $ignored++;
                    continue;
                }
                if($max > 0 && $displayed >= $max) {
                    break;
                }

                $html[] = $this->htmlComment($comment, $htmlTag, true);
                $displayed++;
            }
        } else {
            $html[] = '<'.$htmlTag.'  class="no-comments">';
            $html[] = ' Im Moment keine Kommentare vorhanden!';
            $html[] = '</'.$htmlTag.'>';
        }

        if($return) {
            return implode("\n", $html);
        } else {
            echo implode("\n", $html);
        }
    }

    public function htmlComment($comment, $htmlTag = 'li', $return = true) {
        $isVoted = !empty($comment->vote_author) || !get_current_user_id();
        $html = array();
        $html[] = '<'.$htmlTag.' comment="'.$comment->comment_ID.'" class="li-kos-comment" id="li-kos-comment-'.$comment->comment_ID.'">';
        $html[] = '   <div class="kos-comment" id="kos-comment-'.$comment->comment_ID .'">';
        $html[] = '        <div class="comment-author-avatar">';
        $html[] =            get_avatar($comment, 40);
        if(function_exists('is_user_online') && is_user_online($comment->user_id)) {
            $html[] = '         <span class="common-background user-online">onl</span>';
        }
        $html[] = '        </div>';
        $html[] = '        <div class="comment-body">';
        $html[] = '            <div class="comment-vote">';
        $html[] = '                 <div>';
        $html[] = '                     <a href="javascript:void(0)" class="vote-link '.($isVoted ? 'like-disabled' : 'like vote-action').'" action="like">like</a>';
        $html[] = '                     <a href="javascript:void(0)" class="vote-link '.($isVoted ? 'dislike-disabled' : 'dislike vote-action').'" action="dislike">dislike</a>';
        $html[] = '                 </div>';
        $html[] = '                 <div class="vote-value" value="'.$comment->vote_value.'">';
        if(!empty($comment->vote_value)) {
            $html[] = '                     '.($comment->vote_value < 0 ? ''.$comment->vote_value : '+'.$comment->vote_value);
        }
        $html[] = '                 </div>';
        $html[] = '            </div>';
        $html[] = '            <div class="comment-author">';
        $html[] =                 sprintf( __( '%s <span class="says"></span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link($comment->comment_ID) ) );
        //$html[] = '                 <span class="comment-time">'.date('d.m.Y H:i:s', strtotime($comment->comment_date)).'</span>';
        $html[] = '            </div>';
        $html[] = '            <div class="comment-time">';
        $html[] = '                 '.date('d.m.Y H:i:s', strtotime($comment->comment_date));
        $html[] = '            </div>';
        $html[] = '            <div class="comment-text">';
        $html[] =                apply_filters( 'comment_text', get_comment_text($comment->comment_ID), get_comment($comment->comment_ID));
        $html[] = '            </div>';
        $html[] = '            <div style="clear: both"></div>';
        $html[] = '        </div>';
        $html[] = '   </div>';
        $html[] = '</'.$htmlTag.'>';

        if($return) {
            return implode("\n", $html);
        } else {
            echo implode("\n", $html);
        }
    }

    public function htmlPaging($return = true) {
        $html = array();

        if($this->getNoPage() <= 1) {
            if($return) {
                return '';
            } else {
                echo '';
                return;
            }
        }

        //Calculate page
        $currentPage = (int)$this->getCurrentPage();
        $minPage = $currentPage - 3 > 1 ? $currentPage - 3 : 1;
        $maxPage = $minPage + 5;

        if($maxPage > $this->getNoPage()) {
            $maxPage = $this->getNoPage();
            $minPage = $maxPage - 5 > 1 ? $maxPage - 5 : 1;
        }

        $html[] = '<ul class="paging" current-page="'.$currentPage.'">';


        $html[] = ' <li class="prev"><a href="javascript:void(0)" page="'.($currentPage - 1).'" class="prev-page '.($currentPage == 1 ? 'disable' : 'page').'"> < </a></li>';

        for($i = $minPage; $i <= $maxPage; $i++) {
            $html[] = '<li class="'.($i == $currentPage ? 'active' : '' ).'">';
            $html[] = ' <a class="'.($i == $currentPage ? 'active' : 'page').'" href="javascript:void(0)" page="'.$i.'">';
            $html[] =       $i;
            $html[] = ' </a>';
            $html[] = '</li>';
        }

        $html[] = ' <li class="next"><a href="javascript:void(0)" page="'.($currentPage + 1).'" class="next-page '.($currentPage >= $this->getNoPage() ? 'disable' : 'page').'"> > </a></li>';

        $html[] = '</ul>';

        if($return) {
            return implode("\n", $html);
        } else {
            echo implode("\n", $html);
        }
    }

    public function pagingDescription($return = true) {
        $start = ($this->currentPage - 1) * $this->perPage;
        $start++;
        $end = $start + count($this->getComments()) - 1;
        $total = $this->getTotal();

        if($total > 0) {
            $html = "{$start} - {$end} von {$total} Ergebnissen";
        } else {
            $html = '';
        }
        if($return) {
            return $html;
        } else {
            echo $html;
        }
    }
}