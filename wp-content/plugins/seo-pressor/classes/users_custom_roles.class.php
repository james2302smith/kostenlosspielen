<?php
/**
 * Created to Manage the table of Users and Custom Roles
 * And to handle the users and WordPress Roles 
 */
if (!class_exists('WPPostsRateKeys_UsersCustomRoles')) {
	class WPPostsRateKeys_UsersCustomRoles
	{
		/**
		 * The name of table in the DB
		 * @static
		 * @var string
		 */
		static $table_name = 'users_custom_roles';
		
		/**
		 * Get the common query to perform when the list or the count is requested
		 * 
		 * @param	string	$user_login
		 * @param	string	$role_name
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @return 	array	first element is the Query, second is the array with the values for the placeholders in query
		 */
		static public function get_common_query($user_login='',$role_name='',$not_condition=0) {
		
			global $wpdb;
		   	$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   	$table_roles_capabilities =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . WPPostsRateKeys_RolesCapabilities::$table_name;
		   	$table_wp_users =  $wpdb->users;
		   	
			// From and inner joins
			$query = " from $table 
							inner join $table_roles_capabilities on ($table_roles_capabilities.id=$table.role_id)
							inner join $table_wp_users on ($table_wp_users.ID=$table.user_id)
							";
			$query_params = array();
			
			// Where conditions
			$where_conditions = array();
			if ($user_login!='') {
				$where_conditions[] = " $table_wp_users.user_login like %s";
				$query_params[] = "%$user_login%";
			}
			if ($role_name!='') {
				$where_conditions[] = " $table_roles_capabilities.role_name like %s";
				$query_params[] = "%$role_name%";
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
		 * @param	string	$user_login
		 * @param	string	$role_name
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
		static public function search($user_login='',$role_name=''
										,$not_condition=0
										,$fields=array(),$pagination_offset='',$rows='',$orderby='',$orderdir='') {
		   	
			global $wpdb;
			$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   	$table_roles_capabilities =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . WPPostsRateKeys_RolesCapabilities::$table_name;
		   	$table_wp_users =  $wpdb->users;
									
			// Initialize query
			$query = "select $table.id";
			
			// Set the fields to return
			if (count($fields)==0) {
				// All fields
				$query = "select $table.*,$table_wp_users.user_login,$table_roles_capabilities.role_name";
			}
			else {
				// Only listed fields and ID
				if (in_array('user_login',$fields)) {
					$query .= ", $table_wp_users.user_login";
				}
				if (in_array('role_name',$fields)) {
					$query .= ", $table_roles_capabilities.role_name";
				}
			}
			
			// Add common query
			$query_common_data = self::get_common_query($user_login,$role_name,$not_condition,$fields);
			$query .= $query_common_data[0];
			
			// Pagination and Order
			if ($orderby!='') {
				if ($orderby=='user_login') {
					$orderby = "$table_wp_users.user_login";
				}
				elseif ($orderby=='role_name') {
					$orderby = "$table_roles_capabilities.role_name";
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
		 * @param	string	$user_login
		 * @param	string	$role_name
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @param	array	$fields				if defined, list of fields to return
		 * 											, else all fields will be returned
		 * 
		 * @return 	int
		 */
		static public function search_count($user_login='',$role_name=''
										,$not_condition=0) {
		   	global $wpdb;
			$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   							
			// Initialize query
			$query = "select count($table.id)";
			
			// Add common query
			$query_common_data = self::get_common_query($user_login,$role_name,$not_condition); 
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