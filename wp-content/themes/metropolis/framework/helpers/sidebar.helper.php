<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
	Description: Sidebar utility functions.
*/

/**
 * Sidebar's default position.
 */
define("SIDEBAR_DEFAULT_POSITION", "right");

/**
 * Gets the sidebar position.
 *
 * @param string $post_type The custom post type.
 * @return string
 **/
function thb_get_sidebar_position( $post_type=null ) {
	global $post;

	if(thb_has_sidebar($post_type)) {
		$template = thb_get_page_template();

		if(endsWith($template, "-right.php"))
			$position =  "right";
		elseif(endsWith($template, "-left.php"))
			$position =  "left";
		elseif(endsWith($template, "-full.php")) {
			$position = "no";
		} else {
			$position = thb_get_option("_sidebar_position");
			if(empty($position)) {
				$position = SIDEBAR_DEFAULT_POSITION;
			}
		}
	} else {
		$position = "no";
	}
	
	return $position;
}

/**
 * Returns the sidebar for a given custom post type.
 *
 * @param string $post_type The custom post type.
 * @return string
 **/
function thb_get_post_type_sidebar( $post_type="post" ) {
	return thb_get_option("_sidebar_".$post_type);
}

/**
 * Gets the name of the current page's template.
 *
 * @return string
 **/
function thb_get_page_template() {
	$template_file = "page.php";
	if( is_page() )
		$template_file = get_page_template();
	return basename($template_file);
}

/**
 * Checks if the current page has any sidebar associated.
 *
 * @param string $post_type The custom post type.
 * @return boolean
 **/
function thb_has_sidebar( $post_type=null ) {
	global $post;

	$sidebar = thb_get_sidebar_name($post_type);
	return (!empty($sidebar) && $sidebar != "no");
}

/**
 * Returns the sidebar name, optionally filtered by custom post type.
 *
 * @param string $post_type The custom post type.
 * @return string
 **/
function thb_get_sidebar_name( $post_type=null ) {
	global $post;

	$sidebar="";
	if(!$post_type) {
		if(is_single() ) {
			$post_type = $post->post_type;
			$sidebar = thb_get_post_type_sidebar($post_type);
		}
		elseif(is_page()) {
			$page_id = get_the_ID();
			$sidebar = thb_get_post_meta($page_id, "_page_sidebar");
		}
		elseif(is_search() || is_archive() || is_category() || is_tag() || is_author() || is_404()) {
			$sidebar = thb_get_option("_sidebar_archivesearch_id");
		}
	} else {
		$sidebar = thb_get_post_type_sidebar($post_type);
	}

	return $sidebar;
}

/**
 * Outputs a sidebar.
 *
 * @param string $sidebar The sidebar ID.
 * @param string $type The sidebar ID in the markup.
 * @param string $class The sidebar class in the markup.
 * @return void
 **/
function thb_get_sidebar($sidebar="primary-widget-area", $type="main", $class="") {
	include TEMPLATEPATH . "/sidebar.php";
}