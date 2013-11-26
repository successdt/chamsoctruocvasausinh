<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
	Description: Image utility functions.
*/

/**
 * Resizes an image.
 * Note: if TimThumb is not present, returns the original image.
 *
 * @param string $image The image's URL.
 * @param int $width The image's width.
 * @param int $height The image's height.
 * @param array $parameters The resizing parameters.
 * @return string
 **/
function thb_resize( $image, $width, $height, $parameters=array() )
{
	if( !defined(TIMTHUMB) )
		return $image;
	
	// Removing the site URL (might cause problems with TimThumb)
	$image = urlToPath($image);

	$image = TIMTHUMB . "?src=" . $image;
	$separator = "&amp;";
	
	$image .= $separator . "w=" . $width;
	$image .= $separator . "h=" . $height;
	
	foreach($parameters as $parameter => $value) {
		$image .= $separator . $parameter . "=" . $value;
	}

	return $image;
}

/**
 * Returns the image dimensions.
 *
 * @param string $filename The image's URL.
 * @return array
 **/
function thb_get_image_dimensions( $filename ) {
	$temp_image_name = urlToPath($filename);

	// Get new dimensions
	$myfilesize = getimagesize($temp_image_name);

	// Image object
	$image = new stdClass();
	$image->width = $myfilesize[0];
	$image->height = $myfilesize[1];

	return $image;
}

/**
 * Returns the image size from its generic URL.
 *
 * @param string $thumbnail The image's URL.
 * @param string $size The image size.
 * @return string
 **/
function thb_get_image_size( $thumbnail, $size='thumbnail_image' ) {
	$thumbnail_id = get_attachment_id($thumbnail);
	$thumbnail_image = wp_get_attachment_image_src( $thumbnail_id, $size );
	
	return $thumbnail_image[0];
}