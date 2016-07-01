<?php
if (!class_exists('WPPostsRateKeys_AutomaticInternalLinks')) {
	class WPPostsRateKeys_AutomaticInternalLinks
	{
		/**
		 * The name of table in the DB
		 * @static
		 * @var string
		 */
		static $table_name = 'automatic_internal_links';
		
		/**
		 * Get the common query to perform when the list or the count is requested
		 * 
		 * @param	string	$keywords
		 * @param	string	$post_title
		 * @param	string	$how_many
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @return 	array	first element is the Query, second is the array with the values for the placeholders in query
		 */
		static public function get_common_query($keywords='',$post_title='',$how_many='',$not_condition=0) {
		
			global $wpdb;
		   	$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   	$table_posts =  $wpdb->posts;
		   	
			// From and inner joins
			$query = " from $table inner join $table_posts on ($table.post_id=$table_posts.ID)";
			$query_params = array();
			
			// Where conditions
			$where_conditions = array();
			if ($keywords!='') {
				$where_conditions[] = " keywords like %s";
				$query_params[] = "%$keywords%";
			}
			if ($post_title!='') {
				$where_conditions[] = " $table_posts.post_title like %s";
				$query_params[] = "%$post_title%";
			}
			if ($how_many!='') {
				$where_conditions[] = " how_many = %d";
				$query_params[] = $how_many;
			}
			
			if (count($where_conditions)!=0) {
				if ($not_condition==1) {
					$query .= ' where not (' . implode(' and ',$where_conditions) . ')';
				}
				else {
					$query .= ' where ' . implode(' and ',$where_conditions);
				}
			}
			
			// Return the Query and the parameters to pass to the Prepare query function
			return array($query,$query_params);
		}
		
		
		/**
		 * Return all items to show
		 * 
		 * @param	string	$keywords
		 * @param	string	$post_title
		 * @param	string	$how_many
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @param	array	$fields				if defined, list of fields to return
		 * 											, else all fields will be returned
		 * @param	int		$pagination_offset	if defined, the first row index to get
		 * @param	int		$rows				if defined, define how many rows to return
		 * 											, else all rows will be returned
		 * @param	int		$orderby			if defined, define the field to order by
		 * @param	int		$orderdir			if defined, define order direction
		 * 
		 * @return 	array						of DB filled objects
		 */
		static public function search($keywords='',$post_title='',$how_many=''
										,$not_condition=0
										,$fields=array(),$pagination_offset='',$rows='',$orderby='',$orderdir='') {
		   	
			global $wpdb;
			$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   	$table_posts =  $wpdb->posts;
		   							
			// Initialize query
			$query = "select $table.id";
			
			// Set the fields to return
			if (count($fields)==0) {
				// All fields
				$query = "select $table.*,$table_posts.post_title";
			}
			else {
				// Only listed fields and ID
				if (in_array('keywords',$fields)) {
					$query .= ", keywords";
				}
				if (in_array('post_title',$fields)) {
					$query .= ", post_id, $table_posts.post_title";
				}
				if (in_array('times_to_link',$fields)) {
					$query .= ", how_many";
				}
			}
			
			// Add common query
			$query_common_data = self::get_common_query($keywords,$post_title,$how_many,$not_condition,$fields);
			$query .= $query_common_data[0];
			
			// Pagination and Order
			if ($orderby!='') {
				if ($orderby=='post_id') {
					// Indeed is Post Title
					$orderby = "$table_posts.post_title";
				}
				if ($orderby=='times_to_link') {
					// Indeed is Post Title
					$orderby = "how_many";
				}
				$query .= " order by $orderby";
				if ($orderdir=='desc') {
					$query .= " $orderdir";
				}
			}
			if ($rows!='') {
				$query .= " LIMIT $pagination_offset,$rows";
			}
			
			// Prepare and Execute query
			$query = $wpdb->prepare($query,$query_common_data[1]);
			$results = $wpdb->get_results($query);
			
			return $results;
									
		}
		
		/**
		 * Get the amount that match the filters
		 * 
		 * @param	string	$keywords
		 * @param	string	$post_title
		 * @param	string	$how_many
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @param	array	$fields				if defined, list of fields to return
		 * 											, else all fields will be returned
		 * 
		 * @return 	int
		 */
		static public function search_count($keywords='',$post_title='',$how_many=''
										,$not_condition=0) {
		   	global $wpdb;
			$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   							
			// Initialize query
			$query = "select count($table.id)";
			
			// Add common query
			$query_common_data = self::get_common_query($keywords,$post_title,$how_many,$not_condition); 
			$query .= $query_common_data[0];
			
			// Prepare and Execute query
			$query = $wpdb->prepare($query,$query_common_data[1]);
			$total_rows = $wpdb->get_var($query);
			
			return $total_rows;
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
		   	if (self::$db_obj!=NULL) {
	   			WPPostsRateKeys_Settings::update_internal_link_modification_time(time());
	   			return self::$db_obj->update($data,$where);
		   	}
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
			if (self::$db_obj!=NULL) {
	   			WPPostsRateKeys_Settings::update_internal_link_modification_time(time());
	   			return self::$db_obj->add($data);
			}
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
			if (self::$db_obj!=NULL) {
	   			WPPostsRateKeys_Settings::update_internal_link_modification_time(time());
	   			return self::$db_obj->delete($id,$field,$field_type);
			}
	   		else 
	   			return FALSE;
		}
		
		/*
		 * End Common Code
		 * This can be avoid since PHP 5.3 (http://www.php.net/manual/en/language.oop5.late-static-bindings.php)
		 */
	}
}