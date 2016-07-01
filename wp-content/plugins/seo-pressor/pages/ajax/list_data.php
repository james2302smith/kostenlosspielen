<?php
/**
 * Page to handle all Ajax requests for list data.
 * All data will be returned using JSON format
 *
 * General variables:
 *
 * @uses	$_REQUEST['object']
 * @uses	$_REQUEST['fields']			array with all the fields names that must be returned, if empty returns all fields
 *
 * @uses	$_REQUEST['not_condition']	if defined, will be applied a NOT to the conditions of the query
 *
 * @uses	$_REQUEST['page']			paginations variable to determine which page to show
 * @uses	$_REQUEST['rows']			paginations variable to determine how many items show in that page
 *
 * @uses	$_REQUEST['orderby']		order variable to determine the field to order by it.
 * 											Must be one of the values in Fields array or any available for object if Fields is empty
 * @uses	$_REQUEST['orderdir']		order variable to determine the direction of the order, can be: asc or desc
 *
 * @example of receiving data
 * 		$_REQUEST['object'] = 'showtimes';
		$_REQUEST['fields'] = array('domain');
		$_REQUEST['page'] = 1;
		$_REQUEST['rows'] = 2;
		$_REQUEST['orderby'] = 'domain';
		$_REQUEST['orderdir'] = 'desc';
 */

// Set the list of fields to return
if (isset($_REQUEST['fields']))	$fields = (array) $_REQUEST['fields'];
else $fields = array(); // Equivalent to all fields

// Set the variable not_condition
if (isset($_REQUEST['not_condition'])) $not_condition = 1;
else $not_condition = 0;

// Set pagination variables
if (isset($_REQUEST['page'])) $page = $_REQUEST['page'];
else $page = 1;
if ($page<1) $page = 1; // Validate for non allowed values of page
if (isset($_REQUEST['rows'])) $rows = $_REQUEST['rows'];
else $rows = ''; // Means all rows

if ($rows=='') {
	$pagination_offset = 0;
}
else {
	$pagination_offset = (($page - 1)*$rows) + 1; // This is the number, beggining by 1
	$pagination_offset--;// But Mysql begins counting by 0
}

// Set order variables
if (isset($_REQUEST['orderby'])) $orderby = $_REQUEST['orderby'];
else $orderby = '';
if (isset($_REQUEST['orderdir'])) $orderdir = $_REQUEST['orderdir'];
else $orderdir = '';

/**
 * Get tags from third services
 *
 * Condition
 * - $_REQUEST['object']=='tag'
 *
 */

if ($_REQUEST['object']=='tag') {
	$post_id = $_REQUEST['post_id'];
	$service_id = $_REQUEST['service'];
	$content = $_REQUEST['content'];

	// Prepare response
	$data_to_return = array();
	$data_to_return['message'] = 'Data retrieved successfully.';
	$data_to_return['type'] = 'notification';

	// Get tags
	$data_to_return['tags'] = WPPostsRateKeys_RelatedTags::get_suggested_tags($post_id,$content,$service_id);

	// Return response
	$json = json_encode($data_to_return);
	echo $json;
	die();
}

/**
 * youtube videos entries
 *
 * Condition
 * - $_REQUEST['object']=='youtube_videos'
 *
 */

