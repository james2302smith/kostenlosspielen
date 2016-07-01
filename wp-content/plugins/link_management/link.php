<?php
/**
 * @package Crawler
 * @version 1.0
 */
/*
Plugin Name: Link Management
Plugin URI: http://kostenlosspielen.biz/
Description: Link exchange with other website.
Author: Quang Vinh Pham
Version: 1.0
Author URI: http://kostenlosspielen.biz/
*/
add_action('admin_menu', 'link_plugin_menu');
function link_plugin_menu() {
	add_options_page('Link Plugin Options', 'Link Exchange Admin', 'manage_options', 'link_admin', 'link_plugin_options');
}

function link_plugin_options() {
	global $wpdb, $wp_version;
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	echo '<div class="wrap"><h2>';
	echo '</h2></div>';
	_e('Link exchange management'); 

	$m = new admin_subpages();
	//$m->add_subpage('Add new Exchange', 'exchange_add', 'exchange_add');
    //$m->add_subpage('Exchanges management', 'exchange_list', 'exchange_list');
	//$m->add_subpage('Update new URL for Game', 'update_new_url', 'update_new_url');
	//$m->add_subpage('Update new content for Game', 'update_new_content', 'update_new_content');	
	//$m->add_subpage('Add newgames', 'add_game', 'add_game');
	//$m->add_subpage('Add newgames without Flash', 'add_game_withoutFlash', 'add_game_withoutFlash');	
	$m->add_subpage('Add games from kostenlosspielen.net', 'add_category', 'add_category');	
	//$m->add_subpage('Delete cache', 'delete_cache', 'delete_cache');	
	//$m->add_subpage('Assign Post to Author', 'assign_post', 'assign_post');	
	//$m->add_subpage('List games in category', 'list_games', 'list_games');	
	$m->add_subpage('Change user', 'change_user', 'change_user');
	//$m->add_subpage('Add combination', 'add_combination', 'add_combination');
	//$m->add_subpage('Add 10 punkt to game', 'add_punkt', 'add_punkt');
	//$m->add_subpage('Replace Text in Content', 'replace_text', 'replace_text');
	//$m->add_subpage('Add Games from Spielaffe', 'add_game_from_spielaffe', 'add_game_from_spielaffe');
	$m->add_subpage('Add Games from y8.com', 'add_category_y8', 'add_category_y8');
	$m->add_subpage('Exist Games', 'exist_games', 'exist_games');
	//$m->add_subpage('Add Games from jetztspielen', 'add_category_jetztspielen', 'add_category_jetztspielen');
	//$m->add_subpage('Add Games from spielaffe', 'add_category_spielaffe', 'add_category_spielaffe');
	//$m->add_subpage('Add keyword', 'add_keywords', 'add_keywords');
	//$m->add_subpage('Update Heading', 'update_heading', 'update_heading');
	//$m->add_subpage('Category List', 'category_list', 'category_list');
	//$m->add_subpage('Create Images for all sizes', 'image_sizes', 'image_sizes');	
	//$m->add_subpage('Get PostID', 'getPostID', 'getPostID');	
	$m->add_subpage('Update CategoryID', 'update_category', 'update_category');	
	//$m->add_subpage('Update Games', 'update_games', 'update_games');		
	$m->add_subpage('Update Names', 'update_names', 'update_names');
	$m->add_subpage('Category Statistic', 'category_stat', 'category_stat');
	$m->add_subpage('Multi-category Statistic', 'multi_category_stat', 'multi_category_stat');	
	
	$m->display();
}
function category_stat(){
	global $wpdb, $wp_version;
	if (isset($_POST['category_stat_button'])) {
		$category_id=$_POST['category_id']; //image
		$no_top_post=$_POST['no_top_post']; //game_image
		$count=0;
		$sumTop=0;
		$views_sum=0;
		//echo 'category '.$category_id.'<br/>';post
		//echo 'so luong  '.$no_top_post.'<br/>';
		$querySum = "SELECT sum(game_views) as views_sum FROM `kostenlosspielen_posts` WHERE category2=".$category_id." ORDER BY game_views";
		
		$sumTop=getSumOfTopGames($category_id,$no_top_post);
		$views_sum=getTotalViewsOfGameInCategory($category_id);
		echo $no_top_post.' games (lượng view='.number_format($sumTop,0,',','.').') chiếm '.round($sumTop*100/$views_sum,2).'% toàn bộ games('.number_format($views_sum,0,',','.').')';
		
	}else{
	  echo  ' <form method="post" action="">
	  Thống kế % game_views  của top trò chơi trên tổng số view trong 1 category:
	  <div>ID of category:<input type="text" name="category_id" />  - > Number of top Post:<input type="text" name="no_top_post" /></div>
      <div class="submit"><input type="submit" value="Update" name="category_stat_button" /></div>

      	  <div>ID of Sub Category in kostenlosspielen.biz<br />Action Spiele ::: Ballerspiele:389|Bomberman Spiele:388|Flugzeug Spiele:391|Kampfspiele:387|Kriegspiele:390|Turmverteidigung:392|Verschiedene Actionspiele:393<br />Denkspiele ::: Point & Click: 1935|Mahjong Spiele:104|Schach Spiele:418|Sudoku Spiele:419|Unblock Me:420|Verschiedene Denkspiele:421 <br />Geschicklichkeitsspiele ::: Bubbles Spiele:397|Breakout Spiele:401|Pacman Spiele:395|Parkspiele:399|Pinball Spiele:400|Puzzle Spiele:271|Reaktion Spiele:402|Snake Spiele:398|Tetris Spiele:169|Verschiedene Geschick:403 <br />Jump n Run ::: Mario Spiele:75 | Verschiedene Jump n Run:423 <br />Kartenspiele ::: Blackjack Spiele:406|Memory Spiele:408|Solitär Spiele:407|Verschiedene Kartenspiele:409<br />Mädchen Spiele ::: Lernspiele:1949|Anzielspiele:413|Barbiespiele:447|Dekoration:411|Liebe Spiele:250|Malen Spiele:412|Pferde Spiele:1742|Tier Spiele:414|Verschiedene Mädchenspiele:415<br />Rennspiele ::: Autorennen:425|Boot Rennen:428|Motocross Spiele:426|Motorrad Spiele:427|Verschieden Rennspiele:429<br />Sportspiele ::: Basketball:433|Billard:342|Bowling:435|Boxen:436|Fussball:432|Golf:437|Ski:438|Tennis:434|Verschiedene Sport:439 <br /><input type="text" name="sub_category" /></div>

	  </form>';  
	}	
}
function formatPoint($a){ return number_format($a,0,',','.'); }
function getSumOfTopGames($category2id, $no_top_post)
{
	global $wpdb, $wp_version;
	$sumTop=0;

	$query = "SELECT game_views FROM `kostenlosspielen_posts` WHERE category2=".$category2id." ORDER BY game_views DESC LIMIT ".$no_top_post;
	$pageposts = $wpdb->get_results($query, OBJECT);

	foreach ($pageposts as $post){
			$game_views=$post->game_views;
			$sumTop=$sumTop+$game_views;
	}
	return $sumTop;
}
function getTotalViewsOfGameInCategory($category2id)
{
	global $wpdb, $wp_version;
	$views_sum=0;
	
	$querySum = "SELECT sum(game_views) as views_sum FROM `kostenlosspielen_posts` WHERE category2=".$category2id;			
	$pageposts = $wpdb->get_results($querySum, OBJECT);

	foreach ($pageposts as $post){
		$views_sum=$post->views_sum;		
	}
	return $views_sum;
}
function multi_category_stat(){
	global $wpdb, $wp_version;
	if (isset($_POST['category_stat_button'])) {
		$no_top_post=$_POST['no_top_post']; //game_image
		$count=0;
		$sumTop=0;
		$views_sum=0;
		$cate2query= "SELECT Distinct(category2) from `kostenlosspielen_posts`"; 
		$pageposts = $wpdb->get_results($cate2query, OBJECT);
		$arr=array();
		$arrTotal=array();
		foreach ($pageposts as $post){
			$topViews=getSumOfTopGames($post->category2, $no_top_post);
			$totalViews=getTotalViewsOfGameInCategory($post->category2);
			//$categoryid=$post->category2;
			$categoryName=get_cat_name($post->category2);
			$arr[$topViews]=' Views chiếm '.round($topViews*100/$totalViews,2).'% của '.formatPoint($totalViews).' - '.$categoryName;
			$arrTotal[$totalViews] = $categoryName;
		}
		if($no_top_post==0){
			krsort($arrTotal);
			foreach ($arrTotal as $key => $val) {
	    	echo "".formatPoint($key)." : $val <br />";
			}
		}
		
		if($no_top_post>0){
			krsort($arr);
			foreach ($arr as $key => $val) {
	    	echo "".formatPoint($key)." $val <br />";
			}
		}

		




		//print_r($arr);

		//echo 'category '.$category_id.'<br/>';post
		//echo 'so luong  '.$no_top_post.'<br/>';
		/*$query = "SELECT game_views FROM `kostenlosspielen_posts` WHERE category2=".$category_id." ORDER BY game_views DESC LIMIT ".$no_top_post;
		$querySum = "SELECT sum(game_views) as views_sum FROM `kostenlosspielen_posts` WHERE category2=".$category_id." ORDER BY game_views";
		$pageposts = $wpdb->get_results($query, OBJECT);
		foreach ($pageposts as $post){
			$game_views=$post->game_views;
			$sumTop=$sumTop+$game_views;
		}
		$pageposts = $wpdb->get_results($querySum, OBJECT);
		foreach ($pageposts as $post){
			$views_sum=$post->views_sum;
		}
		echo $no_top_post.' games (lượng view='.number_format($sumTop,0,',','.').') chiếm '.round($sumTop*100/$views_sum,2).'% toàn bộ games('.number_format($views_sum,0,',','.').')';*/
		
	}else{
	  echo  ' <form method="post" action="">
	  Thống kế % game_views  của top trò chơi trên tổng số view trong tất cả category cấp 2:
	  <div>Number of top Post:<input type="text" name="no_top_post" /></div>
      <div class="submit"><input type="submit" value="Update" name="category_stat_button" /></div>
	  </form>';  
	}	
}


function update_games(){
	global $wpdb, $wp_version;
	if (isset($_POST['create_images'])) {
		$post_meta_field=$_POST['post_meta_field']; //image
		$post_field=$_POST['post_field']; //game_image
		$count=0;
		$query = "SELECT ID FROM $wpdb->posts WHERE post_type='post'";
		$pageposts = $wpdb->get_results($query, OBJECT);
		foreach ($pageposts as $post){
			$data_field=get_post_meta($post->ID,$post_meta_field, true);
			$wpdb->update( 'kostenlosspielen_posts', array($post_field => $data_field),array( 'ID' => $post->ID ));
			$count++;
		}
		echo $count.' total updated !';
	}else{
	  echo  ' <form method="post" action="">
	  <div>Post_meta Field:<input type="text" name="post_meta_field" />  - > Post Field:<input type="text" name="post_field" /></div>
      <div class="submit"><input type="submit" value="Update" name="create_images" /></div>
	  </form>';  
	}	
}
function update_names(){
	global $wpdb, $wp_version;
		$count=0;
		$query = "SELECT ID FROM $wpdb->posts WHERE post_type='post' AND post_status = 'future'";
		$pageposts = $wpdb->get_results($query, OBJECT);
		foreach ($pageposts as $post){
			$query_update="UPDATE $wpdb->posts SET game_author='Lea Anders', game_email='support@kostenlosspielen.biz' WHERE ID=".$post->ID;
			$wpdb->query($query_update);
			$count++;
		}
		echo $count.' total updated !';
}

function update_category(){
	global $wpdb, $wp_version;
	if (isset($_POST['create_images'])) {
		$postnumber=$_POST['postnumber'];
		$count=0;
		$query = "SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post' ORDER BY ID";
		$pageposts = $wpdb->get_results($query, OBJECT);
		foreach ($pageposts as $post){
			$post_categories = wp_get_post_categories( $post->ID );
			foreach($post_categories as $c){
				$cat = get_category( $c );
				if($cat->parent >0){
					$category1=$cat->parent;
					$category2=$cat->cat_ID;			
					$wpdb->update( 'kostenlosspielen_posts', array( 'category1' => $category1,'category2' => $category2	),array( 'ID' => $post->ID ));
					$count++;
				}
			}
		}
		echo $count.' total updated !';
	}else{
	  echo  ' <form method="post" action="">
	  <div>Start with the number in Post:<input type="text" name="postnumber" /></div>
      <div class="submit"><input type="submit" value="Bat dau voi game so" name="create_images" /></div>
	  </form>';  
	}	
}
function image_sizes(){
	global $wpdb, $wp_version;
	if (isset($_POST['create_images'])) {
		$postnumber=$_POST['postnumber'];
		$query = "SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post' ORDER BY post_date LIMIT $postnumber,200";
		$pageposts = $wpdb->get_results($query, OBJECT);
		foreach ($pageposts as $post){
			$count++;
			$image_url=get_post_meta($post->ID,'image', true);
			$image_absolute='/kunden/378295_97072/kostenlosspielen'.wp_make_link_relative($image_url);
			$image_absolute_path=dirname($image_absolute);
			$image=getNameOfImage($image_url);
			createthumb($image_absolute,$image_absolute_path.'/'.$image['name'].'-100.'.$image['type'], 100, 75);
			createthumb($image_absolute,$image_absolute_path.'/'.$image['name'].'-75.'.$image['type'], 75, 57);		
			echo $count.'>fertig mit ID='.$post->ID.'<br />';
		}
	}else{
	  echo  ' <form method="post" action="">
	  <div>Start with the number in Post:<input type="text" name="postnumber" /></div>
      <div class="submit"><input type="submit" value="Create new images" name="create_images" /></div>
	  </form>';  
	}	
}

function getPostID(){
	global $wpdb, $wp_version;
	if (isset($_POST['imagename'])) {
		$imagename=strtolower($_POST['imagename']);
		$query = "SELECT * FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post'";
		$pageposts = $wpdb->get_results($query, OBJECT);
		foreach ($pageposts as $post){
			$image_url=get_post_meta($post->ID,'image', true);
			$pos=strpos($image_url,$imagename);
			if ($pos === false) {
				//echo "Khong tim thay file nay";
			} else {
				echo "PostID=".$post->ID;
			}			
		}
	}else{
	  echo  ' <form method="post" action="">
	  <div>The Imagename:<input type="text" name="imagename" /></div>
      <div class="submit"><input type="submit" value="getPostID" name="getPostID" /></div>
	  </form>';  
	}	
}
function category_list(){
	$args = array(
	'show_option_all'    => '',
	'orderby'            => 'name',
	'order'              => 'ASC',
	'style'              => 'list',
	'show_count'         => 0,
	'hide_empty'         => 1,
	'use_desc_for_title' => 1,
	'child_of'           => 0,
	'feed'               => '',
	'feed_type'          => '',
	'feed_image'         => '',
	'exclude'            => '',
	'exclude_tree'       => '',
	'include'            => '',
	'hierarchical'       => 1,
	'title_li'           => __( 'Categories' ),
	'show_option_none'   => __('No categories'),
	'number'             => null,
	'echo'               => 1,
	'depth'              => 0,
	'current_category'   => 0,
	'pad_counts'         => 0,
	'taxonomy'           => 'category',
	'walker'             => null
	); 
	echo wp_list_categories( $args );
}
function add_keywords(){
	global $wpdb, $wp_version;
	
	$query = "SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post'";
	$pageposts = $wpdb->get_results($query, OBJECT);
	foreach ($pageposts as $post){
		$key_draft=get_post_meta($post->ID, '_posts_rate_key',true);
		//echo $key_draft.'<br />';
		if($key_draft!=NULL){
			$key_main=get_post_meta($post->ID, 'posts_rate_key',true);
			//echo $key_main.'<br />';
			if($key_main==NULL){
				update_post_meta($post->ID, 'posts_rate_key',$key_draft);
			}
		}
	}
}
function update_heading(){
	global $wpdb, $wp_version;
	
	$query = "SELECT ID, post_content, post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post' ORDER BY `kostenlosspielen_posts`.`post_date`";
	$pageposts = $wpdb->get_results($query, OBJECT);
	foreach ($pageposts as $post){
		//echo $post->post_content.'----';
		//echo $post->post_title;
		$pos = strpos($post->post_content, 'Spielregeln <strong>'.$post->post_title.' </strong>');
		$pos1 = strpos($post->post_content, '<p>Spielregeln '.$post->post_title.'</p>');
		$pos2 = strpos($post->post_content, '<h2>Spielregeln '.$post->post_title.'</h2>');
		$pos3 = strpos($post->post_content, '<h2><h2>Spielregeln '.$post->post_title.'</h2></h2>');
		/*if (($pos == true)&&($pos2==false)) {*/
		if($pos ===false) {
			
		} else {
			$new_content=str_replace('Spielregeln <strong>'.$post->post_title.' </strong>','<h2>Spielregeln '.$post->post_title.'</h2>',$post->post_content);
			$my_post = array();
			$my_post['ID'] = $post->ID;
			$my_post['post_content'] = $new_content;
			//echo $new_content;
			wp_update_post( $my_post );
			echo $post->ID.'<br />';
			//echo $new_content.'<br />';*/
		}
	

		
	}
}

