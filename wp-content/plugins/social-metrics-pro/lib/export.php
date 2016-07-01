<?php
require_once('../../../../wp-admin/admin.php');
if ( !current_user_can('manage_options') ) wp_die('You do not have sufficient permissions to access this tool. Please contact your WordPress administrator!');
check_admin_referer('smpro-exp-nonce-action');
if (get_option('socialmetricspro_export', 'enabled') == "disabled") wp_die('Export functionality has been disabled. You can enable it from the Social Metrics Pro Settings page.');

$time = time();
$time_start = smpro_microtime_float();
$tzone = get_option('timezone_string');
if ( !empty( $tzone ) ) date_default_timezone_set ( $tzone );
else date_default_timezone_set ( "America/New_York" );
$timezone = date("T");

if ( !isset($_GET['p_type']) ) { $post_type = 'post'; }
elseif ( in_array( $_GET['p_type'], get_post_types( array('show_ui' => true ) ) ) ) {
	$post_type = $_GET['p_type']; }
else {
	wp_die( __('Invalid post type') ); }

global $wpdb;
$filetype = $_GET['ft'];
$cat = $_GET['cat'];
if (isset( $_GET['m'] )) {
	$mon = $_GET['m'];
	if (strlen($mon) == 6) {
	$month = substr($mon,4,6);
	$s_year = substr($mon,0,4);
	} else { $month = 0; $s_year = 0; }
} else { $month = 0; $s_year = 0; }
$s = $_GET['s'];
$sort_col = $_GET['sort'];
$sort_order = $_GET['order'];

if($filetype == 'xls' && (get_option('socialmetricspro_xls', true) == "true")) { 
	$delimiter = "\t";
	$filename="Social Metrics Pro Report ".date('Ymd-His', $time).".tsv";
}
elseif($filetype == 'csv' && (get_option('socialmetricspro_csv', true) == "true")) {
	$delimiter = ",";
	$filename = "Social Metrics Pro Report ".date('Ymd-His', $time).".csv";
}
else{
	wp_die('The filetype is either not supported or has been disabled. Please check your settings.');
}

if (get_option('socialmetricspro_show_twitter') == "true") $show_tc = true; else $show_tc = false;
if (get_option('socialmetricspro_show_facebook') == "true") $show_fc = true; else $show_fc = false;
if (get_option('socialmetricspro_show_plusone') == "true") $show_poc = true; else $show_poc = false;
if (get_option('socialmetricspro_show_su') == "true") $show_sc = true; else $show_sc = false;
if (get_option('socialmetricspro_show_digg') == "true") $show_dc = true; else $show_dc = false;
if (get_option('socialmetricspro_show_linkedin') == "true") $show_lc = true; else $show_lc = false;
if (get_option('socialmetricspro_show_pinterest') == "true") $show_pinc = true; else $show_pinc = false;

$upload_dir = wp_upload_dir(); 

$filepath = $upload_dir['path'] . '/' . $filename; //Absolute path
$fileurl = $upload_dir['url'] . '/' . $filename;

$open = fopen($filepath, 'w') or die ("File cannot be opened.");
$record = "Social Metrics Report - Generated on " . date('m-d-Y H:i:s T',$time) . " - Powered by Social Metrics Pro Plugin (http://socialmetricspro.com/)" . "\r\n";
fwrite($open, $record );

$record = "Post ID" . $delimiter;
$record .= "Update Time" . " (" . $timezone . ")" . $delimiter;
$record .= "Post Type" . $delimiter;
$record .= "Post Title" . $delimiter;
$record .= "Post URL" . $delimiter;
if ($show_tc) $record .= "Tweets" . $delimiter;
if ($show_fc) $record .= "Facebook Likes" . $delimiter;
if ($show_poc) $record .= "Google +1s" . $delimiter;
if ($show_pinc) $record .= "Pins" . $delimiter;
if ($show_sc) $record .= "Stumbles" . $delimiter;
if ($show_dc) $record .= "Diggs" . $delimiter;
if ($show_lc) $record .= "LinkedIn Shares";
$record .= "\r\n";
fwrite($open, $record );

$countquery = 
	"SELECT COUNT(*)" .
	" FROM " . $wpdb->prefix . "posts wposts" .
		" INNER JOIN " . $wpdb->prefix . "smpro_cache smpcache ON wposts.ID = smpcache.post_id";
		