if ($_REQUEST['object']=='youtube_videos') {
	$post_id = $_REQUEST['post_id'];

	$data_to_return = array();
	$data_to_return['message'] = 'Data retrieved successfully.';
	$data_to_return['type'] = 'notification';
	$data_to_return['videos'] = array();
	$data_to_return['videos']['message'] = '';

	$post_key1 = WPPostsRateKeys_WPPosts::get_keyword($post_id);
	$post_key2 = WPPostsRateKeys_WPPosts::get_keyword2($post_id);
	$post_key3 = WPPostsRateKeys_WPPosts::get_keyword3($post_id);
	$data_to_return['videos']['list'] = array();

	if (!WPPostsRateKeys_Upgrade::check_for_outgoing_connections()) {
		$network_ok = FALSE;
		$data_to_return['videos']['message'] = __("The videos couldn't be retrieved due to outgoing network connection problem. If this persist contact yout hosting support.",'seo-pressor');
	}
	else {
		$network_ok = TRUE;
	}

	// Request only 8 videos
	$all_videos_per_key = array();
	if ($post_key1!='') {
		if ($network_ok) {
			$youtubeKey1 = new WPPostsRateKeys_YoutubeKeyword ( $post_key1 );
			$all_videos_per_key[$post_key1] = $youtubeKey1->getVideos ( 8 );
		}
		$data_to_return['videos']['list'][$post_key1] = array('message'=>'','list'=>array());
	}
	if ($post_key2!='') {
		if ($network_ok) {
			$youtubeKey2 = new WPPostsRateKeys_YoutubeKeyword ( $post_key2 );
			$all_videos_per_key[$post_key2] = $youtubeKey2->getVideos ( 8 );
		}
		$data_to_return['videos']['list'][$post_key2] = array('message'=>'','list'=>array());
	}
	if ($post_key3!='') {
		if ($network_ok) {
			$youtubeKey3 = new WPPostsRateKeys_YoutubeKeyword ( $post_key3 );
			$all_videos_per_key[$post_key3] = $youtubeKey3->getVideos ( 8 );
		}
		$data_to_return['videos']['list'][$post_key3] = array('message'=>'','list'=>array());
	}

	/*@var $youtubeVideo WPPostsRateKeys_YoutubeVideo */
	foreach ($all_videos_per_key as $post_key => $youtubeVideos) {

		foreach ($youtubeVideos as $youtubeVideo) {
			$data_item = array();
			/*@var $videoEntry Zend_Gdata_YouTube_VideoEntry */
			$videoEntry = $youtubeVideo->videoEntry;

			$tmp_video_entry = array();
			$tmp_video_entry['url'] = $videoEntry->getVideoWatchPageUrl();
			$tmp_video_entry['thumbnail'] = $youtubeVideo->getThumbnail();
			$seconds = $videoEntry->getVideoDuration();
			$tmp_video_entry['duration'] = gmdate("H:i:s", $seconds);
			// Remove the hours as 00:
			if (strpos($tmp_video_entry['duration'], '00:')===0) {
				$tmp_video_entry['duration'] = substr_replace($tmp_video_entry['duration'], '', 0,3);
			}
			/*@var $author Zend_Gdata_App_Extension_Author */
			$author = $videoEntry->getAuthor();
			/*@var $author Zend_Gdata_App_Extension_Name */
			$author = $author[0]->getName();
			$tmp_video_entry['author'] = $author->getText();
			$tmp_video_entry['title'] = $videoEntry->getVideoTitle();
			$tmp_video_entry['id'] = $youtubeVideo->id;
			$tmp_video_entry['views'] = number_format($videoEntry->getVideoViewCount(),0);
			//$youtubeVideo->getCodeToDisplayVideo ( 425, 350 );

			$data_to_return['videos']['list'][$post_key]['list'][] = $tmp_video_entry;
		}
	}

	$json = json_encode($data_to_return);
	echo $json;
	die();
}

/**
 * Logs entries
 *
 * Condition
 * - $_REQUEST['object']=='log'
 *
 */

if ($_REQUEST['object']=='log') {

	// Set order by default
	if ($orderby=='') {
		$orderby = 'dt';
		$orderdir = 'DESC';
	}

	// Set values for filters.
	if (isset($_REQUEST['type'])) $type = $_REQUEST['type'];
	else $type = '';
	if (isset($_REQUEST['msg_code'])) $msg_code = $_REQUEST['msg_code'];
	else $msg_code = '';
	if (isset($_REQUEST['message'])) $message = $_REQUEST['message'];
	else $message = '';
	if (isset($_REQUEST['dt'])) $dt = $_REQUEST['dt'];
	else $dt = '';

	// Make request and fill data to return
	$list = WPPostsRateKeys_Logs::search($type,$msg_code,$message,$dt
			,$not_condition
			,$fields,$pagination_offset,$rows,$orderby,$orderdir);

	// Get total of rows to calculate the total numbers of pages of the Grid
	$total_rows = WPPostsRateKeys_Logs::search_count($type,$msg_code,$message,$dt
			,$not_condition,$fields);

	$data_to_return['rows'] = array();

	foreach ($list as $item_obj) {
		$data_item = array();

		$data_item['id'] = (string) $item_obj->id;

		$data_item['cell'][] = (string) $item_obj->dt;
		$data_item['cell'][] = (string) $item_obj->type;
		$data_item['cell'][] = (string) $item_obj->msg_code;
		$data_item['cell'][] = (string) $item_obj->message;

		// Add item to list
		$data_to_return['rows'][] = $data_item;
	}
}