function exist_games(){
	global $wpdb, $wp_version;
	if (isset($_POST['check_exist'])) {
		$point=$_POST['point'];
		$args = array(
			    'numberposts' 	  => 500,
			    'offset'          => $point,
			    'orderby'         => 'post_date',
			    'order'           => 'DESC',
			    'post_type'       => 'post',
			    'post_status'     => 'draft' );
		$draft_posts = get_posts($args);
		//print_r($draft_posts);
		
		$query = "SELECT post_name FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post'";
		$pageposts = $wpdb->get_results($query, OBJECT);
		$post_arr=array();
		foreach ($pageposts as $post){
			$post_arr[]=$post->post_name;
		}
		$post_name=array();
		$count=0;
		$ID_text='';
		for($i=0;$i<sizeof($draft_posts);$i++){
			$post_slug=sanitize_title($draft_posts[$i]->post_title);
			//echo $post_slug.'<br />';
			if(in_array($post_slug,$post_arr))
			{
				echo $draft_posts[$i]->post_title.'<br />';
				$count++;	
				$ID_text = $ID_text. ','.$draft_posts[$i]->ID;		
			}
		}
		$ID_text=substr($ID_text,1);
	  ?>
	  <form method="post" action="">
	  <div>ID of exist:<input type="text" name="id_text" value="<?php echo $ID_text; ?>" /></div>
      <div class="submit"><input type="submit" value="Delete Existed games" name="delete_exist" /></div>
	  </form>
	  <?php 
		echo 'exist games in public '.$count;
	}elseif(isset($_POST['delete_exist'])){
		$id_text=$_POST['id_text'];
		$teile = explode(",", $id_text);
		foreach($teile as $teil){
			echo $teil.'<br />';
			wp_delete_post($teil);
		}		
	}else{
	  echo  '
	  <p>Check Exist game from position(500 Games for one check from Draft)</p>
	  <p>Input: Start Point of Draft game</p>	  
	  <form method="post" action="">
	  <div>Startpoint<input type="text" name="point" /> </div>
      <div class="submit"><input type="submit" value="Check Existed games" name="check_exist" /></div>
	  </form>';  
	}	
	
}
function getFlash($url){
	$html=getHTML($url);
	$pos1=strpos($html,'<embed');
	$pos2=strpos($html,'</embed>');
	$embed=substr($html,$pos1,$pos2-$pos1);
	$pos1=strpos($embed,'src=');
	$pos2=strpos($embed,'"',$pos1);
	$pos3=strpos($embed,'.swf');
	//return $pos1.'-'.$pos3;
	return substr($embed,$pos2+1,$pos3-$pos2).'swf';
	//return $embed;
}

function add_game_from_spielaffe(){
	global $wpdb, $wp_version;
	if (isset($_POST['add_games'])) {
		$url_input=$_POST['url_input'];
		echo 	getFlash($url_input);	
	}else{
	  echo  '
	  <p>Add multi games from Spielaffe.de WITHOUT DOWNLOAD</p>
	  <p>Input: URL of homepage(contains games)</p>	  
	  <p>Output: List of URL of games in spielaffe.de</p>	  
	  <form method="post" action="">
	  <div>Link from spielaffe.de:
		<input type="text" style="width:800px;" name="url_input" />
	  </div>
      <div class="submit"><input type="submit" value="Add news games" name="add_games" /></div>
	  </form>';  
		
	}
	
}

function replace_text(){
	global $wpdb, $wp_version;

	if (isset($_POST['assign_execute'])) {
	$start=$_POST['start'];
	$text_in=$_POST['text_in'];
	$text_out=$_POST['text_out'];
	$query_popular_games = "
	SELECT * FROM  $wpdb->posts WHERE post_status =  'publish'
	AND post_type =  'post'
	AND post_content LIKE '%".$text_in."%' AND ID > $start Order by ID ASC LIMIT 200"	;
//	echo $query_popular_games;
	$pageposts = $wpdb->get_results($query_popular_games, OBJECT);
	$count=0;$j=0;	
	foreach ($pageposts as $post){
		$count++;
		$new_content=str_replace($text_in, $text_out, $post->post_content);
		//print_r($post);
		//echo $post->ID.'<br />';
		//echo $count.'>text-in>'.$text_in.'>text-out'.$text_out.'<br />';
		$query_update="UPDATE $wpdb->posts SET post_content='".$new_content."' WHERE ID=".$post->ID;
		//echo $count.'>old>'.$post->post_content.'<br />';
		//echo $count.'>'.$new_content.'<br />';
		$wpdb->query($query_update);
		echo 'ID= '.$post->ID.'<br />';
		
	}
	echo 'Change '.$count.' Spiele';
			  	
			
	}else{
	  echo  '<form method="post" action="">
	  <div>Start Point:<input type="text" name="start" /></div>
	  <div>Text in Content <input type="text" name="text_in" /></div>
	  <div>Text for Replacing <input type="text" name="text_out" /></div>
	  	  
      <div class="submit"><input type="submit" value="Execute" name="assign_execute" /></div>
	  </form>';  
		
	}		
}

