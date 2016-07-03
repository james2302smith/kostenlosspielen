<?php
/*
Plugin Name: Social Metrics Pro
Plugin URI: http://socialmetricspro.com/
Description: Track and analyze how your blog is doing across the leading social networking websites and services like Twitter, Facebook, Google +1, Pinterest, StumbleUpon, Digg and LinkedIn. <a href="http://socialmetricspro.com/jv-invite/">Promote Social Metrics Pro and earn 60% commissions!</a>
Author: socialmetricspro.com
Version: 3.1.0
Author URI: http://socialmetricspro.com/
License: GPL2
*/

/*  Copyright 2011-2013 Riyaz Sayyad  (email : riyaz@riyaz.net)

*/
?>
<?php
global $socialmetricspro_db_version;
global $socialmetricspro_version;
global $socialmetricspro_plugins_file;
$socialmetricspro_db_version = "2.1";
$socialmetricspro_version = "3.1.0";
$socialmetricspro_plugins_file = __FILE__;

$socialmetricspro_api_url = 'http://socialmetricspro.com/api/';
$socialmetricspro_plugin_slug = basename(dirname(__FILE__));
$socialmetricspro_plugin_file = basename(__FILE__);

register_activation_hook( $socialmetricspro_plugins_file, 'socialmetricspro_activate' );
register_deactivation_hook( $socialmetricspro_plugins_file, 'socialmetricspro_deactivate' );
require_once( plugin_dir_path( $socialmetricspro_plugins_file ) . '/lib/options.php' );

add_action('smpro_refresh_cache', 'socialmetricspro_refresh_cache');
add_action('smpro_refresh_cache_single', 'socialmetricspro_refresh_cache' ,10 ,3 );

function socialmetricspro_activate() {
	if ( "enabled" == get_option('socialmetricspro_enable_logs', 'disabled') ) smpro_to_log("Activating Social Metrics Pro","I");
	socialmetricspro_install();
	if ( !wp_next_scheduled( 'smpro_refresh_cache' ) ) {
		if ( "enabled" == get_site_option('socialmetricspro_enable_logs', 'disabled') ) smpro_to_log("Scheduling smpro_cache_refresh: " . ( smpro_microtime_float()+60.0 ),"I");
		wp_schedule_event( time()+60, 'daily', 'smpro_refresh_cache' );
		update_option( "socialmetricspro_refresh_status", wp_next_scheduled( 'smpro_refresh_cache' ) );
		wp_cache_delete( "socialmetricspro_refresh_status" );
	}
}

function socialmetricspro_update_db_check() {
	global $socialmetricspro_db_version, $optionstate;
		
	if ((get_site_option('socialmetricspro_db_version') != $socialmetricspro_db_version)  || ($optionstate != get_site_option('socialmetricspro_currentstate') )  ) {
		socialmetricspro_install();
	}
	
	/* if ( get_site_option("socialmetricspro_refresh_status") != "ON") {
		update_option( "socialmetricspro_refresh_status", wp_next_scheduled( 'smpro_refresh_cache' ) );
	} */
}
add_action('plugins_loaded', 'socialmetricspro_update_db_check');

