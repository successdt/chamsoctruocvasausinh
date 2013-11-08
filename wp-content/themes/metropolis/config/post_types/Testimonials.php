<?php
/*
	Description: Testimonials custom post.
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
	"type" 			=> "testimonials",
	"name" 			=> "Testimonials",
	"singular_name" => "Testimonial",
	"slug" 			=> "testimonials"
);

/*
 * Post metabox (if any)
 */
$metabox = array(
	__("Testimonial info", THEMENAME) => array(
		"position" => "normal",
		"fields" => array(
			array ( 
				"name" => "Company",
				"desc" => "Company name",
				"key" => "_company",
				"type" => "text",
				"std" => ""
			)
		)
	)
);

/*
 * Labels + post type definition
 */
$args = array(
	'supports' => array('title', 'excerpt'),
	'exclude_from_search' => true
);

/*
 * Post type registration
 */
$post_type = new CustomPost($data, $args, $metabox);