$querystr = "SELECT smpcache.post_id,smpcache.update_time,smpcache.post_type,smpcache.post_url,smpcache.twitter_tweets,smpcache.facebook_likes,smpcache.google_plusones,smpcache.pinterest_pins,smpcache.su_stumbles,smpcache.digg_diggs,smpcache.linkedin_shares, wposts.post_title" .
" FROM " . $wpdb->prefix . "posts wposts" .
	" INNER JOIN " . $wpdb->prefix . "smpro_cache smpcache ON wposts.ID = smpcache.post_id";

$where = " WHERE wposts.post_type = '" . $post_type . "'";
if ( !empty( $cat ) and 'post' == $post_type ) {
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
			case 'pinc': $sort_string = 'smpcache.pinterest_pins ' . $sort_order; break;
			case 'sc': $sort_string = 'smpcache.su_stumbles ' . $sort_order; break;
			case 'dc': $sort_string = 'smpcache.digg_diggs ' . $sort_order; break;
			case 'lc': $sort_string = 'smpcache.linkedin_shares ' . $sort_order; break;
			
			case 'date': $sort_string = 'wposts.post_date ' . $sort_order; break;
			default: $sort_string = 'wposts.post_date DESC'; break;
		}
		$querystr .= " ORDER BY " . $sort_string;
} else {
	$querystr .= " ORDER BY wposts.post_date DESC";
}

$per_page = 1000;
$querystr .= " LIMIT " . $per_page ;

$max_posts = $wpdb->get_var( $wpdb->prepare( $countquery, array() ));
$num_pages = ceil (intval($max_posts) / $per_page );

for ($pagenum = 1; $pagenum <= $num_pages; $pagenum++ ) {

	$offset = ( $pagenum - 1 ) * $per_page;
	$exportquery = $querystr . " OFFSET " . $offset;
	
	$recent_posts = $wpdb->get_results( $wpdb->prepare( $exportquery, array() ), OBJECT);
	
	foreach ($recent_posts as $postkey => $post) {
		$record = $post->post_id . $delimiter;
		$record .= $post->update_time . $delimiter;
		$record .= $post->post_type . $delimiter;

		if ( $filetype == 'csv' ) {
			$record .= str_replace (",", "", $post->post_title) . $delimiter;
			$record .= str_replace (",", "", $post->post_url) . $delimiter;
		}
		else {
			$record .= $post->post_title . $delimiter;
			$record .= $post->post_url . $delimiter;
		}

		if ($show_tc) $record .= $post->twitter_tweets . $delimiter;
		if ($show_fc) $record .= $post->facebook_likes . $delimiter;
		if ($show_poc) $record .= $post->google_plusones . $delimiter;
		if ($show_pinc) $record .= $post->pinterest_pins . $delimiter;
		if ($show_sc) $record .= $post->su_stumbles . $delimiter;
		if ($show_dc) $record .= $post->digg_diggs . $delimiter;
		if ($show_lc) $record .= $post->linkedin_shares;
		$record .= "\r\n";

		fwrite($open, $record );
	}
}
fclose($open);
$time_end = smpro_microtime_float();
$timediff = $time_end - $time_start;
if(function_exists("memory_get_peak_usage")) { $mem_usage = memory_get_peak_usage(true); }
else if(function_exists("memory_get_usage")) { $mem_usage = memory_get_usage(true); }

if (!empty ($mem_usage)) $mem_usage = $mem_usage / 1024 / 1024;
?>
<?php add_socialmetricspro_styles(); ?>
<style type="text/css">body {font-family: sans-serif;font-size: 13px;}</style>
<div class="wrap">
	<div class="smwrap">
		<h2 class="sm-branding" style="padding-top: 15px;">Social Metrics Pro Export Tool</h2>
		<div style="margin-left:10px;">
		<div style="padding:10px 5px;">Report generated in <strong><?php echo number_format ( $timediff, 5 ); ?> seconds</strong><?php if (!empty($mem_usage)) { echo " using " . $mem_usage . " MB of memory"; } ?>. Click the link below to download the report to your desktop:</div>
		<div style="padding:10px 20px;"><?php echo '<a href="' . $fileurl . '">' . $filename .'</a>'; ?></div>
		<div style="padding:10px 5px;">Thank you for creating with <a href="http://socialmetricspro.com/" target="_blank">Social Metrics Pro</a>!</div>
		<div style="padding:10px 5px; font-size:0.7em">Note: The file can be opened with Excel or any spreadsheet processor of your choice. You could even use Notepad.</div>
		</div>
	</div>
</div>