/**
 * Suggestions
 *
 * Condition
 * - $_REQUEST['object']=='suggestions'
 *
 */

if ($_REQUEST['object']=='suggestions') {

	if (isset($_REQUEST['post_id'])) {

		$all_suggestions = WPPostsRateKeys_Central::get_suggestions_page($_REQUEST['post_id']);

		echo '<ul id="seopressor-score-page-suggestions-container">';
		foreach ($all_suggestions as $all_suggestions_item) {
			// Only negatives
			if ($all_suggestions_item[0]=='0') {
				echo '<li class="seopressor-negative">
        			<span class="seopressor-icon-suggestion-type"></span>
        			<p>' . $all_suggestions_item[1] . '</p>';
				if ($all_suggestions_item[2]!='') {
        			echo '<a title="Click to show the help" class="seopressor-icon-info"></a>
			        	<div class="ui-helper-hidden seopressor-hidden-help">
			        	<p>' . $all_suggestions_item[2] . '</p>
			        	</div>';
				}
    			echo '</li>';
			}
		}
		echo '</ul>';
	}

	die();
}

/**
 * Posts (Posts and Pages)
 *
 * Condition
 * - $_REQUEST['object']=='posts'
 *
 */

if ($_REQUEST['object']=='posts') {

	// Set order by user_id for default
	if ($orderby=='') {
		$orderby = 'score'; // WordPress user login
	}

	// Set values for filters.
	if (isset($_REQUEST['score'])) $score = $_REQUEST['score'];
	else $score = '';
	if (isset($_REQUEST['post_title'])) $post_title = $_REQUEST['post_title'];
	else $post_title = '';
	if (isset($_REQUEST['post_type'])) $post_type = $_REQUEST['post_type'];
	else $post_type = '';
	if (isset($_REQUEST['keyword'])) $keyword = $_REQUEST['keyword'];
	else $keyword = '';
	if (isset($_REQUEST['post_date'])) $post_date = $_REQUEST['post_date'];
	else $post_date = '';

	// Make request and fill data to return
	$list = WPPostsRateKeys_WPPosts::search($score,$post_title,$post_type,$keyword,$post_date
										,$not_condition
										,$fields,$pagination_offset,$rows,$orderby,$orderdir);

	// Get total of rows to calculate the total numbers of pages of the Grid
	$total_rows = WPPostsRateKeys_WPPosts::search_count($score,$post_title,$post_type,$keyword,$post_date
										,$not_condition,$fields);

	$data_to_return['rows'] = array();
	foreach ($list as $item_obj) {
		$data_item = array();

		$data_item['id'] = (string) $item_obj->ID;

		if (in_array('score',$fields) || count($fields)==0) {
			$score = $item_obj->score;
			$score = number_format($score,2);
			$score = str_replace('.00', '', $score);

			$data_item['cell'][] = (string) $score;
		}
		if (in_array('post_title',$fields) || count($fields)==0) {
			// Show title with link to Edit Post page
			$link_edit_post = WPPostsRateKeys_WPPosts::get_link_to_post_page_edit_page($data_item['id']);
			$data_item['cell'][] = (string) '<a href="' . $link_edit_post . '">' . $item_obj->post_title . '</a>';
		}
		if (in_array('post_type',$fields) || count($fields)==0) {
			// Show Type upper-casing first letter
			$data_item['cell'][] = (string) ucfirst($item_obj->post_type);
		}
		if (in_array('keyword',$fields) || count($fields)==0) {
			$keywords = $item_obj->keyword;
			if ($item_obj->keyword2!='') {
				$keywords .= ',' . $item_obj->keyword2;
			}
			if ($item_obj->keyword3!='') {
				$keywords .= ',' . $item_obj->keyword3;
			}
			$data_item['cell'][] = (string) $keywords;
		}
		if (in_array('post_date',$fields) || count($fields)==0) {
			/* In database has this format: 2011-07-23 17:01:38
			 * We want show it in this one: 07/23/2011
			 */
			$data_item['cell'][] = (string) date('m/d/Y', strtotime($item_obj->post_date));
		}
		// Suggestion column
		$post_suggestions = WPPostsRateKeys_Central::get_suggestions_page($data_item['id']);
		$post_suggestions_count = 0;
		foreach ($post_suggestions as $post_suggestions_item) {
			// Only negatives
			if ($post_suggestions_item[0]=='0') {
				$post_suggestions_count++;
			}
		}

		if ($post_suggestions_count>0) {
			$data_item['cell'][] = '<a href="' . admin_url( 'admin-ajax.php?action=seopressor_list&object=suggestions&post_id=' . $data_item['id'])
				 . '" title="Suggestions" class="thickbox" onclick="return false;">'
									.  __('Click to view','seo-pressor') . ' ' . $post_suggestions_count
									. ' ' . __('suggestions','seo-pressor')
									. '</a>';
		}
		else {
			$data_item['cell'][] = __('No suggestions','seo-pressor');
		}

		// Add item to list
		$data_to_return['rows'][] = $data_item;
	}
}

