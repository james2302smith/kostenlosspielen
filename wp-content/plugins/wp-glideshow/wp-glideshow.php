<?php
/*
Plugin Name: WP Glideshow
Plugin URI: http://www.iwebix.de/wp-glideshow-wordpress-plugin/
Description: WP Glideshow is a revolutionary and highly customizable Slideshow Plugin - Must Have for every Wordpress Installation.
Version: 1.1
Author: Dennis Nissle, IWEBIX
Author URI: http://www.iwebix.de/
*/
/* options page */

$admin_page = get_option('siteurl') . '/wp-admin/admin.php?page=wp-glideshow/options.php';
function glider_options_page() {
	add_options_page('WP Glideshow Options', 'WP Glideshow', 10, 'wp-glideshow/options.php');
}

function add_glider_scripts() {
    if ( !is_admin() ) {
	wp_register_script('jquery.slider', get_bloginfo('url') . '/wp-content/plugins/wp-glideshow/scripts/slider.js', array('jquery'), '1.3' );
	wp_enqueue_script('jquery.slider');
    }
}

add_action('wp_enqueue_scripts', 'add_glider_scripts');

add_action('admin_menu', 'glider_options_page');

add_action("admin_init", "glider_init");
add_action('save_post', 'save_glider');

function glider_init(){
    add_meta_box("content_glider", "WP-Glideshow Options", "glider_meta", "post", "normal", "high");
    add_meta_box("content_glider", "WP-Glideshow Options", "glider_meta", "page", "normal", "high");
}

function glider_meta(){
    global $post;
    $custom = get_post_custom($post->ID);
    $content_glider = $custom["content_glider"][0];
?>
	<div class="inside">
		<table class="form-table">
			<tr>
				<th><label for="content_slider">Feature in WP-Glideshow?</label></th>
				<td><input type="checkbox" name="content_glider" value="1" <?php if($content_glider == 1) { echo "checked='checked'";} ?></td>
			</tr>
		</table>
	</div>
<?php
}

function save_glider(){
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;
    global $post;
    if($post->post_type == "post" || $post->post_type == "page") {
	update_post_meta($post->ID, "content_glider", $_POST["content_glider"]);
    }
}

function insert_glider($atts, $content = null) {
    include (ABSPATH . 'wp-content/plugins/wp-glideshow/glideshow.php');
}
add_shortcode("glider", "insert_glider");

$img_width = get_option('glideshow-img-width');

if(empty($img_width)) {
	$img_width = 540;
}

$img_height = get_option('glideshow-img-height');

if(empty($img_height)) {
	$img_height = 250;
}

if (function_exists('add_image_size')) { 
	add_image_size( 'content_glider', $img_width, $img_height, true ); 
}

function get_glider_thumb($position) {
	$thumb = get_the_post_thumbnail($post_id, $position);
	$thumb = explode("\"", $thumb);
	return $thumb[5];
}

//Check for Post Thumbnail Support

add_theme_support( 'post-thumbnails' );

function cut_glider_text($text, $chars) {
	$length = strlen($text);
	if($length <= $chars) {
		return $text;
	} else {
		return substr($text, 0, $chars)." ...";
	}
}

?>