function add_punkt(){
	global $wpdb, $wp_version;
	//get all post without Rating
	$query_popular_games = "SELECT ID FROM  $wpdb->posts WHERE post_status='publish' AND post_type='post' ";

	$pageposts = $wpdb->get_results($query_popular_games, OBJECT);
	for($i=0;$i<sizeof($pageposts);$i++)
	{
		$post_id=$pageposts[$i]->ID;
		if(get_post_meta($post_id, 'ratings_users', true) == 0) {
			//Add 10 punkt to Game
			add_post_meta($post_id, 'ratings_users', '1', true);
			add_post_meta($post_id, 'ratings_score', '10', true);
			add_post_meta($post_id, 'ratings_average', '10', true);
		}//else {
			//echo '2-';
		//}
	}
}
function add_combination(){
	global $wpdb, $wp_version;

	if (isset($_POST['assign_execute'])) {
	$number=$_POST['number_of_execute']*27;
	$query_popular_games = "
	SELECT * FROM  $wpdb->posts WHERE ( post_author =1 OR post_author =2)
	AND post_status =  'publish'
	AND post_type =  'post'
	LIMIT ".$number.",27";
 	//echo $query_popular_games;
	$pageposts = $wpdb->get_results($query_popular_games, OBJECT);
	$count=0;	
	foreach ($pageposts as $post){
		$url=SITE_ROOT_URL."/wp-content/uploads/rest/rest".($_POST['number_of_execute']+1)."[$count].txt";
		$text_content = getHTML($url);
		$new_content=$post->post_content.'<br />'.mb_convert_encoding($text_content,"UTF-8", "auto");

		$query_update="UPDATE $wpdb->posts SET post_content='".$new_content."' WHERE ID=".$post->ID;
		//echo $query_update.'<br />';
		$wpdb->query($query_update);
		$count++;
		

	}
			  	
			
	}else{
	  echo  '<form method="post" action="">
	  <div>The number of excute <input type="text" name="number_of_execute" /></div>	  
      <div class="submit"><input type="submit" value="Execute" name="assign_execute" /></div>
	  </form>';  
		
	}		
}
function change_user(){
	global $wpdb, $wp_version,$post;	
	if (isset($_POST['assign_execute'])) {
	$author_id=$_POST['author_id'];
	$query_update="UPDATE $wpdb->posts SET post_author=12
	WHERE (post_status =  'future' OR post_status =  'publish' OR post_status =  'pending') AND post_author =".$author_id."";
	echo $query_update.'<br />';
	$arr=$wpdb->query($query_update);
	echo $arr.' updated ! ';
	}else{
			
 	echo  '<form method="post" action="">
	  <div>Author ID( phuonganh:69, toan:58, dat:52, baoanh:59, hien:42, giangduc: 65, minhanh:68, quynhly:64, others:12) <input type="text" name="author_id" /></div>	  
      <div class="submit"><input type="submit" value="Execute" name="assign_execute" /></div>
	  </form>';  
		
		
	}
}
function parseLink($link){
	$xpath = getXpath($link);
	$hrefs = $xpath->evaluate("/html/body/div/div/div/div/div//a");
	$arr=array();
	$arr_full=array();
	$j=0;
	  for ($i = 0; $i < $hrefs->length; $i++ ) 
	  {
			$link_url=$hrefs->item($i)->getAttribute('href');
			if((strpos($link_url,'spielen')>0)&&(strpos($link_url,'http')===false)&&(strpos($link_url,'bubble-shooter')===false)){
				if(!in_array($link_url,$arr)){
					$arr[$j]=$link_url;
					$arr_full[$j]='http://www.kostenlosspielen.net'.$link_url;
					$j++;
				}
				
			}
  	  }
		return $arr_full;
		
}
function delete_cache(){
	
	global $wpdb, $wp_version,$post;
	
			$query_popular_games="SELECT * FROM kostenlosspielen_posts
								WHERE post_type =  'post'
								AND post_status =  'publish'";
 
			$pageposts = $wpdb->get_results($query_popular_games, OBJECT);
			$arrPost=array();

			$arrCheck=array(SITE_ROOT_URL.'/triangle-tetris.html',SITE_ROOT_URL.'/panzer-parkour.html',SITE_ROOT_URL.'/mario-ice-skating.html',SITE_ROOT_URL.'/cristal-loid-tetris.html',SITE_ROOT_URL.'/bundesliga-elfmeter.html',SITE_ROOT_URL.'/super-fahrrad.html',SITE_ROOT_URL.'/schwerer-truck.html',SITE_ROOT_URL.'journey-of-enlightenment.html',SITE_ROOT_URL.'/roly-poly-cannon-3.html',SITE_ROOT_URL.'/mahjong-sudoku.html',SITE_ROOT_URL.'/3-linien-mahjong.html',SITE_ROOT_URL.'/mahjong-schwarz-weiss.html',SITE_ROOT_URL.'/mahjong-memory.html',SITE_ROOT_URL.'/10-mahjong.html',SITE_ROOT_URL.'/wp-content/uploads/2011/mirandaoutfit.html',SITE_ROOT_URL.'/wp-content/uploads/2011/06/index.html',SITE_ROOT_URL.'/mirandaoutfit.html',SITE_ROOT_URL.'/index.html',SITE_ROOT_URL.'/denkspiele/mahjong/mahjong-wahrsager.html',SITE_ROOT_URL.'/denkspiele/mahjong/mahjong-turm-2.html',SITE_ROOT_URL.'/denkspiele/mahjong/mahjong-imperium.html',SITE_ROOT_URL.'/denkspiele/mahjong-flower-tower.html',SITE_ROOT_URL.'/mahjong-mama-jongg.html',SITE_ROOT_URL.'/garten-mahjong-2.html',SITE_ROOT_URL.'/jaime-mahjong-ii.html',SITE_ROOT_URL.'/go.html',SITE_ROOT_URL.'/tower-blocks.html',SITE_ROOT_URL.'/quick-switch.html',SITE_ROOT_URL.'/quick-park.html',SITE_ROOT_URL.'/quarantine-defender.html',SITE_ROOT_URL.'/puzzle-safari.html',SITE_ROOT_URL.'/queens.html',SITE_ROOT_URL.'/puzzle-mania-lion-king.html',SITE_ROOT_URL.'/punching-trainer.html',SITE_ROOT_URL.'/puzzle-bingo.html',SITE_ROOT_URL.'/puppy-love.html',SITE_ROOT_URL.'/punch-britney.html',SITE_ROOT_URL.'/protect-your-planet.html',SITE_ROOT_URL.'/puffygirls-in-space.html',SITE_ROOT_URL.'/pubber.html',SITE_ROOT_URL.'/protect-the-war.html',SITE_ROOT_URL.'/prople.html',SITE_ROOT_URL.'/project-validus.html',SITE_ROOT_URL.'/professor-snape-dress-up.html',SITE_ROOT_URL.'/probe.html',SITE_ROOT_URL.'/princess-abella.html',SITE_ROOT_URL.'/prince-dress-up.html',SITE_ROOT_URL.'/presidentielle-2007.html',SITE_ROOT_URL.'/portapusher.html',SITE_ROOT_URL.'/president-rescue.html',SITE_ROOT_URL.'/popa-night.html',SITE_ROOT_URL.'/pop-pirates.html',SITE_ROOT_URL.'/polar-boar.html',SITE_ROOT_URL.'/pointless-game.html',SITE_ROOT_URL.'/plastic-attack.html',SITE_ROOT_URL.'/plague-of-kittens.html',SITE_ROOT_URL.'/planarity.html',SITE_ROOT_URL.'/planets.html',SITE_ROOT_URL.'/pirate-chains.html',SITE_ROOT_URL.'/pingo.html',SITE_ROOT_URL.'/pixelosis.html',SITE_ROOT_URL.'/pigeons-revenge-2.html',SITE_ROOT_URL.'/pimboli-game.html',SITE_ROOT_URL.'/pigeon-poo.html',SITE_ROOT_URL.'/pig-on-the-rocket.html',SITE_ROOT_URL.'/phoenix.html',SITE_ROOT_URL.'/perspectite.html',SITE_ROOT_URL.'/petrol-rush.html',SITE_ROOT_URL.'/phils-skyak-adventure.html',SITE_ROOT_URL.'/pepsi-max-breakout.html',SITE_ROOT_URL.'/perfect-fart.html',SITE_ROOT_URL.'/perky-island.html',SITE_ROOT_URL.'/peppys-victoria-beckham-dress-up.html',SITE_ROOT_URL.'/peppys-usher-dress-up.html',SITE_ROOT_URL.'/peppys-wentworth-miller-dress-up.html',SITE_ROOT_URL.'/peppys-spencer-smith-dress-up.html',SITE_ROOT_URL.'/peppys-tobey-maguire-dress-up.html',SITE_ROOT_URL.'/peppys-shaggy-dress-up.html',SITE_ROOT_URL.'/peppys-scarlett-johansson-dress-up.html',SITE_ROOT_URL.'/peppys-salma-hayek-dress-up.html',SITE_ROOT_URL.'/peppys-nicole-kidman-dress-up.html',SITE_ROOT_URL.'/peppys-paris-hilton-dress-up.html',SITE_ROOT_URL.'/peppys-paris-hilton-dress-up-2.html',SITE_ROOT_URL.'/peppys-milla-jovovich-dress-up.html',SITE_ROOT_URL.'/peppys-mira-sorvino-dress-up.html',SITE_ROOT_URL.'/peppys-liv-tyler-dress-up.html',SITE_ROOT_URL.'/peppys-meryl-streep-dress-up.html',SITE_ROOT_URL.'/peppys-miley-cyrus-dress-up.html',SITE_ROOT_URL.'/peppys-leah-remini-dress-up.html',SITE_ROOT_URL.'/peppys-lindsay-lohan-dress-up.html',SITE_ROOT_URL.'/peppys-kylie-minogue-dress-up.html',SITE_ROOT_URL.'/peppys-krista-allen-dress-up.html',SITE_ROOT_URL.'/peppys-kelly-clarkson-dress-up.html',SITE_ROOT_URL.'/peppys-josh-stone-dress-up.html',SITE_ROOT_URL.'/peppys-jessica-alba-dress-up.html',SITE_ROOT_URL.'/peppys-jamie-lee-curtis-dress-up.html',SITE_ROOT_URL.'/peppys-heather-locklear-dress-up.html',SITE_ROOT_URL.'/peppys-harry-potter-dress-up.html',SITE_ROOT_URL.'/peppys-eva-longoria-dress-up.html',SITE_ROOT_URL.'/peppys-elisha-cuthbert-dress-up.html',SITE_ROOT_URL.'/peppys-courtney-thorne-dress-up.html',SITE_ROOT_URL.'/peppys-cody-linley-dress-up.html',SITE_ROOT_URL.'/peppys-britney-spears-dress-up.html',SITE_ROOT_URL.'/peppys-barbara-streisand-dress-up.html',SITE_ROOT_URL.'/peppys-bridget-moynahan-dress-up.html',SITE_ROOT_URL.'/peppys-angelina-jolie-dress-up.html',SITE_ROOT_URL.'/peppy-sagittarius-girl.html',SITE_ROOT_URL.'/peppy-capricorn-girl.html',SITE_ROOT_URL.'/penguinsumo.html',SITE_ROOT_URL.'/penalty-shootout.html',SITE_ROOT_URL.'/penguin-header.html',SITE_ROOT_URL.'/pearls-before-swine.html',SITE_ROOT_URL.'/pearl-harbor.html',SITE_ROOT_URL.'/pearl-hunt.html',SITE_ROOT_URL.'/pazzo-francesco-in-escape-from-rakoth-dungeons.html',SITE_ROOT_URL.'/passing-judgment.html',SITE_ROOT_URL.'/parvathy-omanakuttan-femina-miss-india-world-2008.html',SITE_ROOT_URL.'/parking-mania.html',SITE_ROOT_URL.'/parking-perfection-3.html',SITE_ROOT_URL.'/parking-game.html',SITE_ROOT_URL.'/paris-hilton-makeup.html',SITE_ROOT_URL.'/parasite-x.html',SITE_ROOT_URL.'/park-soccer.html',SITE_ROOT_URL.'/paper-flight.html',SITE_ROOT_URL.'/paper-plane.html',SITE_ROOT_URL.'/pank-football.html',SITE_ROOT_URL.'/paper-boat-blowing.html',SITE_ROOT_URL.'/paper-airplane.html',SITE_ROOT_URL.'/paladin-dress-up.html',SITE_ROOT_URL.'/pancake-man.html',SITE_ROOT_URL.'/panda-balance.html',SITE_ROOT_URL.'/paintball.html',SITE_ROOT_URL.'/out-of-halloween.html',SITE_ROOT_URL.'/painter-madness.html',SITE_ROOT_URL.'/origins.html',SITE_ROOT_URL.'/oreo-extreme-creme.html',SITE_ROOT_URL.'/optus-tennis-challenge.html',SITE_ROOT_URL.'/orbital.html',SITE_ROOT_URL.'/operation-overdom.html',SITE_ROOT_URL.'/operation-get-fired.html',SITE_ROOT_URL.'/onsen-pingpong.html',SITE_ROOT_URL.'/onslaught-of-the-glignags.html',SITE_ROOT_URL.'/office-paintball.html',SITE_ROOT_URL.'/ollie.html',SITE_ROOT_URL.'/og-on-the-job.html',SITE_ROOT_URL.'/office-escape.html',SITE_ROOT_URL.'/obnoxius.html',SITE_ROOT_URL.'/not-in-contract.html',SITE_ROOT_URL.'/obama-protect-yourself.html',SITE_ROOT_URL.'/no-name-escape.html',SITE_ROOT_URL.'/ninja-pop.html',SITE_ROOT_URL.'/nike-apparel-dressup.html',SITE_ROOT_URL.'/ninjakid.html',SITE_ROOT_URL.'/night-vision-sniper.html',SITE_ROOT_URL.'/night-raptor.html',SITE_ROOT_URL.'/night-flying.html',SITE_ROOT_URL.'/nibbles.html',SITE_ROOT_URL.'/night-boarding.html',SITE_ROOT_URL.'/ngu.html',SITE_ROOT_URL.'/nerd-quest.html',SITE_ROOT_URL.'/neko-tama.html',SITE_ROOT_URL.'/neko-tower.html',SITE_ROOT_URL.'/nerd-makeover.html',SITE_ROOT_URL.'/my-name-is-blob.html',SITE_ROOT_URL.'/mysims-agents.html',SITE_ROOT_URL.'/mummy-down.html',SITE_ROOT_URL.'/mr-sandwich.html',SITE_ROOT_URL.'/muck-about-cupid.html',SITE_ROOT_URL.'/mr-and-mrs-smith.html',SITE_ROOT_URL.'/movie-connection.html',SITE_ROOT_URL.'/mr-hairy-face.html',SITE_ROOT_URL.'/moths.html',SITE_ROOT_URL.'/mountain-falls.html',SITE_ROOT_URL.'/mosquito-blaster.html',SITE_ROOT_URL.'/morbid.html',SITE_ROOT_URL.'/morbidus.html',SITE_ROOT_URL.'/moodys-magical-eye.html',SITE_ROOT_URL.'/mood-match.html',SITE_ROOT_URL.'/monster-memory.html',SITE_ROOT_URL.'/monster-munch.html',SITE_ROOT_URL.'/montgolfier.html',SITE_ROOT_URL.'/mixed-fruit-juice.html',SITE_ROOT_URL.'/mold.html',SITE_ROOT_URL.'/minigame-kaboom.html',SITE_ROOT_URL.'/mings-dress-room.html',SITE_ROOT_URL.'/mini-wave.html',SITE_ROOT_URL.'/mind-reader-astrological.html',SITE_ROOT_URL.'/mili-and-tary-against-war-2.html',SITE_ROOT_URL.'/miley-cyrus-dress-up-game.html',SITE_ROOT_URL.'/miley-cyrus.html',SITE_ROOT_URL.'/migros-eicatcher.html',SITE_ROOT_URL.'/miestas.html',SITE_ROOT_URL.'/mighty-b-backyard-habitat-heroes.html',SITE_ROOT_URL.'/micro-wars.html',SITE_ROOT_URL.'/micro-sports.html',SITE_ROOT_URL.'/micro-siege.html',SITE_ROOT_URL.'/mice.html',SITE_ROOT_URL.'/metro.html',SITE_ROOT_URL.'/meteor.html',SITE_ROOT_URL.'/metal-armor.html',SITE_ROOT_URL.'/merrelus.html',SITE_ROOT_URL.'/metal-arena.html',SITE_ROOT_URL.'/merge.html',SITE_ROOT_URL.'/memento.html',SITE_ROOT_URL.'/megaryder.html',SITE_ROOT_URL.'/meeting-number.html',SITE_ROOT_URL.'/mega-ryder.html',SITE_ROOT_URL.'/maze-stopper.html',SITE_ROOT_URL.'/mazegirl.html',SITE_ROOT_URL.'/medieval-massacre.html',SITE_ROOT_URL.'/maximus.html',SITE_ROOT_URL.'/maze-game-game-play-22.html',SITE_ROOT_URL.'/maze-man.html',SITE_ROOT_URL.'/marble-madness.html',SITE_ROOT_URL.'/maradona.html',SITE_ROOT_URL.'/march-madness.html',SITE_ROOT_URL.'/malachite.html',SITE_ROOT_URL.'/mama-fly.html',SITE_ROOT_URL.'/make-up-real-girl.html',SITE_ROOT_URL.'/makeup-essentials.html',SITE_ROOT_URL.'/makeover-a-teacher.html',SITE_ROOT_URL.'/madpac-underwater.html',SITE_ROOT_URL.'/make-an-animal.html',SITE_ROOT_URL.'/magic-gift-shop.html',SITE_ROOT_URL.'/madness-drag-and-drop.html',SITE_ROOT_URL.'/mad-pac.html',SITE_ROOT_URL.'/mad-pac-rabios.html',SITE_ROOT_URL.'/love-letter.html',SITE_ROOT_URL.'/lynx-bike.html',SITE_ROOT_URL.'/machete-chamber.html',SITE_ROOT_URL.'/lollys-candy-factory.html',SITE_ROOT_URL.'/lootmore.html',SITE_ROOT_URL.'/lll-mouse-racer.html',SITE_ROOT_URL.'/linkem.html',SITE_ROOT_URL.'/little-loki.html',SITE_ROOT_URL.'/little-sheperd.html',SITE_ROOT_URL.'/liley-girl-dressup.html',SITE_ROOT_URL.'/limbo.html',SITE_ROOT_URL.'/lightyear-alpha.html',SITE_ROOT_URL.'/lights.html',SITE_ROOT_URL.'/let-it-ride.html',SITE_ROOT_URL.'/left-or-right.html',SITE_ROOT_URL.'/last-breath-overwhelmed.html',SITE_ROOT_URL.'/leaving.html',SITE_ROOT_URL.'/labyrinth-ball.html',SITE_ROOT_URL.'/lamer-hunting.html',SITE_ROOT_URL.'/labyrinth.html',SITE_ROOT_URL.'/kwikshot.html',SITE_ROOT_URL.'/koulovacka.html',SITE_ROOT_URL.'/kristin-davis-makeover.html',SITE_ROOT_URL.'/korns-super-switch.html',SITE_ROOT_URL.'/know-your-strength.html',SITE_ROOT_URL.'/kokoris.html',SITE_ROOT_URL.'/kitchen-dressup.html',SITE_ROOT_URL.'/knight.html',SITE_ROOT_URL.'/kick-ups.html',SITE_ROOT_URL.'/kanonenkugel.html',SITE_ROOT_URL.'/kelly-candy-girl-dressup.html',SITE_ROOT_URL.'/kiss-the-boy.html',SITE_ROOT_URL.'/kebab-van.html',SITE_ROOT_URL.'/kcly-diamond.html',SITE_ROOT_URL.'/kayak-king.html',SITE_ROOT_URL.'/kaka-killer.html',SITE_ROOT_URL.'/kaboom.html',SITE_ROOT_URL.'/jungle-combat.html',SITE_ROOT_URL.'/juno-spore.html',SITE_ROOT_URL.'/julneomgisungames.html',SITE_ROOT_URL.'/jouer.html',SITE_ROOT_URL.'/jumping-bubble.html',SITE_ROOT_URL.'/jewel-hunter.html',SITE_ROOT_URL.'/jim-the-worm.html',SITE_ROOT_URL.'/jeff-the-archer.html',SITE_ROOT_URL.'/jennifer-morrison-dress-up.html',SITE_ROOT_URL.'/jessica-college-girl-dressup.html',SITE_ROOT_URL.'/jeannie-and-johnny.html',SITE_ROOT_URL.'/jedi-hunter.html',SITE_ROOT_URL.'/japanese-high-school.html',SITE_ROOT_URL.'/its-mine.html',SITE_ROOT_URL.'/japan-starwars.html',SITE_ROOT_URL.'/jazzy-annette-space-cadet.html',SITE_ROOT_URL.'/invasion-game.html',SITE_ROOT_URL.'/ipumpkin-the-pumpkin-land.html',SITE_ROOT_URL.'/indian-music-game.html',SITE_ROOT_URL.'/image-disorder-willa-holland.html',SITE_ROOT_URL.'/ichi.html',SITE_ROOT_URL.'/ignito-pulse.html',SITE_ROOT_URL.'/ill-blow-your-brains-out.html',SITE_ROOT_URL.'/i-can-hold-my-breath-forever.html',SITE_ROOT_URL.'/i-dont-even-game.html',SITE_ROOT_URL.'/hundreds.html',SITE_ROOT_URL.'/hungry-elf.html',SITE_ROOT_URL.'/hot-shot.html',SITE_ROOT_URL.'/how-to-be-a-graceful-girl.html',SITE_ROOT_URL.'/hot-tomato.html',SITE_ROOT_URL.'/hot-nail.html',SITE_ROOT_URL.'/hopalot-hobbit.html',SITE_ROOT_URL.'/hospital-escape.html',SITE_ROOT_URL.'/hollywood.html',SITE_ROOT_URL.'/home-run-boy.html',SITE_ROOT_URL.'/homecoming-dressup-game.html',SITE_ROOT_URL.'/hollywood-hall-of-fame-4.html',SITE_ROOT_URL.'/hit-the-teddy.html',SITE_ROOT_URL.'/hit-the-ball.html',SITE_ROOT_URL.'/high-dive.html',SITE_ROOT_URL.'/hit-the-looser.html',SITE_ROOT_URL.'/hexa.html',SITE_ROOT_URL.'/heli-attack-1.html',SITE_ROOT_URL.'/helen-bikini-dressup-game.html',SITE_ROOT_URL.'/heavens-hoodlum.html',SITE_ROOT_URL.'/hardware-hurl.html',SITE_ROOT_URL.'/hazard-2.html',SITE_ROOT_URL.'/hard-ball-boy.html',SITE_ROOT_URL.'/hansel-and-grethel-decoration.html',SITE_ROOT_URL.'/hank-on.html',SITE_ROOT_URL.'/halloween-costume-dress-up.html',SITE_ROOT_URL.'/hand-jibe.html',SITE_ROOT_URL.'/halloween-mask-matching.html',SITE_ROOT_URL.'/hair-dressing-salon-for-bald-men.html',SITE_ROOT_URL.'/hair-salon-decoration.html',SITE_ROOT_URL.'/hacky-sack-junior.html',SITE_ROOT_URL.'/hair-and-eyes.html',SITE_ROOT_URL.'/hacker.html',SITE_ROOT_URL.'/h2space.html',SITE_ROOT_URL.'/habibi.html',SITE_ROOT_URL.'/gulliup-keep-it-up.html',SITE_ROOT_URL.'/h-bounce.html',SITE_ROOT_URL.'/gyroball.html',SITE_ROOT_URL.'/great-game.html',SITE_ROOT_URL.'/gravibounce.html',SITE_ROOT_URL.'/gravity-off.html',SITE_ROOT_URL.'/grave-yard.html',SITE_ROOT_URL.'/graphics-are-everything.html',SITE_ROOT_URL.'/graff-gunner.html',SITE_ROOT_URL.'/gotham-girls-punch-the-bats.html',SITE_ROOT_URL.'/gossip-girl-match-game.html',SITE_ROOT_URL.'/goth-make-up.html',SITE_ROOT_URL.'/golf.html',SITE_ROOT_URL.'/goo-slasher.html',SITE_ROOT_URL.'/goal-the-ball.html',SITE_ROOT_URL.'/going-down.html',SITE_ROOT_URL.'/golden-clock-flash-fighter.html',SITE_ROOT_URL.'/go-green-go.html',SITE_ROOT_URL.'/go-santa.html',SITE_ROOT_URL.'/go-shopping.html',SITE_ROOT_URL.'/go-fishing.html',SITE_ROOT_URL.'/gluttony-2.html',SITE_ROOT_URL.'/girls-party.html',SITE_ROOT_URL.'/girl-make-up-2.html',SITE_ROOT_URL.'/girl-football.html',SITE_ROOT_URL.'/giraffe-attack.html',SITE_ROOT_URL.'/gillian-anderson-dress-up.html',SITE_ROOT_URL.'/gi-joe.html',SITE_ROOT_URL.'/get-flippy.html',SITE_ROOT_URL.'/get-a-life.html',SITE_ROOT_URL.'/germageddon.html',SITE_ROOT_URL.'/geogenius-usa.html',SITE_ROOT_URL.'/gembox.html',SITE_ROOT_URL.'/gate-gears.html',SITE_ROOT_URL.'/gawpsters.html',SITE_ROOT_URL.'/geek-or-serial-killer.html',SITE_ROOT_URL.'/gams-descent.html',SITE_ROOT_URL.'/gangsters-war.html',SITE_ROOT_URL.'/galactic-sokoban.html',SITE_ROOT_URL.'/gambling-room-escape.html',SITE_ROOT_URL.'/gamma-bros.html',SITE_ROOT_URL.'/gabriella-dressup.html',SITE_ROOT_URL.'/funky-clothing-dressup.html',SITE_ROOT_URL.'/fura-fura-neko.html',SITE_ROOT_URL.'/fruitanoid.html',SITE_ROOT_URL.'/fry-up-some-bacon.html',SITE_ROOT_URL.'/freezedstyle.html',SITE_ROOT_URL.'/free-the-mouse.html',SITE_ROOT_URL.'/frag-the-lag.html',SITE_ROOT_URL.'/fr-quick-park.html',SITE_ROOT_URL.'/four-square.html',SITE_ROOT_URL.'/four-seasons-dressup.html',SITE_ROOT_URL.'/flying-dango.html',SITE_ROOT_URL.'/forever-fashion-dressup.html',SITE_ROOT_URL.'/fly-sui.html',SITE_ROOT_URL.'/fly-away-rabbit-2.html',SITE_ROOT_URL.'/fly-plane.html',SITE_ROOT_URL.'/fly-away-rabbit.html',SITE_ROOT_URL.'/flower-nourishing.html',SITE_ROOT_URL.'/flood-fill.html',SITE_ROOT_URL.'/flipped-out.html',SITE_ROOT_URL.'/flash-pacman.html',SITE_ROOT_URL.'/flexi-combat.html',SITE_ROOT_URL.'/fishy-game.html',SITE_ROOT_URL.'/fish-eat-fish.html',SITE_ROOT_URL.'/firedragon.html',SITE_ROOT_URL.'/fishing-game.html',SITE_ROOT_URL.'/fire-it-up.html',SITE_ROOT_URL.'/fire-crackers.html',SITE_ROOT_URL.'/find-the-objects-musium.html',SITE_ROOT_URL.'/find-the-shells-in-aquarium.html',SITE_ROOT_URL.'/fingerprint-specialist-2.html',SITE_ROOT_URL.'/find-the-difference-game-play-3.html',SITE_ROOT_URL.'/find-people.html',SITE_ROOT_URL.'/field-goal.html',SITE_ROOT_URL.'/fetch-with-zipper.html',SITE_ROOT_URL.'/fighting.html',SITE_ROOT_URL.'/feed-the-birds.html',SITE_ROOT_URL.'/feline-detective-dress-up.html',SITE_ROOT_URL.'/feed-britney.html',SITE_ROOT_URL.'/fawn-hunter.html',SITE_ROOT_URL.'/fatstone-pyramid.html',SITE_ROOT_URL.'/fat-boy.html',SITE_ROOT_URL.'/fatherhood-the-game.html',SITE_ROOT_URL.'/fatal-puzzle.html',SITE_ROOT_URL.'/fashion-bunny.html',SITE_ROOT_URL.'/fashion-extravaganza.html',SITE_ROOT_URL.'/farmer-mcjoy.html',SITE_ROOT_URL.'/f1211.html',SITE_ROOT_URL.'/fantasy-dolls-human.html',SITE_ROOT_URL.'/fantasy-dolls-elf.html',SITE_ROOT_URL.'/extreme-particle-suite.html',SITE_ROOT_URL.'/experimental-game.html',SITE_ROOT_URL.'/exorbis.html',SITE_ROOT_URL.'/evil-kneivel.html',SITE_ROOT_URL.'/evil-knevil.html',SITE_ROOT_URL.'/even-dead-men-die.html',SITE_ROOT_URL.'/eskimo.html',SITE_ROOT_URL.'/eunice.html',SITE_ROOT_URL.'/escape-from-terrorist.html',SITE_ROOT_URL.'/escape-the-uberkids.html',SITE_ROOT_URL.'/escape-chesnut-room.html',SITE_ROOT_URL.'/endice.html',SITE_ROOT_URL.'/equilibrium.html',SITE_ROOT_URL.'/emogotchi-2.html',SITE_ROOT_URL.'/emily-flower-girl-dressup.html',SITE_ROOT_URL.'/elv-is-black-2.html',SITE_ROOT_URL.'/eggventure-the-sperm-assault.html',SITE_ROOT_URL.'/ek-penalty.html',SITE_ROOT_URL.'/duck-fight.html',SITE_ROOT_URL.'/dudes-are.html',SITE_ROOT_URL.'/easter-egged.html',SITE_ROOT_URL.'/drunk-driver.html',SITE_ROOT_URL.'/drunk-mo.html',SITE_ROOT_URL.'/drum-lessons.html',SITE_ROOT_URL.'/drull.html',SITE_ROOT_URL.'/drew-barrymore.html',SITE_ROOT_URL.'/drivers-license-practice.html',SITE_ROOT_URL.'/driving-home-at-easter.html',SITE_ROOT_URL.'/drop-da-beatz.html',SITE_ROOT_URL.'/dressup-simulator-version-1.html',SITE_ROOT_URL.'/drew-barrymore-dress-up.html',SITE_ROOT_URL.'/dress-the-olsens.html',SITE_ROOT_URL.'/dress-up-myuu.html',SITE_ROOT_URL.'/dress-up-samara.html',SITE_ROOT_URL.'/down-the-chimney.html',SITE_ROOT_URL.'/doughnut-launcher.html',SITE_ROOT_URL.'/downtown-diva-dress-up.html',SITE_ROOT_URL.'/double-jeu.html',SITE_ROOT_URL.'/doodle-physics.html',SITE_ROOT_URL.'/dont-shoot-me.html',SITE_ROOT_URL.'/dolly-parton.html',SITE_ROOT_URL.'/dog-sitter.html',SITE_ROOT_URL.'/dog-game.html',SITE_ROOT_URL.'/dirty-rotters.html',SITE_ROOT_URL.'/dinos-dream.html',SITE_ROOT_URL.'/dingle-ball.html',SITE_ROOT_URL.'/dinner-decoration.html',SITE_ROOT_URL.'/digital-genius.html',SITE_ROOT_URL.'/dig-in-dirty.html',SITE_ROOT_URL.'/dick-cheneys-texas-takedown.html',SITE_ROOT_URL.'/detonate.html',SITE_ROOT_URL.'/defend-your-dirt.html',SITE_ROOT_URL.'/defender-game.html',SITE_ROOT_URL.'/deep-chamber-escape.html',SITE_ROOT_URL.'/dead-duck.html',SITE_ROOT_URL.'/dazzling-nails.html',SITE_ROOT_URL.'/daruma-game.html',SITE_ROOT_URL.'/darts-game.html',SITE_ROOT_URL.'/darkness-the-cage.html',SITE_ROOT_URL.'/darkness-2.html',SITE_ROOT_URL.'/danielle-dressup.html',SITE_ROOT_URL.'/danger-wheels.html',SITE_ROOT_URL.'/daddy-day-camp-watergun-fun.html',SITE_ROOT_URL.'/cyad.html',SITE_ROOT_URL.'/cute-sweet-dressup.html',SITE_ROOT_URL.'/cupids-quest.html',SITE_ROOT_URL.'/crystal-island.html',SITE_ROOT_URL.'/crystal-wizard.html',SITE_ROOT_URL.'/cupids-crush.html',SITE_ROOT_URL.'/cup-your-balls.html',SITE_ROOT_URL.'/crush-maniacs.html',SITE_ROOT_URL.'/crossblocks.html',SITE_ROOT_URL.'/crickler.html',SITE_ROOT_URL.'/crazy-shooter.html',SITE_ROOT_URL.'/crazy-rollercoaster.html',SITE_ROOT_URL.'/crazy-block-breaker.html',SITE_ROOT_URL.'/crackers.html',SITE_ROOT_URL.'/crates-3d.html',SITE_ROOT_URL.'/cow-fly.html',SITE_ROOT_URL.'/core-salvage.html',SITE_ROOT_URL.'/corridor.html',SITE_ROOT_URL.'/cookie-festival.html',SITE_ROOT_URL.'/cool-guy-dressup.html',SITE_ROOT_URL.'/constellation.html',SITE_ROOT_URL.'/connexions.html',SITE_ROOT_URL.'/connect-4.html',SITE_ROOT_URL.'/comschool-goal.html',SITE_ROOT_URL.'/complex-path.html',SITE_ROOT_URL.'/comet-buster.html',SITE_ROOT_URL.'/collector.html',SITE_ROOT_URL.'/color-compact.html',SITE_ROOT_URL.'/cold-room-escape.html',SITE_ROOT_URL.'/cola-ducks-exprese.html',SITE_ROOT_URL.'/cocoon-island.html',SITE_ROOT_URL.'/coconut-joe-soccer-shootout.html',SITE_ROOT_URL.'/coco-penalty-shootout.html',SITE_ROOT_URL.'/cockroaches-battle-royale.html',SITE_ROOT_URL.'/cocktail-quest.html',SITE_ROOT_URL.'/clowns.html',SITE_ROOT_URL.'/clouds-and-climates.html',SITE_ROOT_URL.'/clash-of-the-star-fighter.html',SITE_ROOT_URL.'/closure.html',SITE_ROOT_URL.'/clone-commando.html',SITE_ROOT_URL.'/clinic-escape.html',SITE_ROOT_URL.'/climb-the-snow-capped-mountain.html',SITE_ROOT_URL.'/clickxxy-road.html',SITE_ROOT_URL.'/clever-count.html',SITE_ROOT_URL.'/clever-frog.html',SITE_ROOT_URL.'/christmas-game.html',SITE_ROOT_URL.'/claire-danes-makeover.html',SITE_ROOT_URL.'/chomp-n-chew.html',SITE_ROOT_URL.'/chopper-drop.html',SITE_ROOT_URL.'/chiqui.html',SITE_ROOT_URL.'/chicken-invaders.html',SITE_ROOT_URL.'/children-of-the-atom.html',SITE_ROOT_URL.'/chernobil-rabbits.html',SITE_ROOT_URL.'/chicken-and-chocolate.html',SITE_ROOT_URL.'/cheeseburger.html',SITE_ROOT_URL.'/cheeky-worm-hunt.html',SITE_ROOT_URL.'/chaos-chamber.html',SITE_ROOT_URL.'/champis.html',SITE_ROOT_URL.'/central-and-south-of-america.html',SITE_ROOT_URL.'/caverns-of-doom-last-mission.html',SITE_ROOT_URL.'/cave-hunter.html',SITE_ROOT_URL.'/celebs-in-designer-clothes.html',SITE_ROOT_URL.'/catherine.html',SITE_ROOT_URL.'/catch-me-caports-sneakers.html',SITE_ROOT_URL.'/catch-the-rats-2.html',SITE_ROOT_URL.'/catch-the-chicks.html',SITE_ROOT_URL.'/catch-a-thief.html',SITE_ROOT_URL.'/cat-baseball.html',SITE_ROOT_URL.'/catch-fish.html',SITE_ROOT_URL.'/cash-dash.html',SITE_ROOT_URL.'/card-game.html',SITE_ROOT_URL.'/card-throwing.html',SITE_ROOT_URL.'/callow-drift.html',SITE_ROOT_URL.'/cannon-star.html',SITE_ROOT_URL.'/bule.html',SITE_ROOT_URL.'/butterfly-girl-dressup.html',SITE_ROOT_URL.'/cable-miner.html',SITE_ROOT_URL.'/bubblepop.html',SITE_ROOT_URL.'/breaker360.html',SITE_ROOT_URL.'/book-worm.html',SITE_ROOT_URL.'/book-racer.html',SITE_ROOT_URL.'/block-twister.html',SITE_ROOT_URL.'/bird-hunting.html',SITE_ROOT_URL.'/arctic-river-adventure.html',SITE_ROOT_URL.'/angelina-jolie-makeover.html',SITE_ROOT_URL.'/apocalyptic-differences.html',SITE_ROOT_URL.'/abstract-sea.html',SITE_ROOT_URL.'/501-dart-challenge.html',SITE_ROOT_URL.'/zz-tops-beard-brawl.html',SITE_ROOT_URL.'/zymbols.html',SITE_ROOT_URL.'/zorro-team.html',SITE_ROOT_URL.'/zombie-world.html',SITE_ROOT_URL.'/zoo-decor-game.html',SITE_ROOT_URL.'/zeitenwende.html',SITE_ROOT_URL.'/zero.html',SITE_ROOT_URL.'/zen-zoop.html',SITE_ROOT_URL.'/zac-efron-dress-up.html',SITE_ROOT_URL.'/youth-style-dressup.html',SITE_ROOT_URL.'/yummy-turkey.html',SITE_ROOT_URL.'/young-cardinals.html',SITE_ROOT_URL.'/young-and-cute-outfit.html',SITE_ROOT_URL.'/yeti-hammer-throw.html',SITE_ROOT_URL.'/yokoruta.html',SITE_ROOT_URL.'/yeti-sports-8-jungle-swing.html',SITE_ROOT_URL.'/xtreme-tugboating.html',SITE_ROOT_URL.'/xtreme-qb-challenge.html',SITE_ROOT_URL.'/xtreme-cliff-diving.html',SITE_ROOT_URL.'/x-chains.html',SITE_ROOT_URL.'/xmas-gift-breaker.html',SITE_ROOT_URL.'/xplay.html',SITE_ROOT_URL.'/world-oldsports.html',SITE_ROOT_URL.'/worm-race.html',SITE_ROOT_URL.'/wrath-of-the-empire.html',SITE_ROOT_URL.'/world-of-sports.html',SITE_ROOT_URL.'/world-of-pain-puzzle.html',SITE_ROOT_URL.'/wood-carving-road-runner.html',SITE_ROOT_URL.'/wood-carving-mickey.html',SITE_ROOT_URL.'/word-search-2.html',SITE_ROOT_URL.'/witch-ball.html',SITE_ROOT_URL.'/wood-carving-dopez.html',SITE_ROOT_URL.'/winter-stars.html',SITE_ROOT_URL.'/windbell.html',SITE_ROOT_URL.'/wiggi-trash-pickerupper.html',SITE_ROOT_URL.'/willy-wonka-shoot-em-up.html',SITE_ROOT_URL.'/whack-a-boss.html',SITE_ROOT_URL.'/whack-a-groundhog.html',SITE_ROOT_URL.'/wei-ziya-miss-china-2007.html',SITE_ROOT_URL.'/welcome-to-air-hockey.html',SITE_ROOT_URL.'/wendell-baker-story.html',SITE_ROOT_URL.'/wedding-bouquets.html',SITE_ROOT_URL.'/water-bomb.html',SITE_ROOT_URL.'/watermelon-hunter.html',SITE_ROOT_URL.'/warhammer-bb-the-game.html',SITE_ROOT_URL.'/washbasin-ride.html',SITE_ROOT_URL.'/watchmen-dress-up.html',SITE_ROOT_URL.'/vr-squad.html',SITE_ROOT_URL.'/wakeboarding.html',SITE_ROOT_URL.'/vr-quarterback-challenge.html',SITE_ROOT_URL.'/virtual-band-2000.html',SITE_ROOT_URL.'/virus-panic.html',SITE_ROOT_URL.'/virtual-3d-city.html',SITE_ROOT_URL.'/virtua-worm.html',SITE_ROOT_URL.'/victoria-beckham-dress-up.html',SITE_ROOT_URL.'/viking-raiders-of-the-lost-monastary.html',SITE_ROOT_URL.'/vampires-crypt.html',SITE_ROOT_URL.'/vanessa-hudgens-dress-up.html',SITE_ROOT_URL.'/valerie-begue-miss-france-2008.html',SITE_ROOT_URL.'/unicycle-balancer.html',SITE_ROOT_URL.'/unicycle-rider.html',SITE_ROOT_URL.'/ultimate-chopper.html',SITE_ROOT_URL.'/ultimate-spring-break.html',SITE_ROOT_URL.'/underground.html',SITE_ROOT_URL.'/ugly-stick.html',SITE_ROOT_URL.'/ufo-shooting-girl.html',SITE_ROOT_URL.'/ufo-recording.html',SITE_ROOT_URL.'/udi-v20.html',SITE_ROOT_URL.'/two-rooms.html',SITE_ROOT_URL.'/uchuwars.html',SITE_ROOT_URL.'/twinz.html',SITE_ROOT_URL.'/twist-and-shoot.html',SITE_ROOT_URL.'/twice-as-bounce.html',SITE_ROOT_URL.'/twiddlestix.html',SITE_ROOT_URL.'/twang.html',SITE_ROOT_URL.'/turtitrop.html',SITE_ROOT_URL.'/turtle-herder.html',SITE_ROOT_URL.'/turkey-shooting.html',SITE_ROOT_URL.'/turbostar.html',SITE_ROOT_URL.'/turret-pong.html',SITE_ROOT_URL.'/turbo-racer.html',SITE_ROOT_URL.'/tunnel-maze.html',SITE_ROOT_URL.'/truth-battle.html',SITE_ROOT_URL.'/trucks-fun.html',SITE_ROOT_URL.'/trouble-fright-club.html',SITE_ROOT_URL.'/troglodite.html',SITE_ROOT_URL.'/trn-47-subversion.html',SITE_ROOT_URL.'/tricky-paris.html',SITE_ROOT_URL.'/tribal-artifacts.html',SITE_ROOT_URL.'/trippy-maze.html',SITE_ROOT_URL.'/tremclads-holiday-part-time.html',SITE_ROOT_URL.'/trendy-aquarius-maedchen.html',SITE_ROOT_URL.'/treasure-quest.html',SITE_ROOT_URL.'/tree-troopers.html',SITE_ROOT_URL.'/treasure-hunt-2.html',SITE_ROOT_URL.'/treasure-hunt-game.html',SITE_ROOT_URL.'/trampie.html',SITE_ROOT_URL.'/transcripted.html',SITE_ROOT_URL.'/trapr.html',SITE_ROOT_URL.'/tracey-nicolaas-miss-aruba-2007.html',SITE_ROOT_URL.'/tour-de-france.html',SITE_ROOT_URL.'/totomi.html',SITE_ROOT_URL.'/totally-spies-memory-spies.html',SITE_ROOT_URL.'/topple.html',SITE_ROOT_URL.'/torture-chamber.html',SITE_ROOT_URL.'/tommy-tooth.html',SITE_ROOT_URL.'/tong.html',SITE_ROOT_URL.'/too-cool-fashion-makeover.html',SITE_ROOT_URL.'/tony-the-turtle-and-the-island-adventure.html',SITE_ROOT_URL.'/tomb-trapper.html',SITE_ROOT_URL.'/toilet-quest.html',SITE_ROOT_URL.'/tobby-balance.html',SITE_ROOT_URL.'/toaster.html',SITE_ROOT_URL.'/titoonic-snowboard.html',SITE_ROOT_URL.'/tipsy-drive.html',SITE_ROOT_URL.'/tire-toss.html',SITE_ROOT_URL.'/tiny-combat-2.html',SITE_ROOT_URL.'/tiny-gp.html',SITE_ROOT_URL.'/tinkerbell-dress-up-8.html',SITE_ROOT_URL.'/tinkerbell-barbie-dress-up.html',SITE_ROOT_URL.'/time-warp.html',SITE_ROOT_URL.'/time-fighter.html',SITE_ROOT_URL.'/time-travel.html',SITE_ROOT_URL.'/through-the-revolving-door.html',SITE_ROOT_URL.'/thrust-ii.html',SITE_ROOT_URL.'/throw-donust-at-an-old-guy.html',SITE_ROOT_URL.'/theme-park-thriller.html',SITE_ROOT_URL.'/the-wing.html',SITE_ROOT_URL.'/the-treb-challenge.html',SITE_ROOT_URL.'/the-tarot-enigma.html',SITE_ROOT_URL.'/the-swiffer.html',SITE_ROOT_URL.'/the-wesleys-kitchen-game.html',SITE_ROOT_URL.'/the-recycler.html',SITE_ROOT_URL.'/the-simple-game-2.html',SITE_ROOT_URL.'/the-rather-difficult-game.html',SITE_ROOT_URL.'/the-pumpkin.html',SITE_ROOT_URL.'/the-queens-jewels.html',SITE_ROOT_URL.'/the-portal.html',SITE_ROOT_URL.'/the-package.html',SITE_ROOT_URL.'/the-payback.html',SITE_ROOT_URL.'/the-piranha.html',SITE_ROOT_URL.'/the-orphanage-mission.html',SITE_ROOT_URL.'/the-matrix-dock-defense.html',SITE_ROOT_URL.'/the-ningotiators.html',SITE_ROOT_URL.'/the-master-of-packaging.html',SITE_ROOT_URL.'/the-long-jump.html',SITE_ROOT_URL.'/the-last-wave.html',SITE_ROOT_URL.'/the-lost-bride.html',SITE_ROOT_URL.'/the-last-evasion.html',SITE_ROOT_URL.'/the-last-apple.html',SITE_ROOT_URL.'/the-impossibly-hard-quiz.html',SITE_ROOT_URL.'/the-kill-kar.html',SITE_ROOT_URL.'/the-impossibly-hard-quiz-3.html',SITE_ROOT_URL.'/the-hedgehogs.html',SITE_ROOT_URL.'/the-great-cookie-drop.html',SITE_ROOT_URL.'/the-hidden-ring.html',SITE_ROOT_URL.'/the-grabasnack-hurdles.html',SITE_ROOT_URL.'/the-flood.html',SITE_ROOT_URL.'/the-escape-game.html',SITE_ROOT_URL.'/the-evils.html',SITE_ROOT_URL.'/the-dream-game.html',SITE_ROOT_URL.'/the-chickenator.html',SITE_ROOT_URL.'/the-coins.html',SITE_ROOT_URL.'/the-click-five-super-switch.html',SITE_ROOT_URL.'/the-competitor.html',SITE_ROOT_URL.'/the-cave-of-death.html',SITE_ROOT_URL.'/the-call.html',SITE_ROOT_URL.'/the-bloodinator.html',SITE_ROOT_URL.'/the-blackout.html',SITE_ROOT_URL.'/the-bad-plastic-surgery-game.html',SITE_ROOT_URL.'/the-ant-bully.html',SITE_ROOT_URL.'/the-arena.html',SITE_ROOT_URL.'/the-athlete.html',SITE_ROOT_URL.'/the-ant-arena.html',SITE_ROOT_URL.'/terrorlympics-bullet-proof-punk.html',SITE_ROOT_URL.'/test-platformer.html',SITE_ROOT_URL.'/terrace-escape.html',SITE_ROOT_URL.'/tasha-supermodel-dressup.html',SITE_ROOT_URL.'/tennis-guru.html',SITE_ROOT_URL.'/tennis-smash.html',SITE_ROOT_URL.'/swing-and-set-terminator-salvation.html',SITE_ROOT_URL.'/swordsman.html',SITE_ROOT_URL.'/sweet-switch.html',SITE_ROOT_URL.'/sweet-street-beauty-salon.html',SITE_ROOT_URL.'/sweatshop-boy.html',SITE_ROOT_URL.'/survival-dress-up.html',SITE_ROOT_URL.'/survival-game.html',SITE_ROOT_URL.'/supuzzle.html',SITE_ROOT_URL.'/super-sweatshop-mastar.html',SITE_ROOT_URL.'/supermarket.html',SITE_ROOT_URL.'/super-raccoon.html',SITE_ROOT_URL.'/super-perfectoprop.html',SITE_ROOT_URL.'/super-mario-strikers.html',SITE_ROOT_URL.'/super-koala.html',SITE_ROOT_URL.'/super-derrick.html',SITE_ROOT_URL.'/super-chicken.html',SITE_ROOT_URL.'/super-alpha-soup.html',SITE_ROOT_URL.'/sunshine-dressup.html',SITE_ROOT_URL.'/summer-forest.html',SITE_ROOT_URL.'/suitcase-skyway.html',SITE_ROOT_URL.'/sub-2.html',SITE_ROOT_URL.'/street-fight-game.html',SITE_ROOT_URL.'/street-and-party-style.html',SITE_ROOT_URL.'/stpx.html',SITE_ROOT_URL.'/stone-falls.html',SITE_ROOT_URL.'/stickya-adventurya.html',SITE_ROOT_URL.'/stickman-jones.html',SITE_ROOT_URL.'/stickbrix.html',SITE_ROOT_URL.'/steve-jobs-dressup.html',SITE_ROOT_URL.'/start-wars.html',SITE_ROOT_URL.'/starbot-17.html',SITE_ROOT_URL.'/star-grabber.html',SITE_ROOT_URL.'/star-gazer.html',SITE_ROOT_URL.'/stairway-to-heaven.html',SITE_ROOT_URL.'/stackz.html',SITE_ROOT_URL.'/spy-sitter.html',SITE_ROOT_URL.'/spuddys-reel-deal.html',SITE_ROOT_URL.'/sprinkle-duty.html',SITE_ROOT_URL.'/spring-summer-midseason-time.html',SITE_ROOT_URL.'/spookiz.html',SITE_ROOT_URL.'/spill-the-beans.html',SITE_ROOT_URL.'/spider-x-2-royal-lunch.html',SITE_ROOT_URL.'/spider-solitaire.html',SITE_ROOT_URL.'/speed-x.html',SITE_ROOT_URL.'/speed-freak.html',SITE_ROOT_URL.'/sparks.html',SITE_ROOT_URL.'/sparks-recharged.html',SITE_ROOT_URL.'/space-xuttle.html',SITE_ROOT_URL.'/sparks-and-dust.html',SITE_ROOT_URL.'/space-girls-singing.html',SITE_ROOT_URL.'/sourdough-sam-in-eggcatcher.html',SITE_ROOT_URL.'/space-bugs.html',SITE_ROOT_URL.'/soundscape-blast.html',SITE_ROOT_URL.'/sort-my-tiles-flushed-away.html',SITE_ROOT_URL.'/sort-my-tiles-everyone-hero.html',SITE_ROOT_URL.'/soopa-sprinta.html',SITE_ROOT_URL.'/solarsaurs.html',SITE_ROOT_URL.'/sokolan.html',SITE_ROOT_URL.'/soccerpong.html',SITE_ROOT_URL.'/soccer-fan.html',SITE_ROOT_URL.'/soap-bubble.html',SITE_ROOT_URL.'/snowman-hunter.html',SITE_ROOT_URL.'/snowfight.html',SITE_ROOT_URL.'/snowballs.html',SITE_ROOT_URL.'/snow-siege.html',SITE_ROOT_URL.'/snow-fight.html',SITE_ROOT_URL.'/sniper-global-mercenary.html',SITE_ROOT_URL.'/snakeman-steve.html',SITE_ROOT_URL.'/snap-crackle-and-pops-1200-m.html',SITE_ROOT_URL.'/snack-attack.html',SITE_ROOT_URL.'/smith-in-work.html',SITE_ROOT_URL.'/smiley-blast.html',SITE_ROOT_URL.'/small-white-lymphocyte.html',SITE_ROOT_URL.'/smack-the-wabbit.html',SITE_ROOT_URL.'/slumboy.html',SITE_ROOT_URL.'/sloyd.html',SITE_ROOT_URL.'/slit-your-wrists.html',SITE_ROOT_URL.'/slingshot-santa.html',SITE_ROOT_URL.'/slide.html',SITE_ROOT_URL.'/slap-the-ref.html',SITE_ROOT_URL.'/skyship-pepelac.html',SITE_ROOT_URL.'/sky-marauder.html',SITE_ROOT_URL.'/sky-diver-dress-up.html',SITE_ROOT_URL.'/skirmish.html',SITE_ROOT_URL.'/skating-down-shit-street.html',SITE_ROOT_URL.'/skateboarder.html',SITE_ROOT_URL.'/sixty.html',SITE_ROOT_URL.'/sk8park.html',SITE_ROOT_URL.'/sinjid-battle-arena.html',SITE_ROOT_URL.'/simpsons-magic-ball.html',SITE_ROOT_URL.'/simone-make-up.html',SITE_ROOT_URL.'/shuffle-the-penguin.html',SITE_ROOT_URL.'/shuffle-swuffle.html',SITE_ROOT_URL.'/shuriken-escape.html',SITE_ROOT_URL.'/shredhead.html',SITE_ROOT_URL.'/shop-n-dress-path-sketching.html',SITE_ROOT_URL.'/shoplifter.html',SITE_ROOT_URL.'/show-good-basketball-game.html',SITE_ROOT_URL.'/shooting-the-fly.html',SITE_ROOT_URL.'/shootgun-skeet.html',SITE_ROOT_URL.'/shoe-defense.html',SITE_ROOT_URL.'/shoot-the-gatso.html',SITE_ROOT_URL.'/shoot-em.html',SITE_ROOT_URL.'/sheert-wilders.html',SITE_ROOT_URL.'/sheepteroids.html',SITE_ROOT_URL.'/shape-in-gap.html',SITE_ROOT_URL.'/sexy-and-luxurious-summer.html',SITE_ROOT_URL.'/scull-catch.html',SITE_ROOT_URL.'/serenity.html',SITE_ROOT_URL.'/schwarz-angriff-zerstoerung.html',SITE_ROOT_URL.'/school-ready-dressup.html',SITE_ROOT_URL.'/scarlett-johansson-makeover.html',SITE_ROOT_URL.'/scarlet-horizon.html',SITE_ROOT_URL.'/save-the-chicks.html',SITE_ROOT_URL.'/sarkar-bus.html',SITE_ROOT_URL.'/save-my-robotos.html',SITE_ROOT_URL.'/sam-surfing.html',SITE_ROOT_URL.'/ryu-komori.html',SITE_ROOT_URL.'/salchunggi.html',SITE_ROOT_URL.'/sacha-scott-miss-bahamas-2008.html',SITE_ROOT_URL.'/russian-jeep.html',SITE_ROOT_URL.'/runes-of-shalak.html',SITE_ROOT_URL.'/run-run-shoot.html',SITE_ROOT_URL.'/run-elephant-run.html',SITE_ROOT_URL.'/run-chicken-run.html',SITE_ROOT_URL.'/rugby-ruck-it.html',SITE_ROOT_URL.'/rumble-ball-field-4.html',SITE_ROOT_URL.'/rufus-ii.html',SITE_ROOT_URL.'/rotation.html',SITE_ROOT_URL.'/rudolfs-revenge.html',SITE_ROOT_URL.'/rope-jumping.html',SITE_ROOT_URL.'/rofl-attack.html',SITE_ROOT_URL.'/rogue-cupid.html',SITE_ROOT_URL.'/robot-soccer.html',SITE_ROOT_URL.'/rocket-mx.html',SITE_ROOT_URL.'/river-game.html',SITE_ROOT_URL.'/rockin-soccer.html',SITE_ROOT_URL.'/riku-lostart-taiken.html',SITE_ROOT_URL.'/rigelian-hotshots.html',SITE_ROOT_URL.'/return-of-the-squid.html',SITE_ROOT_URL.'/reno-911-excessive-force.html',SITE_ROOT_URL.'/riddle-school-4.html',SITE_ROOT_URL.'/rebuzz.html',SITE_ROOT_URL.'/rebeca-moreno-miss-el-salvador-2008.html',SITE_ROOT_URL.'/reach-the-skies.html',SITE_ROOT_URL.'/real-surf.html',SITE_ROOT_URL.'/rayray-parade.html',SITE_ROOT_URL.'/rap-attack.html',SITE_ROOT_URL.'/ramps.html',SITE_ROOT_URL.'/ragdoll-lincoln.html',SITE_ROOT_URL.'/rafting-game.html',SITE_ROOT_URL.'/raid-gaza.html',SITE_ROOT_URL.'/rachel-bilson-makeover.html',SITE_ROOT_URL.'/rachel-stripes-dressup.html',SITE_ROOT_URL.'/radial.html',SITE_ROOT_URL.'/r-shot-version-3.html',SITE_ROOT_URL.'/rachel-bilson-make-up.html',SITE_ROOT_URL.'/raccoon-rush.html',SITE_ROOT_URL.'/quix-2.html',SITE_ROOT_URL.'/quix.html',SITE_ROOT_URL.'/quiet-magic-2.html',SITE_ROOT_URL.'/mahjong-sudoku.html',SITE_ROOT_URL.'/3-linien-mahjong.html',SITE_ROOT_URL.'/mahjong-schwarz-weiss.html',SITE_ROOT_URL.'/mahjong-memory.html',SITE_ROOT_URL.'/10-mahjong.html',SITE_ROOT_URL.'/mahjong-mama-jongg.html',SITE_ROOT_URL.'/garten-mahjong-2.html',SITE_ROOT_URL.'/jaime-mahjong-ii.html');
  		    foreach ($pageposts as $post){
			   $arrPost[]=get_permalink();
			}
			$query_popular_games="SELECT * FROM kostenlosspielen_posts
								WHERE post_type =  'post'
								AND post_status =  'draft'";
			$pageposts = $wpdb->get_results($query_popular_games, OBJECT);
			  foreach ($pageposts as $post){
			   $arrPost[]=SITE_ROOT_URL.'/'.sanitize_title($post->post_title).'.html';
			}
			//print_r($arrPost);
			$public=0;$remove=0;
			for($i=0;$i<sizeof($arrCheck);$i++){
				$new=substr($arrCheck[$i],0,strlen($arrCheck[$i])-5).'-done.html';
				if(in_array($arrCheck[$i],$arrPost)||in_array($new,$arrPost)){
					$public++;	

				}else{
					echo '<div>'.$arrCheck[$i].'</div>';
						$remove++;				
				}
			}
			echo 'Tong can remove'.$remove;
			echo 'Tong can publish'.$public;
			
   
}

