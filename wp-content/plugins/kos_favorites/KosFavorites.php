<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nttuyen
 * Date: 1/22/14
 * Time: 10:06 PM
 * To change this template use File | Settings | File Templates.
 */

class KosFavorites {
    private $perPage = 2;
    private $currentPage = 1;
    private $total = 0;

    private $orderType;

    private $games;
    
    private $userid;


    private function __construct($userid) {
        $this->userid = $userid;
    }

    private static $instances = array();

    /**
     * @param int $postId
     * @return KosFavorites
     */
    public static function getInstance($userid = 0) {
        if(empty($userid)) {
            $userid = get_current_user_id();
        }

        if(empty(self::$instances[$userid])) {
            self::$instances[$userid] = new KosFavorites($userid);
        }

        return self::$instances[$userid];
    }

    public function isFavoritedGame($postid = 0) {
        if(empty($postid)) {
            $postid = get_the_ID();
        }
        if(empty($postid)) {
            return false;
        }

        if ($this->userid) {
            global $wpdb;
            global $table_prefix;
            $sql = 'SELECT * FROM '.$table_prefix.'favorite_games AS fav WHERE fav.user_id = '.(int)$this->userid.' AND fav.post_id = '.(int)$postid;
            $result = $wpdb->get_row($sql);

            return !empty($result);
        } else {
            $favorites = json_decode(stripslashes($_COOKIE['favorites']), true);
            if (empty($favorites) || !is_array($favorites)) return false;
            foreach ($favorites as $f) {
                if ($f['post_id'] == $postid) return true;
            }
            return false;
        }

    }
    
    public function addToFavorite($postid) {
        if(empty($postid)) {
            $postid = get_the_ID();
        }
        if(empty($postid)) {
            return false;
        }
        
        if($this->isFavoritedGame($postid)) {
            return true;
        }

        $data = array(
            'user_id' => $this->userid,
            'post_id' => $postid,
            'timestamp' => time()
        );

        if ($this->userid) {
            global $table_prefix;
            $table = $table_prefix.'favorite_games';
            $format = array('%d', '%d', '%d');

            global $wpdb;
            $result = $wpdb->insert($table, $data, $format);
            if($result === false) {
                return false;
            }
            return true;
        } else {
            $favorites = json_decode(stripslashes($_COOKIE['favorites']), true);
            if (empty($favorites) || !is_array($favorites)) {
                $favorites = array();
            }
            array_push($favorites, $data);
            setcookie('favorites', json_encode($favorites), time()+60*60*24*30, '/');
            return true;
        }
    }
    
    public function removeFromFavorite($postid) {
        if(empty($postid)) {
            $postid = get_the_ID();
        }
        if(empty($postid)) {
            return true;
        }

        if ($this->userid) {
            global $table_prefix;
            $table = $table_prefix.'favorite_games';
            $where = array(
                'user_id' => $this->userid,
                'post_id' => $postid
            );
            $where_format = array('%d', '%d');

            global $wpdb;
            $wpdb->delete($table, $where, $where_format);

            return true;
        } else {
            $favorites = json_decode(stripslashes($_COOKIE['favorites']), true);
            if (!is_array($favorites) || empty($favorites)) return true;

            $fa = array();
            foreach($favorites as $f) {
                if ($f['post_id'] != $postid) {
                    array_push($fa, $f);
                }
            }
            setcookie('favorites', json_encode($fa), time()+60*60*24*30, '/');
            //$_COOKIE['favorites'] = $fa;
            return true;
        }
    }
    
    
    public function init($currentPage = 1, $limit = 20, $orderType = 'last_add_to_favorite') {
        $this->currentPage = $currentPage;
        $this->perPage = $limit;
        $this->orderType = $orderType;
        
        $start = ($this->currentPage - 1) * $this->perPage;

        $listId = array();
        if (!$this->userid) {
            $favorites = json_decode(stripslashes($_COOKIE['favorites']), true);
            if (is_array($favorites) && !empty($favorites)) {
                foreach($favorites as $f) {
                    array_push($listId, $f['post_id']);
                }
            }
            if (empty($listId)) return;
        }
        
        global $wpdb;
        global $table_prefix;

        $select = 'SELECT SQL_CALC_FOUND_ROWS DISTINCT post.*';
        $from = '';
        if ($this->userid) {
            $from = 'FROM '.$table_prefix.'posts as post INNER JOIN '.$table_prefix.'favorite_games AS fav ON fav.post_id = post.ID';
        } else {
            $from = 'FROM '.$table_prefix.'posts as post';
        }

        $where = "WHERE post.post_status = 'publish' ";
        if ($this->userid) {
            $where .= " AND fav.user_id = ".(int)$this->userid;
        } else {
            $where .= ' AND post.ID in ('.implode(',', $listId).') ';
        }
        $where .= " AND post.post_type = 'post' ";
        //$where .= " AND post.category2 = ".(int)$this->id.' ';
        if ($this->userid) {
            $orderby = 'ORDER BY fav.timestamp DESC';
        } else {
            $orderby = '';
        }

        if($this->orderType == 'new') {
            $orderby = 'ORDER BY post.post_date DESC';
        } else if($this->orderType == 'best') {
            $select .= ' ,(m1.meta_value+0.00) AS ratings_average, (m2.meta_value + 0.00) AS ratings_users';
            $from .= ' LEFT JOIN '.$table_prefix.'postmeta as m1 ON (m1.post_id = post.ID AND m1.meta_key = \'ratings_average\')';
            $from .= ' LEFT JOIN '.$table_prefix.'postmeta as m2 ON (m2.post_id = post.ID AND m2.meta_key = \'ratings_users\')';
            $where .= " ";
            $orderby = 'ORDER BY ratings_average DESC, ratings_users DESC';
        } else if($this->orderType == 'vote') {
            $select .= ' ,(m4.meta_value + 0.00) as ratings_users';
            $from .= ' LEFT JOIN '.$table_prefix.'postmeta as m4 ON (m4.post_id = post.ID AND m4.meta_key = \'ratings_users\')';
            $where .= " ";
            $orderby = 'ORDER BY ratings_users DESC';
        }  else if($this->orderType == 'view') {
            $orderby = 'ORDER BY post.game_views DESC';
        }

        $query = $select.' '.$from.' '.$where.' '.$orderby;
        $query .= ' LIMIT '.$start.', '.$limit;
        //print_r($query);die;

        //$sql = 'SELECT SQL_CALC_FOUND_ROWS post.* FROM '.$table_prefix.'posts AS post INNER JOIN '.$table_prefix.'favorite_games AS fav ON fav.post_id = post.ID WHERE fav.user_id = '.(int)$this->userid.' ORDER BY fav.timestamp DESC LIMIT '.(int)$start.', '.(int)$limit;
        
        $this->games = $wpdb->get_results($query);
        
        $countQuery = 'SELECT FOUND_ROWS() as count';
        $countResult = $wpdb->get_results($countQuery, ARRAY_A);
        $this->total = $countResult[0]['count'];
    }
    
    public function getGames() {
        if(empty($this->games)) {
            $this->init();
        }
        return $this->games;
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
    public function getNoItemPerPage() {
        return $this->perPage;
    }
    public function getNoPage() {
        if($this->perPage > 0 && $this->total > 0) {
            return ceil($this->total / $this->perPage);
        } else {
            return $this->total;
        }
    }
    public function getOrderType() {
        return $this->orderType;
    }
}
