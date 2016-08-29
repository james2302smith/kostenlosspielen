<?php
/**
 * Created by PhpStorm.
 * User: nttuyen
 * Date: 7/28/14
 * Time: 8:39 PM
 */

class CommentFeedModel extends AbstractListModel {
    private $userId;
    private $noUnread = false;

    private static $instances = array();


    protected  function __construct($userId, $config) {
        parent::__construct($config);
        $this->userId = $userId;
    }

    /**
     * @param $userId
     * @param array $config
     * @return CommentFeedModel
     * @throws Exception
     */
    public static function getInstance($userId, $config = array()) {
        if(empty($userId)) {
            throw new Exception("USER_ID must not be empty");
        }

        if(empty(self::$instances[$userId])) {
            if(empty($config)) {
                $config = array();
            }

            if(empty($config['per_page'])) {
                $config['per_page'] = 20;
            }
            if(empty($config['current_page'])) {
                $config['current_page'] = 1;
            }

            $model = new CommentFeedModel($userId, $config);
            self::$instances[$userId] = $model;
        }
        return self::$instances[$userId];
    }

    public function getNoUnreadFeed() {
        if($this->noUnread !== false) {
            return $this->noUnread;
        }

        global $wpdb;
        global $table_prefix;
        $query = 'SELECT COUNT(*) as count FROM '.$table_prefix.'feeds WHERE user_id = '.(int)$this->userId.' AND type = \'comment\' AND status = 0';

        $countResult = $wpdb->get_results($query, ARRAY_A);
        $this->noUnread = $countResult[0]['count'];

        return $this->noUnread;
    }

    protected function getQuery() {
        global $table_prefix;
        $query = 'SELECT * FROM '.$table_prefix.'feeds WHERE user_id = '.(int)$this->userId.' AND type = \'comment\' ORDER BY time DESC ';
        return $query;
    }
}