function list_games(){
	global $wpdb, $wp_version;

	if (isset($_POST['assign_games'])) {
		$category=$_POST['category'];
$query_popular_games = "
	SELECT ID FROM $wpdb->posts
	LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
	LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
	LEFT JOIN $wpdb->terms ON($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id)
	WHERE $wpdb->terms.name = '".$category."'
	AND $wpdb->term_taxonomy.taxonomy = 'category'
	AND $wpdb->posts.post_status = 'publish'
	AND $wpdb->posts.post_type = 'post'
";   
//echo $query_popular_games;
			$pageposts = $wpdb->get_results($query_popular_games, OBJECT);
			
			foreach ($pageposts as $post){
				echo get_permalink($post->ID).'<br />';
			}
			  	
			
	}else{
	  echo  '<form method="post" action="">
	  <div>Category Name<input type="text" name="category" /></div>	  
      <div class="submit"><input type="submit" value="Assign post to author" name="assign_games" /></div>
	  </form>';  
		
	}		
}
function assign_post(){
	global $wpdb, $wp_version;

	if (isset($_POST['assign_games'])) {
		$author=$_POST['user'];
		$authorID=get_user_by(login,$author)->ID;
		$category=$_POST['category'];
		if(($_POST['exclude']==NULL)||(trim($_POST['exclude'])=='')){
		}else{
			$exclude=explode(",", $_POST['exclude']);
		}
$query_popular_games = "
	SELECT ID FROM $wpdb->posts
	LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
	LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
	LEFT JOIN $wpdb->terms ON($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id)
	WHERE $wpdb->terms.name = '".$category."'
	AND $wpdb->term_taxonomy.taxonomy = 'category'
	AND $wpdb->posts.post_status = 'draft'
	AND $wpdb->posts.post_type = 'post'
";   
//echo $query_popular_games;
			$pageposts = $wpdb->get_results($query_popular_games, OBJECT);
			
			foreach ($pageposts as $post){
			if(sizeof($exclude)==0){
				$query_update="UPDATE $wpdb->posts SET post_author='".$authorID."' WHERE ID=".$post->ID;
				$count++;				
			}else{
				if(!in_array($post->ID,$exclude)){
				$query_update="UPDATE $wpdb->posts SET post_author='".$authorID."' WHERE ID=".$post->ID;
				$count++;	
				}
			}
			$wpdb->query($query_update);
			}
			  	
		echo 'Total Games to Asign to '.$author.': '.$count;
	
	}else{
	  echo  '<form method="post" action="">
	  <div>Author User:<input type="text" name="user" /></div>
	  <div>Category Name<input type="text" name="category" /></div>	  
	  <div>Exclude PostID:<input type="text" name="exclude" /></div>
      <div class="submit"><input type="submit" value="Assign post to author" name="assign_games" /></div>
	  </form>';  
		
	}	
}
function getURL1001($link){
		$returnArr=array();
		$xpath = getXpath($link);
		$hrefs = $xpath->evaluate("/html/body/div/div/div/div/div/div/div/div/div/ul/li//a");
		for($i=0;$i<$hrefs->length;$i++)
		{
			$returnArr[]=trim($hrefs->item($i)->getAttribute('href'));
		}
		$hrefs = $xpath->evaluate("/html/body/div/div/div/div/div/div/div/div/div[@class=\"mainMain mainMainSpecialTop\"]/div/ul/li//a");
		for($i=0;$i<$hrefs->length;$i++)
		{
			$returnArr[]=trim($hrefs->item($i)->getAttribute('href'));
		}

	return $returnArr;	
}
function getURLjetztspielen($link){
		$returnArr=array();
		$xpath = getXpath($link);
		$hrefs = $xpath->evaluate("/html/body/div/div/div/div/div/div/div/ul/div/li/div[@class=\"game-data\"]//a[@class=\"title\"]");
		for($i=0;$i<$hrefs->length;$i++)
		{
			$returnArr[]='http://www.jetztspielen.de'.trim($hrefs->item($i)->getAttribute('href'));
		}
	return $returnArr;	
}
function getURLspielaffe($link){
		$returnArr=array();
		$xpath = getXpath($link);
		$hrefs = $xpath->evaluate("/html/body//a[@class=\"gameContainerWithBackground__textcontainer_left\"]");
		for($i=0;$i<$hrefs->length;$i++)
		{
			$returnArr['url'][]='http://www.spielaffe.de'.trim($hrefs->item($i)->getAttribute('href'));
			$returnArr['name'][]=trim($hrefs->item($i)->getAttribute('title'));
		}
		$hrefs = $xpath->evaluate("/html/body//a[@class=\"gameContainerWithBackground__textcontainer_left_big\"]");
		for($i=0;$i<$hrefs->length;$i++)
		{
			$returnArr['url'][]='http://www.spielaffe.de'.trim($hrefs->item($i)->getAttribute('href'));
			$returnArr['name'][]=trim($hrefs->item($i)->getAttribute('title'));
		}

	return $returnArr;	
}
function getInfospielaffe($link){
		$returnInfo=array();
		$xpath = getXpath($link);
		$hrefs = $xpath->evaluate("/html/body//div[@class=\"contentArea\"]");
		$returnInfo['intro']=trim($hrefs->item(5)->nodeValue);
		$hrefs = $xpath->evaluate("/html/body//div[@class=\"game__imageContainer\"]/img");
		$returnInfo['image']=trim($hrefs->item($i)->getAttribute('src'));
		$returnInfo['swf']=getFlash($link);
	return $returnInfo;	
}

