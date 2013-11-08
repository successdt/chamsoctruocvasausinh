<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

/*
 * Theme menu
 */
$theme['menu'] = array(
	THEMENAME,
	'Slideshow',
	'Sidebars',
	'Style',
	'Upload your fonts',
	'Help'
);

/*
 * Post types
 */
$theme['post_types'] = array(
	"Posts",
	"Pages",
	"Works",
	"Testimonials"
);

/* 
 * Post formats
 * aside, gallery, link, image, quote, status, video, audio, chat
 */
$theme['post_formats'] = array('gallery');

/*
 * Taxonomies
 */
$theme['taxonomies'] = array(
	"TypesTaxonomy"
);

/*
 * WordPress custom menus
 */
$theme['wp_menus'] = array(
	'primary' 	=> 'Primary',
	'secondary' => 'Secondary',
	'tertiary' => 'Tertiary'
);

/*
 * Sidebars
 */
$theme['sidebar_template'] = array(
	'name'          => 'Primary widget area',
	'id'            => 'primary-widget-area',
	'description'   => '',
	'before_widget' => '<div class="widget primary block">',
	'after_widget'  => '</div>',
	'before_title'  => '<header><h3>',
	'after_title'   => '</h3></header>'
);

$theme['sidebars'] = array(
	array(
		'name'          => 'Main sidebar',
		'id'            => 'primary-widget-area',
		'description'   => '',
		'before_widget' => '<div class="widget primary block">',
		'after_widget'  => '</div>',
		'before_title'  => '<header><h3>',
		'after_title'   => '</h3></header>'
	)
);

$theme['system_sidebars'] = array();

// Top sidebar
$topsidebar_layout_columns = get_option(THEMEPREFIX . "_top_sidebar_columns_number");

for( $i=1; $i<=$topsidebar_layout_columns; $i++ ) {
	$theme['system_sidebars'][] = array(
		'name'          => 'Top area column ' . $i,
		'id'            => 'top-page-widget-area-' . $i,
		'description'   => '',
		'before_widget' => '<div class="widget primary block">',
		'after_widget'  => '</div>',
		'before_title'  => '<header><h3>',
		'after_title'   => '</h3></header>'
	);
}

// Footer sidebars
$footer_layout_columns = get_option(THEMEPREFIX . "_footer_columns_number");

for( $i=1; $i<=$footer_layout_columns; $i++ ) {
	$theme['system_sidebars'][] = array(
		'name'          => 'Footer area column ' . $i,
		'id'            => 'footer-widget-area-' . $i,
		'description'   => '',
		'before_widget' => '<div class="widget footer block">',
		'after_widget'  => '</div>',
		'before_title'  => '<header><h3>',
		'after_title'   => '</h3></header>'
	);
}

/**
 * Page templates that allow for a sidebar
 */
$theme['pages_with_sidebars'] = array(
	"template-contact.php"
);

/*
 * Widgets
 */
$theme['widgets'] = array(
	"contact/widget_contact",
	"news/news",
	"news/popular",
	"news/category",
	"social/social",
	"twitter/widget_twitter",
	"flickr/widget_flickr",
	"works/works",
	"pages/pages",
	"map/widget_map",
	"testimonials/widget_testimonials",
	"testimonials/widget_testimonial",
	"taxonomies/widget_tags"
);

/*
 * Shortcodes
 */
$theme['shortcodes'] = array(
	"shortcodes",
	"toggle/toggle",
	"columns/columns",
	"general/general",
	"buttons/buttons",
	"tabs/tabs",
	"accordion/accordion",
	"testimonials",
	"thb_gallery",
	"pricing/pricingtable",
	"messages/messages"
);

/*
 * Image sizes
 */
$theme['imagesizes'] = array(
	array("micro", 50, 50, true),
	array("thumbnail", 120, 120, true),
	array("small", 280, 200, true),
	array("medium", 360, null, true),
	array("large", 600, null, true),
	
	array("portfolio", 460, 300, true),
	array("portfolio-large", 900, null, true)
);

/**
 * Custom entry slides number
 */
$slides_number = get_option(THEMEPREFIX . "_slideshow_slide_number");
if( empty($slides_number) ) $slides_number = 5;
define("ENTRY_SLIDES_NUM", $slides_number);