function socialmetricspro_install() {
   global $wpdb;
   global $socialmetricspro_db_version,$socialmetricspro_plugins_file;

   $table_name = $wpdb->prefix . "smpro_cache";
   $installed_ver = get_option( "socialmetricspro_db_version" );
   
   $table_exists = false;
   if($wpdb->get_var("SHOW TABLES LIKE '" . $table_name ."'") == $table_name) {
		$table_exists = true;
   }
   
   if( $installed_ver != $socialmetricspro_db_version || !$table_exists) {
		$sql = "CREATE TABLE " . $table_name . " (
		post_id bigint(20) UNSIGNED NOT NULL,
		update_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		post_type varchar(20) NOT NULL,
		post_title text NOT NULL,
		post_url text NOT NULL,
		twitter_tweets mediumint(9) UNSIGNED NOT NULL,
		facebook_likes mediumint(9) UNSIGNED NOT NULL,
		google_plusones mediumint(9) UNSIGNED NOT NULL,
		su_stumbles mediumint(9) UNSIGNED NOT NULL,
		digg_diggs mediumint(9) UNSIGNED NOT NULL,
		linkedin_shares mediumint(9) UNSIGNED NOT NULL,
		pinterest_pins mediumint(9) UNSIGNED NOT NULL,

		UNIQUE KEY post_id (post_id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		update_option("socialmetricspro_db_version", $socialmetricspro_db_version);
   }
    update_option( "socialmetricspro_currentstate", md5_file($socialmetricspro_plugins_file) );
	wp_cache_delete( "socialmetricspro_currentstate" );
	//wp_clear_scheduled_hook('smpro_refresh_cache');
	//wp_schedule_event(time(), 'daily', 'smpro_refresh_cache');

}
function socialmetricspro_deactivate() {
	wp_clear_scheduled_hook('smpro_refresh_cache');
	update_option( "socialmetricspro_ltype", "" );
	delete_option( "socialmetricspro_refresh_starttime" );
	if ( "enabled" == get_option('socialmetricspro_enable_logs', 'disabled') ) smpro_to_log("Deactivating Social Metrics Pro","I");
}

function socialmetricspro_refresh_cache_single() {
	$p_type = $_GET['p_type'];
	if ( empty ($p_type) ) $p_type = 'post';
	if ( wp_next_scheduled( 'smpro_refresh_cache_single', array("Manual", $p_type)) || get_option("socialmetricspro_refresh_status") == "ON") {
		echo '<div id="message" class="updated"><span style="line-height: 30px;">Data refresh is already in progress. Please try again later.</span></div>';
	} else {
		wp_schedule_single_event(time()+10, 'smpro_refresh_cache_single', array("Manual", $p_type, 0));
		echo '<div id="message" class="updated"><span style="line-height: 30px;">Data refresh scheduled in background and should begin shortly.</span></div>';
	}
}

function socialmetricspro_refresh_cache ( $mode = "Standard", $p_type = "any", $initial_offset = 0 ){
	set_time_limit ( 0 );
	$tzone = get_option('timezone_string');
	if ( !empty( $tzone ) )
		date_default_timezone_set ( $tzone );
	else 
		date_default_timezone_set ( "America/New_York" );
	
	$refresh_start = smpro_microtime_float();
	$refresh_mem_usage = 0;

	global $wpdb, $optionstate;
	global $smpro_debug_mode;
	$smpro_debug_mode = false;
	if ( "enabled" == get_option('socialmetricspro_enable_logs', 'disabled') ) $smpro_debug_mode = true;
	
	$refresh_starttime = floatval(get_option("socialmetricspro_refresh_starttime", 0));
	
	$time_since_last_refresh = $refresh_start - $refresh_starttime;
	
	if ( floatval($time_since_last_refresh) < floatval(86000) && $initial_offset == 0 && $mode == "Standard" ) {
		if ( $smpro_debug_mode ) smpro_to_log( $mode . " Cache refresh triggered. Another cache refresh already in progress or completed recently. Exiting. Last Refresh Status: " . get_option("socialmetricspro_refresh_status") . " Time since last refresh: " . intval($time_since_last_refresh) ."seconds.");
		return;
	}
	
	if ( $mode == "Standard" ) {
		update_option( "socialmetricspro_refresh_starttime", $refresh_start );
		wp_cache_delete( "socialmetricspro_refresh_starttime" );
	}
	
	update_option( "socialmetricspro_refresh_status", "ON" );
	wp_cache_delete( "socialmetricspro_refresh_status" );
	
	$table_name = $wpdb->prefix . "smpro_cache";
	$refreshstate = ($optionstate == get_option('socialmetricspro_currentstate')) ? 1 : 0;
	
	if ((get_option('socialmetricspro_show_twitter', "true") == "true") && $refreshstate ) $show_tc = '1'; else $show_tc = '0';
	if ((get_option('socialmetricspro_show_facebook', "true") == "true") && $refreshstate ) $show_fc = '1'; else $show_fc = '0';
	if ((get_option('socialmetricspro_show_plusone', "true") == "true") && $refreshstate ) $show_poc = '1'; else $show_poc = '0';
	if ((get_option('socialmetricspro_show_su', "true") == "true") && $refreshstate ) $show_sc = '1'; else $show_sc = '0';
	if ((get_option('socialmetricspro_show_digg', "false") == "true") && $refreshstate ) $show_dc = '1'; else $show_dc = '0';
	if ((get_option('socialmetricspro_show_linkedin', "false") == "true") && $refreshstate ) $show_lc = '1'; else $show_lc = '0';
	if ((get_option('socialmetricspro_show_pinterest', "true") == "true") && $refreshstate ) $show_pinc = '1'; else $show_pinc = '0';

	if ( $smpro_debug_mode ) { 
		if ( $initial_offset == 0 ) smpro_to_log( $mode . " Cache refresh started. Active services(" . $refreshstate .") - Twitter:" .$show_tc.",Facebook:".$show_fc.",Google+1:".$show_poc.",SU:".$show_sc.",Digg:".$show_dc.",LinkedIn:".$show_lc.",Pinterest:".$show_pinc, "I" );
		else smpro_to_log( "Resuming ". $mode . " Cache refresh from offset " . $initial_offset . ". Active services(" . $refreshstate .") - Twitter:" .$show_tc.",Facebook:".$show_fc.",Google+1:".$show_poc.",SU:".$show_sc.",Digg:".$show_dc.",LinkedIn:".$show_lc.",Pinterest:".$show_pinc, "I" );
	}
	
	if ( $mode == "Manual" ) $per_page = 20;
	else $per_page = 100;
	$offset = $initial_offset;
	$pagenum = ( $offset / $per_page ) + 1;
	
	$countquery = 
	"SELECT COUNT(*)" .
	" FROM " . $wpdb->prefix . "posts wposts" .
	" WHERE wposts.post_status = 'publish'";
	
	if ( $p_type != "any" ) $countquery .= " AND wposts.post_type = '" . $p_type . "'";
			
	$max_posts = $wpdb->get_var( $wpdb->prepare( $countquery, array() ));
	$num_pages = ceil( $max_posts / $per_page );
	
	$posts_processed = 0;
	do {
		if ( $smpro_debug_mode && $mode == "Standard" ) smpro_to_log( "******************* Current Pagenum: ".$pagenum."/".$num_pages ." *******************", "I");
		$querystr = 
		"SELECT wposts.ID,wposts.post_type" .
		" FROM " . $wpdb->prefix . "posts wposts" .
		" WHERE wposts.post_status = 'publish'";
		
		if ( $p_type != "any" ) { $querystr .= " AND wposts.post_type = '" . $p_type . "'"; }
		$querystr .= " ORDER BY wposts.post_date DESC" .
					 " LIMIT " . $per_page .
					 " OFFSET " . $offset .
					 "";
		$recent_posts = $wpdb->get_results( $wpdb->prepare( $querystr, array() ), OBJECT);
		
		foreach ($recent_posts as $post) {
			
			$post_id = $post->ID;
			$post_url = get_permalink($post_id);
			
			//if ( $smpro_debug_mode ) smpro_to_log($post_id .":".$post_url);
			
			$data['post_id'] = $post_id;
			$data['update_time'] = date('Y-m-d H:i:s');
			$data['post_type'] = $post->post_type;
			$data['post_title'] = get_the_title( $post_id );
			$data['post_url'] = $post_url;
			$data['twitter_tweets'] = ($show_tc == '1') ? smpro_tc_get($post_url) : 0;
			$data['facebook_likes'] = ($show_fc == '1') ? smpro_fc_get($post_url) : 0;
			$data['google_plusones'] = ($show_poc == '1') ? smpro_poc_get($post_url) : 0;
			$data['su_stumbles'] = ($show_sc == '1') ? smpro_sc_get($post_url) : 0;
			$data['digg_diggs'] = ($show_dc == '1') ? smpro_dc_get($post_url) : 0;
			$data['linkedin_shares'] = ($show_lc == '1') ? smpro_lc_get($post_url) : 0;
			$data['pinterest_pins'] = ($show_pinc == '1') ? smpro_pinc_get($post_url) : 0;
			
			$data = socialmetricspro_merge_record($table_name, $data);
			socialmetricspro_insert_update($table_name, $data);
			
			$posts_processed++;
			usleep(750000);
		}
		
		$pagenum++;
		$offset = ( $pagenum - 1 ) * $per_page;
	} while ( $pagenum <= $num_pages && $mode == "Standard" && $posts_processed < 1000 );
	
	$refresh_end = smpro_microtime_float();
	if ( $mode == "Standard" ) {
		if ( $initial_offset == 0 ) {
			$refresh_time = $refresh_end - $refresh_start;
		} else {
			$refresh_time = get_option( "socialmetricspro_last_refresh_time" );
			$refresh_time += ( $refresh_end - $refresh_start );
		}
		
		if(function_exists("memory_get_peak_usage")) { $refresh_mem_usage = memory_get_peak_usage(true); }
		else if(function_exists("memory_get_usage")) { $refresh_mem_usage = memory_get_usage(true); }
		if (!empty ($refresh_mem_usage)) $refresh_mem_usage = $refresh_mem_usage / 1024 / 1024;
		
		update_option( "socialmetricspro_last_refresh_time", $refresh_time );
		update_option( "socialmetricspro_last_refresh_mem", $refresh_mem_usage );
	}
	
	if ( $mode == "Manual" ) {
		update_option( "socialmetricspro_refresh_status", wp_next_scheduled( 'smpro_refresh_cache' ) );
		wp_cache_delete( "socialmetricspro_refresh_status" );
		if ( $smpro_debug_mode ) smpro_to_log( $mode . " Cache refresh completed.", "I");
		return true;
	}
	
	if ( $pagenum > $num_pages ) {
		update_option( "socialmetricspro_refresh_status", wp_next_scheduled( 'smpro_refresh_cache' ) );
		wp_cache_delete( "socialmetricspro_refresh_status" );
		if ( $smpro_debug_mode ) smpro_to_log( $mode . " Cache refresh completed. Time Taken: " . $refresh_time . "seconds. Memory Used: " .$refresh_mem_usage ."MB", "I");
	} else {
		update_option( "socialmetricspro_refresh_status", "PAUSED" );
		wp_cache_delete( "socialmetricspro_refresh_status" );
		wp_schedule_single_event( time() + 600, 'smpro_refresh_cache_single', array( "Standard", $p_type, ( $initial_offset + 1000 ) ) );
		if ( $smpro_debug_mode ) smpro_to_log( $mode . " Cache refresh paused. Resuming in 10 minutes...", "I");
	}
}

function socialmetricspro_refresh_one_post ( $single_post_id ){
	$tzone = get_option('timezone_string');
	if ( !empty( $tzone ) )
		date_default_timezone_set ( $tzone );
	else 
		date_default_timezone_set ( "America/New_York" );
	
	global $wpdb, $optionstate;
	global $smpro_debug_mode;
	$smpro_debug_mode = false;
	if ( "enabled" == get_option('socialmetricspro_enable_logs', 'disabled') ) $smpro_debug_mode = true;
	
	$table_name = $wpdb->prefix . "smpro_cache";
	$refreshstate = ($optionstate == get_option('socialmetricspro_currentstate')) ? 1 : 0;
		
	if ((get_option('socialmetricspro_show_twitter', "true") == "true") && $refreshstate ) $show_tc = '1'; else $show_tc = '0';
	if ((get_option('socialmetricspro_show_facebook', "true") == "true") && $refreshstate ) $show_fc = '1'; else $show_fc = '0';
	if ((get_option('socialmetricspro_show_plusone', "true") == "true") && $refreshstate ) $show_poc = '1'; else $show_poc = '0';
	if ((get_option('socialmetricspro_show_su', "true") == "true") && $refreshstate ) $show_sc = '1'; else $show_sc = '0';
	if ((get_option('socialmetricspro_show_digg', "false") == "true") && $refreshstate ) $show_dc = '1'; else $show_dc = '0';
	if ((get_option('socialmetricspro_show_linkedin', "false") == "true") && $refreshstate ) $show_lc = '1'; else $show_lc = '0';
	if ((get_option('socialmetricspro_show_pinterest', "true") == "true") && $refreshstate ) $show_pinc = '1'; else $show_pinc = '0';

	$querystr = 
	"SELECT wposts.ID,wposts.post_type" .
	" FROM " . $wpdb->prefix . "posts wposts" .
	" WHERE wposts.post_status = 'publish'" .
	" AND wposts.ID = ". $single_post_id;
	
	$post = $wpdb->get_row( $wpdb->prepare( $querystr, array() ), OBJECT, 0);
	
	$post_id = $post->ID;
	$post_url = get_permalink($post_id);
		
	$data['post_id'] = $post_id;
	$data['update_time'] = date('Y-m-d H:i:s');
	$data['post_type'] = $post->post_type;
	$data['post_title'] = get_the_title( $post_id );
	$data['post_url'] = $post_url;
	$data['twitter_tweets'] = ($show_tc == 1) ? smpro_tc_get($post_url) : 0;
	$data['facebook_likes'] = ($show_fc == 1) ? smpro_fc_get($post_url) : 0;
	$data['google_plusones'] = ($show_poc == 1) ? smpro_poc_get($post_url) : 0;
	$data['su_stumbles'] = ($show_sc == 1) ? smpro_sc_get($post_url) : 0;
	$data['digg_diggs'] = ($show_dc == 1) ? smpro_dc_get($post_url) : 0;
	$data['linkedin_shares'] = ($show_lc == 1) ? smpro_lc_get($post_url) : 0;
	$data['pinterest_pins'] = ($show_pinc == 1) ? smpro_pinc_get($post_url) : 0;
	
	$data = socialmetricspro_merge_record($table_name, $data);
	socialmetricspro_insert_update($table_name, $data);
	if ( $smpro_debug_mode ) smpro_to_log( "Single post refreshed. Post: " . $post_id . " ( " . $post_url . " )", "I");
}

function socialmetricspro_merge_record($table, $data) {
	global $wpdb;
	$sql = "SELECT * FROM " . $table . " WHERE post_id = " . $data['post_id'] . "";
	$result = $wpdb->get_row ( $wpdb->prepare ( $sql, array() ) );

	if ( $result == null ) { return $data; }
	else {
		$data['twitter_tweets'] = ( $data['twitter_tweets'] >= $result->twitter_tweets ) ? $data['twitter_tweets'] : $result->twitter_tweets;
		$data['facebook_likes'] = ( $data['facebook_likes'] >= $result->facebook_likes ) ? $data['facebook_likes'] : $result->facebook_likes;
		$data['google_plusones'] = ( $data['google_plusones'] >= $result->google_plusones ) ? $data['google_plusones'] : $result->google_plusones;
		$data['su_stumbles'] = ( $data['su_stumbles'] >= $result->su_stumbles ) ? $data['su_stumbles'] : $result->su_stumbles;
		$data['digg_diggs'] = ( $data['digg_diggs'] >= $result->digg_diggs ) ? $data['digg_diggs'] : $result->digg_diggs;
		$data['linkedin_shares'] = ( $data['linkedin_shares'] >= $result->linkedin_shares ) ? $data['linkedin_shares'] : $result->linkedin_shares;	
		$data['pinterest_pins'] = ( $data['pinterest_pins'] >= $result->pinterest_pins ) ? $data['pinterest_pins'] : $result->pinterest_pins;	
		return $data;
	}
}

function socialmetricspro_insert_update($table, $data) {

	global $wpdb;

	$fields = array_keys($data);
	$formatted_fields = array();
	foreach ( $fields as $field ) {
		$form = '%s';
		$formatted_fields[] = $form;
	}
	$sql = "INSERT INTO `$table` (`" . implode( '`,`', $fields ) . "`) VALUES ('" . implode( "','", $formatted_fields ) . "')";
	$sql .= " ON DUPLICATE KEY UPDATE ";
		
	$dup = array();
	foreach($fields as $field) {
		$dup[] = "`" . $field . "` = VALUES(`" . $field . "`)";
	}
		
	$sql .= implode(',', $dup);
	
	return $wpdb->query( $wpdb->prepare( $sql, $data ) );
}
?>
<?php
function socialmetricspro_init() {
//wp_enqueue_script('jquery');
//wp_enqueue_script('jquery-ui-core');
?>
<?php }
add_action('init', 'socialmetricspro_init');
?>
<?php
function add_socialmetricspro_styles(){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url() . '/social-metrics-pro/style.css'; ?>" />
<?php
}
?>
<?php
function add_socialmetricspro_sharebutton_scripts( $source = "dashboard" ){ 
	global $dsc;
	global $show_tc, $show_fc, $show_poc, $show_sc, $show_dc, $show_lc, $show_pinc;
	
	if ( $dsc == 'plain' && $source == "dashboard" ) {
		$html = '<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
	} elseif ( $dsc == 'plain' && $source != "dashboard" ) {
		$html = "";
	} elseif ( $dsc == 'sharebuttons' && $source == "dashboard" ) {
		$html = "";
		if ($show_tc) $html .= '<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
		
		if ($show_fc) $html .= '<div id="fb-root"></div>' .
								'<script>(function(d, s, id) {' .
								' var js, fjs = d.getElementsByTagName(s)[0];' .
								'  if (d.getElementById(id)) return;' .
								'  js = d.createElement(s); js.id = id;' .
								'  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=123108194373437";' .
								'  fjs.parentNode.insertBefore(js, fjs);' .
								"}(document, 'script', 'facebook-jssdk'));</script>";
		if ($show_poc) $html .= '<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>';
		if ($show_sc) $html .= '<script type="text/javascript">' .
							   '(function() {' .
							   "var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;" .
							   "li.src = 'https://platform.stumbleupon.com/1/widgets.js';" .
							   "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);" .
							   "})();" .
							   "</script>";
		if ($show_dc) $html .= '<script type="text/javascript">' .
								'(function() {' .
								"var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];" .
								"s.type = 'text/javascript';" .
								"s.async = true;" .
								"s.src = 'http://widgets.digg.com/buttons.js';" .
								"s1.parentNode.insertBefore(s, s1);" .
								"})();" .
								"</script>";
		if ($show_lc) $html .= '<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>';
		if ($show_pinc) $html .= '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';
	} elseif ( $dsc == 'sharebuttons' && $source == "widget" ) {
		$html = "";
		$widget_col_count = 0;
		
		if ( $show_tc && $widget_col_count < 3 ) { 
			$html .= '<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
			$widget_col_count ++;
		}
				
		if ( $show_fc && $widget_col_count < 3 ) {
			$html .= '<div id="fb-root"></div>' .
								'<script>(function(d, s, id) {' .
								' var js, fjs = d.getElementsByTagName(s)[0];' .
								'  if (d.getElementById(id)) return;' .
								'  js = d.createElement(s); js.id = id;' .
								'  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=123108194373437";' .
								'  fjs.parentNode.insertBefore(js, fjs);' .
								"}(document, 'script', 'facebook-jssdk'));</script>";
			$widget_col_count ++;
		}
		if ( $show_poc && $widget_col_count < 3 ) { 
			$html .= '<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>';
			$widget_col_count ++;
		}
		if ( $show_sc && $widget_col_count < 3 ) {
			$html .= '<script type="text/javascript">' .
							   '(function() {' .
							   "var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;" .
							   "li.src = 'https://platform.stumbleupon.com/1/widgets.js';" .
							   "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);" .
							   "})();" .
							   "</script>";
			$widget_col_count ++;
		}
		if ( $show_dc && $widget_col_count < 3 ) {
			$html .= '<script type="text/javascript">' .
								'(function() {' .
								"var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];" .
								"s.type = 'text/javascript';" .
								"s.async = true;" .
								"s.src = 'http://widgets.digg.com/buttons.js';" .
								"s1.parentNode.insertBefore(s, s1);" .
								"})();" .
								"</script>";
			$widget_col_count ++;
		}
		if ( $show_lc && $widget_col_count < 3 ) {
			$html .= '<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>';
			$widget_col_count ++;
		}
		if ($show_pinc && $widget_col_count < 3 ) {
			$html .= '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';
			$widget_col_count ++;
		}
	}
	echo $html;
}
?>
<?php
// create custom plugin settings menu
add_action('admin_menu', 'socialmetricspro_create_menu');
function socialmetricspro_create_menu() {
	//create new top-level menu
	add_menu_page( 'Social Metrics Pro', 'Social Metrics Pro', get_option('socialmetricspro_access_role', 'manage_options') , "socialmetricspro_dashboard", "socialmetricspro_dashboard_page", plugins_url() . "/social-metrics-pro/images/sm-pro-logo-20.png",3.2 );
	//create sub-menu
	add_submenu_page('socialmetricspro_dashboard', 'Social Metrics Pro Settings', 'Settings', 'administrator', "socialmetricspro_settings", "socialmetricspro_settings_page" );
	//call register settings function
	add_action( 'admin_init', 'register_socialmetricspro_settings' );
}

function socialmetricspro_adminbar() {
	global $wp_admin_bar;
	if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }
	$href = add_query_arg( 'page', 'socialmetricspro_dashboard', admin_url() );
	$href = wp_nonce_url($href);
	$wp_admin_bar->add_menu( array(
	'id' => 'socialmetricspro_dashboard',
	'title' => __( 'Social Metrics Pro', 'socialmetricspro_dashboard' ),
	'href' => $href ) );
}
add_action( 'admin_bar_menu', 'socialmetricspro_adminbar', 100 );