function getIMGjetztspielen($link){
		$returnArr=array();
		$xpath = getXpath($link);
		$hrefs = $xpath->evaluate("/html/body/div/div/div/div/div/div/div/ul/div/li/div/div/a/img");
		for($i=0;$i<$hrefs->length;$i++){
			if(strlen($hrefs->item($i)->getAttribute('data-src'))>7){
			$returnArr[]=trim($hrefs->item($i)->getAttribute('data-src'));
			}else{
			$returnArr[]=trim($hrefs->item($i)->getAttribute('src'));
			}
		}
	return $returnArr;	
}
function getInfojetzt($link){
		$xpath = getXpath($link);
		$hrefs = $xpath->evaluate("/html/body/div/div/div/div/div/div/h2");
		$array['name']=trim($hrefs->item(0)->nodeValue);

		$hrefs = $xpath->evaluate("/html/body/div/div/div/div/div/div/div/div/div/div/table/tbody/tr/td[@class=\"tc-about-cnt\"]");
		$array['intro']='Beschreibung:'.trim($hrefs->item(0)->nodeValue).'Anleitung:';
		$hrefs = $xpath->evaluate("/html/body/div/div/div/div/div/div/div/div/div/div/table/tbody/tr/td[@class=\"tc-manual-cnt\"]");
		$array['intro']=$array['intro'].trim($hrefs->item(0)->nodeValue);
		return $array;
}
function getSWFjetzt($link){
		$xpath = getXpath($link);
		$hrefs = $xpath->evaluate("/html/body");
		$text=trim($hrefs->item(0)->nodeValue);
		//print_r($text);
		$pos1=strpos($text,'flashobj_mc');
		$text=substr($text,$pos1);
		$pos2=strpos($text,'.swf');
		$text=substr($text,0,$pos2).'.swf';
		$pos3=strpos($text,'http://');
		$swf=trim(substr($text,$pos3));
		if($swf==NULL){return NULL;
		}else{ return $swf;}
}
function getSWFspielaffe($link){
		$xpath = getXpath($link);
		$hrefs = $xpath->evaluate("/html/body");
		$text=trim($hrefs->item(0)->nodeValue);
		print_r($text);
		/*$pos1=strpos($text,'flashobj_mc');
		$text=substr($text,$pos1);
		$pos2=strpos($text,'.swf');
		$text=substr($text,0,$pos2).'.swf';
		$pos3=strpos($text,'http://');
		$swf=trim(substr($text,$pos3));
		if($swf==NULL){return NULL;
		}else{ return $swf;}*/
}

