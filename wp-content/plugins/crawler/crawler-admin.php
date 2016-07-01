<?php
/**
 * @package Crawler
 * @version 1.0
 */
/*
Plugin Name: Crawler
Plugin URI: http://kostenlosspielen.biz/
Description: Crawl data from y3.com, y8.com and others.
Author: Quang Vinh Pham
Version: 1.0
Author URI: http://kostenlosspielen.biz/
*/
add_action('admin_menu', 'crawler_plugin_menu');

function crawler_plugin_menu() {
	add_options_page('Crawler Plugin Options', 'Crawler Admin', 'manage_options', 'crawler_admin', 'crawler_plugin_options');
}
function getListGameY3($url){
  $xpath = getXpath($url);
  $gameURL=array();
  $hrefs = $xpath->evaluate("/html/body/center/table/tr/td/table/tr/td/table/tr/td/table/tr/td/a");
  for ($i = 0; $i < $hrefs->length; $i++ ) 
  {
    $gameURL[]=$hrefs->item($i)->getAttribute('href');
  }
  return $gameURL;
}
function crawler_plugin_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	echo '<div class="wrap"><h2>';
	_e('Crawler Admin Option'); 
	echo '</h2></div>';
	$m = new admin_subpages();

	$m->add_subpage('Statistics from y3.com', 'stat_y3_pages', 'stat_y3_pages');
  $m->add_subpage('One game from y3.com', 'crawler_y3_page', 'crawler_y3_page');
  $m->add_subpage('List game from y3.com', 'list_y3_pages', 'list_y3_pages');
	$m->display();
}
function list_y3_pages(){
  global $wpdb, $wp_version;    
  echo '<div class="wrap"><h3>';
  _e('List games from y3.com'); 
  echo '</h3></div>';
  if (isset($_POST['list_game_y3'])) {
      $start=$_POST['start'];
      $stop=$_POST['stop'];
      $i=$stop;
      while($i>=$start)
      {
          $url='http://www.y3.com/'.$i;
          $i=$i-1;
          $gameURL=array();
          $gameURL=getListGameY3($url);
          for($j=sizeof($gameURL)-1;$j>=0;$j--){
            //insert DB
            $time=time();
            $wpdb->query("INSERT INTO ".$wpdb->prefix."games(src,url,status,tstamps) VALUE('y3.com','".$gameURL[$j]."','download','".$time."') ");
          }
      }    
      echo '<div class="updated fade"><p>update</p></div>';
  }else{
  
  echo  '<form method="post" action="">
    <div>Start:<input type="text" name="start" /></div>
    <div>Stop :<input type="text" name="stop" /></div>
    <div class="submit"><input type="submit" name="list_game_y3" value="List game Y3"  /></div>
    </form>';  
  } 
}
function statisticGame(){
  global $wpdb, $wp_version;    
  echo '<div class="wrap"><h3>';
  _e('Game Statistic');
  echo '</h3></div>';  
  $game_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix."games"));
  $game_update_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix."games WHERE status='update'"));
  $game_german_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix."games WHERE status='update'"));
  $game_toobig_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix."games WHERE toobig=1"));
  
  echo '<div>Total games: '.$game_count.'</div>';
  echo '<div>Games in Site: '.$game_update_count.'</div>';
  echo '<div>Games in German: '.$game_german_count.'</div>';  
  echo '<div>Too big Games: '.$game_toobig_count.'</div>';
  echo '<div>Need to insert: '.($game_count-$game_update_count).'</div>';  
}