/**
 * Automatic Internal Links
 *
 * Condition
 * - $_REQUEST['object']=='automatic_internal_links'
 *
 */

if ($_REQUEST['object']=='automatic_internal_links') {

	// Set order by user_id for default
	if ($orderby=='') {
		$orderby = 'keywords'; // WordPress user login
	}

	// Set values for filters.
	if (isset($_REQUEST['keywords'])) $keywords = $_REQUEST['keywords'];
	else $keywords = '';
	if (isset($_REQUEST['post_id'])) $post_title = $_REQUEST['post_id']; // Received as post_id but is indeed the Post title. Done in this way due to a handipac in the Grid
	else $post_title = '';
	if (isset($_REQUEST['times_to_link'])) $how_many = $_REQUEST['times_to_link']; // Received as post_id but is indeed the Post title. Done in this way due to a handipac in the Grid
	else $how_many = '';

	// Make request and fill data to return
	$list = WPPostsRateKeys_AutomaticInternalLinks::search($keywords,$post_title,$how_many
										,$not_condition
										,$fields,$pagination_offset,$rows,$orderby,$orderdir);

	// Get total of rows to calculate the total numbers of pages of the Grid
	$total_rows = WPPostsRateKeys_AutomaticInternalLinks::search_count($keywords,$post_title,$how_many
										,$not_condition,$fields);

	$data_to_return['rows'] = array();
	foreach ($list as $item_obj) {
		$data_item = array();

		$data_item['id'] = (string) $item_obj->id;

		// Add cell for Actions column
		$data_item['cell'][] = '<button class="action_edit seopressor-button">Edit</button>'
		. '<button class="action_delete seopressor-button">Delete</button>';

		if (in_array('keywords',$fields) || count($fields)==0) {
			$data_item['cell'][] = (string) WPPostsRateKeys_Validator::parse_output($item_obj->keywords);
		}
		if (in_array('post_id',$fields) || count($fields)==0) {
			// Show title and the link to the view Post page
			$post_title = $item_obj->post_title;
			$post_link = get_permalink($item_obj->post_id);

			$data_item['cell'][] = (string) '<a href="' . $post_link . '">' . $post_title . '</a>';
		}
		if (in_array('times_to_link',$fields) || count($fields)==0) {
			$data_item['cell'][] = (string) $item_obj->how_many;
		}

		// Add item to list
		$data_to_return['rows'][] = $data_item;
	}
}

