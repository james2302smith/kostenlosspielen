<?php
if (!class_exists('WPPostsRateKeys_Visits')) {
	class WPPostsRateKeys_Visits
	{
		/**
		 * The name of table in the DB
		 * @static
		 * @var string
		 */
		static $table_name = 'visits';
		
		/**
		 * The name of the cookie
		 * @static
		 * @var string
		 */
		static $cookie_name = 'spcookie';
		
		/**
		 * Return the cookie expiration in seconds
		 * 
		 */
		static private function cookie_expiration() {
			return 30 * 60;
		}
		
		/**
		 * Check the visit if is unique
		 * 
		 * only for front end visits
		 */
		static public function check() {
			if (!is_admin()) {
				// Check for cookie
				if (!isset($_COOKIE[self::$cookie_name])) {
					// Count Visit
					$dt = date('Y-m-d H:i:s');
					self::add(array('visit_dt'=>$dt));
				}
				
				// Set/Reset the time
				$result = setcookie(self::$cookie_name, 'True', time() + self::cookie_expiration());
			}
		}
		
		/*
		 * except "WPPostsRateKeys" that is the name of the class of the plugin
		 * Begin Common Code
		 * This can be avoid since PHP 5.3 (http://www.php.net/manual/en/language.oop5.late-static-bindings.php)
		 */
		
		/**
		 * The Object to access DB
		 * @static
		 * @var GpcKits_DBO
		 */
		static $db_obj;
		
		/**
		 * Set DB Object
		 *
		 * @static 
		 * @global $wpdb used to access to WordPress Object that manage DB
		 * @param string $table optional value of the table
		 * @access public
		 */
		static public function set_db_obj($table='')
		{
		   	global $wpdb;
		   	if ($table=='') $table = self::$table_name;
		   	$full_table_name =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . $table;
		   	
		   	if (class_exists('WPPostsRateKeys_DBO'))
				self::$db_obj = new WPPostsRateKeys_DBO($full_table_name);
		}
		
		/**
		 * Get all items from DB
		 * 
		 * @static
		 * @param int $id value of the field to filter
		 * @param string $field name of the column to filter
		 * @param string $order_by name of the column to order by
		 * @param string $field_type type of the column to filter (can be '%s' for strings or '%d' for numeric values)
		 * @return array
		 * @access public
		 */
		static public function get_all($id='', $field='', $order_by='', $field_type='')
		{
	   		self::set_db_obj();
	   		if (self::$db_obj!=NULL)
	   			return self::$db_obj->get_all($id, $field, $order_by, $field_type);
	   		else
	   			return array();
		}
		
		/**
		 * Get item from DB
		 * 
		 * @static
		 * @param int $id value of the field to filter
		 * @param string $field name of the column to filter
		 * @param string $field_type type of the column to filter (can be '%s' for strings or '%d' for numeric values)
		 * @return array|NULL data when query was executed succesfully, else return NULL
		 * @access public
		 */
		static public function get($id, $field='', $field_type='')
		{
			self::set_db_obj();
			if (self::$db_obj!=NULL)
	   			return self::$db_obj->get($id, $field, $field_type);
	   		else
	   			return NULL;
		}
		
		/**
		 * Update item DB
		 * 
		 * @static
		 * @param array $data with all the key/values to be updated in the table
		 * @param array $where with all the key/values to filter the update
		 * @return bool true when query was executed succesfully, else return FALSE
		 * @access public
		 */
		static public function update($data,$where)
		{
		   	self::set_db_obj();
		   	if (self::$db_obj!=NULL)
	   			return self::$db_obj->update($data,$where);
	   		else 
	   			return FALSE;
		}
		
		/**
		 * Add item DB
		 * 
		 * @static
		 * @param array $data with all the key/values to be added to table
		 * @return int|bool ID generated for an AUTO_INCREMENT column by the most recent INSERT query 
		 * 					or FALSE when the query wasn't executed succesfully
		 * @access public
		 */
		static public function add($data)
		{
			self::set_db_obj();
			if (self::$db_obj!=NULL)
	   			return self::$db_obj->add($data);
	   		else 
	   			return FALSE;
		}
		
		/**
		 * Delete item DB
		 * 
		 * @static
		 * @param int $id value of the field of the data to delete
		 * @param string $field name of the column to filter
		 * @param string $field_type type of the column to filter (can be '%s' for strings or '%d' for numeric values)
		 * @return bool true when query was executed succesfully, else return FALSE
		 * @access public
		 */
		static public function delete($id, $field='', $field_type='')
		{
			self::set_db_obj();
			if (self::$db_obj!=NULL)
	   			return self::$db_obj->delete($id,$field,$field_type);
	   		else 
	   			return FALSE;
		}
		
		/*
		 * End Common Code
		 * This can be avoid since PHP 5.3 (http://www.php.net/manual/en/language.oop5.late-static-bindings.php)
		 */
	}
}
