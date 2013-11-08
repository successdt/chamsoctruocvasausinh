<?php

/**
 * Uploads a file to a specified upload folder.
 *
 * @param File $upload The file to be uploaded.
 * @param array $mimes The MIME type(s) the uploaded file should be checked against.
 * @return mixed
 **/
function thb_upload( $upload, $mimes=array() )
{
	// Turn off error reporting if needed
	if( WP_DEBUG == true ) {
		error_reporting( E_ERROR | E_WARNING | E_PARSE & ~E_STRICT );
	}

	// Getting the upload directory
	$upload_dir = wp_upload_dir();

	// The file
	$return_file = false;

	// Check if upload dir is writable
	if( is_writable($upload_dir['path']) ) {
		// Check if uploaded file is not empty
		if( !empty($upload['tmp_name']) && $upload['tmp_name'] ) {
			// Let's upload the file
			$file = thb_handle_upload($upload, $mimes);

			$return_file = array(
				"file" => $file,
				"upload_dir" => $upload_dir
			);
		}
	}

	// Turn error reporting back on if needed
	if( WP_DEBUG == true ) {
		error_reporting( E_ALL );
	}

	return $return_file;
}

/**
 * Handles the file upload.
 *
 * @param File $upload The file being uploaded.
 * @param array $mimes The MIME type(s) the uploaded file should be checked against.
 * @return mixed
 **/
function thb_handle_upload( $upload, $mimes=array() )
{
	if( !empty($mimes) ) {
		$info = @getimagesize($upload['tmp_name']);
		if( !in_array($info['mime'], $mimes) ) {
			return false;
		}
	}

	$overrides = array('test_form' => false);
	$file = wp_handle_upload($upload, $overrides);

	return $file;
}