function getSWFjetztspielen($link){
		$link='http://www.jetztspielen.de/spiel/Magische-Safari.html';
		$xpath = getXpath($link);
		$hrefs = $xpath->evaluate("/html/body/div[@id='flashobj']");
		$text=trim($hrefs->item(0)->nodeValue);
		print_r($text);
}

function add_category_spielaffe(){
	global $wpdb, $wp_version;
		
	if (isset($_POST['add_games'])) {
		$link=$_POST['link'];
		$urls=getURLspielaffe($link);
		$sub_category=$_POST['sub_category'];
		$category=$_POST['category'];
		$author_id=$_POST['author_id'];
		$query= "
			SELECT post_title FROM $wpdb->posts	WHERE ($wpdb->posts.post_status = 'future' OR $wpdb->posts.post_status = 'draft' OR $wpdb->posts.post_status = 'publish')
			AND $wpdb->posts.post_type = 'post' 
		";   
		$pageposts = $wpdb->get_results($query, OBJECT);
		foreach ($pageposts as $post){
			$exist_arr[]=strtolower(trim($post->post_title));
		}
		//$exist_posts = get_posts($args);
		$no_insert=0;
		for($i=0;$i<sizeof($urls['url']);$i++){
			$url=$urls['url'][$i];
			$name=$urls['name'][$i];
			$info=getInfospielaffe($url);
			$swf=$info['swf'];

				if((!in_array(strtolower($name),$exist_arr))&&($swf!=NULL)&&($swf!='swf')){
					//echo $arr_links[$i].'<br />';
					$currentdate = date ("Y/m");	
					$flash=$swf;
					$intro=$info['intro']; 
					$img=$info['image'];
					$path_parts=pathinfo($img); 
					$imghttp=get_bloginfo('home').'/wp-content/uploads/'.$currentdate.'/'.$path_parts['basename'];
					$path_parts=pathinfo($flash); 
					$flashhttp=get_bloginfo('home').'/wp-content/uploads/'.$currentdate.'/'.$path_parts['basename'];
					echo $flash.'<br />';
					echo $img.'<br />';
					//create Post
					$new_post=array(
						'post_title' => $name,
						'post_content' => $intro,
						'post_status' => 'draft',
						'post_author' => $author_id,
						'post_type' =>'post',
						'post_date' => date("Y-m-d H:i:s"),
						'post_category' => array($category, $sub_category),
						'post_date_gmt' => date("Y-m-d H:i:s")
					);
					
					$post_id=wp_insert_post($new_post);
					//create a Post Meta like flash, how to play, width, height, image
					if($post_id>0){
					update_post_meta($post_id,'flash',$flashhttp);
					update_post_meta($post_id,'image',$imghttp);
					$no_insert++;
					}
				}
			
		}
		echo 'Inserted more '.$no_insert.' games';
	}else{
	  echo  '<form method="post" action="">
	  Link from spielaffe.de
	  <input type="text" name="link" />
	  <br />
	  <div>ID of Category in kostenlosspielen.biz<br />Action Spiele:385|Denkspiele:417|Geschicklichkeitsspiele:394|Abenteuer:422|Kartenspiele:404|Mädchen Spiele:410|Rennspiele:430|Sport Spiele:431|Weitere Spiele:261<br /><input type="text" name="category" /></div>
	  <br />
	  <div>ID of Sub Category in kostenlosspielen.biz<br />
	  Action Spiele :::Fliegen & Schießen(4301)|Spiderman(4268)|Roboter(4240)|Sniper(4241)|Batman(4239)|Asteroids(2534)|Space Invaders(4187)|Piraten(4208)|Mafia(4209)|Counter Strike(4191)|Ninja Spiele(4192)|Tanks(3067)|Ballerspiele:389|Bomberman Spiele:388|Flugzeug Spiele:391|Kampfspiele:387|Kriegspiele:390|Turmverteidigung:392|Verschiedene Actionspiele:393<br />
	  Denkspiele ::: Point & Click: 1935|Mahjong Spiele:104|Schach Spiele:418|Sudoku Spiele:419|Unblock Me:420|Verschiedene Denkspiele:421 
	  <br />
	  Geschicklichkeitsspiele :::Gold Miner(1310)|Konzentrationsspiele(4269)|Bubbles Spiele:397|Breakout Spiele:401|Pacman Spiele:395|Parkspiele:399|Pinball Spiele:400|Puzzle Spiele:271|Reaktion Spiele:402|Snake Spiele:398|Tetris Spiele:169|Verschiedene Geschick:403 <br />
	  Abenteuer ::: Springen&Schießen(4580)|Sammeln & Fliegen(4581)|Ausweichen & Laufen(4582)|Fluchtspiele:3925|Puzzlen & Laufen:3924|Rollenspiele:3923|Sammeln & Laufen:3926|Sonic:3927|Mario Spiele:75 | Verschiedene Abenteuer:423 <br />
	  Kartenspiele ::: Blackjack Spiele:406|Memory Spiele:408|Solitär Spiele:407|Verschiedene Kartenspiele:409<br />Mädchen Spiele ::: Lernspiele:1949|Anzielspiele:413|Barbiespiele:447|Dekoration:411|Liebe Spiele:250|Malen Spiele:412|Pferde Spiele:1742|Tier Spiele:414|Verschiedene Mädchenspiele:415<br />Rennspiele ::: Autorennen:425|Boot Rennen:428|Motocross Spiele:426|Motorrad Spiele:427|Verschieden Rennspiele:429<br />Sportspiele ::: Basketball:433|Billard:342|Bowling:435|Boxen:436|Fussball:432|Golf:437|Ski:438|Tennis:434|Verschiedene Sport:439 <br />
	  Weitere Spiele:Lernspiele(4705)|2 Spieler(3818)|Farm-Spiele(3894)|Ritter(2263) <br />
	  <input type="text" name="sub_category" /></div>

  	  <div>ID of Author(luat:20,leon:24,steve:25, quangvinh@tae:1)<input type="text" name="author_id" /></div>
      <div class="submit"><input type="submit" value="Add news games" name="add_games" /></div>
	  </form>';  
		
	}	
}


