<?php
if (!class_exists('WPPostsRateKeys_LSI')) {
	class WPPostsRateKeys_LSI
	{
		/**
		 * The name of table in the DB
		 * @static
		 * @var string
		 */
		static $table_name = 'lsi';
		
		/**
		 * Check if the current API key is valid
		 * 
		 * @param	string	$use_this_test_key
		 */
		static function check_apikey_is_valid($use_this_test_key='') {
			if (count(self::get_lsi_by_keyword('internet',TRUE,$use_this_test_key))>0) {
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
		
		/**
		 * Get the LSI suggestions
		 * 
		 * Get it from database if there or from internet service.
		 * If are getted from server will be stored on database too.
		 * 
		 * @param 	string 	$keyword
		 * @param 	bool 	$testing	true when we are testing, so no from database and don't store result
		 * @param	string	$use_this_test_key
		 * 
		 * @return	array	each element is a keyword returned
		 */
		static function get_lsi_by_keyword($keyword,$testing=FALSE,$use_this_test_key='') {
			$to_return = array();
			
			// Avoid add the keyword twice
			$already_added = array();
			
			// Before get,compare,search replace the follow
			$keyword = str_replace("\'","'", $keyword);
			
			$get_all = self::get_all($keyword,'keyword');
			if (!$testing && count($get_all)>0) {
				// There is a list in database
				foreach ($get_all as $get_all_item) {
					if (!in_array($get_all_item->lsi_suggestion, $already_added)) {
						$already_added[] = $get_all_item->lsi_suggestion;
						$to_return[] = array('lsi'=>$get_all_item->lsi_suggestion,'BingUrl'=>$get_all_item->bing_url);
					}
				}
			}
			else {
				// Make the request to the service
				$settings = WPPostsRateKeys_Settings::get_options();
				if ($use_this_test_key=='') {
					$accountKey = trim($settings['lsi_bing_api_key']);
				}
				else {
					$accountKey = $use_this_test_key;
				}
				
				if ($accountKey!='') {
					$language = trim($settings['lsi_language']);
					
					$ServiceRootURL =  'https://api.datamarket.azure.com/Bing/Search/';
					$WebSearchURL = $ServiceRootURL . 'RelatedSearch?$format=json&Query=';
					$request = $WebSearchURL . urlencode( "'$keyword'");
					if ($language!='') {
						$request .= '&Market=' . urlencode( "'$language'");
					}
					
					if (function_exists('curl_version')) {
						$process = curl_init($request);
						curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
						curl_setopt($process, CURLOPT_USERPWD,  $accountKey . ":" . $accountKey);
						curl_setopt($process, CURLOPT_TIMEOUT, 30);
						curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
						
						@curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
						@curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
						
						$response = @curl_exec($process);
						if (!$response) {
							// Is null, so return the error message
							$response_error = curl_error($process);
						}
					}
					/*
					if (!function_exists('curl_version') || !$response) {
						$args = array(
								'headers' => array(
										'Authorization' => 'Basic ' . base64_encode($accountKey . ":" . $accountKey)
								)
						);
						$response = wp_remote_request( $request, $args );
						$response = wp_remote_retrieve_body ($response);
					}
					*/
					if (!function_exists('curl_version') || !$response) {
						$context = stream_context_create(
								array('http' => array(
										//'proxy' => 'tcp://127.0.0.1:8888',
										'request_fulluri' => true,
										'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
								)
								)
						);
						$response = @file_get_contents($request, 0, $context);
					}
					
					if ($response) {
					
						$jsonobj = json_decode($response);
						if (is_array($jsonobj->d->results)) {
							foreach($jsonobj->d->results as $value) {
								if (!in_array($value->Title, $already_added)) {
									$already_added[] = $value->Title;
									
									$to_return[] = array('lsi'=>$value->Title,'BingUrl'=>$value->BingUrl);
									if (!$testing) {
										// Add to database
										self::add(array(
													'keyword' => $keyword
													,'lsi_suggestion' => $value->Title
													,'bing_url' => $value->BingUrl
													,'added_dt' => date('Y-m-d H:i:s')
												));	
									}
								}
							}
						}
					}
					else {
						// Store in log that the keyword is invalid
						$code = '311';
						$msg = "Fail getting LSI keywords for Key: $keyword and Bing API Key: $accountKey Check that the Bing API Key is correct. Return: " . $response_error;
						WPPostsRateKeys_Logs::add_error($code, $msg);
					}
				}
			}
			
			return $to_return;
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
