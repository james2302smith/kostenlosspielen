<?php
/***
* Plugin Name: Wordpress dbMyadmin
* Description: Plugin for Database Management
* Version: 1.0
* Author: Syed Amir Hussain
***/
if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly.');
}
define('plugin_name', 'Wordpress dbMyadmin');
if(!class_exists('WP_dbMyadmin')) {	
	class WP_dbMyadmin {
		/* variables */
		var $db_name;
		var $table;
		var $limit;
		var $start;
		var $total;
		function __construct() {
			if( is_admin() ) {
				/* hook for adding admin menus */
				add_action('admin_menu', array( $this, 'sy_add_pages' ));
				add_action( 'admin_init', array( $this, 'sy_init_css_js' ) );
				/* action hook to handle ajax request */
				add_action( 'wp_ajax_syAjax', array( $this, 'sy_handleRequest' ) );
				$this->db_name = $this->sy_get_db_name();
				$this->start = 0;
				$this->limit = 30;
				$this->load_more = true;
			}
		}
		function sy_add_pages() {
			/* add a new top-level menu */
			add_menu_page('Wordpress dbMyadmin', 'Wordpress dbMyadmin', 'manage_options', 'wp-phpmyadmin', array( &$this, 'sy_get_option' ) );
		}
		/* action function to include css and js */
		function sy_init_css_js() {
			wp_register_style( 'sy_style', plugins_url('/css/sy_style.css', __FILE__));
			wp_enqueue_style( 'sy_style' );
			wp_register_script( 'sy_js', plugins_url('/js/sy_js.js', __FILE__));
			wp_enqueue_script( 'sy_js' );
		}
		/* action function displays the page content for the Make CSV */
		function sy_get_option() {
			global $wpdb;
			/* must check that the user has the required capability */
			if (!current_user_can('manage_options'))
			{
			  wp_die( __('You do not have sufficient permissions to access this page.') );
			}
			$this->sy_echo_option();
		}
		function sy_get_tables(){
			global $wpdb;
			$sql = 'SHOW TABLES LIKE "%"';
			$results = $wpdb->get_results( $sql );
			$this->tables = array();
			foreach($results as $index => $value) {
				foreach($value as $tableName) {
					$this->tables[] = $tableName;
				}
			}
			if(!count( array_filter($this->tables) )){
				die('Error! there is no tables in the selected database.');
			}
		}
		function sy_get_db_name(){
			global $wpdb;
			$db = $wpdb->get_results("SELECT DATABASE( ) as db");
			return $db[0]->db;
		}
		/* action function to create dropdown of the tables */
		function sy_echo_option() {
			$option  = '<div class="wrap"><h2 class="center">Wordpress dbMyadmin</h2></div>';
			$this->sy_get_tables();
			$option .= '<div class="sy-main-content"><table class="sy-database-container" align="center" cellspacing="0"><tr><td class="sy-header">'.$this->db_name.'('.count($this->tables).')</td></tr>';
			$class = "";	$i = 1;
			foreach( $this->tables as $val ):
				$class = ( $i++%2 == 0) ? "odd" : "even";
				$option .= '<tr title="click to view records"><td class="'.$class.' table" data="'.urlencode(base64_encode(time().'###'.$val.'###'.$this->start.'###'.time())).'">'.$val.'</td></tr>';
			endforeach;
			$js = '<script>var plugin_url =  "'.plugins_url('/js/sy_js.js', __FILE__).'";</script>';
			echo $option.'</table></div>'.$js;
		}
		function sy_handleRequest() {
			$func = 'sy_'.$_POST['data']['act'];
			$this->$func();
			die;
		}
		function sy_set_record() {
			global $wpdb;
			$this->records = array();
			$this->records = $wpdb->get_results( 'SELECT * FROM '.$this->table.' LIMIT '.$this->start.', '.$this->limit );
		}
		function sy_set_column(){
			global $wpdb;
			$this->columns = array();
			$cols = $wpdb->get_results( 'SHOW COLUMNS FROM '.$this->table );
			foreach( $cols as $col ):
				array_push( $this->columns, $col->Field );
			endforeach;
		}
		function sy_set_char_limit( $string, $lim ) {
			$dot = ( strlen($string) > $lim ) ? '...' : '';
			return substr( $string, 0, $lim ).$dot;
		}
		function sy_show_record(){
			$this->table = $this->sy_decode_table_and_set_start();
			$this->total = $this->sy_get_total();
			/* Weather load more request */
			if( !$this->sy_is_load_more() ){
				$this->sy_set_column();
				$option  = '<div class="wrap"><h2>Wordpress dbMyadmin</h2></div>';
				$option .= '<div class="sy-main-content" align="center"><table align="center" class="sy-database-container" cellspacing="0"><tr><td class="sy-header" colspan='.count($this->columns).'><label class="sy_database" title="back">'.$this->db_name.'</label>&nbsp;&raquo;&nbsp;'.$this->table.'</td></tr>';
				$class   = "";	$i = 1;
				$options = '<tr>';
				foreach( $this->columns as $column ):
					$option .= '<th>'.$column.'</th>';
				endforeach;
				$option .= '</tr>';
			}
			$option .= $this->sy_get_rows();
			$this->sy_set_query_limit();
			if( $this->start < $this->total ) {
				$pagination = $this->sy_get_pagination();
			}
			
			if( $this->sy_is_load_more() ){
				exit(json_encode(array('data'=>$option, 'paging'=>$pagination)));
			}
			else {
				exit($option.'</table>'.$pagination.'</div>');
			}
		}
		function sy_get_rows(){
			$option = ''; $i = 1;
			$this->sy_set_record();
			foreach( $this->records as $record ):
				$class = ( $i++%2 == 0) ? "odd" : "even";
				$option .= '<tr class="row data-row-'.$class.'">';
				foreach( $record as $rec ):
					$option .= '<td>'.$this->sy_set_char_limit($rec, 50).'</td>';
				endforeach;
				$option .= '</tr>';
			endforeach;
			return $option;
		}
		function sy_back(){
			$this->sy_echo_option();
		}
		function sy_get_pagination(){
			return '<div class="sy_paginate" data="'.urlencode(base64_encode(time().'###'.$this->table.'###'.$this->start.'###'.time())).'">load more</div>';
		}
		function sy_decode_table_and_set_start(){
			list($fo, $tab, $this->start, $foo) = explode('###', base64_decode(urldecode($_POST['data']['tab'])));
			return mysql_escape_string(trim($tab));
		}
		function sy_set_query_limit(){
			$this->start += $this->limit;
		}
		function sy_is_load_more(){
			if(isset($_POST['data']['cond']) && !empty($_POST['data']['cond'])){
				return true;
			}
			return false;
		}
		function sy_get_total(){
			global $wpdb;
			$total = $wpdb->get_results( 'SELECT COUNT(*) as tot FROM '.$this->table );
			return $total[0]->tot;
		}
	}
	new WP_dbMyadmin();
}
?>