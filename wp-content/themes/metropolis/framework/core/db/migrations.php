<?php
global $wpdb;

/*
 * THB theme additional tables
 */
define("DUPLICABLE_TABLE", "thb_" . THEMEPREFIX . "_duplicable");

function thb_execute_migration() {
	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
   	// Duplicable fields
	$table_name = DUPLICABLE_TABLE;
	$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  name text NULL,
	  ord mediumint(9) NOT NULL DEFAULT '0',
	  type tinytext NOT NULL,
	  subtype text NULL,
	  post_id mediumint(9) NULL,
	  title text NULL,
	  caption text NULL,
	  url text NULL,
	  src text NULL,
	  UNIQUE KEY id (id)
	);";
	
	dbDelta($sql);
}