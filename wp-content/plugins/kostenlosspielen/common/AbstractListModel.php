<?php
abstract class AbstractListModel {
	protected $items;

	private $currentPage;
	private $noPage;
	private $perPage;
	private $total;

	private $queried = false;

	protected function __construct($configs) {
		if(!is_array($configs)) {
			$configs = array();
		}

		$this->currentPage = isset($configs['current_page']) ? $configs['current_page'] : 1;
		$this->perPage = isset($configs['per_page']) ? $configs['per_page'] : 20;

		$this->items = array();
		$this->noPage = 0;
	}

    /**
     * @return array
     */
    public function getItems() {
		$this->query();

		return $this->items;
	}

    /**
     * @return int
     */
    public function getNoPage() {
		$this->query();

		return $this->noPage;
	}

    /**
     * @return mixed
     */
    public function getTotal() {
		$this->query();

		return $this->total;
	}

	protected function query() {
		if($this->queried) return;

		$this->queried = true;

		//TODO: process cache here

		//. Get query
		$query = $this->getQuery();
		if(empty($query)) {
			return;
		}

		//. Calculate limit and start
		$start = ($this->currentPage- 1) * $this->perPage;
		$limit = $this->perPage;
		$query .= ' LIMIT '.$start.', '.$limit;

        global $wpdb;

		//. Get items of current page
		$this->items = $wpdb->get_results($query);
        
        //. Get total
        $countQuery = 'SELECT FOUND_ROWS() as count';
        $countResult = $wpdb->get_results($countQuery, ARRAY_A);
        $this->total = $countResult[0]['count'];

        //. Calculate noPage
        if($this->perPage > 0 && $this->total > 0) {
            $this->noPage = ceil($this->total / $this->perPage);
        } else {
            $this->noPage = $this->total;
        }
	}

	protected abstract function getQuery();
	protected function getCacheKey() {
		return false;
	}
}