/**
 * External Cloacked Links
 *
 * Condition
 * - $_REQUEST['object']=='external_cloacked_links'
 *
 */

if ($_REQUEST['object']=='external_cloacked_links') {

	// Set order by user_id for default
	if ($orderby=='') {
		$orderby = 'keywords'; // WordPress user login
	}

	// Set values for filters.
	if (isset($_REQUEST['keywords'])) $keywords = $_REQUEST['keywords'];
	else $keywords = '';
	if (isset($_REQUEST['cloaking_folder'])) $cloaking_folder = $_REQUEST['cloaking_folder'];
	else $cloaking_folder = '';
	if (isset($_REQUEST['external_url'])) $external_url = $_REQUEST['external_url'];
	else $external_url = '';
	if (isset($_REQUEST['times_to_link'])) $how_many = $_REQUEST['times_to_link'];
	else $how_many = '';

	// Make request and fill data to return
	$list = WPPostsRateKeys_ExternalCloackedLinks::search($keywords,$cloaking_folder,$external_url,$how_many
										,$not_condition
										,$fields,$pagination_offset,$rows,$orderby,$orderdir);

	// Get total of rows to calculate the total numbers of pages of the Grid
	$total_rows = WPPostsRateKeys_ExternalCloackedLinks::search_count($keywords,$cloaking_folder,$external_url,$how_many
										,$not_condition,$fields);

	$data_to_return['rows'] = array();
	foreach ($list as $item_obj) {
		$data_item = array();

		$data_item['id'] = (string) $item_obj->id;

		// Add cell for Actions column
		$data_item['cell'][] = '<button class="action_edit seopressor-button">Edit</button>'
		. '<button class="action_delete seopressor-button">Delete</button>';

		if (in_array('keywords',$fields) || count($fields)==0) {
			$data_item['cell'][] = (string) WPPostsRateKeys_Validator::parse_output($item_obj->keywords);
		}
		if (in_array('cloaking_folder',$fields) || count($fields)==0) {
			$data_item['cell'][] = (string) WPPostsRateKeys_Validator::parse_output($item_obj->cloaking_folder);
		}
		if (in_array('external_url',$fields) || count($fields)==0) {
			$data_item['cell'][] = (string) $item_obj->external_url;
		}
		if (in_array('times_to_link',$fields) || count($fields)==0) {
			$data_item['cell'][] = (string) $item_obj->how_many;
		}

		// Add item to list
		$data_to_return['rows'][] = $data_item;
	}
}

/**
 * Users and Custom Roles
 *
 * Condition
 * - $_REQUEST['object']=='users_custom_roles'
 *
 */

if ($_REQUEST['object']=='users_custom_roles') {

	// Set order by user_id for default
	if ($orderby=='') {
		$orderby = 'user_login'; // WordPress user login
	}

	// Set values for filters.
	if (isset($_REQUEST['user_login'])) $user_login = $_REQUEST['user_login'];
	else $user_login = '';
	if (isset($_REQUEST['role_name'])) $role_name = $_REQUEST['role_name'];
	else $role_name = '';

	// Make request and fill data to return
	$list = WPPostsRateKeys_UsersCustomRoles::search($user_login,$role_name
										,$not_condition
										,$fields,$pagination_offset,$rows,$orderby,$orderdir);

	// Get total of rows to calculate the total numbers of pages of the Grid
	$total_rows = WPPostsRateKeys_UsersCustomRoles::search_count($user_login,$role_name
										,$not_condition,$fields);

	$data_to_return['rows'] = array();
	foreach ($list as $item_obj) {
		$data_item = array();

		$data_item['id'] = (string) $item_obj->id;

		// Add cell for Actions column
		$data_item['cell'][] = '<button class="action_edit seopressor-button">Edit</button>'
		. '<button class="action_delete seopressor-button">Delete</button>';

		if (in_array('user_login',$fields) || count($fields)==0) {
			$data_item['cell'][] = (string) $item_obj->user_login;
		}
		if (in_array('role_name',$fields) || count($fields)==0) {
			$data_item['cell'][] = (string) WPPostsRateKeys_Validator::parse_output($item_obj->role_name);
		}

		// Add item to list
		$data_to_return['rows'][] = $data_item;
	}
}

