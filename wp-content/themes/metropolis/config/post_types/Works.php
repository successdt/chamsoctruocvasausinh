<?php
/*
	Description: Portfolio custom post.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

/*
 * Post type data
 */
$data = array(
	"type" 			=> "works",
	"name" 			=> "Works",
	"singular_name" => "Work",
	"slug" 			=> "works"
);

/*
 * Post metabox (if any)
 */

$metabox = array(
	__("Additional side informations", THEMENAME) => array(
		"id" => "side_info",
		"position" => "normal",
		"priority" => "high",
		"fields" => array(
			array ( 
				"name" => "",
				"desc" => "",
				"key" => "_side_info",
				"type" => "textarea",
				"std" => ""
			)
		)
	),
    __("Extra", THEMENAME) => array(
		"position" => "normal",
		"priority" => "high",
		"fields" => array(
			array (
				"name" => "Video URL",
				"desc" => "",
				"key" => "_video_url",
				"type" => "text",
				"std" => ""
			),
			array ( 
				"name" => "Background/slideshow",
				"desc" => "",
				"key" => "_background",
				"type" => "select",
				"options" => get_background_image_options(),
				"std" => 1
			)
		)
	),
	__("Slideshow", THEMENAME) => get_slideshow_metabox(),
	__("SEO", THEMENAME) => array(
		"id" => "seo",
		"position" => "side",
		"priority" => "normal",
		"fields" => array(
			array ( 
				"name" => "Keywords",
				"desc" => "Comma separated.",
				"key" => "_seo_keywords",
				"type" => "text",
				"std" => ""
			),
			array ( 
				"name" => "Description",
				"desc" => "",
				"key" => "_seo_description",
				"type" => "textarea",
				"std" => ""
			)
		)
	)
);

/*
 * Labels + post type definition
 */
$args = array(
	'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'revisions', 'post-formats')
);

/**
 * Enabling comments?
 */
if( thb_get_option("_works_comments") == 1 )
	$args['supports'][] = 'comments';

/*
 * Post type registration
 */
$post_type = new CustomPost($data, $args, $metabox);