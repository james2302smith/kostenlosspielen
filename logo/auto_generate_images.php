<?php
/*DB Connection*/
	
$con=mysqli_connect("mysql5.kostenlosspielen247.com","db378295","p_5VYaBO","db378295");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
//setPostMeta(10938);

$result = mysqli_query($con,"SELECT * FROM kostenlosspielen_posts WHERE post_status='future' AND post_type='post'");
//echo getPath('http://www.kostenlosspielen.biz/wp-content/uploads/2012/10/skateboard-game.jpg');
//generateImages(9848);
while($row = mysqli_fetch_array($result))
  {
  $count++;
  if(getPostMeta($row['ID'],'image_gen')!='true'){
	//create thumb
	generateImages($row['ID']);
	//marked as created
	setPostMeta($row['ID']);
	//echo $count.'>'.$row['ID'].'-title:'.$row['post_title'].'<br />';
  }
}
  
function setPostMeta($id){
	$con=mysqli_connect("mysql5.kostenlosspielen247.com","db378295","p_5VYaBO","db378295");
	$query="INSERT INTO kostenlosspielen_postmeta(post_id,meta_key,meta_value) VALUES($id,'image_gen','true')";
	$result = mysqli_query($con,$query);
}
function getPostMeta($id,$attribute){
$con=mysqli_connect("mysql5.kostenlosspielen247.com","db378295","p_5VYaBO","db378295");
$query="SELECT meta_value FROM kostenlosspielen_postmeta WHERE post_id='".$id."' AND meta_key='$attribute'";
$result = mysqli_query($con,$query);
$rows=mysqli_fetch_array($result);
return $rows['meta_value'];
}
function generateImages($postid){
	//echo 'test generate:'.$postid;
	$image_url=getPostMeta($postid,'image');
	//echo $image_url;
	$image_absolute='/kunden/378295_97072/kostenlosspielen/wp-content/uploads'.getPath($image_url);
	$image_absolute_path=dirname($image_absolute);
	$image=getNameOfImage($image_url);
	//print_r($image);
	createthumb($image_absolute,$image_absolute_path.'/'.$image[0].'-100.'.$image[1], 100, 75);
	createthumb($image_absolute,$image_absolute_path.'/'.$image[0].'-75.'.$image[1], 75, 57);		
}
function getPath($image_url){
	$pos=strpos($image_url,SITE_ROOT_URL.'/wp-content/uploads/');
	return substr($image_url, $pos+50);
}
function replaceImages($image_url, $last){
	$pos=strrpos($image_url,'/');
	$path=substr($image_url,0, $pos);
	$image=substr($image_url,$pos+1);
	$image=getNameOfImage($image_url);
	return $path.'/'.$image['name'].'-'.$last.'.'.$image['type'];
}
function getNameOfImage($url){
	//$url='http://www.kostenlosspielen.biz/wp-content/uploads/2012/09/cinema-decoration.gif';
	$pos= strrpos($url,'/');
	$image=substr($url,$pos+1);
	$images = explode(".", $image);
	return $images;
}

//Create thumbnail image by php
function createthumb($source_image,$destination_image_url, $get_width, $get_height){
	ini_set('memory_limit','512M');
	set_time_limit(0);
	//echo 'source:'.$source_image;
	//echo 'destination:'.$destination_image_url;
	
	$image_array         = explode('/',$source_image);
	$image_name = $image_array[count($image_array)-1];
	$max_width     = $get_width;
	$max_height =$get_height;
	if($max_width==100){
		$quality = 85;
	}else{
		$quality = 80;
	}

	//Set image ratio
	list($width, $height) = getimagesize($source_image);
	$ratio = ($width > $height) ? $max_width/$width : $max_height/$height;
	$ratiow = $width/$max_width ;
	$ratioh = $height/$max_height;
	$ratio = ($ratiow > $ratioh) ? $max_width/$width : $max_height/$height;

	if($width > $max_width || $height > $max_height) {
		$new_width = $width * $ratio;
		$new_height = $height * $ratio;
	} else {
		$new_width = $width;
		$new_height = $height;
	}
	$source_image=strtolower($source_image);
	if (preg_match("/.jpg/i","$source_image") or preg_match("/.jpeg/i","$source_image")) {
		//JPEG type thumbnail
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($source_image);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagejpeg($image_p, $destination_image_url, $quality);
		imagedestroy($image_p);

	} elseif (preg_match("/.png/i", "$source_image")){
		//PNG type thumbnail
		$im = imagecreatefrompng($source_image);
		$image_p = imagecreatetruecolor ($new_width, $new_height);
		imagealphablending($image_p, false);
		imagecopyresampled($image_p, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagesavealpha($image_p, true);
		imagepng($image_p, $destination_image_url);

	} elseif (preg_match("/.gif/i", "$source_image")){
		
		//GIF type thumbnail
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromgif($source_image);
		$bgc = imagecolorallocate ($image_p, 255, 255, 255);
		imagefilledrectangle ($image_p, 0, 0, $new_width, $new_height, $bgc);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagegif($image_p, $destination_image_url, $quality);
		imagedestroy($image_p);

	} else {
		echo 'unable to load image source';
		exit;
	}
}


?>