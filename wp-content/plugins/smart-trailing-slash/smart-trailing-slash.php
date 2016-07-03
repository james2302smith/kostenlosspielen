<?php
/*
Plugin Name: Smart Trailing Slash
Plugin URI: http://www.fastagent.de/res/download/smart-trailing-slash.zip
Description: Gives permalinks a trailing slash, but removes it in permalinks with a filename extension, e.g. .html
Version: 1.01
Author: Peter Claus Lamprecht
Author URI: http://www.fastagent.de/
*/

function pcl_smart_trailingslashit($string) {
	/* ensure, that there is one trailing slash */
	$string = rtrim($string, '/') . '/';
	/* if there is a filename extension like .html or .php, then remove the trailing slash */
	if ( 0 < preg_match("#\.[^/]+/$#", $string) ) {
		$string = rtrim($string, '/');
	}
	return $string;
}
add_filter('user_trailingslashit', 'pcl_smart_trailingslashit');
?>