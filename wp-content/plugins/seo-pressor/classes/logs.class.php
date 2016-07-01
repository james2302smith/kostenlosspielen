<?php
/**
 * Class to store log messages
 * 
 * Codes convention:
 * 
 * 1- All requests to Central Server begins with: 1
 * 		1- requests for keywords continues with 1
 * 		2- requests for others data cotinues with 2
 * 
 * 2- Other errors
 * 		1- Translation
 * 		2- Checking for Upgrade
 * 		3- Activation and Re-Activation
 * 
 * 3- All error messages begins with: 3
 * 		1- errors requesting data from third sites, like the LSI keywords
 * 		2- all others Includes continues with 2
 * 		3- all others AJAX pages continues with 3
 * 		4- all others Main Class continues with 4
 * 		5- all others Pages continues with 5
 * 		6- related to youtube
 * 		7- errors requesting Central Server
 * 		8- requesting made related with Tags
 * 		9- requesting internal pages
 * 
 * 4- All notifications begins with: 4
 * 		1- cron job related continues with 1
 * 		2- activation related continues with 2
 * 		3- unauthorized access
 * 		
 */
if (!class_exists('WPPostsRateKeys_Logs')) {
	class WPPostsRateKeys_Logs
	{
		/**
		 * The name of table in the DB
		 * @static
		 * @var string
		 */
		static $table_name = 'logs';
		
		/**
		 * Store a message in the log table
		 * 
		 * @param string $code
		 * @param string $msg
		 * @param string $type
		 */
		static private function add_message($code,$msg,$type) {
			return self::add(array('msg_code'=>$code,'message'=>$msg,'type'=>$type,'dt'=>date('Y-m-d H:i:s')));
		}
		
		/**
		 * Add log entry corresponding to an error
		 * 
		 * @param string $code
		 * @param string $msg
		 */
		static public function add_error($code,$msg) {
			// Only if error loggin feature is enabled
			if (WPPostsRateKeys::ERROR_LOG_ENABLE) {
				self::add_message($code,$msg, 'error');
			}
		}
		
		/**
		 * Add log entry corresponding to an notification
		 * 
		 * @param string $code
		 * @param string $msg
		 */
		static public function add_notification($code,$msg) {
			// Only if loggin feature is enabled
			if (WPPostsRateKeys::LOG_ENABLE) {
				self::add_message($code,$msg, 'notification');
			}
		}
		
		/**
		 * Add log entry corresponding to a requests_to_central_server
		 * 
		 * @param string $code
		 * @param string $msg
		 */
		static public function add_request_to_central_server($code,$msg) {
			// Only if loggin feature is enabled
			if (WPPostsRateKeys::LOG_ENABLE) {
				self::add_message($code,$msg, 'request_to_central_server');
			}
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
		 * Get the common query to perform when the list or the count is requested
		 * 
		 * @param	string	$type
		 * @param	string	$msg_code
		 * @param	string	$message
		 * @param	string	$dt
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @return 	array	first element is the Query, second is the array with the values for the placeholders in query
		 */
		static public function get_common_query($type='',$msg_code='',$message='',$dt='',$not_condition=0) {
		
			global $wpdb;
		   	$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   	
			// From and inner joins
			$query = " from $table";
			$query_params = array();
			
			// Where conditions
			$where_conditions = array();
			if ($type!='') {
				$where_conditions[] = " `type` like %s";
				$query_params[] = "%$type%";
			}
			if ($msg_code!='') {
				$where_conditions[] = " `msg_code` like %s";
				$query_params[] = "%$msg_code%";
			}
			if ($message!='') {
				$where_conditions[] = " `message` like %s";
				$query_params[] = "%$message%";
			}
			if ($dt!='') {
				$where_conditions[] = " `dt` like %s";
				$query_params[] = "%$dt%";
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
		 * @param	string	$type
		 * @param	string	$msg_code
		 * @param	string	$message
		 * @param	string	$dt
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
		static public function search($type='',$msg_code='',$message='',$dt=''
										,$not_condition=0
										,$fields=array(),$pagination_offset='',$rows='',$orderby='',$orderdir='') {
		   	
			global $wpdb;
			
			// Set the fields to return
			// All fields
			$query = "select *";
						
			// Add common query
			$query_common_data = self::get_common_query($type,$msg_code,$message,$dt,$not_condition,$not_condition,$fields);
			$query .= $query_common_data[0];
			
			// Pagination and Order
			if ($orderby!='') {
				$query .= " order by `$orderby`";
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
		 * @param	string	$type
		 * @param	string	$msg_code
		 * @param	string	$message
		 * @param	string	$dt
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @param	array	$fields				if defined, list of fields to return
		 * 											, else all fields will be returned
		 * 
		 * @return 	int
		 */
		static public function search_count($type='',$msg_code='',$message='',$dt=''
										,$not_condition=0) {
		   	global $wpdb;
			$table =  $wpdb->prefix . WPPostsRateKeys::$db_prefix . self::$table_name;
		   							
			// Initialize query
			$query = "select count($table.id)";
			
			// Add common query
			$query_common_data = self::get_common_query($type,$msg_code,$message,$dt,$not_condition); 
			$query .= $query_common_data[0];
			
			// Prepare and Execute query
			$query = $wpdb->prepare($query,$query_common_data[1]);
			$total_rows = $wpdb->get_var($query);
			
			return $total_rows;
		}
		
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
		static public function get_all($id='', $field='', $order_by='', $field_type='',$order_direction='ASC')
		{
	   		self::set_db_obj();
	   		if (self::$db_obj!=NULL)
	   			return self::$db_obj->get_all($id, $field, $order_by, $field_type,$order_direction);
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