function crawler_y3_page(){
	global $wpdb, $wp_version;		
	$limit= '10';
	echo '<div class="wrap"><h3>';
	_e('Get one game from y3.com'); 
	echo '</h3></div>';
	$game_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix."games_crawler;"));
	$gamerows = $wpdb->get_results("SELECT game_url FROM ".$wpdb->prefix."games_crawler ORDER BY game_timestamp DESC LIMIT $limit" );
  $count=0;
	
	echo '<div>Total game updated: '.$game_count.'</div>';
   	echo '<div style="font-style:italic">';
   	foreach ($gamerows as $row)
	{
		$count++;	
		echo $count.'. '.$row->game_url.'<br />';
	}
	echo '</div>';
	if (isset($_POST['game_update_options'])) {
		//get game info
		$game_url=$_POST['game_url'];
		$gameInfo=getInfo($game_url);

		//download image to 2011/03/filename.gif
    $imagehttp=downloadFile($gameInfo['image']);
    
    if($gameInfo['flash']!=NULL){
		//download File to 2011/03/filename.swf
		$flashhttp=downloadFile($gameInfo['flash']);
    }	
		//create Post
		$new_post=array(
			'post_title' => $gameInfo['name'],
	     	'post_content' => $gameInfo['description'],
	     	'post_status' => 'publish',
	     	'post_author' => 1,
	     	'post_type' =>'post',
	     	'post_date' => date("Y-m-d H:i:s"),
	     	'post_date_gmt' => date("Y-m-d H:i:s"),
	     	'tags_input' =>  $gameInfo['tags']
		);
		$post_id=wp_insert_post($new_post);
		$dimension=getDimension($gameInfo['height'],$gameInfo['width']);
		

		//create a Post Meta like flash, how to play, width, height, image
		if($post_id>0){
			update_post_meta($post_id,'image',$imagehttp);
			update_post_meta($post_id,'how_to_play',$gameInfo['control']);
      if($gameInfo['flash']!=NULL){
        update_post_meta($post_id,'flash',$flashhttp);
        update_post_meta($post_id,'flash_height',$dimension['height']);
        update_post_meta($post_id,'flash_width',$dimension['width']);
      }else{
        update_post_meta($post_id,'iframe',$gameInfo['iframe']);
      }
      
		}
		// Show a message to say we've done something
		echo '<div class="updated fade"><p>' .$gameInfo['name']. ' added!</p></div>';
	}else{
	
	echo	'<form method="post" action="">
		<div>Game URL:<input type="text" name="game_url" /></div>
		<div class="submit"><input type="submit" name="game_update_options" value="Add a single game(from Y3.com)"  /></div>
		</form>';  
	} 
	
	
}
function getDimension($height, $width){
	$dimension=array();	
	if(intval($width)>710){
		$dimension['width']=710;
		$dimension['height']= intval($height*710/$width);
	}else{
		$dimension['width']=$width;
		$dimension['height']=$height;
	}
	return $dimension; 
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
  curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
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
function stat_y3_pages(){
  statisticGame();
  
}
function getInfo($url){
	$gameInfo=array();
	//$url='http://www.y3.com/games/14054/King_of_Fighters_WING_Version_2';
	//$url='http://www.y3.com/games/27098/Goodgame_Disco';
	//$url='http://www.y3.com/games/27097/Sonic_RPG_eps_8';
	$xpath = getXpath($url);
	//get image, name of game, height & width of Flash, flash
	$hrefs = $xpath->evaluate("/html/body/center/center/table/tr/td/textarea");
	if($hrefs->length==0){
    $hrefs = $xpath->evaluate("/html/body/center/table/tr/td/textarea");
    $gameInfo['image']=getTextHTML('src="','"',$hrefs->item(0)->nodeValue);
    $gameInfo['name']=getTextHTML('">','<br>',$hrefs->item(0)->nodeValue);
    $hrefs = $xpath->evaluate("/html/body//iframe/@src");
    for ($i = 0; $i < $hrefs->length; $i++ ) 
    {
         $iframe=$hrefs->item($i)->nodeValue;
         if((strpos($iframe,'y3.com')===false)&&(strpos($iframe,'www.facebook.com/plugins/likebox')===false)){
           $gameInfo['iframe']=$iframe;
         }
    }
    $hrefs = $xpath->evaluate("/html/body/center/table/tr/td//center/table/tr/td/table/tr/td/div");
    $gameInfo['description']=getDescription($hrefs->item(0)->nodeValue);
    $gameInfo['control']=trim(substr($hrefs->item(1)->nodeValue,15));
    
  }else{
    $gameInfo['name']=getTextHTML('">','<br>',$hrefs->item(0)->nodeValue);
    $gameInfo['image']=getTextHTML('src="','"',$hrefs->item(0)->nodeValue);
    $gameInfo['height']=getTextHTML('height="','"',$hrefs->item(1)->nodeValue);
    $gameInfo['width']=getTextHTML('width="','"',$hrefs->item(1)->nodeValue);
    $gameInfo['flash']=getTextHTML('src="','"',$hrefs->item(1)->nodeValue);
    $hrefs = $xpath->evaluate("/html/body/center/table/tr/td//center/table/tr/td/table/tr/td/div");
    $gameInfo['description']=trim(substr(getDescription($hrefs->item(0)->nodeValue),6));
    $gameInfo['control']=trim(substr($hrefs->item(1)->nodeValue,22));
        
  }
	//get the tag
	$hrefs = $xpath->evaluate("/html/body/center/table/tr/td//center/table/tr/td/a");
	$tags=array();
	$textTags='';
	for ($i = 0; $i < $hrefs->length; $i++ ) 
	{
		$textTags=$textTags.$hrefs->item($i)->nodeValue.',';
	}
	
	$gameInfo['tags']=substr($textTags,0,strlen($textTags)-1);
	//get description and how to play
	return $gameInfo;
	//print_r($gameInfo);
}
function getTextHTML($start,$stop,$text){
	//$findme1='src="';
	$pos1 = strpos($text, $start);
	if($pos1>0){
		$returntext=substr($text,$pos1+strlen($start));
	}

	$pos2 = strpos($returntext, $stop);
	if($pos2>0){
		$returntext=substr($returntext,0,$pos2);
	}
	return trim($returntext);
}
function getDescription($text){

	$findme1='Share';
	$findme2='var addthis_config';
	$pos1 = strpos($text, $findme1);
	$pos2 = strripos($text, $findme1);
	if(($pos1!=$pos2)&&($pos1>0)){
		//dont find Share tag or there are 2 Share tags
		$pos4 = strpos($text, $findme2);
		$returntext=substr($text,0,$pos4);
	}else{
		//only 1 Share
		$returntext=substr($text,0,$pos1);
	}
  
	$returntext=trim(substr($returntext,17));
	return $returntext;
}
function getControl($text){
	return $controlText;
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
?>
