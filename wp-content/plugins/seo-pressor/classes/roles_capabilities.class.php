<?php
if (!class_exists('WPPostsRateKeys_RolesCapabilities')) {
	class WPPostsRateKeys_RolesCapabilities
	{
		/**
		 * The name of table in the DB
		 * @static
		 * @var string
		 */
		static $table_name = 'roles_capabilities';
		
		/**
		 * Check if all Roles of the WordPress are added at least with empty Capabilities
		 */
		static function check_for_wp_roles() {
			global $wp_roles;
			
			foreach ($wp_roles->roles as $role_key => $role_arr) {
				$role_data = self::get($role_key,'role_name','%s');
				
				// Ignore the "subscriber"
				if ($role_key!='subscriber') {
					if (!$role_data) {
						// Add it, if is "administrator" Role add the ADMIN capability
						if ($role_key=='administrator') {
							self::add(array('role_name'=>$role_key,'capabilities'=>WPPostsRateKeys_Capabilities::ADMIN));
						}
						else {
							self::add(array('role_name'=>$role_key));
						}
					}
				}
				else {
					// Delete the subscriber if is there
					if ($role_data) {
						self::delete($role_key,'role_name','%s');
					}
				}
			}
		}
		
		/**
		 * Get the common query to perform when the list or the count is requested
		 * 
		 * @param	string	$role_name
		 * @param	string	$capabilities
		 * @param	string	$role_type
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @return 	array	first element is the Query, second is the array with the values for the placeholders in query
		 */
		static public function get_common_query($role_name='',$capabilities='',$role_type='',$not_condition=0) {
		
			global $wpdb;
		   	$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   	
		   	// From and inner joins
			$query = " from $table";
			
			$query_params = array();
			
			// Where conditions
			$where_conditions = array();
			if ($role_name!='') {
				$where_conditions[] = " role_name like %s";
				$query_params[] = "%$role_name%";
			}
			if ($capabilities!='') {
				$where_conditions[] = " capabilities like %s";
				$query_params[] = "%$capabilities%";
			}
			if ($role_type!='') {
				$where_conditions[] = " role_type = %s";
				$query_params[] = "$role_type";
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
		 * @param	string	$role_name
		 * @param	string	$capabilities
		 * @param	string	$role_type
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
		static public function search($role_name='',$capabilities='',$role_type=''
										,$not_condition=0
										,$fields=array(),$pagination_offset='',$rows='',$orderby='',$orderdir='') {
		   	
			// Check if all Roles of the WordPress are added at least with empty Capabilities
			self::check_for_wp_roles();
											
			global $wpdb;
			$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   							
			// Initialize query
			$query = "select id";
			
			// Set the fields to return
			if (count($fields)==0) {
				// All fields
				$query = "select *";
			}
			else {
				// Only listed fields and ID
				if (in_array('role_name',$fields)) {
					$query .= ", role_name";
				}
				if (in_array('capabilities',$fields)) {
					$query .= ", capabilities";
				}
				if (in_array('role_type',$fields)) {
					$query .= ", role_type";
				}
			}
			
			// Add common query
			$query_common_data = self::get_common_query($role_name,$capabilities,$role_type,$not_condition,$fields);
			$query .= $query_common_data[0];
			
			// Pagination and Order
			if ($orderby!='') {
				
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
		 * @param	string	$role_name
		 * @param	string	$capabilities
		 * @param	string	$role_type
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @param	array	$fields				if defined, list of fields to return
		 * 											, else all fields will be returned
		 * 
		 * @return 	int
		 */
		static public function search_count($role_name='',$capabilities='',$role_type=''
										,$not_condition=0) {
		   	global $wpdb;
			$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   							
			// Initialize query
			$query = "select count($table.id)";
			
			// Add common query
			$query_common_data = self::get_common_query($role_name,$capabilities,$role_type,$not_condition); 
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