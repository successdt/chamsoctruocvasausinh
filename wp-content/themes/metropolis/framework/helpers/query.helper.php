<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
	Description: Querying utility functions.
*/

/**
 * Creates a new loop for a specific custom post type.
 *
 * @param string $post_type The custom post type.
 * @param array $args The loop's parameters.
 * @return WP_Query
 * @see http://codex.wordpress.org/Function_Reference/query_posts
 **/
function thb_get_posts( $post_type, $args=array() )
{
	// Getting the pagination right
	$paged = 1;
	if (get_query_var('paged'))
		$paged = get_query_var('paged');
	elseif (get_query_var('page'))
		$paged = get_query_var('page');

	$args['post_type'] = $post_type;

	$default_args = array(
		"posts_per_page" => get_option("posts_per_page"),
		"status" => "publish",
		"paged" => $paged,
		"ignore_sticky_posts" => 1
	);
	$args = $args + $default_args;

	$loop = new WP_Query($args);
	wp_reset_query();

	return $loop;
}

/**
 * Gets a list of duplicable elements, filtered by type.
 *
 * @param string $type The items type.
 * @param string $subtype The items subtype.
 * @param int $limit How many items to retrieve.
 * @return array
 **/
function thb_get_duplicable( $type, $subtype = null, $limit=null ) {
	global $wpdb;

	$where = "type = '$type'";
	if($subtype)
		$where .= " and subtype = '$subtype'";

	if($limit)
		$limit = " LIMIT $limit";

	$query = "SELECT * FROM " . DUPLICABLE_TABLE . " WHERE $where ORDER BY ord $limit";

	$items = $wpdb->get_results($query, ARRAY_A);
	return $items;
}

/**
 * Function to fix problem where next/previous buttons are broken on list
 * of posts in a category when the custom permalink string is:
 * /%category%/%year%/%monthnum%/%postname%/ 
 *
 * @param array $query_string The query string
 * @return array
 **/
if( !function_exists("remove_page_from_query_string") ) {
	function remove_page_from_query_string( $query_string )
	{ 
	    if( isset($query_string['name']) && $query_string['name'] == 'page' && isset($query_string['page']) ) {
	        unset($query_string['name']);
	        // 'page' in the query_string looks like '/2', so split it out
	        list($delim, $page_index) = split('/', $query_string['page']);
	        $query_string['paged'] = $page_index;
	    }      
	    return $query_string;
	}
}

add_filter('request', 'remove_page_from_query_string');