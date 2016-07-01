<?php

error_reporting ( E_ALL );

require_once 'YoutubeKeyword.php';
require_once 'YoutubeVideo.php';

/**
 * ***********************************************************************
 * Usage example.
 * ************************************************************************
 */

$youtubeUser = new YoutubeKeyword ( 'ElectronicArtsItalia' );
$youtubeVideos = $youtubeUser->getVideos ( 3 );

echo '<p> <h1> First video </h1> </p>';
echo $youtubeVideos [0]->getCodeToDisplayVideo ( 425, 350 );
echo "<p> <h1> title: {$youtubeVideos [0]->title} </h1> </p>";
echo "<p> <h1> tags: ";
var_dump ( $youtubeVideos [0]->tags );
echo "</h1> </p>";
echo "<p> <h1> id: {$youtubeVideos [0]->id} </h1> </p>";
echo "<p> <h1> publishedDate: {$youtubeVideos [0]->publishedDate} </h1> </p>";
echo "<p> <h1> description: {$youtubeVideos [0]->description} </h1> </p>";
echo '<p> <h1> Related videos </h1> </p>';
foreach ( $youtubeVideos [0]->getRelatedVideos ( 3 ) as $youtubeVideo ) {
	echo '<p> <h1> Video </h1> </p>';
	echo $youtubeVideo->getCodeToDisplayVideo ( 200, 150 );
}