/**
 * Roles (WP and Custom) and SEOPressor Capabilities
 *
 * Condition
 * - $_REQUEST['object']=='roles_capabilities'
 *
 */

if ($_REQUEST['object']=='roles_capabilities') {

	// Set order by default
	if ($orderby=='') {
		$orderby = 'role_name'; // WordPress user login
	}

	// Set values for filters.
	if (isset($_REQUEST['role_name'])) $role_name = $_REQUEST['role_name'];
	else $role_name = '';
	if (isset($_REQUEST['capabilities'])) $capabilities = $_REQUEST['capabilities'];
	else $capabilities = '';
	if (isset($_REQUEST['role_type'])) $role_type = $_REQUEST['role_type'];
	else $role_type = '';

	// Make request and fill data to return
	$list = WPPostsRateKeys_RolesCapabilities::search($role_name,$capabilities,$role_type
										,$not_condition
										,$fields,$pagination_offset,$rows,$orderby,$orderdir);

	// Get total of rows to calculate the total numbers of pages of the Grid
	$total_rows = WPPostsRateKeys_RolesCapabilities::search_count($role_name,$capabilities,$role_type
										,$not_condition,$fields);

	$data_to_return['rows'] = array();

	foreach ($list as $item_obj) {
		$data_item = array();

		$data_item['id'] = (string) $item_obj->id;

		// Add cell for Actions column
		if ($role_type=='wp') {
			// Edit only for WordPress roles, except for "Administrator" that is fixed
			if ($wp_roles->roles[$item_obj->role_name]['name']!='Administrator') {
				$data_item['cell'][] = '<button class="action_edit seopressor-button">Edit</button>';
			}
			else {
				$data_item['cell'][] = '';
			}
		}
		else {
			// Edit and Delete
			$data_item['cell'][] = '<button class="action_edit seopressor-button">Edit</button>'
				. '<button class="action_delete seopressor-button">Delete</button>';
		}

		if (in_array('role_name',$fields) || count($fields)==0) {
			if ($role_type=='wp') {
				global $wp_roles;
				$data_item['cell'][] = (string) $wp_roles->roles[$item_obj->role_name]['name'];
			}
			else {
				$data_item['cell'][] = (string) WPPostsRateKeys_Validator::parse_output($item_obj->role_name);
			}
		}
		if (in_array('capabilities',$fields) || count($fields)==0) {
			// Show name of Capabilities instead of ID
			$capabilities_ids_arr = explode(',', $item_obj->capabilities);
			$capabilities_names_arr = array();
			foreach ($capabilities_ids_arr as $capabilities_id) {
				$capabilities_names_arr[] = WPPostsRateKeys_Capabilities::get_name($capabilities_id);
			}

			$data_item['cell'][] = (string) implode(', ', $capabilities_names_arr);
		}

		// Add item to list
		$data_to_return['rows'][] = $data_item;
	}
}

/**
 * Return data
 *
 * @return	$data_to_return	if JSON format
 * @example $data_to_return = array(
	"total" => "12",
	"page" => "2",
	"records" => "24",
	"rows"  => array(
				array("id" => "1", "cell" => ("example1","exa1")),
				array("id" => "2", "cell" => ("example2","exa2")),
				array("id" => "3", "cell" => ("example3","exa3")),
			),
		);
 */
if (isset($data_to_return)) {
	// Define data to return
	$data_to_return['page'] = $page; 	// Used by JS Grid: Current page, the same the JS sent me
	// Calculate the total numbers of pages of the Grid, using the $rows general data and the total of rows $total_rows
	if ($rows=='') { // This means all rows will be showed
		$data_to_return['total'] = 1;
	}
	else {
		$data_to_return['total'] = ceil($total_rows / $rows);
	}
	$data_to_return['records'] = $total_rows;

	$json = json_encode($data_to_return);
	echo $json;
	die();
}




