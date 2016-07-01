<?php
/**
 * Create/Update database structure
 * 
 * Called in activation hook
 */

// Define plugin tables prefix
global $wpdb;
$prefix = $wpdb->prefix . WPPostsRateKeys::$db_prefix;

/*
 * Creating Table for the Relation between Roles and Capabilities
 */
$table_name = $prefix . WPPostsRateKeys_RolesCapabilities::$table_name;
if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	$wpdb->query("CREATE TABLE `$table_name` (
		`id` INT NOT NULL auto_increment ,
		`capabilities` VARCHAR (255),
		`role_type` VARCHAR (255) NOT NULL DEFAULT 'wp',
		`role_name` VARCHAR (255) NOT NULL,
		PRIMARY KEY  ( `id` )) DEFAULT CHARSET=utf8");
	
	WPPostsRateKeys_RolesCapabilities::add(array('capabilities'=>'admin','role_type'=>'wp','role_name'=>'administrator'));
}

/*
 * Creating Table for Relations between Users and Custom Roles
 * 
 * Only Users and Custom Roles relation because the relation between 
 * users and WordPress roles aren't concern of this plugin
 */
$table_name = $prefix . WPPostsRateKeys_UsersCustomRoles::$table_name;
if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	$wpdb->query("CREATE TABLE `$table_name` (
		`id` INT NOT NULL auto_increment ,
		`user_id` INT ,
		`role_id` INT ,
		PRIMARY KEY  ( `id` )) DEFAULT CHARSET=utf8");
}

/*
 * Creating Table for External Cloaked keywords-links
 * 
 * "keywords" has separated by comma keywords
 * "cloaking_folder" for example: recommends
 */
$table_name = $prefix . WPPostsRateKeys_ExternalCloackedLinks::$table_name;
if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	$wpdb->query("CREATE TABLE `$table_name` (
		`id` INT NOT NULL auto_increment ,
		`keywords` VARCHAR (255) NOT NULL ,
		`cloaking_folder` VARCHAR (255) NOT NULL ,
		`external_url` VARCHAR (255) NOT NULL ,
		`how_many` INT NULL ,
		PRIMARY KEY ( `id` )) DEFAULT CHARSET=utf8");
}
else {
	// Add bing_url column
	$tmp_result = $wpdb->get_results("show columns from `$table_name` where field = 'how_many'");
	if (sizeof($tmp_result) == 0) { // No field created
		$wpdb->query("ALTER TABLE `$table_name` ADD `how_many` INT NULL");
	}
}

/*
 * Creating Table for Automatic Internal Links
 * 
 * "keywords" has separated by comma keywords
 */
$table_name = $prefix . WPPostsRateKeys_AutomaticInternalLinks::$table_name;
if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	$wpdb->query("CREATE TABLE `$table_name` (
		`id` INT NOT NULL auto_increment ,
		`keywords` VARCHAR (255) NOT NULL ,
		`post_id` INT NOT NULL ,
		`how_many` INT NULL ,
		PRIMARY KEY ( `id` )) DEFAULT CHARSET=utf8");
}
else {
	// Add bing_url column
	$tmp_result = $wpdb->get_results("show columns from `$table_name` where field = 'how_many'");
	if (sizeof($tmp_result) == 0) { // No field created
		$wpdb->query("ALTER TABLE `$table_name` ADD `how_many` INT NULL");
	}
}

/*
 * Creating Table for visits
*
*/
$table_name = $prefix . WPPostsRateKeys_Visits::$table_name;
if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	$wpdb->query("CREATE TABLE `$table_name` (
			`id` INT NOT NULL auto_increment ,
			`visit_dt` DATETIME ,
		PRIMARY KEY ( `id` )) DEFAULT CHARSET=utf8");
}

/*
 * Creating Table to store the LSI colection
 * 
 */
$table_name = $prefix . WPPostsRateKeys_LSI::$table_name;
if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	$wpdb->query("CREATE TABLE `$table_name` (
		`id` INT NOT NULL auto_increment ,
		`keyword` VARCHAR (255) NOT NULL ,
		`lsi_suggestion` VARCHAR (255) NULL ,
		`bing_url` VARCHAR (255) NULL ,
		`added_dt` DATETIME ,
		PRIMARY KEY ( `id` )) DEFAULT CHARSET=utf8");
}
else {
	// Add bing_url column
	$tmp_result = $wpdb->get_results("show columns from `$table_name` where field = 'bing_url'");
	if (sizeof($tmp_result) == 0) { // No field created
		$wpdb->query("ALTER TABLE `$table_name` ADD `bing_url` VARCHAR (255) NULL");
	}
}

/*
 * Creating Table for Logs
*
* type can be: error, notification, request_to_central_server
*/
$table_name = $prefix . WPPostsRateKeys_Logs::$table_name;

if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	$wpdb->query("CREATE TABLE `$table_name` (
			`id` INT NOT NULL auto_increment ,
			`type` VARCHAR (255),
			`msg_code` VARCHAR (255),
			`message` TEXT,
			`dt` DATETIME,
		PRIMARY KEY ( `id` )) DEFAULT CHARSET=utf8");
}