function add_category_jetztspielen(){
	global $wpdb, $wp_version;
		
	if (isset($_POST['add_games'])) {
		$link=$_POST['link'];
		$urls=getURLjetztspielen($link);
		$imgs=getIMGjetztspielen($link);
		//print_r($imgs);
		$sub_category=$_POST['sub_category'];
		$category=$_POST['category'];
		$author_id=$_POST['author_id'];
		$query= "
			SELECT post_title FROM $wpdb->posts	WHERE ($wpdb->posts.post_status = 'future' OR $wpdb->posts.post_status = 'draft' OR $wpdb->posts.post_status = 'publish')
			AND $wpdb->posts.post_type = 'post' 
		";   
		$pageposts = $wpdb->get_results($query, OBJECT);
		foreach ($pageposts as $post){
			$exist_arr[]=strtolower(trim($post->post_title));
		}
		//$exist_posts = get_posts($args);
		$no_insert=0;

		for($i=0;$i<sizeof($urls);$i++){
			//$swf=getSWFjetzt($urls[$i]);
			if(strpos($urls[$i],'/spiel/')!==false){
			$swf=getSWFjetzt($urls[$i]);
			$info=getInfojetzt($urls[$i]);
				if((!in_array(strtolower($info['name']),$exist_arr))&&($swf!=NULL)&&(strlen($swf)>7)){
					//echo $arr_links[$i].'<br />';
					$currentdate = date ("Y/m");	
					$name=$info['name'];
					$flash=$swf;
					$intro=$info['intro']; 
					$img=$imgs[$i];
					$path_parts=pathinfo($img); 
					$imghttp=get_bloginfo('home').'/wp-content/uploads/'.$currentdate.'/'.$path_parts['basename'];
					$path_parts=pathinfo($flash); 
					$flashhttp=get_bloginfo('home').'/wp-content/uploads/'.$currentdate.'/'.$path_parts['basename'];
					echo $flash.'<br />';
					echo $img.'<br />';
					//create Post
					$new_post=array(
						'post_title' => $name,
						'post_content' => $intro,
						'post_status' => 'draft',
						'post_author' => $author_id,
						'post_type' =>'post',
						'post_date' => date("Y-m-d H:i:s"),
						'post_category' => array($category, $sub_category),
						'post_date_gmt' => date("Y-m-d H:i:s")
					);
					
					$post_id=wp_insert_post($new_post);
					//create a Post Meta like flash, how to play, width, height, image
					if($post_id>0){
					update_post_meta($post_id,'flash',$flashhttp);
					update_post_meta($post_id,'image',$imghttp);
					$no_insert++;
					}
				}
			}
		}
		echo 'Inserted more '.$no_insert.' games';
	}else{
	  echo  '<form method="post" action="">
	  Link from jetztspielen.de
	  <input type="text" name="link" />
	  <br />
	  <div>ID of Category in kostenlosspielen.biz<br />Action Spiele:385|Denkspiele:417|Geschicklichkeitsspiele:394|Abenteuer:422|Kartenspiele:404|Mädchen Spiele:410|Rennspiele:430|Sport Spiele:431|Weitere Spiele:261<br /><input type="text" name="category" /></div>
	  <br />
	  <div>ID of Sub Category in kostenlosspielen.biz<br />
	  Action Spiele :::Fliegen & Schießen(4301)|Spiderman(4268)|Roboter(4240)|Sniper(4241)|Batman(4239)|Asteroids(2534)|Space Invaders(4187)|Piraten(4208)|Mafia(4209)|Counter Strike(4191)|Ninja Spiele(4192)|Tanks(3067)|Ballerspiele:389|Bomberman Spiele:388|Flugzeug Spiele:391|Kampfspiele:387|Kriegspiele:390|Turmverteidigung:392|Verschiedene Actionspiele:393<br />
	  Denkspiele ::: Point & Click: 1935|Mahjong Spiele:104|Schach Spiele:418|Sudoku Spiele:419|Unblock Me:420|Verschiedene Denkspiele:421 
	  <br />
	  Geschicklichkeitsspiele :::Gold Miner(1310)|Konzentrationsspiele(4269)|Bubbles Spiele:397|Breakout Spiele:401|Pacman Spiele:395|Parkspiele:399|Pinball Spiele:400|Puzzle Spiele:271|Reaktion Spiele:402|Snake Spiele:398|Tetris Spiele:169|Verschiedene Geschick:403 <br />
	  Abenteuer ::: Springen&Schießen(4580)|Sammeln & Fliegen(4581)|Ausweichen & Laufen(4582)|Fluchtspiele:3925|Puzzlen & Laufen:3924|Rollenspiele:3923|Sammeln & Laufen:3926|Sonic:3927|Mario Spiele:75 | Verschiedene Abenteuer:423 <br />
	  Kartenspiele ::: Blackjack Spiele:406|Memory Spiele:408|Solitär Spiele:407|Verschiedene Kartenspiele:409<br />Mädchen Spiele ::: Lernspiele:1949|Anzielspiele:413|Barbiespiele:447|Dekoration:411|Liebe Spiele:250|Malen Spiele:412|Pferde Spiele:1742|Tier Spiele:414|Verschiedene Mädchenspiele:415<br />Rennspiele ::: Autorennen:425|Boot Rennen:428|Motocross Spiele:426|Motorrad Spiele:427|Verschieden Rennspiele:429<br />Sportspiele ::: Basketball:433|Billard:342|Bowling:435|Boxen:436|Fussball:432|Golf:437|Ski:438|Tennis:434|Verschiedene Sport:439 <br />
	  Weitere Spiele:2 Spieler(3818)|Farm-Spiele(3894)|Ritter(2263) <br />
	  <input type="text" name="sub_category" /></div>

  	  <div>ID of Author(luat:20,leon:24,steve:25, quangvinh@tae:1)<input type="text" name="author_id" /></div>
      <div class="submit"><input type="submit" value="Add news games" name="add_games" /></div>
	  </form>';  
		
	}	
}
	
function getURLY8($content){
/*$content='<div class="item thumb" id="item_71">
    <a href="/games/farm_stand_math" data-url="http://media.y8.com/system/contents/71/original/farm_stand_math.swf" title="Farm Stand Math">

      <img alt="Farm_stand_math" src="http://img.y8.com/system/screenshots/71/original/farm_stand_math.jpg" />
      Farm Stand Math
</a>
        <p class="item-caption">
  Spielbewertung:
  <strong>78.52%</strong>
</p>

</div>
  <div class="item thumb" id="item_598">
    <a href="/games/the_great_escape" data-url="http://media.y8.com/system/contents/598/original/thegreatescape.swf" title="The Great Escape">

      <img alt="Thegreatescape" src="http://img.y8.com/system/screenshots/598/original/thegreatescape.jpg" />
      The Great Escape
</a>
        <p class="item-caption">
  Spielbewertung:
  <strong>86.21%</strong>
</p>

</div>
  <div class="item thumb" id="item_1598">
    <a href="/games/robo_farmer" data-url="http://media.y8.com/system/contents/1598/original/RoboFarmer.swf" title="Robo Farmer">

      <img alt="Robofarmer" src="http://img.y8.com/system/screenshots/1598/original/robofarmer.gif" />
      Robo Farmer
</a>
        <p class="item-caption">
  Spielbewertung:
  <strong>84.92%</strong>
</p>';*/

//$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
$reg_exUrl = "/\"\/games(\/\S*)?/";
preg_match_all($reg_exUrl,$content,$text);

return $text[0];
}

function add_category_y8(){
	global $wpdb, $wp_version;
		
	if (isset($_POST['add_games'])) {
		$content=$_POST['content'];
		//print_r($content);
		$urls=getURLY8($content);
		//print_r($urls);
		
		$sub_category=$_POST['sub_category'];
		$category=$_POST['category'];
		$author_id=$_POST['author_id'];
		$query= "
			SELECT game_name_en FROM $wpdb->posts	WHERE ($wpdb->posts.post_status = 'future' OR $wpdb->posts.post_status = 'draft' OR $wpdb->posts.post_status = 'publish')
			AND $wpdb->posts.post_type = 'post' 
		";   
			$pageposts = $wpdb->get_results($query, OBJECT);
			foreach ($pageposts as $post){
				$exist_arr[]=strtolower(trim($post->game_name_en));
			}
		//$exist_posts = get_posts($args);
		$no_insert=0;
		for($i=0;$i<sizeof($urls);$i++){
			$y=substr($urls[$i],1,strlen($urls[$i])-3);
			$url=trim('http://de.y8.com'.$y);
			//$url= http://de.y8.com/games/sudoku
			$info=getInfoY8($url);
			if((!in_array(strtolower($info['name']),$exist_arr))&&($info!=NULL)){
				//echo $arr_links[$i].'<br />';
				//echo $info['name'].'<br />';
				if(strtoupper($info['how_to_play'])!='STEUERUNG DER ANIMATION:'){
					$currentdate = date ("Y/m");	
					$name=$info['name'];
					$name   = esc_sql( $name );
					$flash=$info['swf'];
					$intro=$info['description'].'.'.$info['how_to_play']; 
					$img=$info['img'];
					$path_parts=pathinfo($img); 
					$imghttp=get_bloginfo('home').'/wp-content/uploads/'.$currentdate.'/'.$path_parts['basename'];
					$path_parts=pathinfo($flash); 
					$flashhttp=get_bloginfo('home').'/wp-content/uploads/'.$currentdate.'/'.$path_parts['basename'];
					echo $flash.'<br />';
					echo $img.'<br />';
					//create Post
					$new_post=array(
						'post_title' => $name,
				     	'post_content' => $intro,
				     	'post_status' => 'draft',
				     	'post_author' => $author_id,
				     	'post_type' =>'post',
				     	'post_date' => date("Y-m-d H:i:s"),
				     	'post_category' => array($category, $sub_category),
				     	'post_date_gmt' => date("Y-m-d H:i:s")
					);
					
					$post_id=wp_insert_post($new_post);
					//create a Post Meta like flash, how to play, width, height, image
					if($post_id>0){
					$insert_query=	"UPDATE kostenlosspielen_posts SET game_name_en = '".$name."', game_image = '".$imghttp."', game_flash = '".$flashhttp."' WHERE ID = ".$post_id;
					//echo $insert_query;
					$wpdb->query($insert_query);
					$no_insert++;
			      	}
		      	}
			}
		}
		
		echo 'Inserted more '.$no_insert.' games';
	}else{
	  echo  '<form method="post" action="">
	  Source-Code Text from y8.com: (Search tren Y8, sau do post Source-Code doan List of Games)
	  <textarea rows="20" cols="160" name="content"></textarea>
	  <br />
	  <div>ID of Category in kostenlosspielen.biz<br />
	  Action Spiele:385|Denkspiele:417|Geschicklichkeitsspiele:394|Abenteuer:422|Kartenspiele:404|Mädchen Spiele:410|Rennspiele:430|Sport Spiele:431|Weitere Spiele:261|Tiere & Cartoon:4033 <br /><input type="text" name="category" /></div>
	  <br />
	  <div>ID of Sub Category in kostenlosspielen.biz<br />
	  Action Spiele :::Spiderman(4268)|Konzentrationsspiele(4269)|Roboter(4240)|Sniper(4241)|Batman(4239)|Asteroids(2534)|Space Invaders(4187)|Piraten(4208)|Mafia(4209)|Counter Strike(4191)|Ninja Spiele(4192)|Tanks(3067)|Ballerspiele:389|Bomberman Spiele:388|Flugzeug Spiele:391|Kampfspiele:387|Kriegspiele:390|Turmverteidigung:392|Verschiedene Actionspiele:393<br />
	  Denkspiele ::: Wortspiele(4149),Point & Click: 1935|Mahjong Spiele:104|Schach Spiele:418|Sudoku Spiele:419|Unblock Me:420|Verschiedene Denkspiele:421 <br />
	  Geschicklichkeitsspiele ::: Bubbles Spiele:397|Breakout Spiele:401|Pacman Spiele:395|Parkspiele:399|Pinball Spiele:400|Puzzle Spiele:271|Reaktion Spiele:402|Snake Spiele:398|Tetris Spiele:169|Verschiedene Geschick:403 <br />
	  Abenteuer ::: Mario Spiele:75 | Geister:4800| Verschiedene Abenteuer:423 <br />
	  Brettspiele(404)|Roulette(1664)|Kartenspiele(569)|Casino(4172)|Blackjack Spiele:406|Memory Spiele:408|Solitär Spiele:407|Verschiedene Kartenspiele:409<br />
	  Mädchen Spiele ::: Makeup(4389),Lernspiele:1949|Anzielspiele:413|Barbiespiele:447|Dekoration:411|Liebe Spiele:250|Malen Spiele:412|Pferde Spiele:1742|Tier Spiele:414|Verschiedene Mädchenspiele:415<br />
	  Rennspiele ::: Truck(12421),Zug(4649), Fahrrad(11819), Formel 1(2114)|Autorennen:425|Boot Rennen:428|Motocross Spiele:426|Motorrad Spiele:427|Verschieden Rennspiele:429<br />
	  Sportspiele ::: Skate(4651),Basketball:433|Billard:342|Bowling:435|Boxen:436|Fussball:432|Golf:437|Ski:438|Tennis:434|Verschiedene Sport:439 <br />
	  Weitere Spiele:2 Spieler(3818)|Farm-Spiele(3894)|Ritter(2263) <br />
	  Tiere & Cartoon: Elefanten(4036)|Fischspiele(4049)|Hähnchen(4038)|Hamster(1006)|Hunde(4034)|Insekten(4047)|Katze(1318)|
	  Löwen(4044)|Mickey(1587)|Naruto(4048)|Pinguine(1567)|Ratte(4037)|Tom&Jerry(4046)|Bären(4045)|Biene(4050)|Delfin(4035)|Donald Duck(3090)|Drachen(4039)|Weitere Tierspiele(4051)
	  <br />
	  <input type="text" name="sub_category" /></div>

  	  <div>ID of Author(luat:20,leon:24,steve:25, quangvinh@tae:1)<input type="text" name="author_id" /></div>
      <div class="submit"><input type="submit" value="Add news games" name="add_games" /></div>
	  </form>';  
		
	}	
}
function getInfoY8($url){
		//echo $url.'<br />';
		$xpath = getXpath($url);
		$hrefs = $xpath->evaluate("/html/body//div[@id=\"download-button-container\"]/a");
		//print_r($hrefs);
		
		if($hrefs->length>0){
			$swf= $hrefs->item(0)->getAttribute('href');
			if(strlen($swf)>0){
				$return['swf']=$swf;
				//get Name
				$hrefs = $xpath->evaluate("/html/body/div/div/div/h3");
				$return['name']=trim($hrefs->item($i)->nodeValue);
				//get Info
				$hrefs = $xpath->evaluate("/html/body//div[@class=\"grey-box-bg js-left-height\"]");
				$return['description']=$hrefs->item(0)->nodeValue;
				$hrefs = $xpath->evaluate("/html/body//div[@class=\"grey-box-bg js-right-height\"]");
				$return['how_to_play']=trim($hrefs->item(0)->nodeValue);
				//get Image	
				$hrefs = $xpath->evaluate("/html/body/div/table/tr/td/img");
				$return['img']=trim($hrefs->item(0)->getAttribute('src'));
			}
		}else{$return=NULL;}
		return $return;
}
function add_category(){
	global $wpdb, $wp_version;
		
	if (isset($_POST['add_games'])) {
		$link=$_POST['link'];
		$arr_links=parseLink($link);
		$sub_category=$_POST['sub_category'];
		$category=$_POST['category'];
		$author_id=$_POST['author_id'];
		$args = array(
		    'numberposts' 	  => 10000,
		    'offset'          => 0,
		    'category'        => $sub_category,
		    'orderby'         => 'post_date',
		    'order'           => 'DESC',
		    'post_type'       => 'post',
		    'post_status'     => 'publish' );

		$exist_posts = get_posts($args);
		$exist_arr=array();
		for($i=0;$i<sizeof($exist_posts);$i++){
			$exist_arr[]='http://www.kostenlosspielen.net/spielen/'.$exist_posts[$i]->post_name;
		}
		$no_insert=0;
		for($i=0;$i<sizeof($arr_links);$i++){
			if(!in_array($arr_links[$i],$exist_arr)){
				//echo $arr_links[$i].'<br />';
				$no_insert++;	
				$single_link=trim($arr_links[$i]);
				$pos=strpos($single_link,'spielen/');
				$flash_name=substr($single_link,$pos+8);
				$arr=lm_getInfo($single_link);
				$name=$arr[0];
				$flash=$arr[1];
				$intro=$arr[2]; 
				$img=$arr[3];
				$currentdate = date ("Y/m");
				$flashhttp=get_bloginfo('home').'/wp-content/uploads/'.$currentdate.'/'.$flash_name.'.swf';
				$imghttp=get_bloginfo('home').'/wp-content/uploads/'.$currentdate.'/'.$flash_name.'.gif';
				echo $flash.'<br />';
				echo $img.'<br />';
				//create Post
				$new_post=array(
					'post_title' => $name,
			     	'post_content' => $intro,
			     	'post_status' => 'draft',
			     	'post_author' => $author_id,
			     	'post_type' =>'post',
			     	'post_date' => date("Y-m-d H:i:s"),
			     	'post_category' => array($category, $sub_category),
			     	'post_date_gmt' => date("Y-m-d H:i:s")
				);
				
				$post_id=wp_insert_post($new_post);
				//create a Post Meta like flash, how to play, width, height, image
				if($post_id>0){
		        update_post_meta($post_id,'flash',$flashhttp);
		        update_post_meta($post_id,'image',$imghttp);
		      	}
			}
		}
		
		echo 'Inserted more '.$no_insert.' games';
	}else{
	  echo  '<form method="post" action="">
	  <div>Link from kostenlosspielen.net:<input type="text" name="link" /></div>
	  <br />
	  <div>ID of Category in kostenlosspielen.biz<br />Action Spiele:385|Denkspiele:417|Geschicklichkeitsspiele:394|Jump n Run:422|Kartenspiele:404|Mädchen Spiele:410|Rennspiele:430|Sport Spiele:431|Weitere Spiele:261<br /><input type="text" name="category" /></div>
	  <br />
	  <div>ID of Sub Category in kostenlosspielen.biz<br />Action Spiele ::: Ballerspiele:389|Bomberman Spiele:388|Flugzeug Spiele:391|Kampfspiele:387|Kriegspiele:390|Turmverteidigung:392|Verschiedene Actionspiele:393<br />Denkspiele ::: Point & Click: 1935|Mahjong Spiele:104|Schach Spiele:418|Sudoku Spiele:419|Unblock Me:420|Verschiedene Denkspiele:421 <br />Geschicklichkeitsspiele ::: Bubbles Spiele:397|Breakout Spiele:401|Pacman Spiele:395|Parkspiele:399|Pinball Spiele:400|Puzzle Spiele:271|Reaktion Spiele:402|Snake Spiele:398|Tetris Spiele:169|Verschiedene Geschick:403 <br />Jump n Run ::: Mario Spiele:75 | Verschiedene Jump n Run:423 <br />Kartenspiele ::: Blackjack Spiele:406|Memory Spiele:408|Solitär Spiele:407|Verschiedene Kartenspiele:409<br />Mädchen Spiele ::: Lernspiele:1949|Anzielspiele:413|Barbiespiele:447|Dekoration:411|Liebe Spiele:250|Malen Spiele:412|Pferde Spiele:1742|Tier Spiele:414|Verschiedene Mädchenspiele:415<br />Rennspiele ::: Autorennen:425|Boot Rennen:428|Motocross Spiele:426|Motorrad Spiele:427|Verschieden Rennspiele:429<br />Sportspiele ::: Basketball:433|Billard:342|Bowling:435|Boxen:436|Fussball:432|Golf:437|Ski:438|Tennis:434|Verschiedene Sport:439 <br /><input type="text" name="sub_category" /></div>

  	  <div>ID of Author(luat:20,leon:24,steve:25, quangvinh@tae:1)<input type="text" name="author_id" /></div>
      <div class="submit"><input type="submit" value="Add news games" name="add_games" /></div>
	  </form>';  
		
	}	
}
function getHTML($link)
	{
		$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_URL,$link);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
		$html= curl_exec($ch);
		return $html;
	}