function register_socialmetricspro_settings() {
	//register the settings
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_show_twitter' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_show_facebook' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_show_plusone' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_show_su' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_show_digg' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_show_linkedin' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_show_pinterest' );
	/* register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_data_refresh_frequncy' ); */
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_conditional_formatting' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_conditional_formatting_ds' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_export' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_xls' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_csv' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_per_page' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_share_counts' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_show_on_dashboard' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_license_email' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_license_key' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_notification_email' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_enable_logs' );
	register_setting( 'socialmetricspro-settings-group', 'socialmetricspro_access_role' );
}
?>
<?php
function socialmetricspro_validate_key(){
	global $socialmetricspro_version;
	
	global $smpro_debug_mode;
	$smpro_debug_mode = false;
	if ( "enabled" == get_option('socialmetricspro_enable_logs', 'disabled') ) $smpro_debug_mode = true;
	
	$le = get_option("socialmetricspro_license_email", "");
	
	if ( !is_email( $le ) ) return "false";
	
	$lk = get_option("socialmetricspro_license_key", "");
	$ld = site_url();
	$lv = "There was an error validating your Social Metrics Pro License. Please try again in a few minutes. Contact our support team if you need help.";
	$license_url = "http://socialmetricspro.com/api/lc.php";
	$la = "18FF74F43DA410C5"; 
	$lz = "529F7D6FCA84F115";
	$lt = get_option("socialmetricspro_ltime" );
	
	/* Request License Info From External URL */
	if(!class_exists("WP_Http"))
		include_once( ABSPATH . WPINC. "/class-http.php" );

	$request = new WP_Http;

	$req = $license_url. "?pid=01&email=".$le."&key=".$lk."&did=". md5( $ld )."&lnk=" . esc_url_raw( $ld ) . "&ver=" . $socialmetricspro_version;
	$result = $request->request( $req );
	
	/* Error - Return error message */
	if( is_wp_error($result) ) {
		$error_string = $result->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("LICENSE_CHECK_ERROR\t" . "WP_Error: " . $error_string );
		return $lv;
	}

	if ( strstr( $result["body"], 'X--' ) ) {
		$license_urlalt = "http://socialmetricspro.com/api/lcalt/01|" . $le ."|".$lk."|". md5( $ld ). "|". esc_url_raw( $ld ) . "|" . $socialmetricspro_version;
		$result = $request->request( $license_urlalt );
		
		if( is_wp_error($result) ) {
			$error_string = $result->get_error_message();
			if ( $smpro_debug_mode ) smpro_to_log("LICENSE_CHECK_ERROR_ALT\t" . "WP_Error: " . $error_string );
			return $lv;
		}
	}

	if ( strstr( $result["body"], $la . $lz ) ) {
		update_option( "socialmetricspro_ltime", date( "Y-m-d H:i:s" ) );
		if ( strstr( $result["body"], "SMS" ) ) update_option( "socialmetricspro_ltype", "SMS" );
		if ( strstr( $result["body"], "SMU" ) ) update_option( "socialmetricspro_ltype", "SMU" );
		return "true";
		}
	else {
		return "false";
		}

	
	return $lv;
}
?>
<?php 
function socialmetricspro_dashboard_page() {
	socialmetricspro_dashboard_page_function();
}

function socialmetricspro_dashboard_page_function() {
	
	$le = get_option("socialmetricspro_license_email", "");
	$lk = get_option("socialmetricspro_license_key", "");
	$lt = get_option("socialmetricspro_ltime" );
	$ld = site_url();
	$lv = "true";
	$ct = intval ( "43200" );
	if( strtotime( date ( "Y-m-d H:i:s" ) ) > ( strtotime( $lt ) + $ct ) ) {
		$lv = socialmetricspro_validate_key();
	}
	
	$logging_error_html = "";
	$logging_error = get_option( "socialmetricspro_logging_error" ); 
	if ( $logging_error == "YES" ) { $logging_error_html = smpro_get_logging_error_html(); } 

	if ( "" == $le || "" == $lk ) {
		$out = "<div class=\"wrap\"><div class=\"smwrap\"><h2 class=\"sm-branding\">Social Metrics Pro Dashboard: ". get_bloginfo('name') . "</h2>"
				."<div id=\"message\" class=\"error\"><span style=\"line-height: 30px;\">Please enter License Information on the <a title=\"Change Settings\" class=\"th-sort-t sm-export\" href=" 
				. wp_nonce_url( admin_url() . "admin.php?page=socialmetricspro_settings" ) . ">Settings Page</a>.</span></div>" . $logging_error_html . "</div></div>";
		echo $out;

	}elseif (!is_email( $le ) ) {
		$out = "<div class=\"wrap\"><div class=\"smwrap\"><h2 class=\"sm-branding\">Social Metrics Pro Dashboard: ". get_bloginfo('name') . "</h2>"
				."<div id=\"message\" class=\"error\"><span style=\"line-height: 30px;\">Please verify your email address entered on the <a title=\"Change Settings\" class=\"th-sort-t sm-export\" href=" 
				. wp_nonce_url( admin_url() . "admin.php?page=socialmetricspro_settings" ) . ">Settings Page</a>.</span></div>" . $logging_error_html . "</div></div>";
		echo $out;
	
	}elseif ( "true" != $lv ) {
		if ( "false" == $lv ) {
			$out = "<div class=\"wrap\"><div class=\"smwrap\"><h2 class=\"sm-branding\">Social Metrics Pro Dashboard: ". get_bloginfo('name') . "</h2>"
					."<div id=\"message\" class=\"error\"><span style=\"line-height: 30px;\">License Information provided is not valid. Please activate your product by entering correct License Information on the <a title=\"Change Settings\" class=\"th-sort-t sm-export\" href="
					. wp_nonce_url( admin_url() . "admin.php?page=socialmetricspro_settings" ) . ">Settings Page</a>. Please contact our support team if you need help.</span></div>" . $logging_error_html . "</div></div>";
			echo $out;
			
		}	else {
			$out = "<div class=\"wrap\"><div class=\"smwrap\"><h2 class=\"sm-branding\">Social Metrics Pro Dashboard: ". get_bloginfo('name') . "</h2>"
					."<div id=\"message\" class=\"error\"><span style=\"line-height: 30px;\">" . $lv ."</span></div>" . $logging_error_html . "</div></div>";
			echo $out;
			}
	}
	else {
		socialmetricspro_dashboard_page_content();
	}

}
?>
<?php
function socialmetricspro_dashboard_page_content() {
?>
<?php $time_start = smpro_microtime_float(); ?>
<div class="wrap">
<div class="smwrap">
<?php
	$s_uri = $_SERVER['REQUEST_URI']; 
	$s_uri = remove_query_arg(array('paged','cat','m','user','smpro_refresh','smpro_refresh_post','sort','order'), $s_uri );
	$s_uri = add_query_arg('page', 'socialmetricspro_dashboard', $s_uri );			
?>
<form  id="posts-filter" action="<?php echo $s_uri; ?>" method="get">
<?php wp_nonce_field(); ?>
<?php
check_admin_referer();
add_socialmetricspro_styles();

if ( !isset($_GET['p_type']) ) { $post_type = 'post'; }
elseif ( in_array( $_GET['p_type'], get_post_types( array('show_ui' => true ) ) ) ) {
	$post_type = $_GET['p_type']; }
else {
	wp_die( __('Invalid post type') ); }

$_GET['p_type'] = $post_type;

$post_type_object = get_post_type_object($post_type);
?>
<?php
	if (isset( $_GET['smpro_refresh_post'] )) {
		$refresh_post_id = $_GET['smpro_refresh_post'];
		socialmetricspro_refresh_one_post ( $refresh_post_id );
	}
?>
<?php
	global $dsc;
	$dsc = get_option('socialmetricspro_share_counts', 'plain');
	$per_page = get_option('socialmetricspro_per_page', 10);
	
	if ( $dsc == 'sharebuttons' && $per_page > 20 ) { $per_page = 20; }
	
	if ( $per_page <= 0 ) { $per_page = 10; }

	$paged = $_GET['paged'];
	$cat = $_GET['cat'];
	$user = $_GET['user'];
	$sort_col = $_GET['sort'];
	$sort_order = $_GET['order'];
	
	$s = $_GET['s'];
	
	if (isset( $_GET['m'] )) {
		$mon = $_GET['m'];
		if (strlen($mon) == 6) {
		$month = substr($mon,4,6);
		$s_year = substr($mon,0,4);
		} else { $month = 0; $s_year = 0; }
	} else { $month = 0; $s_year = 0; }

	$pagenum = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 0;
	if ( empty($pagenum) ){ $pagenum = 1; }
	
	global $wpdb;
	$offset = ( $pagenum - 1 ) * $per_page;
	$countquery = 
	"SELECT COUNT(*)" .
	" FROM " . $wpdb->prefix . "posts wposts" .
		" INNER JOIN " . $wpdb->prefix . "smpro_cache smpcache ON wposts.ID = smpcache.post_id";

	$querystr = 
	"SELECT smpcache.post_id,smpcache.update_time,smpcache.post_type,smpcache.post_url,smpcache.twitter_tweets,smpcache.facebook_likes,smpcache.google_plusones,smpcache.pinterest_pins,smpcache.su_stumbles,smpcache.digg_diggs,smpcache.linkedin_shares, wposts.post_title" .
	" FROM " . $wpdb->prefix . "posts wposts" .
		" INNER JOIN " . $wpdb->prefix . "smpro_cache smpcache ON wposts.ID = smpcache.post_id";
	
	$where = " WHERE wposts.post_type = '" . $post_type . "'" .
			 " AND wposts.post_status = 'publish'";
	
	if ( !empty( $cat ) and 'post' == $post_type ) {
		//$cat = preg_replace( '|[^0-9,-]|', '', $cat ); // comma separated list of positive or negative integers (for future use)
	
		$req_cats = array();
		$catint = intval($cat);
		if ( $catint > 0 ) {
			$req_cats[] = $catint;
			$req_cats = array_merge( $req_cats, get_term_children($catint, 'category') );

			$post_ids_in_cats = get_objects_in_term( $req_cats, 'category' );
			if ( $post_ids_in_cats ) $cat_posts = implode(',', $post_ids_in_cats);
			
			if ( !empty ( $cat_posts) ) $where .= " AND wposts.ID IN (" . $cat_posts . ")";
			else  $where .= " AND wposts.ID = -1";
		}
	}
	
	if ( !empty( $s_year ) ) {
		$where .= " AND YEAR(wposts.post_date)='" . $s_year . "'";
	}
	
	if ( !empty( $month ) ) {
		$where .= " AND MONTH(wposts.post_date)='" . $month . "'";
	}
	
	if ( !empty( $user ) ) {
		$where .= " AND wposts.post_author = " . $user;
	}
	
	if ( !empty( $s )) {
		$s = stripslashes($s);
		
		preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $s, $matches);
		$search_terms = array_map('_search_terms_tidy', $matches[0]);
		
		$n = '%%';
		$searchand = '';
		foreach( (array) $search_terms as $term ) {
				$term = esc_sql( like_escape( $term ) );
				$search .= "{$searchand}((wposts.post_title LIKE '{$n}{$term}{$n}') OR (wposts.post_content LIKE '{$n}{$term}{$n}'))";
				$searchand = ' AND ';
		}
		
		$where .= " AND " . $search;
	}
	
	$countquery .= $where;
	$querystr .= $where;
	
	if ( !empty( $sort_col ) && !empty( $sort_order ) ) {
		switch ( $sort_col ) {
			case 'tc': $sort_string = 'smpcache.twitter_tweets ' . $sort_order; break;
			case 'fc': $sort_string = 'smpcache.facebook_likes ' . $sort_order; break;
			case 'poc': $sort_string = 'smpcache.google_plusones ' . $sort_order; break;
			case 'sc': $sort_string = 'smpcache.su_stumbles ' . $sort_order; break;
			case 'dc': $sort_string = 'smpcache.digg_diggs ' . $sort_order; break;
			case 'lc': $sort_string = 'smpcache.linkedin_shares ' . $sort_order; break;
			case 'pinc': $sort_string = 'smpcache.pinterest_pins ' . $sort_order; break;
			
			case 'date': $sort_string = 'wposts.post_date ' . $sort_order; break;
			default: $sort_string = 'wposts.post_date DESC'; break;
		}
		$querystr .= " ORDER BY " . $sort_string;
	} else {
		$querystr .= " ORDER BY wposts.post_date DESC";
	}
	$querystr .= " LIMIT " . $per_page .
	" OFFSET " . $offset .
	"";

	$max_posts = $wpdb->get_var( $wpdb->prepare( $countquery, array() ));
	$recent_posts = $wpdb->get_results( $wpdb->prepare( $querystr, array() ), OBJECT);
