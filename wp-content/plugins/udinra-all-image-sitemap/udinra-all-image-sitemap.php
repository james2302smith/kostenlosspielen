<?php
/*
Plugin Name: Udinra All Image Sitemap 
Plugin URI: http://udinra.com/blog/udinra-image-sitemap
Description: Automatically generates Google Image Sitemap and submits it to Google,Bing and Ask.com.
Author: Udinra
Version: 2.0
Author URI: http://udinra.com
*/

function UdinraAA_IMS() {
if(!isset($_POST['udinra_ping_google'])){
$_POST['udinra_ping_google'] = "";
}
if(!isset($_POST['udinra_ping_bing'])){
$_POST['udinra_ping_bing'] = "";
}
if(!isset($_POST['udinra_ping_ask'])){
$_POST['udinra_ping_ask'] = "";
}
if(!isset($_POST['udinra_gzip'])){
$_POST['udinra_gzip'] = "";
}
if($_POST['udinra_img_site']){
update_option('udinra_ping_google',$_POST['udinra_ping_google']);
update_option('udinra_ping_bing',$_POST['udinra_ping_bing']);
update_option('udinra_ping_ask',$_POST['udinra_ping_ask']);
update_option('udinra_gzip',$_POST['udinra_gzip']);
}
$wp_udinra_ping_google = get_option('udinra_ping_google');
$wp_udinra_ping_bing  = get_option('udinra_ping_bing');
$wp_udinra_ping_ask = get_option('udinra_ping_ask');
$wp_udinra_gzip = get_option('udinra_gzip');
$udinra_sitemap_response = "";
if(isset($_POST['udinra_img_site'])){
$udinra_sitemap_response = udinra_image_sitemap_loop(); 
}
?>
<div class="wrap">
<h2>Udinra All Image Sitemap (Configuration)</h2>
<form method="post" id="UdinraAA_IMS">
<fieldset class="options">
<p><input type="checkbox" id="udinra_gzip" name="udinra_gzip" value="udinra_gzip" <?php if($wp_udinra_gzip == true) { echo('checked="checked"'); } ?> />Create gzip file sitemap-image.xml.gz</p>
<p><input type="checkbox" id="udinra_ping_google" name="udinra_ping_google" value="udinra_ping_google" <?php if($wp_udinra_ping_google == true) { echo('checked="checked"'); } ?> />Ping Google (Recommended)</p>
<p><input type="checkbox" id="udinra_ping_bing" name="udinra_ping_bing" value="udinra_ping_bing" <?php if($wp_udinra_ping_bing == true) { echo('checked="checked"'); } ?> />Ping Bing (Recommended)</p>
<p><input type="checkbox" id="udinra_ping_ask" name="udinra_ping_ask" value="udinra_ping_ask" <?php if($wp_udinra_ping_ask == true) { echo('checked="checked"'); } ?> />Ping Ask.com (Recommended)</p>
<p><em>If you have a minute, please <a href="http://wordpress.org/extend/plugins/udinra-all-image-sitemap/" target="_blank">rate this plugin</a> on WordPress.org... thanks!</em></p>
<p><input type="submit" name="udinra_img_site" value="Create Sitemap" /></p>
<p><?php echo "Status:"."<br><br>".$udinra_sitemap_response; ?></p>
</fieldset>
</form>
</div>
<?php

}

