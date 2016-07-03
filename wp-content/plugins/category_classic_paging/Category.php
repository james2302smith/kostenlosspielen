<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nttuyen
 * Date: 10/1/13
 * Time: 8:40 PM
 * To change this template use File | Settings | File Templates.
 */

class Category {
    protected static $CATEGORIES = array();

    /**
     * @param int $id
     * @return Category currentCategory
     */
    public static function getInstance($id = 0) {
        static $currentCategoryId;
        if(empty($id)) {
            $id = $currentCategoryId;
        } else {
            $currentCategoryId = $id;
        }

        if(empty($id)) return NULL;

        if(empty(self::$CATEGORIES[$id])) {
            self::$CATEGORIES[$id] = new Category($id);
        }
        return self::$CATEGORIES[$id];
    }

    private $id = 0;
    private $categoryInfo = null;
    private $orderType = 'view';
    private $currentPage = 1;
    private $itemPerPage = 30;
    private $items = array();
    private $total = 0;

    public function __construct($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
    public function setOrderType($orderType) {
        $this->orderType = $orderType;
    }
    public function getOrderType() {
        return $this->orderType;
    }
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }
    public function getCurrentPage() {
        return $this->currentPage;
    }
    public function getItemPerPage() {
        return $this->itemPerPage;
    }
    public function getTotal() {
        if(empty($this->items)) {
            $this->fetch();
        }
        return $this->total;
    }
    public function getItems() {
        if(empty($this->items)) {
            $this->fetch();
        }
        return $this->items;
    }
    public function getCategoryInfo() {
        if(empty($this->categoryInfo)) {
           //Get category info here
            if($this->id) {
                $this->categoryInfo = get_category($this->id, ARRAY_A);
            }
        }
        return $this->categoryInfo;
    }

    public function getBaseURL() {
        global $wp;
        $categoryPath = $wp->query_vars['category_name'];
        $baseCategoryURL = SITE_ROOT_URL.'/'.$categoryPath;
        if($this->orderType != 'view') {
            global $CATEGORY_ORDER_PARAMS_INVERSE;
            $baseCategoryURL .= '/'.$CATEGORY_ORDER_PARAMS_INVERSE[$this->orderType];
        }
        return $baseCategoryURL;
    }
    public function getNoPage() {
        return ceil($this->getTotal() / $this->getItemPerPage());
    }
    public function getNextLink() {
        $noPages = $this->getNoPage();
        if($this->currentPage == $noPages) {
            return '';
        }
        $nextLink = $this->getBaseURL().'/';
        $nextLink .= PAGE.'/'.($this->currentPage + 1).'/';
        return $nextLink;
    }
    public function getPrevLink() {
        if($this->currentPage <= 1) {
            return '';
        }
        $prevLink = $this->getBaseURL().'/';
        if($this->currentPage > 2) {
            $prevLink .= PAGE.'/'.($this->currentPage - 1).'/';
        }
        return $prevLink;
    }

    private function fetch() {
        if(!empty($this->items)) return;
        if(empty($this->id)) return;

        global $table_prefix;

        $select = 'SELECT SQL_CALC_FOUND_ROWS DISTINCT post.*';
        $from = 'FROM '.$table_prefix.'posts as post ';
        $where = "WHERE post.post_status = 'publish' ";
        $where .= " AND post.post_type = 'post' ";
        $where .= " AND post.category2 = ".(int)$this->id.' ';
        $orderby = 'ORDER BY post.game_views DESC';

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
        }

        $query = $select.' '.$from.' '.$where.' '.$orderby;
        //print_r($query);die;

        $start = 0;
        if($this->currentPage > 1) {
            $start = ($this->currentPage - 1) * $this->itemPerPage;
        }
        $start = intval($start);
        $limit = $this->itemPerPage;
        $limit = intval($limit);
        if($limit > 0) {
            $query .= ' LIMIT '.$start.', '.$limit;
        }

        global $wpdb;
        $this->items = $wpdb->get_results($query, ARRAY_A);

        $countQuery = 'SELECT FOUND_ROWS() as count';
        $countResult = $wpdb->get_results($countQuery, ARRAY_A);
        $this->total = $countResult[0]['count'];
    }
}