?>
<script>
$(document).ready(function() {
	var shared = {
		position: {
			my: 'bottom center', 
			at: 'top center'
		},
		style: {
			classes: 'ui-tooltip-smblue ui-tooltip-shadow ui-tooltip-rounded'
		}
	};
	
	$( ".smwrap *" ).qtip( $.extend({}, shared, {
	content: {
		attr: 'title'
	}
	}));
});
</script>
	<h2 class="sm-branding">Social Metrics Pro Dashboard: <?php bloginfo('name'); ?>
	
	<?php if ( $s != '' ){
	printf( '<span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>', str_replace('\\','',esc_attr($s)));} ?></h2>
<?php 
	$logging_error = get_option( "socialmetricspro_logging_error" ); 
	$logging_error_html = "";
	if ( $logging_error == "YES" ) { $logging_error_html = smpro_get_logging_error_html(); } 
	echo $logging_error_html; 
?>
<?php
	if (isset( $_GET['smpro_refresh'] )) {
		socialmetricspro_refresh_cache_single();
	}
	?><div class="tablenav">
	<div class="tablenav-pages" style="float: left;"><a href="http://twitter.com/share?url=http://socialmetricspro.com/&text=I am using the Social Metrics Pro plugin to track how's my blog doing across Social Media Networks&via=wpsmpro&related=riyaznet" target="_blank">Like what you see? Tweet about it!</a></div>
	<div class="tablenav-pages">	
	<input name="page" type="hidden" value="socialmetricspro_dashboard">
	<input name="p_type" type="hidden" value="<?php echo $post_type; ?>">
	<input type="text" id="post-search-input" name="s" value="<?php echo str_replace('\\','',esc_attr($s)); ?>"/>
	<input type="submit" value="Search" class="button"/> 
	</div>
	</div>
	<div class="tablenav">
<?php
		$num_pages = ceil (intval($max_posts) / $per_page );
?>
<?php
		$page_links = paginate_links( array(
			'base' => add_query_arg( 'paged', '%#%' ),
			'format' => '',
			'prev_text' => __('&laquo;'),
			'next_text' => __('&raquo;'),
			'total' => $num_pages,
			'current' => $pagenum
		));
?>
		<div class="tablenav-pages" style="float: left;">

<?php 
$s_uri = $_SERVER['REQUEST_URI'];
$s_uri = remove_query_arg(array('paged','p_type','cat','m','user','s','sort','order','smpro_refresh','smpro_refresh_post'), $s_uri );
$s_uri = wp_nonce_url($s_uri);
?>
<a href="<?php echo esc_url(add_query_arg('p_type', $post_type, $s_uri )) ?>">Remove Filters</a>
<?php
$s_uri = $_SERVER['REQUEST_URI']; 
$s_uri = remove_query_arg(array('paged','p_type','cat','m','user','s','sort','order','smpro_refresh','smpro_refresh_post'), $s_uri );
$s_uri = wp_nonce_url($s_uri);	

$post_types = get_post_types( array('show_ui' => true ) );


$p_type = isset($_GET['p_type']) ? $_GET['p_type'] : 'post';
?>
<select name='p_type' id='p_type'>
<?php
foreach ($post_types as $c_post_type ) {

$p_type_object = get_post_type_object($c_post_type);

if ( $c_post_type == $p_type ) {
	$default = ' selected="selected"'; 
	$current_p_type_label = $p_type_object->label;
	}
else {
	$default = ''; 
	}

echo "<option$default value='" . $c_post_type ."'>";
echo "Show " . $p_type_object->label;
echo "</option>\n";
}
?>
</select>
<script type="text/javascript"><!--
	var dropdown_p_type = document.getElementById("p_type");
	function onPostTypeChange() {
		location.href = "<?php echo html_entity_decode($s_uri); ?>&p_type="+dropdown_p_type.options[dropdown_p_type.selectedIndex].value;
	}
	dropdown_p_type.onchange = onPostTypeChange;
--></script>
<?php 
			$s_uri = $_SERVER['REQUEST_URI']; 
			$s_uri = remove_query_arg(array('paged','p_type','cat','s','_wpnonce','smpro_refresh','smpro_refresh_post'), $s_uri );
			$s_uri = add_query_arg('page', 'socialmetricspro_dashboard', $s_uri );
			$s_uri = wp_nonce_url($s_uri);

			if ( is_object_in_taxonomy($post_type, 'category') && ( 'post' == $post_type ) ) {
				$dropdown_options = array('show_option_none' => __('Filter by category'), 'hide_empty' => 0, 'hierarchical' => 1,'show_count' => 0, 'orderby' => 'name', 'selected' => $cat);
				wp_dropdown_categories($dropdown_options); ?>
				<script type="text/javascript"><!--
				var dropdown = document.getElementById("cat");
				function onCatChange() {
					if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
				location.href = "<?php echo html_entity_decode($s_uri); ?>&cat="+dropdown.options[dropdown.selectedIndex].value;
					}
				}
				dropdown.onchange = onCatChange;
				--></script>
<?php		} ?>
<?php 
			global $wpdb;
			global $wp_locale;

			if ( !is_singular() ) {
				$s_uri = $_SERVER['REQUEST_URI']; 
				$s_uri = remove_query_arg(array('paged','m','s','_wpnonce','smpro_refresh','smpro_refresh_post'), $s_uri );
				$s_uri = add_query_arg('page', 'socialmetricspro_dashboard', $s_uri );
				$s_uri = wp_nonce_url($s_uri);

				$arc_query = $wpdb->prepare( "SELECT DISTINCT YEAR(post_date) AS yyear, MONTH(post_date) AS mmonth FROM $wpdb->posts WHERE post_type = %s ORDER BY post_date DESC", $post_type );
				$arc_result = $wpdb->get_results( $arc_query );
				$month_count = count($arc_result);

				if ( $month_count && !( 1 == $month_count && 0 == $arc_result[0]->mmonth ) ) {
					$m = isset($_GET['m']) ? (int)$_GET['m'] : 0;
?>
					<select name='m' id='m'>
						<option<?php selected( $m, 0 ); ?> value='0'><?php _e('Filter by date'); ?></option>
<?php
						foreach ($arc_result as $arc_row) {
							if ( $arc_row->yyear == 0 ) { continue; }
							$arc_row->mmonth = zeroise( $arc_row->mmonth, 2 );

							if ( $arc_row->yyear . $arc_row->mmonth == $m ) {
								$default = ' selected="selected"'; }
							else {
								$default = ''; }

							echo "<option$default value='" . esc_attr("$arc_row->yyear$arc_row->mmonth") . "'>";
							echo $wp_locale->get_month($arc_row->mmonth) . " $arc_row->yyear";
							echo "</option>\n";
						}
?>					</select>
					<script type="text/javascript"><!--
					var dropdown_m = document.getElementById("m");
					function onMonthChange() {
						if ( dropdown_m.options[dropdown_m.selectedIndex].value > 0 ) {
				location.href = "<?php echo html_entity_decode($s_uri); ?>&m="+dropdown_m.options[dropdown_m.selectedIndex].value;
						}
					}
					dropdown_m.onchange = onMonthChange;
					--></script>
<?php 			} ?>
<?php 		} ?>
<?php 			
			$s_uri = $_SERVER['REQUEST_URI']; 
			$s_uri = remove_query_arg(array('paged','s','_wpnonce','smpro_refresh','smpro_refresh_post'), $s_uri );
			$s_uri = add_query_arg('page', 'socialmetricspro_dashboard', $s_uri );
			$s_uri = wp_nonce_url($s_uri);
			wp_dropdown_users( array( 'show_option_all' => 'Filter by author', 'selected' => $user, 'who' => 'authors' ) ); ?>
			<script type="text/javascript"><!--
			var dropdown_u = document.getElementById("user");
			function onUserChange() {
				if ( dropdown_u.options[dropdown_u.selectedIndex].value > 0 ) {
			location.href = "<?php echo html_entity_decode($s_uri); ?>&user="+dropdown_u.options[dropdown_u.selectedIndex].value;
				}
			}
			dropdown_u.onchange = onUserChange;
			--></script>
<?php if (get_option('socialmetricspro_export', 'enabled') == "enabled") {
			$s_uri = plugins_url() .'/social-metrics-pro/lib/export.php?p_type='.$post_type;
			if($cat != '') $s_uri .= '&cat='.$cat;
			if($m != '') $s_uri .= '&m='.$mon;
			if($user != '') $s_uri .= '&user='.$user;
			if($s != '') $s_uri .= '&s='.$s;
			if($sort_col != '') $s_uri .= '&sort='.$sort_col;
			if($sort_order != '') $s_uri .= '&order='.$sort_order;
?>
<?php if (get_option('socialmetricspro_xls', true) == "true") { ?>
			<a title="Export to Excel (tab-separated format)" class="sm-export" href="<?php echo wp_nonce_url($s_uri.'&ft=xls', 'smpro-exp-nonce-action'); ?>" onclick="window.open('<?php echo wp_nonce_url($s_uri.'&ft=xls', 'smpro-exp-nonce-action'); ?>','popup','width=500,height=275,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false"><img src="<?php echo plugins_url() . '/social-metrics-pro/images/xls.png';?>"></a>
<?php } ?>
<?php if (get_option('socialmetricspro_csv', true) == "true") { ?>
			<a title="Export to Excel (comma separated format)" class="sm-export" href="<?php echo wp_nonce_url($s_uri.'&ft=csv', 'smpro-exp-nonce-action'); ?>" onclick="window.open('<?php echo wp_nonce_url($s_uri.'&ft=csv', 'smpro-exp-nonce-action'); ?>','popup','width=500,height=275,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false"><img src="<?php echo plugins_url() . '/social-metrics-pro/images/csv.png';?>"></a>
<?php } ?>
<?php } ?>
			<a title="Change Settings" class="th-sort-t sm-export" href="<?php echo wp_nonce_url( admin_url() . 'admin.php?page=socialmetricspro_settings') ;?>"><img src="<?php echo plugins_url() . '/social-metrics-pro/images/options.png';?>"></a>
			<a title="Refresh Data for Recent 20 <?php echo $current_p_type_label; ?>" class="th-sort-t sm-export" href="<?php echo wp_nonce_url( admin_url() . 'admin.php?page=socialmetricspro_dashboard&smpro_refresh=1&p_type=' . $post_type );?>"><img src="<?php echo plugins_url() . '/social-metrics-pro/images/refresh.png';?>"></a>
		</div>
		<div class="tablenav-pages">
<?php 		if ( $page_links ) { ?>
<?php
				$count_posts = $max_posts;
				
				$page_links_text = sprintf( '<span class="displaying-num">' . __( '%s %s&#8211;%s of %s' ) . '</span>%s',
									$current_ptype,
									number_format_i18n( ( $pagenum - 1 ) * $per_page + 1 ),
									number_format_i18n( min( $pagenum * $per_page, $count_posts ) ),
									number_format_i18n( $count_posts ),
									$page_links
									);
				echo $page_links_text;
			}