function getXpath($link)
	{
		$html=getHTML($link);
		if (!$html) {
			echo "<br />cURL error number:" .curl_errno($ch);
			echo "<br />cURL error:" . curl_error($ch);
			exit;
		}
		
		// parse the html into a DOMDocument
		$dom = new DOMDocument('1.0', 'utf-8');
		@$dom->loadHTML($html);
		// grab all the on the page
		$xpath = new DOMXPath($dom);
		return $xpath;
}
function lm_getInfo($url){
		//$url='http://www.kostenlosspielen.net/spielen/bundesliga-elfmeter';

		$xpath = getXpath($url);
		$hrefs = $xpath->evaluate("/html/body/div/div/div/div/div/table/tr");
		$intro=$hrefs->item(0)->nodeValue;
		$pos=strpos($intro,'{lang');
		$intro=trim(substr($intro,0,$pos));
		
		$hrefs = $xpath->evaluate("/html/body/div/div/div/div/h1");
		$name=$hrefs->item(0)->nodeValue;
		$pos=strpos($name,'-');
		$name=trim(substr($name,0,$pos));

		$pos=strpos($url,'spielen/');
		$flash_name=substr($url,$pos+8);

		//get flash file
		$hrefs = $xpath->evaluate("/html/body/div/div/div/div/div/div/div/div");
		$text= $hrefs->item(0)->nodeValue;
		$swf=get_pathurl($text);
		$img_path=getImg($swf);
		$flash=trim('http://www.kostenlosspielen.net'.$swf.'/'.$flash_name.'.swf');
		$img=$img_path.'/'.$flash_name.'.gif';
		$arr= array();
		$arr[0]=$name;
		$arr[1]=$flash;
		$arr[2]=$intro;
		$arr[3]=$img;
		return $arr;
}
function getImg($swf){
	$pos1=strpos($swf,'/games');
	$img_pathname=substr($swf, $pos1 + 7,strlen($swf)-$pos1-6);
	$img_path='http://www.kostenlosspielen.net/thumbs/game/'.$img_pathname;
	return $img_path;
}
function get_pathurl($string){
	//echo $string;
	$pos1=strpos($string,'/file');
	$pos2=strpos($string,'/file', $pos1+5);
	$pos3=strpos($string,')', $pos2);
	return substr($string, $pos2,$pos3-$pos2-1);
}
function add_game_withoutFlash()
{
		global $wpdb, $wp_version;
	if (isset($_POST['add_games'])) {
		$link=$_POST['link'];
		$category=$_POST['category'];
		$sub_category=$_POST['sub_category'];		

		$arr_links = explode(",", $link);

		for($i=0;$i<sizeof($arr_links);$i++){
			$single_link=trim($arr_links[$i]);
			$pos=strpos($single_link,'spielen/');
			$flash_name=substr($single_link,$pos+8);
			$arr=lm_getInfo($single_link);
			$name=$arr[0];
			$flash=$arr[1];
			$intro=$arr[2]; 
			$currentdate = date ("Y/m");
			$flashhttp=get_bloginfo('home').'/wp-content/uploads/'.$currentdate.'/'.$flash_name.'.swf';
			echo $flash.'<br />'; 
			//create Post
			$new_post=array(
				'post_title' => $name,
		     	'post_content' => $intro,
		     	'post_status' => 'draft',
		     	'post_author' => 1,
		     	'post_type' =>'post',
		     	'post_date' => date("Y-m-d H:i:s"),
		     	'post_date_gmt' => date("Y-m-d H:i:s")
			);
			$post_id=wp_insert_post($new_post);
			
			//create a Post Meta like flash, how to play, width, height, image
			if($post_id>0){
	        update_post_meta($post_id,'flash',$flashhttp);
	      	}
			//insert in Category
		  	$query="INSERT INTO ".$wpdb->prefix."term_relationships(object_id, term_taxonomy_id) VALUE('".$post_id."','".$category."') ";
			//echo $query;
			$wpdb->query($query);			  	
			$query="INSERT INTO ".$wpdb->prefix."term_relationships(object_id, term_taxonomy_id) VALUE('".$post_id."','".$sub_category."') ";
			$wpdb->query($query);
		}
		

		// Show a message to say we've done something
		echo '<div class="updated fade"><p>' .$name. ' added!</p></div>';
		
	}else{
	  echo  '
	  <p>Add multi games from kostenlosspielen.net to website WITHOUT DOWNLOAD</p>
	  <p>Input: Multi URL of games, category, sub-category</p>	  
	  <p>Output: List of URL of games in kostenlosspielen.net</p>	  
	  <form method="post" action="">
	  <div>Link from kostenlosspielen.net:
		<textarea rows="8" cols="70" name="link"></textarea>
	  </div>
	  <div>Category<input type="text" name="category" /></div>	  
	  <div>Sub Category<input type="text" name="sub_category" /></div>
      <div class="submit"><input type="submit" value="Add news games" name="add_games" /></div>
	  </form>';  
		
	}
}
function add_game()
{
	global $wpdb, $wp_version;
	if (isset($_POST['add_games'])) {
		$link=$_POST['link'];
		$category=$_POST['category'];
		$sub_category=$_POST['sub_category'];		
		$arr=lm_getInfo($link);
		$name=$arr[0];
		$flash=$arr[1];
		$intro=$arr[2]; 
		$flashhttp=downloadFile($flash);
		echo 'uploaded in '.$flashhttp;
		//create Post
		$new_post=array(
			'post_title' => $name,
	     	'post_content' => $intro,
	     	'post_status' => 'draft',
	     	'post_author' => 1,
	     	'post_type' =>'post',
	     	'post_date' => date("Y-m-d H:i:s"),
	     	'post_date_gmt' => date("Y-m-d H:i:s")
		);
		$post_id=wp_insert_post($new_post);
		
		//create a Post Meta like flash, how to play, width, height, image
		if($post_id>0){
        update_post_meta($post_id,'flash',$flashhttp);
      	}
		//insert in Category
	  	$query="INSERT INTO ".$wpdb->prefix."term_relationships(object_id, term_taxonomy_id) VALUE('".$post_id."','".$category."') ";
		//echo $query;
		$wpdb->query($query);			  	
		$query="INSERT INTO ".$wpdb->prefix."term_relationships(object_id, term_taxonomy_id) VALUE('".$post_id."','".$sub_category."') ";
		$wpdb->query($query);			  	

		// Show a message to say we've done something
		echo '<div class="updated fade"><p>' .$name. ' added!</p></div>';
		
	}else{
	  echo  '
	  <p>Add single game from kostenlosspielen.net to website</p>
	  <p>Input: single URL, category, sub-category</p>
	  <p>Auto download flash to directory in kostenlosspielen.biz</p>	  	  
	  <form method="post" action="">
	  <div>Link from kostenlosspielen.net:<input type="text" name="link" /></div>
	  <div>Category<input type="text" name="category" /></div>	  
	  <div>Sub Category<input type="text" name="sub_category" /></div>
      <div class="submit"><input type="submit" value="Add news games" name="add_games" /></div>
	  </form>';  
		
	}
	
}
function downloadFile($url)
{
  $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 100000);
  $rawdata=curl_exec($ch);
  curl_close ($ch);
  $filename=basename($url);
  $currentdate = date ("Y/m");
  $abspath = ABSPATH;
  
  $filepath=$abspath.'wp-content/uploads/'.$currentdate.'/'.$filename;
  $fp=fopen($filepath,"w+");
  fwrite($fp, $rawdata);
  fclose($fp);
	$filehttp=get_bloginfo('home').'/wp-content/uploads/'.$currentdate.'/'.$filename;
	return $filehttp; 
}

function update_new_content()
{
	global $wpdb, $wp_version;
	if (isset($_POST['link'])) {
		$old_content=$_POST['content'];
		
		//update post
		$query_select="SELECT ID,post_content FROM  ".$wpdb->prefix."posts WHERE post_content LIKE  '%".$old_content."%'";
		
		$posts_select = $wpdb->get_results($query_select, OBJECT);
		foreach ($posts_select as $post){
		  $id=$post->ID;
		  $content=$post->post_content;
		  $new_content=str_replace($old_content,'Spielregel',$content);
		  $query_update="UPDATE ".$wpdb->prefix."posts SET post_content='".$new_content."' WHERE id=".$id;
		  $wpdb->query($query_update);
		}


	}else{

	  echo  '
	  <p>Input: Spielanleitung + text</p>
	  <p>Output: Spielregeln + text</p>
	  <p>Function: Replace the Spielanleitung to Spielregel</p>
	  <form method="post" action="">
	  <div>Old Content need to replace:<input type="text" name="content" /></div>
      <div class="submit"><input type="submit" value="Update Content" name="link" /></div>
	  </form>';  
		
	}
	
}

function update_new_url()
{
	global $wpdb, $wp_version;
	if (isset($_POST['link'])) {
		$new_url=$_POST['url'];
		
		//update post
		$query_select="SELECT ID,guid FROM  ".$wpdb->prefix."posts WHERE guid LIKE  '%".$new_url."%'";		
		$posts_select = $wpdb->get_results($query_select, OBJECT);
		foreach ($posts_select as $post){
		  $id=$post->ID;
		  $guid=$post->guid;
		  //$new_guid=getnew_guid($guid);
		  $new_guid=str_replace($new_url,'kostenlosspielen.biz',$guid);
  	  	  $query_update="UPDATE ".$wpdb->prefix."posts SET guid='".$new_guid."',post_author=2 WHERE id=".$id;
		  $wpdb->query($query_update);
		}

		//update post_meta
		$query_select="SELECT meta_id,meta_value FROM  ".$wpdb->prefix."postmeta WHERE meta_value LIKE  '%".$new_url."%'";		
		$posts_select = $wpdb->get_results($query_select, OBJECT);
		foreach ($posts_select as $post){
		  $meta_id=$post->meta_id;
		  $meta_value=$post->meta_value;
		  $new_meta=str_replace($new_url,'kostenlosspielen.biz',$meta_value);
  	  	  $query_update="UPDATE ".$wpdb->prefix."postmeta SET meta_value='".$new_meta."' WHERE meta_id=".$meta_id;
		  $wpdb->query($query_update);
		}
		
						

	}else{
	  	
	  echo  '
	  <p>Function: Replace the old URL in posts and postmeta to kostenlosspielen.biz</p>
	  <form method="post" action="">
	  <div>New URL:<input type="text" name="url" /></div>
      <div class="submit"><input type="submit" value="Update URL" name="link" /></div>
	  </form>';  
		
	}
	
}


function exchange_add()
{	
	global $wpdb, $wp_version;

	if (isset($_POST['link'])) {
      $link_url=$_POST['url'];
	  $name=$_POST['name'];
      $time=time();
	  if($_POST['link']=='Add link'){
	  	$query="INSERT INTO ".$wpdb->prefix."exchanges(url, timestamp, name ) VALUE('".$link_url."','".$time."','".$name."') ";
	  	echo '<div class="updated fade">'.$name.' added!</div>';
	  }else{
	 	$link_id=$_GET['link_id'];
	  	$query="UPDATE ".$wpdb->prefix."exchanges SET url='".$link_url."', name='".$name."' WHERE id=".$link_id;
		echo '<div class="updated fade">'.$name.' updated!</div>';
	  }
      $wpdb->query($query);
      
  	}elseif (isset($_GET['action'])) {
	 	  $link_id=$_GET['link_id'];
 	  if($_GET['action']=='edit'){
	      $query_games = "SELECT * FROM ".$wpdb->prefix."exchanges WHERE id=".$link_id;
		  $pageposts = $wpdb->get_results($query_games, OBJECT);
		  foreach ($pageposts as $post){
		  echo  '<form method="post" action="">
		  <div>CodeURL:<input type="text" name="url" value="'.$post->url.'" /></div>
		  <div>Name:<input type="text" name="name" value="'.$post->name.'" /></div>
	      <div class="submit"><input type="submit" value="Update link" name="link" /></div>
		  </form>';  
		  }
	  }else{
	      $query_games = "DELETE FROM ".$wpdb->prefix."exchanges WHERE id=".$link_id;
		  echo 'deleted.';
		  $wpdb->query($query_games);
	  }
		
  	}else{
	  echo  '<form method="post" action="">
	  <div>CodeURL:<input type="text" name="url" /></div>
	  <div>Name:<input type="text" name="name" /></div>
      <div class="submit"><input type="submit" value="Add link" name="link" /></div>
	  </form>';  
	}
}
function exchange_list(){
	global $wpdb, $wp_version;

   $query_games = "SELECT * FROM ".$wpdb->prefix."exchanges ORDER BY timestamp DESC";

	  $pageposts = $wpdb->get_results($query_games, OBJECT);
	  $num=1;
	  foreach ($pageposts as $post){
	  	echo '<a href="'.get_bloginfo('url').'/wp-admin/options-general.php?page=link_admin&link_id='.$post->id.'&action=edit'.'">'.$post->name.'</a>&nbsp;<a href="'.get_bloginfo('url').'/wp-admin/options-general.php?page=link_admin&link_id='.$post->id.'&action=delete'.'">delete</a> &nbsp;&nbsp;&nbsp;';
	  	if(intval($num) % 6==0) {echo '<br />';}
		$num++;
			}
}
?>
