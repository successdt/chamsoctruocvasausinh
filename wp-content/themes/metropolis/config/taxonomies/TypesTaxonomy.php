<?php
/*
	Description: Portfolio taxonomy.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

$taxonomy = array(
	"type" 			=> "types",
	"name" 			=> "Types",
	"singular_name" => "Type",
	"slug" 			=> "types",
	"post_type"		=> "works"
);

$skills = array(
	"type" 			=> "skills",
	"name" 			=> "Skills",
	"singular_name" => "Skill",
	"slug" 			=> "skills",
	"post_type"		=> "works"
);

$labels = array(
	'name' => _x( $taxonomy['name'], 'taxonomy general name' ),
	'singular_name' => _x( $taxonomy['singular_name'], 'taxonomy singular name' ),
	'search_items' =>  __( 'Search '.$taxonomy['name'] ),
	'popular_items' => __( 'Popular '.$taxonomy['name'] ),
	'all_items' => __( 'All '.$taxonomy['name'] ),
	'parent_item' => null,
	'parent_item_colon' => null,
	'edit_item' => __( 'Edit '.$taxonomy['singular_name'] ), 
	'update_item' => __( 'Update '.$taxonomy['singular_name'] ),
	'add_new_item' => __( 'Add New '.$taxonomy['singular_name'] ),
	'new_item_name' => __( 'New '.$taxonomy['singular_name'].' Name' ),
	'separate_items_with_commas' => __( 'Separate '.strtolower($taxonomy['name']).' with commas' ),
	'add_or_remove_items' => __( 'Add or remove '.strtolower($taxonomy['name']) ),
	'choose_from_most_used' => __( 'Choose from the most used '.strtolower($taxonomy['name']) ),
	'menu_name' => __($taxonomy['name'])
); 

$skills_labels = array(
	'name' => _x( $skills['name'], 'taxonomy general name' ),
	'singular_name' => _x( $skills['singular_name'], 'taxonomy singular name' ),
	'search_items' =>  __( 'Search '.$skills['name'] ),
	'popular_items' => __( 'Popular '.$skills['name'] ),
	'all_items' => __( 'All '.$skills['name'] ),
	'parent_item' => null,
	'parent_item_colon' => null,
	'edit_item' => __( 'Edit '.$skills['singular_name'] ), 
	'update_item' => __( 'Update '.$skills['singular_name'] ),
	'add_new_item' => __( 'Add New '.$skills['singular_name'] ),
	'new_item_name' => __( 'New '.$skills['singular_name'].' Name' ),
	'separate_items_with_commas' => __( 'Separate '.strtolower($skills['name']).' with commas' ),
	'add_or_remove_items' => __( 'Add or remove '.strtolower($skills['name']) ),
	'choose_from_most_used' => __( 'Choose from the most used '.strtolower($skills['name']) ),
	'menu_name' => __($skills['name'])
); 

register_taxonomy($taxonomy['type'], $taxonomy['post_type'], array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => $taxonomy['slug'] )
));

register_taxonomy($skills['type'], $skills['post_type'], array(
	'hierarchical' => false,
	'labels' => $skills_labels,
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => $skills['slug'] )
));