function udinra_image_sitemap_loop() {

$wp_udinra_ping_google = get_option('udinra_ping_google');
$wp_udinra_ping_bing  = get_option('udinra_ping_bing');
$wp_udinra_ping_ask = get_option('udinra_ping_ask');
$wp_udinra_gzip = get_option('udinra_gzip');

global $wpdb;
	$query='SELECT DISTINCT ID, post_title, post_name, post_date_gmt, f1.meta_value as image , f2.meta_value as intro
			FROM kostenlosspielen_posts
			JOIN kostenlosspielen_postmeta f1 ON ( f1.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f2 ON ( f2.post_id = kostenlosspielen_posts.ID )
			WHERE kostenlosspielen_posts.post_status =  \'publish\'
			AND kostenlosspielen_posts.post_type =  \'post\'
			AND f1.meta_key =  \'image\'
			AND f2.meta_key =  \'intro\'
			ORDER BY post_date DESC'; 
    $posts = $wpdb->get_results ($query);
	$udinra_xml   = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$udinra_xml  .= '<!-- Generated-on="' . date("F j, Y, g:i a") .'" -->' . "\n";		     
	$udinra_xml  .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
	foreach ($posts as $udinra_post) { 
			$udinra_xml .= "\t"."<url>"."\n";
			$udinra_xml .= "\t\t"."<loc>".SITE_ROOT_URL."/".$udinra_post->post_name.".html</loc>"."\n";
			$udinra_xml .= "\t\t"."<image:image>"."\n";
			$udinra_xml .= "\t\t\t"."<image:loc>".$udinra_post->image."</image:loc>"."\n";
			$udinra_xml .= "\t\t\t"."<image:caption>".htmlspecialchars($udinra_post->intro)."</image:caption>"."\n";
			$udinra_xml .= "\t\t\t"."<image:title>".htmlspecialchars($udinra_post->post_title)."</image:title>"."\n";
			$udinra_xml .= "\t\t"."</image:image>"."\n";
			$udinra_xml .= "\t"."</url>"."\n";
	}
	/*Category Page Sitemap*/ 
	$args = array(
	'type'                     => 'post',
	'child_of'                 => 0,
	'parent'                   => '',
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'hide_empty'               => 1,
	'hierarchical'             => 1,
	'exclude'                  => '',
	'include'                  => '',
	'number'                   => '',
	'taxonomy'                 => 'category',
	'pad_counts'               => false );
	$categories = get_categories( $args );
	$i=0;
	foreach($categories as $category){
			$udinra_xml .= "\t"."<url>"."\n";
			if($category->category_parent>0){
				$parent_category=get_category($category->category_parent);
				$udinra_xml .= "\t\t"."<loc>".SITE_ROOT_URL."/".$parent_category->slug."/".$category->slug."/</loc>"."\n";
			}
			else{
				$udinra_xml .= "\t\t"."<loc>".SITE_ROOT_URL."/".$category->slug."/</loc>"."\n";
			}
			$udinra_xml .= "\t\t"."<image:image>"."\n";
			$udinra_xml .= "\t\t\t"."<image:loc>".SITE_ROOT_URL."/wp-content/themes/twentyten/styles/default/".$category->slug.".png</image:loc>"."\n";
			$udinra_xml .= "\t\t\t"."<image:caption>".htmlspecialchars($category->category_description)."</image:caption>"."\n";
			$udinra_xml .= "\t\t\t"."<image:title>".htmlspecialchars($category->name)."</image:title>"."\n";
			$udinra_xml .= "\t\t"."</image:image>"."\n";
			$udinra_xml .= "\t"."</url>"."\n";
	}
	
	$udinra_xml .= "</urlset>";

	$udinra_image_sitemap_url = $_SERVER["DOCUMENT_ROOT"] . '/sitemap-image.xml';
	if (IsImageSitemapWritable($_SERVER["DOCUMENT_ROOT"]) || IsImageSitemapWritable($udinra_image_sitemap_url)) {
	if (file_put_contents ($udinra_image_sitemap_url, $udinra_xml)) {
		$udinra_tempurl = get_bloginfo('url'). '/sitemap-image.xml';
		$udinra_sitemap_response = "Sitemap created successfully"."<br>";
		}
	}
	/*
	if ($wp_udinra_gzip == true) {
		$udinra_image_sitemap_url = $_SERVER["DOCUMENT_ROOT"] . '/sitemap-image.xml.gz';
		if (IsImageSitemapWritable($_SERVER["DOCUMENT_ROOT"]) || IsImageSitemapWritable($udinra_image_sitemap_url)) {
		$udinra_gz = gzopen($udinra_image_sitemap_url,'w9');
		gzwrite($udinra_gz, $udinra_xml);
		gzclose($udinra_gz);
		$udinra_tempurl = get_bloginfo('url'). '/sitemap-image.xml.gz';
		$udinra_sitemap_response = "Sitemap created successfully"."<br>";
		}
	}

			
	if ($wp_udinra_ping_google == true) {
		$udinra_ping_url ='';
		$udinra_ping_url = "http://www.google.com/webmasters/tools/ping?sitemap=" . urlencode($udinra_tempurl);
		$udinra_response = wp_remote_get( $udinra_ping_url );
		if($udinra_response['code']=200)
			{ $udinra_sitemap_response .= "Pinged Google Successfully"."<br>"; }
			else { $udinra_sitemap_response .= "Failed to ping Google.Please submit your image sitemap(sitemap-image.xml) at Google Webmaster.";}}
	if ($wp_udinra_ping_bing == true) {
		$udinra_ping_url ='';
		$udinra_ping_url = "http://www.bing.com/webmaster/ping.aspx?sitemap=" . urlencode($udinra_tempurl);
		$udinra_response = wp_remote_get( $udinra_ping_url );
		if($udinra_response['code']=200)
			{ $udinra_sitemap_response .= "Pinged Bing Successfully"."<br>"; }
			else { $udinra_sitemap_response .= "Failed to ping Bing.Please submit your image sitemap(sitemap-image.xml) at Bing Webmaster.";}}
	if ($wp_udinra_ping_ask == true) {
		$udinra_ping_url ='';
		$udinra_ping_url = "http://submissions.ask.com/ping?sitemap=" . urlencode($udinra_tempurl);
		$udinra_response = wp_remote_get( $udinra_ping_url );
		if($udinra_response['code']=200)
			{ $udinra_sitemap_response .= "Pinged Ask.com Successfully"."<br>"; }
			else { $udinra_sitemap_response .= "Failed to ping Ask.com."; }}*/

return $udinra_sitemap_response;
}

function udinra_image_sitemap_admin() {
	if (function_exists('add_options_page')) {
	add_options_page('Udinra Image Sitemap', 'Udinra Image Sitemap', 'manage_options', basename(__FILE__), 'UdinraAA_IMS');
	}
}

function IsImageSitemapWritable($udinra_filename) {
	if(!is_writable($udinra_filename)) {
		$udinra_sitemap_response = "The file sitemap-image.xml is not writable please check permission of the file for more details visit http://udinra.com/blog/udinra-image-sitemap";
		return false;
	}
	return true;
}

add_action ('publish_post','udinra_image_sitemap_loop');
add_action ('publish_page','udinra_image_sitemap_loop');
add_action('admin_menu','udinra_image_sitemap_admin');

?>
