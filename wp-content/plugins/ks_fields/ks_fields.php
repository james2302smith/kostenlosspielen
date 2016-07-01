<?php
/*
Plugin Name: kostenlosspielen.biz Fields
Plugin URI: http://www.kostenlosspielen.biz
Description: Add some custom fields for games, for example: image, flash,..
Version: 1.0
Author: Quang Vinh Pham
Author URI: http://www.kostenlosspielen.biz/
*/

add_action("admin_init", "ks_fields_init");
add_action('save_post', 'save_ks_fields');

function ks_fields_init(){
    add_meta_box("game_fields_glider", "Game's Options", "fields_meta", "post", "normal", "high");
}

function fields_meta(){
    global $post;
?>
	<div class="inside">
		<table>

			<tr><td>Image</td><td><input type="text" style="width: 680px;" name="game_image" value="<?php if(strlen($post->game_image) >0) { echo $post->game_image;} ?>"</td></tr>
			<tr><td>Intro</td><td><input type="text" style="width: 100%;" name="game_intro" value="<?php if(strlen($post->game_intro) >0) { echo $post->game_intro;} ?>"</td></tr>
			<tr><td>Intro_home</td><td><input type="text" style="width: 100%;" name="game_intro_home" value="<?php if(strlen($post->game_intro_home) >0) { echo $post->game_intro_home;} ?>"</td></tr>
			<tr><td>Flash</td><td><input type="text" style="width: 100%;" name="game_flash" value="<?php if(strlen($post->game_flash) >0) { echo $post->game_flash;} ?>"</td></tr>
			<tr><td>Author's Name</td><td><input type="text" style="width: 100%;" name="game_author" value="<?php if(strlen($post->game_author) >0) { echo $post->game_author;} ?>"</td></tr>
			<tr><td>Author's Email</td><td><input type="text" style="width: 100%;" name="game_email" value="<?php if(strlen($post->game_email) >0) { echo $post->game_email;} ?>"</td></tr>
			<tr><td>Height</td><td><input type="text" style="width: 100%;" name="game_height" value="<?php if($post->game_height >0) { echo $post->game_height;} ?>"</td></tr>
			<tr><td>Width</td><td><input type="text" style="width: 100%;" name="game_width" value="<?php if($post->game_width >0) { echo $post->game_width;} ?>"</td></tr>
			<tr><td>Iframe</td><td><input type="text" style="width: 100%;" name="game_iframe" value="<?php if(strlen($post->game_iframe) >0) { echo $post->game_iframe;} ?>"</td></tr>			
			<tr><td>Name in English</td><td><input type="text" readonly style="width: 100%;" name="game_name_en" value="<?php if(strlen($post->game_name_en) >0) { echo $post->game_name_en;} ?>"</td></tr>
		</table>
	</div>
<?php
}

function save_ks_fields(){
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;
    global $post, $wpdb;
    if($post->post_type == "post" || $post->post_type == "page") {
	$wpdb->update( 'kostenlosspielen_posts', array( 'game_image' => $_POST["game_image"],'game_intro' => $_POST["game_intro"],'game_intro_home' => $_POST["game_intro_home"],'game_flash' => $_POST["game_flash"],'game_height' => $_POST["game_height"],'game_width' => $_POST["game_width"],'game_iframe' => $_POST["game_iframe"],'game_author' => $_POST["game_author"],'game_email' => $_POST["game_email"],'game_name_en' => $_POST["game_name_en"]),array( 'ID' => $post->ID ));					
    }
}

?>
