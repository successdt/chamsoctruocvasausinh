<?php

$sidebars = get_sidebars_for_select();
$categories = get_categories();

$blog_categories = array();
$blog_categories[] = "-- All categories";
foreach($categories as $c) {
	$blog_categories[$c->term_id] = $c->name; 
}

$works_categories = array();
$works_categories[] = "-- All types";
$terms = get_terms("types");
if( !empty($terms) ) {
	foreach($terms as $t) {
		$works_categories[$t->term_id] = $t->name;
	}
}

/*
 * Pages metaboxes (if any)
 */
$pages_metaboxes = array(
	__("Subtitle", THEMENAME) => array(
		"id" => "subtitle",
		"position" => "normal",
		"priority" => "high",
		"fields" => array(
			array ( 
				"name" => "",
				"desc" => "",
				"key" => "_page_subtitle",
				"type" => "text",
				"std" => ""
			)
		)
	),
    __("Extra", THEMENAME) => array(
		"position" => "normal",
		"priority" => "high",
		"fields" => array(
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
	__("Sidebar", THEMENAME) => array(
		"id" => "sidebar",
		"position" => "side",
		"priority" => "core",
		"fields" => array(
			array ( 
				"name" => "",
				"desc" => "The sidebar associated to this page",
				"key" => "_page_sidebar",
				"type" => "select",
				"options" => $sidebars,
				"std" => ""
			)
		)
	),
	__("Blog options", THEMENAME) => array(
		"id" => "blog",
		"position" => "normal",
		"priority" => "low",
		"fields" => array(
			array ( 
				"name" => "",
				"desc" => "Filter the page by the selected category",
				"key" => "_page_blog_category_filter",
				"type" => "select",
				"options" => $blog_categories,
				"std" => ""
			)
		)
	),
	__("Portfolio options", THEMENAME) => array(
		"id" => "portfolio",
		"position" => "normal",
		"priority" => "low",
		"fields" => array(
			array ( 
				"name" => "",
				"desc" => "Filter the page by the selected work category",
				"key" => "_page_portfolio_category_filter",
				"type" => "select",
				"options" => $works_categories,
				"std" => ""
			)
		)
	)
);

$thb_custom_pages = new CustomPage($pages_metaboxes);