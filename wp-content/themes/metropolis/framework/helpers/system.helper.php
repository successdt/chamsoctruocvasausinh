<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
	Description: System-wide utility functions.
*/

/**
 * Checks if the system is in debug mode.
 *
 * @return boolean
 **/
function thb_is_debug() {
	return defined("THBDEBUG") && THBDEBUG == true;
}

/**
 * Gets an option with the appropriate prefix.
 *
 * @param string $key The option key without the THEMEPREFIX.
 * @param boolean $formatted Set to TRUE to encode the string.
 * @param string $default A default value for the string.
 * @return string
 **/
function thb_get_option( $key, $formatted=false, $default="" ) {
	$key = THEMEPREFIX.$key;
	if(thb_is_debug() && isset($_GET[$key])) {
		$option_value = urldecode( $_GET[$key] );
		// $option_value = str_replace(" ", "+", $option_value);
		// $option_value = str_replace("%20", " ", $option_value);
		return $option_value;
	}

	$option_value = thb_getvalue(get_option($key));

	if( empty($option_value) && !empty($default) )
		$option_value = $default;
		
	if( $formatted )
		$option_value = htmlspecialchars_decode($option_value);

	return $option_value;
}

/**
 * Updates an option with the appropriate prefix.
 *
 * @param string $key The option key without the THEMEPREFIX.
 * @param string $value A value for the string.
 * @return void
 **/
function thb_update_option( $key, $value="" ) {
	$key = THEMEPREFIX.$key;
	update_option($key, $value);
}

/**
 * Checks if a THB options page is being saved.
 *
 * @return boolean
 **/
function thb_admin_page_saved()
{
	return !empty($_POST) && isset($_POST[THB_ADMIN_PAGE_SAVED]);
}

/**
 * Gets an attachment's ID from its URL.
 *
 * @param string $url The attachment's URL
 * @return int
 **/
function get_attachment_id( $url ) {

	$dir = wp_upload_dir();
	$dir = trailingslashit($dir['baseurl']);

	if( false === strpos( $url, $dir ) )
		return false;

	$file = basename($url);

	$query = array(
		'post_type' => 'attachment',
		'fields' => 'ids',
		'meta_query' => array(
			array(
				'value' => $file,
				'compare' => 'LIKE',
			)
		)
	);

	$query['meta_query'][0]['key'] = '_wp_attached_file';
	$ids = get_posts( $query );

	foreach( $ids as $id )
		if( $url == array_shift( wp_get_attachment_image_src($id, 'full') ) )
			return $id;

	$query['meta_query'][0]['key'] = '_wp_attachment_metadata';
	$ids = get_posts( $query );

	foreach( $ids as $id ) {

		$meta = wp_get_attachment_metadata($id);

		foreach( $meta['sizes'] as $size => $values )
			if( $values['file'] == $file && $url == array_shift( wp_get_attachment_image_src($id, $size) ) ) {
				return $id;
			}
	}

	return false;
}

/**
 * Converts a file URL to its filesystem path.
 *
 * @param string $url The file's URL.
 * @return string
 **/
function urlToPath( $url ) {
	$path = str_replace(site_url(), "", $url);

	return ABSPATH . trim($path, "/");
}

/**
 * Normalizes an image file name.
 *
 * @param string $image The image's file name.
 * @return string
 **/
function normalizeFileName( $image ) {
	$image_name = str_replace("repeat-x-", "", $image);
	$image_name = str_replace("repeat-y-", "", $image_name);
	$image_name = str_replace("no-repeat-", "", $image_name);

	$image_name = explode(".", $image_name);
	unset($image_name[count($image_name)-1]);
	$image_name = implode("", $image_name);
	$image_name = str_replace("_", " ", $image_name);
	$image_name = str_replace("-", " ", $image_name);
	
	return ucwords($image_name);
}

/**
 * Parses a directory for files.
 *
 * @param string $directory The folder to scan.
 * @return array
 **/
function getFiles( $directory ) {
	$results = array();
	$handler = opendir($directory);
	while ($file = readdir($handler)) {
		if ($file != "." && $file != ".." && !startsWith($file, "."))
			$results[] = $file;
	}
	closedir($handler);
	return $results;
}

/**
 * Parses a query string into an array.
 *
 * @param string $str The query string.
 * @return array
 **/
function parseQueryString( $str ) { 
	$op = array(); 
	$pairs = explode("&", $str); 
	foreach ($pairs as $pair) {
		if(empty($pair))
			continue;
		list($k, $v) = array_map("urldecode", explode("=", $pair)); 
		$op[$k] = $v; 
	}
	return $op; 
}

/**
 * Sanitizes the POST array.
 *
 * @return array
 **/
function thb_get_data()
{
	$data = array();
	if( !empty($_POST) ) {
		$data = $_POST;
		if( isset($data['icl_post_language']) )
			unset($data['icl_post_language']);
	}

	return $data;
}

/**
 * Unzip the source_file in the destination dir
 *
 * @param   string      The path to the ZIP-file.
 * @param   string      The path where the zipfile should be unpacked, if false the directory of the zip-file is used
 * @param   boolean     Indicates if the files will be unpacked in a directory with the name of the zip-file (true) or not (false) (only if the destination directory is set to false!)
 * @param   boolean     Overwrite existing files (true) or not (false)
 * @return  boolean     Succesful or not
 */
function unzip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true) {
	if ($zip = zip_open($src_file)) {
		if ($zip) {
	  		$splitter = ($create_zip_name_dir === true) ? "." : "/";
	  		if ($dest_dir === false) $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";
	  
			// Create the directories to the destination dir if they don't already exist
			create_dirs($dest_dir);

			// For every file in the zip-packet
			while ($zip_entry = zip_read($zip)) {
				// Now we're going to create the directories in the destination directories
		
				// If the file is not in the root dir
				$pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
				if ($pos_last_slash !== false) {
		  			// Create the directory where the zip-entry should be saved (with a "/" at the end)
		  			create_dirs($dest_dir.substr(zip_entry_name($zip_entry), 0, $pos_last_slash+1));
				}

				// Open the entry
				if (zip_entry_open($zip,$zip_entry,"r")) 
				{
					// The name of the file to save on the disk
					$file_name = $dest_dir.zip_entry_name($zip_entry);

					// Check if the files should be overwritten or not
					if ($overwrite === true || $overwrite === false && !is_file($file_name)) {
						// Get the content of the zip entry
						$fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

						file_put_contents($file_name, $fstream );
						
						// Set the rights
						chmod($file_name, 0777);
						// echo "save: ".$file_name."<br />";
					}

					// Close the entry
					zip_entry_close($zip_entry);
				}

	  		}

			// Close the zip-file
			zip_close($zip);
		}
	} else {
		return false;
	}

	return true;
}

/**
 * This function creates recursive directories if it doesn't already exist
 *
 * @param String  The path that should be created
 *  
 * @return  void
 */
function create_dirs($path)
{
  if (!is_dir($path))
  {
    $directory_path = "";
    $directories = explode("/",$path);
    array_pop($directories);
    
    foreach($directories as $directory)
    {
      $directory_path .= $directory."/";
      if (!is_dir($directory_path))
      {
        mkdir($directory_path);
        chmod($directory_path, 0777);
      }
    }
  }
}