?>
		</div>
	</div>	
	<div class="clear"></div>
<?php
	global $show_tc, $show_fc, $show_poc, $show_sc, $show_dc, $show_lc, $show_pinc;
	
	if (get_option('socialmetricspro_show_twitter') == "true") $show_tc = true; else $show_tc = false;
	if (get_option('socialmetricspro_show_facebook') == "true") $show_fc = true; else $show_fc = false;
	if (get_option('socialmetricspro_show_plusone') == "true") $show_poc = true; else $show_poc = false;
	if (get_option('socialmetricspro_show_pinterest') == "true") $show_pinc = true; else $show_pinc = false;
	if (get_option('socialmetricspro_show_su') == "true") $show_sc = true; else $show_sc = false;
	if (get_option('socialmetricspro_show_digg') == "true") $show_dc = true; else $show_dc = false;
	if (get_option('socialmetricspro_show_linkedin') == "true") $show_lc = true; else $show_lc = false;
?>
<?php
	$min_tw = $min_fb = $min_po = $min_pin = $min_su = $min_dg = $min_li = $min = 0;
	$max_tw = $max_fb = $max_po = $max_pin = $max_su = $max_dg = $max_li = $max = 0;
	$cfds = get_option( 'socialmetricspro_conditional_formatting_ds', 'sitewide' );
	
	if ( $cfds == "sitewide" ) {
		if ($show_tc) {
			$min_tw = $wpdb->get_var( $wpdb->prepare( "SELECT MIN(twitter_tweets) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max_tw = $wpdb->get_var( $wpdb->prepare( "SELECT MAX(twitter_tweets) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max = max($max, $max_tw);
		} 
		if ($show_fc) {
			$min_fb = $wpdb->get_var( $wpdb->prepare( "SELECT MIN(facebook_likes) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max_fb = $wpdb->get_var( $wpdb->prepare( "SELECT MAX(facebook_likes) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max = max($max, $max_fb);
		} 
		if ($show_poc) {
			$min_po = $wpdb->get_var( $wpdb->prepare( "SELECT MIN(google_plusones) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max_po = $wpdb->get_var( $wpdb->prepare( "SELECT MAX(google_plusones) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max = max($max, $max_po);
		} 
		if ($show_pinc) {
			$min_pin = $wpdb->get_var( $wpdb->prepare( "SELECT MIN(pinterest_pins) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max_pin = $wpdb->get_var( $wpdb->prepare( "SELECT MAX(pinterest_pins) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max = max($max, $max_pin);
		} 
		if ($show_sc) {
			$min_su = $wpdb->get_var( $wpdb->prepare( "SELECT MIN(su_stumbles) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max_su = $wpdb->get_var( $wpdb->prepare( "SELECT MAX(su_stumbles) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max = max($max, $max_su);
		} 
		if ($show_dc) {
			$min_dg = $wpdb->get_var( $wpdb->prepare( "SELECT MIN(digg_diggs) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max_dg = $wpdb->get_var( $wpdb->prepare( "SELECT MAX(digg_diggs) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max = max($max, $max_dg);
		} 
		if ($show_lc) {
			$min_li = $wpdb->get_var( $wpdb->prepare( "SELECT MIN(linkedin_shares) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max_li = $wpdb->get_var( $wpdb->prepare( "SELECT MAX(linkedin_shares) FROM " . $wpdb->prefix . "smpro_cache WHERE post_type = '" . $post_type ."'", array() ));
			$max = max($max, $max_li);
		}
	}
?>
<?php 
	$i=0; $j=0; 
	$sm = array();

	foreach ($recent_posts as $post) {

		$sm[$i][0] = $post->post_title;
		$sm[$i][1] = $post->post_url;
		$sm[$i][9] = $post->post_id;
		
		if ( $cfds == "displayed" ) {
			if ($show_tc) {
				$min_tw = min($min_tw, $post->twitter_tweets);
				$max_tw = max($max_tw, $post->twitter_tweets);
				$max = max($max, $max_tw);
			} 
			if ($show_fc) {
				$min_fb = min($min_fb, $post->facebook_likes);
				$max_fb = max($max_fb, $post->facebook_likes);
				$max = max($max, $max_fb);
			} 
			if ($show_poc) {
				$min_po = min($min_po, $post->google_plusones);
				$max_po = max($max_po, $post->google_plusones);
				$max = max($max, $max_po);
			} 
			if ($show_pinc) {
				$min_pin = min($min_pin, $post->pinterest_pins);
				$max_pin = max($max_pin, $post->pinterest_pins);
				$max = max($max, $max_pin);
			} 
			if ($show_sc) {
				$min_su = min($min_su, $post->su_stumbles);
				$max_su = max($max_su, $post->su_stumbles);
				$max = max($max, $max_su);
			} 
			if ($show_dc) {
				$min_dg = min($min_dg, $post->digg_diggs);
				$max_dg = max($max_dg, $post->digg_diggs);
				$max = max($max, $max_dg);
			} 
			if ($show_lc) {
				$min_li = min($min_li, $post->linkedin_shares);
				$max_li = max($max_li, $post->linkedin_shares);
				$max = max($max, $max_li);
			}
		}
		
		if ( $show_tc ) $sm[$i][2] = ( $dsc == "sharebuttons" ) ? smpro_tb_get( $post->post_url, $post->post_title ) : $post->twitter_tweets;
		if ( $show_fc ) $sm[$i][3] = ( $dsc == "sharebuttons" ) ? smpro_fb_get( $post->post_url ) : $post->facebook_likes;
		if ( $show_poc ) $sm[$i][4] = ( $dsc == "sharebuttons" ) ? smpro_pob_get( $post->post_url ) : $post->google_plusones;
		if ( $show_sc ) $sm[$i][5] = ( $dsc == "sharebuttons" ) ? smpro_sb_get( $post->post_url ) : $post->su_stumbles;
		if ( $show_dc ) $sm[$i][6] = ( $dsc == "sharebuttons" ) ? smpro_db_get( $post->post_url, $post->post_title ) : $post->digg_diggs;
		if ( $show_lc ) $sm[$i][7] = ( $dsc == "sharebuttons" ) ? smpro_lb_get( $post->post_url ) : $post->linkedin_shares;
		if ( $show_pinc ) $sm[$i][8] = ( $dsc == "sharebuttons" ) ? smpro_pinb_get( $post->post_url, $post->post_id, $post->post_title ) : $post->pinterest_pins;
		$i++;
	}

	if (get_option('socialmetricspro_conditional_formatting', 'bycolumns') == "bytable") {
		$min_tw = $min_fb = $min_po = $min_pin = $min_su = $min_dg = $min_li = $min;
		$max_tw = $max_fb = $max_po = $max_pin = $max_su = $max_dg = $max_li = $max;
	}
?>
<table class="widefat post fixed smtable" cellspacing="0">
<thead> 
<tr>
<?php
$s_uri = $_SERVER['REQUEST_URI'];
$s_uri = remove_query_arg( 'smpro_refresh', $s_uri );
$s_uri = remove_query_arg( 'smpro_refresh_post', $s_uri );
$s_uri = remove_query_arg( 'sort', $s_uri );
$s_uri = remove_query_arg( 'order', $s_uri );
$s_uri = add_query_arg('sort', 'date', $s_uri );
$sort_order = strtoupper($sort_order);
if ($sort_col == 'date' && $sort_order == 'DESC' ) $s_uri = add_query_arg('order', 'ASC', $s_uri );
else $s_uri = add_query_arg('order', 'DESC', $s_uri );
$s_uri = wp_nonce_url($s_uri);
?>
<th scope="col" id="title0" title="Sort by posting date" class="<?php if ($sort_col == 'date' && $sort_order == 'DESC' ) echo "sort-desc "; elseif ($sort_col == 'date' && $sort_order == 'ASC' ) echo "sort-asc "; ?>th-sort-t manage-column column-title" ><a href="<?php echo esc_url($s_uri); ?>">Title</a></th>
<?php if ( $show_tc ){ ?>
<?php
$s_uri = $_SERVER['REQUEST_URI'];
$s_uri = remove_query_arg( 'smpro_refresh', $s_uri );
$s_uri = remove_query_arg( 'smpro_refresh_post', $s_uri );
$s_uri = remove_query_arg( 'sort', $s_uri );
$s_uri = remove_query_arg( 'order', $s_uri );
$s_uri = add_query_arg('sort', 'tc', $s_uri );
$sort_order = strtoupper($sort_order);
if ($sort_col == 'tc' && $sort_order == 'DESC' ) $s_uri = add_query_arg('order', 'ASC', $s_uri );
else $s_uri = add_query_arg('order', 'DESC', $s_uri );
$s_uri = wp_nonce_url($s_uri);
?>
<th scope="col" id="title1" class="<?php if ($sort_col == 'tc' && $sort_order == 'DESC' ) echo "sort-desc "; elseif ($sort_col == 'tc' && $sort_order == 'ASC' ) echo "sort-asc "; ?>manage-column column-title" title="Click to Sort"><a href="<?php echo esc_url($s_uri); ?>">Twitter</a></th>
<?php } ?>
<?php if ( $show_fc ){ ?>
<?php
$s_uri = $_SERVER['REQUEST_URI'];
$s_uri = remove_query_arg( 'smpro_refresh', $s_uri );
$s_uri = remove_query_arg( 'smpro_refresh_post', $s_uri );
$s_uri = remove_query_arg( 'sort', $s_uri );
$s_uri = remove_query_arg( 'order', $s_uri );
$s_uri = add_query_arg('sort', 'fc', $s_uri );
$sort_order = strtoupper($sort_order);
if ($sort_col == 'fc' && $sort_order == 'DESC' ) $s_uri = add_query_arg('order', 'ASC', $s_uri );
else $s_uri = add_query_arg('order', 'DESC', $s_uri );
$s_uri = wp_nonce_url($s_uri);
?>
<th scope="col" id="title2" class="<?php if ($sort_col == 'fc' && $sort_order == 'DESC' ) echo "sort-desc "; elseif ($sort_col == 'fc' && $sort_order == 'ASC' ) echo "sort-asc "; ?>manage-column column-title" title="Click to Sort"><a href="<?php echo esc_url($s_uri); ?>">Facebook</a></th>
<?php } ?>
<?php if ( $show_poc ){ ?>
<?php
$s_uri = $_SERVER['REQUEST_URI'];
$s_uri = remove_query_arg( 'smpro_refresh', $s_uri );
$s_uri = remove_query_arg( 'smpro_refresh_post', $s_uri );
$s_uri = remove_query_arg( 'sort', $s_uri );
$s_uri = remove_query_arg( 'order', $s_uri );
$s_uri = add_query_arg('sort', 'poc', $s_uri );
$sort_order = strtoupper($sort_order);
if ($sort_col == 'poc' && $sort_order == 'DESC' ) $s_uri = add_query_arg('order', 'ASC', $s_uri );
else $s_uri = add_query_arg('order', 'DESC', $s_uri );
$s_uri = wp_nonce_url($s_uri);
?>
<th scope="col" id="title3" class="<?php if ($sort_col == 'poc' && $sort_order == 'DESC' ) echo "sort-desc "; elseif ($sort_col == 'poc' && $sort_order == 'ASC' ) echo "sort-asc "; ?>manage-column column-title" title="Click to Sort"><a href="<?php echo esc_url($s_uri); ?>">Google +1</a></th>
<?php } ?>
<?php if ( $show_pinc ){ ?>
<?php
$s_uri = $_SERVER['REQUEST_URI'];
$s_uri = remove_query_arg( 'smpro_refresh', $s_uri );
$s_uri = remove_query_arg( 'smpro_refresh_post', $s_uri );
$s_uri = remove_query_arg( 'sort', $s_uri );
$s_uri = remove_query_arg( 'order', $s_uri );
$s_uri = add_query_arg('sort', 'pinc', $s_uri );
$sort_order = strtoupper($sort_order);
if ($sort_col == 'pinc' && $sort_order == 'DESC' ) $s_uri = add_query_arg('order', 'ASC', $s_uri );
else $s_uri = add_query_arg('order', 'DESC', $s_uri );
$s_uri = wp_nonce_url($s_uri);
?>
<th scope="col" id="title3_1" class="<?php if ($sort_col == 'pinc' && $sort_order == 'DESC' ) echo "sort-desc "; elseif ($sort_col == 'pinc' && $sort_order == 'ASC' ) echo "sort-asc "; ?>manage-column column-title" title="Click to Sort"><a href="<?php echo esc_url($s_uri); ?>">Pinterest</a></th>
<?php } ?>
<?php if ( $show_sc ){ ?>
<?php
$s_uri = $_SERVER['REQUEST_URI'];
$s_uri = remove_query_arg( 'smpro_refresh', $s_uri );
$s_uri = remove_query_arg( 'smpro_refresh_post', $s_uri );
$s_uri = remove_query_arg( 'sort', $s_uri );
$s_uri = remove_query_arg( 'order', $s_uri );
$s_uri = add_query_arg('sort', 'sc', $s_uri );
$sort_order = strtoupper($sort_order);
if ($sort_col == 'sc' && $sort_order == 'DESC' ) $s_uri = add_query_arg('order', 'ASC', $s_uri );
else $s_uri = add_query_arg('order', 'DESC', $s_uri );
$s_uri = wp_nonce_url($s_uri);
?>
<th scope="col" id="title5" class="<?php if ($sort_col == 'sc' && $sort_order == 'DESC' ) echo "sort-desc "; elseif ($sort_col == 'sc' && $sort_order == 'ASC' ) echo "sort-asc "; ?>manage-column column-title" title="Click to Sort"><a href="<?php echo esc_url($s_uri); ?>">StumbleUpon</a></th>
<?php } ?>
<?php if ( $show_dc ){ ?>
<?php
$s_uri = $_SERVER['REQUEST_URI'];
$s_uri = remove_query_arg( 'smpro_refresh', $s_uri );
$s_uri = remove_query_arg( 'smpro_refresh_post', $s_uri );
$s_uri = remove_query_arg( 'sort', $s_uri );
$s_uri = remove_query_arg( 'order', $s_uri );
$s_uri = add_query_arg('sort', 'dc', $s_uri );
$sort_order = strtoupper($sort_order);
if ($sort_col == 'dc' && $sort_order == 'DESC' ) $s_uri = add_query_arg('order', 'ASC', $s_uri );
else $s_uri = add_query_arg('order', 'DESC', $s_uri );
$s_uri = wp_nonce_url($s_uri);
?>
<th scope="col" id="title6" class="<?php if ($sort_col == 'dc' && $sort_order == 'DESC' ) echo "sort-desc "; elseif ($sort_col == 'dc' && $sort_order == 'ASC' ) echo "sort-asc "; ?>manage-column column-title" title="Click to Sort"><a href="<?php echo esc_url($s_uri); ?>">Digg</a></th>
<?php } ?>
<?php if ( $show_lc ){ ?>
<?php
$s_uri = $_SERVER['REQUEST_URI'];
$s_uri = remove_query_arg( 'smpro_refresh', $s_uri );
$s_uri = remove_query_arg( 'smpro_refresh_post', $s_uri );
$s_uri = remove_query_arg( 'sort', $s_uri );
$s_uri = remove_query_arg( 'order', $s_uri );
$s_uri = add_query_arg('sort', 'lc', $s_uri );
$sort_order = strtoupper($sort_order);
if ($sort_col == 'lc' && $sort_order == 'DESC' ) $s_uri = add_query_arg('order', 'ASC', $s_uri );
else $s_uri = add_query_arg('order', 'DESC', $s_uri );
$s_uri = wp_nonce_url($s_uri);
?>
<th scope="col" id="title7" class="<?php if ($sort_col == 'lc' && $sort_order == 'DESC' ) echo "sort-desc "; elseif ($sort_col == 'lc' && $sort_order == 'ASC' ) echo "sort-asc "; ?>manage-column column-title" title="Click to Sort"><a href="<?php echo esc_url($s_uri); ?>">LinkedIn</a></th>
<?php } ?>
</tr></thead><tbody>
<?php for ($k = 0; $k < count($sm); $k++) { ?>
<tr>
<?php
$s_uri = $_SERVER['REQUEST_URI'];
$s_uri = remove_query_arg( 'smpro_refresh', $s_uri );
$s_uri = remove_query_arg( 'smpro_refresh_post', $s_uri );
$s_uri = add_query_arg('smpro_refresh_post', $sm[$k][9], $s_uri );
$s_uri = wp_nonce_url($s_uri);
?>
<td><div class="post-title"><a target="_blank" href="<?php echo $sm[$k][1]; ?>" rel="bookmark"><?php echo $sm[$k][0]; ?></a></div><div class="post-refresh"><a title="Refresh Data for this <?php echo $p_type; ?>" href="<?php echo esc_url($s_uri); ?>"><img src="<?php echo plugins_url() . '/social-metrics-pro/images/refresh-sm.png';?>"></a></div></td>
<?php if ( $show_tc ){ ?><td style="background:<?php echo sm_get_rank($sm[$k][2], $min_tw, $max_tw); ?>;"><?php echo $sm[$k][2]; ?></td><?php } ?>
<?php if ( $show_fc ){ ?><td style="overflow:visible; background:<?php echo sm_get_rank($sm[$k][3], $min_fb, $max_fb); ?>;"><?php echo $sm[$k][3]; ?></td><?php } ?>
<?php if ( $show_poc ){ ?><td style="overflow:visible; background:<?php echo sm_get_rank($sm[$k][4], $min_po, $max_po); ?>;"><?php echo $sm[$k][4]; ?></td><?php } ?>
<?php if ( $show_pinc ){ ?><td style="background:<?php echo sm_get_rank($sm[$k][8], $min_pin, $max_pin); ?>;"><?php echo $sm[$k][8]; ?></td><?php } ?>
<?php if ( $show_sc ){ ?><td style="background:<?php echo sm_get_rank($sm[$k][5], $min_su, $max_su); ?>;"><?php echo $sm[$k][5]; ?></td><?php } ?>
<?php if ( $show_dc ){ ?><td style="background:<?php echo sm_get_rank($sm[$k][6], $min_dg, $max_dg); ?>;"><?php echo $sm[$k][6]; ?></td><?php } ?>
<?php if ( $show_lc ){ ?><td style="background:<?php echo sm_get_rank($sm[$k][7], $min_li, $max_li); ?>;"><?php echo $sm[$k][7]; ?></td><?php } ?>	
</tr>
<?php } ?>
</tbody><tfoot>
<tr> 
<th scope="col"  class="manage-column column-title">Title</th>
<?php if ( $show_tc ){ ?><th scope="col"  class="manage-column column-title">Twitter</th><?php } ?>
<?php if ( $show_fc ){ ?><th scope="col"  class="manage-column column-title">Facebook</th><?php } ?>
<?php if ( $show_poc ){ ?><th scope="col"  class="manage-column column-title">Google +1</th><?php }  ?>
<?php if ( $show_pinc ){ ?><th scope="col"  class="manage-column column-title">Pinterest</th><?php }  ?>
<?php if ( $show_sc ){ ?><th scope="col"  class="manage-column column-title">StumbleUpon</th><?php } ?>
<?php if ( $show_dc ){ ?><th scope="col"  class="manage-column column-title">Digg</th><?php } ?>
<?php if ( $show_lc ){ ?><th scope="col"  class="manage-column column-title">LinkedIn</th><?php } ?>				
</tr></tfoot></table>
<div class="tablenav">
	<div class="tablenav-pages" style="float:left;">
<?php 	if ( $page_links ) { 
			$count_posts = $max_posts;
			$page_links_text = sprintf( '<span class="displaying-num">' . __( '%s %s&#8211;%s of %s' ) . '</span>%s',
								$current_ptype,
								number_format_i18n( ( $pagenum - 1 ) * $per_page + 1 ),
								number_format_i18n( min( $pagenum * $per_page, $count_posts ) ),
								number_format_i18n( $count_posts ),
								$page_links
								);
			echo $page_links_text;
		} ?>
	</div>
<?php
	add_socialmetricspro_sharebutton_scripts();
	$time_end = smpro_microtime_float();
	$timediff = $time_end - $time_start;
	if(function_exists("memory_get_peak_usage")) { $mem_usage = memory_get_peak_usage(true); }
	else if(function_exists("memory_get_usage")) { $mem_usage = memory_get_usage(true); }

	if (!empty ($mem_usage)) $mem_usage = $mem_usage / 1024 / 1024;
?>
<div class="tablenav-pages-right" style="float:right;padding-top: 5px;">Report generated in <strong><?php echo number_format ( $timediff, 5 ); ?> seconds</strong><?php if (!empty($mem_usage)) { echo " using " . $mem_usage . " MB of memory"; } ?>. Thank you for choosing <a href="http://socialmetricspro.com/" target="_blank">Social Metrics Pro</a>!</div>
</div>
</form>

</div>
</div>
<?php } ?>
<?php 
function smpro_tb_get( $url, $title ) {
	$html = '<a href="http://twitter.com/share" class="twitter-share-button" data-text="' . $title . '" data-count="horizontal" data-url="' . $url . '">Tweet</a>';
	return $html;
}

function smpro_fb_get( $url ) {
	$html = '<div class="fb-like" data-href="' . $url . '" data-send="true" data-layout="button_count" data-width="100" data-show-faces="false"></div>';
	return $html;
}

function smpro_pob_get( $url ) {
	$html = '<g:plusone size="medium" href="' . $url . '"></g:plusone>';
	return $html;
}

function smpro_sb_get( $url ) {
	$html = '<su:badge layout="1" location="' . $url . '"></su:badge>';
	return $html;
}

function smpro_db_get( $url, $title ) {
	$html = '<a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url=' . $url . '&amp;title=' . $title . '"></a>';
	return $html;
}

function smpro_lb_get( $url ) {
	$html = '<script type="in/share" data-url="' . $url . '" data-counter="right"></script>';
	return $html;
}

function smpro_pinb_get( $url, $id, $title ) {
	$image_url = "";
	$full_image_url = smpro_get_images( $id );
	if ($full_image_url) { $image_url =  $full_image_url[0][0]; }
	
	if ( function_exists( 'has_post_thumbnail' ) ) {
		if ( has_post_thumbnail( $id ) ) {
			$full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full');
			$image_url =  $full_image_url[0];
		}
	}

	$html = '<a href="http://pinterest.com/pin/create/button/?url='. urlencode( $url ) .
			'&media=' . urlencode($image_url) . 
			'&description=' . $title . '" class="pin-it-button" count-layout="horizontal">' .
			'<img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
	return $html;
}

?>
<?php
function smpro_get_images($post_id, $size = 'full') {

	$images = get_children( array('post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
	$results = array();

	if ($images) {
		foreach ($images as $image) {
			$results[] = wp_get_attachment_image_src($image->ID, $size);
		}
	}
	return $results;
}
?>
<?php function smpro_tc_get($url) {
	global $smpro_debug_mode;
	$count = 0;
	$data = wp_remote_get('ht'.'tp://urls.api.twitter.com/1/urls/count.json?url='.urlencode($url) );
	if (!is_wp_error($data) ) {
		if ( $data['response']['code'] == 200 ) {
			$resp = json_decode($data['body'],true);
			if ($resp['count']) $count = $resp['count'];
		} elseif ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_TC\t" . "NO_WP_ERROR" . "\t" . $url ."\tHTTP_RESP: " . $data['response']['code'] ." / " . $data['response']['message']);
	} else {
		$error_string = $data->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_TC\t" . "WP_Error: " . $error_string . "\t" . $url );
	}
	return $count;
}
?>
<?php function smpro_fc_get($url) {
	global $smpro_debug_mode;
	$count = 0;
	/* $data = wp_remote_get('ht'.'tp://graph.facebook.com/'.urlencode($url) );
	if (!is_wp_error($data) ) {
		if ( $data['response']['code'] == 200 ) {
			$resp = json_decode($data['body'],true);
			if ($resp['shares']) $count = $resp['shares'];
		} elseif ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_FC\t" . "NO_WP_ERROR" . "\t" . $url ."\tHTTP_RESP: " . $data['response']['code'] ." / " . $data['response']['message'] ."\tHTTP_BODY: ". serialize( $data['body'] ) );
	} else {
		$error_string = $data->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_FC\t" . "WP_Error: " . $error_string . "\t" . $url );
	} */
	
	$fql = 'ht'.'tps://graph.facebook.com/fql?q='. urlencode( 'SELECT total_count FROM link_stat WHERE url="' . $url . '"' );
	$data = wp_remote_get( $fql );
	
	if (!is_wp_error($data) ) {
		if ( $data['response']['code'] == 200 ) {
			$resp = json_decode($data['body'],true);
			if ($resp['data'][0]['total_count']) $count = $resp['data'][0]['total_count'];
			else $count = smpro_fc_get_alternate($url);
		} elseif ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_FC\t" . "NO_WP_ERROR" . "\t" . $url ."\tHTTP_RESP: " . $data['response']['code'] ." / " . $data['response']['message'] ."\tHTTP_BODY: ". serialize( $data['body'] ) );
	} else {
		$error_string = $data->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_FC\t" . "WP_Error: " . $error_string . "\t" . $url );
	}
	return $count;
}

function smpro_fc_get_alternate($url) {
	global $smpro_debug_mode;
	$count = 0;
	$data = wp_remote_get('ht'.'tp://graph.facebook.com/'.urlencode($url) );
	if (!is_wp_error($data) ) {
		if ( $data['response']['code'] == 200 ) {
			$resp = json_decode($data['body'],true);
			if ($resp['shares']) $count = $resp['shares'];
		} elseif ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_FC_ALT\t" . "NO_WP_ERROR" . "\t" . $url ."\tHTTP_RESP: " . $data['response']['code'] ." / " . $data['response']['message'] ."\tHTTP_BODY: ". serialize( $data['body'] ) );
	} else {
		$error_string = $data->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_FC_ALT\t" . "WP_Error: " . $error_string . "\t" . $url );
	}
	return $count;
}
?>
<?php function smpro_poc_get($url) {
	global $smpro_debug_mode;

	$count = 0;
	$data = wp_remote_post( 'ht'.'tps://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ', array( 'method' => 'POST', 'headers' => array('content-type' => 'application/json'), 'body' => '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]' ) );
	if (!is_wp_error($data) ) { 
		if ( $data['response']['code'] == 200 ) {
			$resp = json_decode($data['body'], true);
			if ($resp[0]['result']['metadata']['globalCounts']['count']) $count = $resp[0]['result']['metadata']['globalCounts']['count'];
		} elseif ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_POC\t" . "NO_WP_ERROR" . "\t" . $url ."\tHTTP_RESP: " . $data['response']['code'] ." / " . $data['response']['message']);
	} else {
		$error_string = $data->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_POC\t" . "WP_Error: " . $error_string . "\t" . $url );
	}
	return $count;
}
?>
<?php function smpro_pinc_get($url) {
	global $smpro_debug_mode;
	$count = 0;
	$data = wp_remote_get('ht'.'tp://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url='.urlencode($url) );
	if (!is_wp_error($data) ) { 
		if ( $data['response']['code'] == 200 ) {
			$data = str_replace ( "receiveCount(" , "" ,  $data['body'] );
			$data = str_replace ( ")" , "" , $data );
			$resp = json_decode($data,true);
			if ($resp['count']) $count = $resp['count'];
			else $count = 0;
		} elseif ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_PINC\t" . "NO_WP_ERROR" . "\t" . $url ."\tHTTP_RESP: " . $data['response']['code'] ." / " . $data['response']['message']);
	} else {
		$error_string = $data->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_PINC\t" . "WP_Error: " . $error_string . "\t" . $url );
	}
	return $count;
}
?>
<?php function smpro_sc_get($url) {
	global $smpro_debug_mode;
	$count = 0;
	$data = wp_remote_get('ht'.'tp://www.stumbleupon.com/services/1.01/badge.getinfo?url='.urlencode($url) );
	if (!is_wp_error($data) ) {
		if ( $data['response']['code'] == 200) {
			$resp = json_decode($data['body'],true);
			if ($resp['result']['views']) { $count = $resp['result']['views']; }
			elseif ($resp['success'] == false) {
				if ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_SC\t" . $resp['error_code'] . ":" . $resp['error_message'] . "\t" . $url . "\tHTTP_RESP: " . $data['response']['code'] ." / " . $data['response']['message']);
			}
		} elseif ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_SC\t" . "NO_WP_ERROR" . "\t" . $url ."\tHTTP_RESP: " . $data['response']['code'] ." / " . $data['response']['message']);
	} else {
		$error_string = $data->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_SC\t" . "WP_Error: " . $error_string . "\t" . $url );
	}
	return $count;
}
?>
<?php function smpro_dc_get($url) {
	global $smpro_debug_mode;
	$count = 0;
	$data = wp_remote_get('ht'.'tp://services.digg.com/2.0/story.getInfo?links='.urlencode($url) );
	if (!is_wp_error($data) ) {
		if ( $data['response']['code'] == 200 ) {
			$resp = json_decode($data['body'],true);
			if ($resp['stories'][0]['diggs']) $count = $resp['stories'][0]['diggs'];
			elseif ($resp['count']) $count = $resp['count'];
		} elseif ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_DC\t" . "NO_WP_ERROR" . "\t" . $url ."\tHTTP_RESP: " . $data['response']['code'] ." / " . $data['response']['message']);
	} else {
		$error_string = $data->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_DC\t" . "WP_Error: " . $error_string . "\t" . $url );
	}
	return $count;
}
?>
<?php function smpro_lc_get($url) {
	global $smpro_debug_mode;
	$count = 0;
	/* $data = wp_remote_get( 'ht'.'tp://www.linkedin.com/cws/share-count?url='.urlencode($url) ); */
	$data = wp_remote_get( 'ht'.'tp://www.linkedin.com/countserv/count/share?url='.urlencode($url) );
	if (!is_wp_error($data) ) { 
		if ( $data['response']['code'] == 200 ) {
			$data = str_replace ( "IN.Tags.Share.handleCount(" , "" ,  $data['body'] );
			$data = str_replace ( ");" , "" , $data );
			$resp = json_decode($data,true);
			if ($resp['count']) $count = $resp['count'];
			else $count = 0;
		} elseif ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_LC\t" . "NO_WP_ERROR" . "\t" . $url ."\tHTTP_RESP: " . $data['response']['code'] ." / " . $data['response']['message']);
	} else {
		$error_string = $data->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("DATA_REFRESH_ERROR_LC\t" . "WP_Error: " . $error_string . "\t" . $url );
	}
	return $count;
}
?>
<?php function sm_get_rank($count, $min, $max) {
if (get_option('socialmetricspro_conditional_formatting', 'bycolumns') == "disabled") return '#FFFFFF';

if (get_option('socialmetricspro_share_counts', 'plain') == "sharebuttons")
return '#FFFFFF';

$colors = array( '#F8696B','#F86B6B','#F86E6C','#F8706C','#F8736D','#F8766D','#F8786E','#F87B6E','#F97E6F','#F9806F','#F98370','#F98570','#F98861','#F98B71','#F98D62','#FA9072','#FA9373','#FA9573','#FA9874','#FA9A74','#FA9D75','#FAA075','#FBA276','#FBA576','#FBA877','#FBAA77','#FBAD78','#FBAF78','#FBB279','#FCB579','#FCB77A','#FCBA7A','#FCBD7B','#FCBF7B','#FCC27C','#FCC47C','#FDC77D','#FDCA7D','#FDCC7E','#FDCF7E','#FDD27F','#FDD47F','#FDD780','#FED980','#FEDC81','#FEDF81','#FEE182','#FEE482','#FEE783','#FEE983','#FEEB84','#FBEA84','#F8E984','#F4E884','#F1E784','#EEE683','#EBE683','#E8E583','#E5E483','#E2E383','#DEE283','#DBE182','#D8E082','#D5DF82','#D2DE82','#CFDD82','#CCDD82','#C8DC81','#C5DB81','#C2DA81','#BFD981','#BCD881','#B9D780','#B5D680','#B2D580','#AFD480','#ACD380','#A9D27F','#A6D27F','#A3D17F','#9FD07F','#9CCF7F','#99CE7F','#96CD7E','#93CC7E','#90CB7E','#8CCA7E','#89C97E','#86C97E','#83C87D','#80C77D','#7DC67D','#7AC57D','#76C47D','#73C37C','#70C27C','#6DC17C','#6AC07C','#67BF7C','#63BE7B' );

if($min == $max) return $colors[0];
$fscore = (($count - $min + 1)/($max - $min + 1)) * 100;
$iscore = intval(round($fscore)) - 1;
if ($iscore < 0) $iscore = 0;
if ($iscore > 99) $iscore = 99;
if ($colors[$iscore]) return $colors[$iscore];
else return '#FFFFFF';
}
?>
<?php
function socialmetricspro_dashboard_widget_function() {
	socialmetricspro_dashboard_widget_display();
}

function socialmetricspro_dashboard_widget_display() {
	global $wpdb;
	global $show_tc, $show_fc, $show_poc, $show_pinc, $show_sc, $show_dc, $show_lc;
	global $dsc;
	
	$per_page = 5;
	
	$querystr = 
	"SELECT smpcache.post_id,smpcache.update_time,smpcache.post_type,smpcache.post_url,smpcache.twitter_tweets,smpcache.facebook_likes,smpcache.google_plusones,smpcache.su_stumbles,smpcache.digg_diggs,smpcache.linkedin_shares,smpcache.pinterest_pins, wposts.post_title" .
	" FROM " . $wpdb->prefix . "posts wposts" .
	" INNER JOIN " . $wpdb->prefix . "smpro_cache smpcache ON wposts.ID = smpcache.post_id" .
	" WHERE wposts.post_type = 'post'" .
	" AND wposts.post_status = 'publish'" .
	
	" ORDER BY wposts.post_date DESC" .
	" LIMIT 5";
	
	$recent_posts = $wpdb->get_results( $wpdb->prepare( $querystr, array() ), OBJECT);
?>
<?php add_socialmetricspro_styles() ?>
<?php $i=0; $j=0; 
$sm = array();

$min = $max = 0;
$min_tw = $max_tw = $count_tw = 0;
$min_fb = $max_fb = $count_fb = 0;
$min_po = $max_po = $count_po = 0;
$min_pin = $max_pin = $count_pin = 0;
$min_su = $max_su = $count_su = 0;
$min_dg = $max_dg = $count_dg = 0;
$min_li = $max_li = $count_li = 0;
?>
<?php
$dsc = get_option('socialmetricspro_share_counts', 'plain');
if (get_option('socialmetricspro_show_twitter') == "true") $show_tc = true; else $show_tc = false;
if (get_option('socialmetricspro_show_facebook') == "true") $show_fc = true; else $show_fc = false;
if (get_option('socialmetricspro_show_plusone') == "true") $show_poc = true; else $show_poc = false;
if (get_option('socialmetricspro_show_pinterest') == "true") $show_pinc = true; else $show_pinc = false;
if (get_option('socialmetricspro_show_su') == "true") $show_sc = true; else $show_sc = false;
if (get_option('socialmetricspro_show_digg') == "true") $show_dc = true; else $show_dc = false;
if (get_option('socialmetricspro_show_linkedin') == "true") $show_lc = true; else $show_lc = false;
?>
<?php 
	foreach ($recent_posts as $post) {
		$widget_col_count = 1;

		$sm[$i][0] = $post->post_title;
		$sm[$i][1] = $post->post_url;

		if ($show_tc && $widget_col_count < 4) {
			$widget_col_count++;
			$count_tw = $post->twitter_tweets;
			$min_tw = min($min_tw, $count_tw);
			$max_tw = max($max_tw, $count_tw);
			$sm[$i][$widget_col_count] = ( $dsc == "sharebuttons" ) ? smpro_tb_get( $post->post_url, $post->post_title ) : $count_tw;
		}

		if ($show_fc && $widget_col_count < 4) {
			$widget_col_count++;
			$count_fb = $post->facebook_likes;
			$min_fb = min($min_fb, $count_fb);
			$max_fb = max($max_fb, $count_fb);
			$sm[$i][$widget_col_count] = ( $dsc == "sharebuttons" ) ? smpro_fb_get( $post->post_url ) : $count_fb;
		}

		if ($show_poc && $widget_col_count < 4){
			$widget_col_count++;
			$count_po = $post->google_plusones;
			$min_po = min($min_po, $count_po);
			$max_po = max($max_po, $count_po);
			$sm[$i][$widget_col_count] = ( $dsc == "sharebuttons" ) ? smpro_pob_get( $post->post_url ) : $count_po;
		}

		if ($show_pinc && $widget_col_count < 4){
			$widget_col_count++;
			$count_pin = $post->pinterest_pins;
			$min_pin = min($min_pin, $count_pin);
			$max_pin = max($max_pin, $count_pin);
			$sm[$i][$widget_col_count] = ( $dsc == "sharebuttons" ) ? smpro_pinb_get( $post->post_url, $post->post_id, $post->post_title ) : $count_pin;
		}
		
		if ($show_sc && $widget_col_count < 4) {
			$widget_col_count++;
			$count_su = $post->su_stumbles;
			$min_su = min($min_su, $count_su);
			$max_su = max($max_su, $count_su);
			$sm[$i][$widget_col_count] = ( $dsc == "sharebuttons" ) ? smpro_sb_get( $post->post_url ) : $count_su;
		}

		if ($show_dc && $widget_col_count < 4){
			$widget_col_count++;
			$count_dg = $post->digg_diggs;
			$min_dg = min($min_dg, $count_dg);
			$max_dg = max($max_dg, $count_dg);
			$sm[$i][$widget_col_count] = ( $dsc == "sharebuttons" ) ? smpro_db_get( $post->post_url, $post->post_title ) : $count_dg;
		}

		if ($show_lc && $widget_col_count < 4){
			$widget_col_count++;
			$count_li = $post->linkedin_shares;
			$min_li = min($min_li, $count_li);
			$max_li = max($max_li, $count_li);
			$sm[$i][$widget_col_count] = ( $dsc == "sharebuttons" ) ? smpro_lb_get( $post->post_url ) : $count_li;
		}
	$i++;
	} 
?>
<?php $widget_col_count = 1; ?>
<div class="smwrap">
<div class="tablenav"><div class="tablenav-pages"><a href="<?php echo admin_url().'admin.php?page=socialmetricspro_dashboard'; ?>">View All</a></div>
</div>
<table class="widefat post fixed sortable smtable" cellspacing="0">
<thead> 
<tr>
<th scope="col" id="title0" class="manage-column column-title" >Title</th>
<?php if ($show_tc && $widget_col_count < 4){ $widget_col_count++; ?><th scope="col" id="title1" class="manage-column column-title">Twitter</th><?php } ?>
<?php if ($show_fc && $widget_col_count < 4){ $widget_col_count++; ?><th scope="col" id="title2" class="manage-column column-title">Facebook</th><?php } ?>
<?php if ($show_poc && $widget_col_count < 4){ $widget_col_count++; ?><th scope="col" id="title3" class="manage-column column-title">Google +1</th><?php } ?>
<?php if ($show_pinc && $widget_col_count < 4){ $widget_col_count++; ?><th scope="col" id="title8" class="manage-column column-title">Pinterest</th><?php } ?>
<?php if ($show_sc && $widget_col_count < 4){ $widget_col_count++; ?><th scope="col" id="title5" class="manage-column column-title">StumbleUpon</th><?php } ?>
<?php if ($show_dc && $widget_col_count < 4){ $widget_col_count++; ?><th scope="col" id="title6" class="manage-column column-title">Digg</th><?php } ?>
<?php if ($show_lc && $widget_col_count < 4){ $widget_col_count++; ?><th scope="col" id="title7" class="manage-column column-title">LinkedIn</th><?php } ?>
</tr></thead><tbody>
<?php
if (get_option('socialmetricspro_conditional_formatting', 'bycolumns') == "bytable") {
	$min = min ($min_tw,$min_fb,$min_po,$min_pin,$min_su,$min_dg,$min_li);
	$max = max ($max_tw,$max_fb,$max_po,$max_pin,$max_su,$max_dg,$max_li);
	$min_tw = $min_fb = $min_po = $min_pin = $min_su = $min_dg = $min_li = $min;
	$max_tw = $max_fb = $max_po = $max_pin = $max_su = $max_dg = $max_li = $max;
}
?>
<?php for ($k = 0; $k < count($sm); $k++) {
$widget_col_count = 1;
?>
<tr>
<td><a target="_blank" href="<?php echo $sm[$k][1]; ?>" rel="bookmark"><?php echo $sm[$k][0]; ?></a></td>
<?php if ($show_tc && $widget_col_count < 4){ $widget_col_count++; ?><td style="background:<?php echo sm_get_rank($sm[$k][$widget_col_count], $min_tw, $max_tw); ?>;"><?php echo $sm[$k][$widget_col_count]; ?></td><?php } ?>
<?php if ($show_fc && $widget_col_count < 4){ $widget_col_count++; ?><td style="background:<?php echo sm_get_rank($sm[$k][$widget_col_count], $min_fb, $max_fb); ?>;"><?php echo $sm[$k][$widget_col_count]; ?></td><?php } ?>
<?php if ($show_poc && $widget_col_count < 4){ $widget_col_count++; ?><td style="background:<?php echo sm_get_rank($sm[$k][$widget_col_count], $min_po, $max_po); ?>;"><?php echo $sm[$k][$widget_col_count]; ?></td><?php } ?>
<?php if ($show_pinc && $widget_col_count < 4){ $widget_col_count++; ?><td style="background:<?php echo sm_get_rank($sm[$k][$widget_col_count], $min_pin, $max_pin); ?>;"><?php echo $sm[$k][$widget_col_count]; ?></td><?php } ?>
<?php if ($show_sc && $widget_col_count < 4){ $widget_col_count++; ?><td style="background:<?php echo sm_get_rank($sm[$k][$widget_col_count], $min_su, $max_su); ?>;"><?php echo $sm[$k][$widget_col_count]; ?></td><?php } ?>
<?php if ($show_dc && $widget_col_count < 4){ $widget_col_count++; ?><td style="background:<?php echo sm_get_rank($sm[$k][$widget_col_count], $min_dg, $max_dg); ?>;"><?php echo $sm[$k][$widget_col_count]; ?></td><?php } ?>
<?php if ($show_lc && $widget_col_count < 4){ $widget_col_count++; ?><td style="background:<?php echo sm_get_rank($sm[$k][$widget_col_count], $min_li, $max_li); ?>;"><?php echo $sm[$k][$widget_col_count]; ?></td><?php } ?>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<?php 
add_socialmetricspro_sharebutton_scripts( "widget" );
} ?>
<?php
function smpro_microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
?>
<?php

add_filter('pre_set_site_transient_update_plugins', 'socialmetricspro_update_check');
function socialmetricspro_update_check($current_versions) {
	global $socialmetricspro_api_url, $socialmetricspro_plugin_slug, $socialmetricspro_plugin_file;
	global $smpro_debug_mode;
	
	$smpro_debug_mode = false;
	if ( "enabled" == get_option('socialmetricspro_enable_logs', 'disabled') ) $smpro_debug_mode = true;
	
	if (empty($current_versions->checked))
		return $current_versions;
	
	
	$request_args = array(
		'slug' => $socialmetricspro_plugin_slug,
		'version' => $current_versions->checked[$socialmetricspro_plugin_slug .'/'. $socialmetricspro_plugin_file],
	);
	
	$request_string = socialmetricspro_api_request('check_update', $request_args);
	$raw_response = wp_remote_post($socialmetricspro_api_url, $request_string);
	
	if (!is_wp_error($raw_response) ) {
		if ( $raw_response['response']['code'] == 200 ) {
			$response = unserialize($raw_response['body']);
		} elseif ( $smpro_debug_mode ) smpro_to_log("UPDATE_CHECK_FAILED\t" . "NO_WP_ERROR" ."\tHTTP_RESP: " . $raw_response['response']['code'] ." / " . $raw_response['response']['message']);
	} else {
		$error_string = $raw_response->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("UPDATE_CHECK_FAILED\t" . "WP_Error: " . $error_string );
	}
	if (is_object($response) && !empty($response)) {
		$current_versions->response[$socialmetricspro_plugin_slug .'/'. $socialmetricspro_plugin_file] = $response;
		
		$new_version = $response->new_version;
		socialmetricspro_notify_update( $new_version );
	}
	
	//print_r ($current_versions);
	return $current_versions;
}

add_filter('plugins_api', 'socialmetricspro_plugin_api', 10, 3);
function socialmetricspro_plugin_api($res, $action, $args) {
	global $socialmetricspro_plugin_slug, $socialmetricspro_api_url, $socialmetricspro_plugin_file;
	global $smpro_debug_mode;
	
	$smpro_debug_mode = false;
	if ( "enabled" == get_option('socialmetricspro_enable_logs', 'disabled') ) $smpro_debug_mode = true;
	
	if ($args->slug != $socialmetricspro_plugin_slug)
		return $res;
	
	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$socialmetricspro_plugin_slug .'/'. $socialmetricspro_plugin_file];
	$args->version = $current_version;
	
	$request_string = socialmetricspro_api_request($action, $args);
	
	$request = wp_remote_post($socialmetricspro_api_url, $request_string);
	
	if ( is_wp_error($request) ) {
		$error_string = $request->get_error_message();
		if ( $smpro_debug_mode ) smpro_to_log("PLUGINS_API_FAILED\t" . "WP_Error: " . $error_string );
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);
		
		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred.'), $request['body']);
	}
	
	return $res;
}

function socialmetricspro_api_request($action, $args) {
	global $wp_version;
	$apikey = get_option("socialmetricspro_license_key", "") . ":" . md5( site_url() );
	
	return array(
		'body' => array(
			'action' => $action, 
			'request' => serialize($args),
			'api-key' => $apikey
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . site_url()
	);	
}
?>
<?php
function socialmetricspro_notify_update( $new_version ) {
	$notify_to = get_option('socialmetricspro_notification_email', '');
	$notification_sent = get_option('socialmetricspro_notification_sent', '');
	$dn_url = "http://socialmetricspro.com/members/download/";
	
	if ( empty($notify_to) || !is_email( $notify_to ) || $notification_sent == $new_version )
		return;
	
	$subject = sprintf( "Social Metrics Pro %s is available for %s", esc_html( $new_version ), home_url() );
		
	$message = sprintf( "Social Metrics Pro %s is now available. We have provided 1-click updates for this plugin, so please update at your earliest convenience. To use 1-click update, log into your WordPress at %s and go to Dashboard -> Updates.", esc_html( $new_version ), wp_login_url() );
	$message .= "\n\n";
	$message .= sprintf( "Alternatively, you can update manually by downloading the new version from %s.", $dn_url );
	$message .= "\n\n" . "Thank you for choosing Social Metrics Pro!";
	
	wp_mail( sanitize_email($notify_to), $subject, $message );
	update_option( 'socialmetricspro_notification_sent', $new_version );
}
?>
<?php
function add_socialmetricspro_dashboard_widget() {
	wp_add_dashboard_widget('socialmetricspro_dashboard_widget', 'Social Metrics Pro', 'socialmetricspro_dashboard_widget_function');	
}
if (get_option('socialmetricspro_show_on_dashboard', 'enabled') == "enabled") {
add_action('wp_dashboard_setup', 'add_socialmetricspro_dashboard_widget' );
}
?>
<?php
function smpro_to_log( $msg, $mestyp = "E" ) {

	$tzone = get_option('timezone_string');
	if ( !empty( $tzone ) ) date_default_timezone_set ( $tzone );
	else date_default_timezone_set ( "America/New_York" );	

	$dir = plugin_dir_path(__FILE__) . 'logs/';
	$filename = "smpro.log";
	$logfile = $dir . $filename; //Absolute path

	$fh = fopen($logfile, 'a');
	if ( $fh == FALSE ) {
		update_option("socialmetricspro_logging_error", "YES");
		return;
	}
	update_option("socialmetricspro_logging_error", "NO");
	
	$text = "[" . date('Y-m-d H:i:s T') . "]\t";
	$text .= $mestyp . "\t" . $msg;
	$text .= "\tEOM\n";
	fwrite($fh, $text);
	fclose($fh);
}
?>
<?php
function smpro_get_logging_error_html() {
	$dir = plugin_dir_path(__FILE__) . 'logs/';
	$filename = "smpro.log";
	
	$error_html = '<div id="message" class="error" style="padding: 10px;">' .
				  'We could not update the error log file. Please check the file permissions for the file named <code>' . $filename .
				  '</code> under the directory <code>' . $dir . '</code> on your server. Make sure it is writable by WordPress by giving appropriate <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">file permissions</a>.' .
				  '</div>';
	return $error_html;
}
?>