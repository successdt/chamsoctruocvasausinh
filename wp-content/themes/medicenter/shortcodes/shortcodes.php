<?php
//slider
require_once("slider.php");
//home box
require_once("home_box.php");
//blog
require_once("blog.php");
//post
require_once("single-post.php");
//items_list
require_once("items_list.php");
//columns
require_once("columns.php");
//timetable
require_once("timetable.php");
//map
require_once("map.php");
//accordion
//require_once("accordion.php");
//nested tabs
//require_once("nested_tabs.php");
//carousel
require_once("carousel.php");
//small slider
require_once("small_slider.php");
//photostream
require_once("photostream.php");
//announcement box
require_once("announcement_box.php");
//testimonials
require_once("testimonials.php");
//notification box
require_once("notification_box.php");
//icon
require_once("icon.php");

//page layout
function theme_page_layout($atts, $content)
{
	return '<div class="page_layout clearfix">' . do_shortcode($content) . '</div>';
}
add_shortcode("page_layout", "theme_page_layout");

//page left
function theme_page_left($atts, $content)
{
	if(is_active_sidebar('left-top'))
	{
		ob_start();
		get_sidebar('left-top');
		$sidebar_left_top = ob_get_contents();
		ob_end_clean();
	}
	return '<div class="page_left">' . $sidebar_left_top . do_shortcode($content) . '</div>';
}
add_shortcode("page_left", "theme_page_left");

//page right
function theme_page_right($atts, $content)
{
	if(is_active_sidebar('right-top'))
	{
		ob_start();
		get_sidebar('right-top');
		$sidebar_right_top = ob_get_contents();
		ob_end_clean();
	}
	return '<div class="page_right">' . $sidebar_right_top . do_shortcode($content) . '</div>';
}
add_shortcode("page_right", "theme_page_right");

//button more
function theme_button_more($atts, $content)
{
	extract(shortcode_atts(array(
		"color" => "black",
		"arrow" => "margin_right_white",
		"href" => "#",
		"title" => "More"
	), $atts));
	
	return '<a class="more ' . $color . ($arrow!="" ? ' icon_small_arrow ' . $arrow : '') . '" href="' . $href . '" title="' . $title . '">' . do_shortcode($content) . '</a>';
}
add_shortcode("button_more", "theme_button_more");

//box_header
function theme_box_header($atts)
{
	extract(shortcode_atts(array(
		"title" => "Sample Header",
		"type" => "h3",
		"class" => "",
		"bottom_border" => 1,
		"top_margin" => "none"
	), $atts));
	return '<' . $type . ' class="box_header' . ($class!="" ? ' ' . $class : '') . (!(int)$bottom_border ? ' no_border' : '') . ($top_margin!="none" ? ' ' . $top_margin : '') . '">' . do_shortcode($title) . '</' . $type . '>';
}
add_shortcode("box_header", "theme_box_header");
//visual composer
wpb_map( array(
	"name" => __("Box header", 'medicenter'),
	"base" => "box_header",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-box-header",
	"category" => __('MediCenter', 'medicenter'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'medicenter'),
			"param_name" => "title",
			"value" => "Sample Header"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'medicenter'),
			"param_name" => "type",
			"value" => array(__("H3", 'medicenter') => "h3",  __("H1", 'medicenter') => "h1", __("H2", 'medicenter') => "h2", __("H4", 'medicenter') => "h4", __("H5", 'medicenter') => "h5")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Bottom border", 'medicenter'),
			"param_name" => "bottom_border",
			"value" => array(__("yes", 'medicenter') => 1,  __("no", 'medicenter') => 0)
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'medicenter'),
			"param_name" => "class",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page_margin_top", __("Section (large)", 'medicenter') => "page_margin_top_section")
		)
	)
));

//dropcap
function theme_dropcap($atts, $content)
{
	extract(shortcode_atts(array(
		"id" => "",
		"label" => "1",
		"label_background_color" => "",
		"custom_label_background_color" => "",
		"label_color" => "",
		"content_text_color" => "",
		"class" => "",
		"top_margin" => "none"
	), $atts));
	
	$label_background_color = ($custom_label_background_color!="" ? $custom_label_background_color : $label_background_color);
	return ($content_text_color!="" && $id!="" ? '<style type="text/css">#' . $id . ' p{color:' . $content_text_color . ';}</style>': '') . '<div' . ($id!="" ? ' id="' . $id . '"' : '') . ' class="dropcap' . ($top_margin!="none" ? ' ' . $top_margin : '') . '"><div class="dropcap_label"' . ($label_background_color!="" ? ' style="background-color:' . $label_background_color . ';"' : '') . '><h3' . ($label_color!="" ? ' style="color:' . $label_color . ';"' : '') . '>' . $label . '</h3></div>' . wpb_js_remove_wpautop($content) . '</div>';
}
add_shortcode("dropcap", "theme_dropcap");
//visual composer
$mc_colors_arr = array(__("Dark blue", "js_composer") => "#3156a3", __("Blue", "js_composer") => "#0384ce", __("Light blue", "js_composer") => "#42b3e5", __("Black", "js_composer") => "#000000", __("Gray", "js_composer") => "#AAAAAA", __("Dark gray", "js_composer") => "#444444", __("Light gray", "js_composer") => "#CCCCCC", __("Green", "js_composer") => "#43a140", __("Dark green", "js_composer") => "#008238", __("Light green", "js_composer") => "#7cba3d", __("Orange", "js_composer") => "#f17800", __("Dark orange", "js_composer") => "#cb451b", __("Light orange", "js_composer") => "#ffa800", __("Red", "js_composer") => "#db5237", __("Dark red", "js_composer") => "#c03427", __("Light red", "js_composer") => "#f37548", __("Turquoise", "js_composer") => "#0097b5", __("Dark turquoise", "js_composer") => "#006688", __("Light turquoise", "js_composer") => "#00b6cc", __("Violet", "js_composer") => "#6969b3", __("Dark violet", "js_composer") => "#3e4c94", __("Light violet", "js_composer") => "#9187c4", __("White", "js_composer") => "#FFFFFF", __("Yellow", "js_composer") => "#fec110");
wpb_map( array(
	"name" => __("Dropcap text", 'medicenter'),
	"base" => "dropcap",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-dropcap",
	"category" => __('MediCenter', 'medicenter'),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Id", 'medicenter'),
			"param_name" => "id",
			"value" => "",
			"description" => __("Please provide unique id for each dropcap on the same page/post if you would like to have custom content color for each one", 'medicenter')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Label", 'medicenter'),
			"param_name" => "label",
			"value" => "1"
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content", 'medicenter'),
			"param_name" => "content",
			"value" => ""
		),
		array(
            "type" => "dropdown",
            "heading" => __("Label background color", "medicenter"),
            "param_name" => "label_background_color",
            "value" => $mc_colors_arr,
            "description" => __("Button color.", "js_composer")
        ),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom label background color", 'medicenter'),
			"param_name" => "custom_label_background_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Label text color", 'medicenter'),
			"param_name" => "label_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content text color", 'medicenter'),
			"param_name" => "content_text_color",
			"value" => "",
			"description" => __("If you would like to use 'Content text color', you need to fill 'Id' field", 'medicenter')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'medicenter'),
			"param_name" => "class",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page_margin_top", __("Section (large)", 'medicenter') => "page_margin_top_section")
		)
	)
));

//show all
function theme_show_all_button($atts)
{
	extract(shortcode_atts(array(
		"url" => "blog",
		"title" => __("Show all &rarr;", 'medicenter')
	), $atts));
	return '<div class="show_all clearfix"><a href="' . $url . '" title="' . esc_attr($title) . '">' . $title . '</a></div>';
}
add_shortcode("show_all_button", "theme_show_all_button");
//visual composer
wpb_map( array(
	"name" => __("Show all button", 'medicenter'),
	"base" => "show_all_button",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-shape-text",
	"category" => __('MediCenter', 'medicenter'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'medicenter'),
			"param_name" => "title",
			"value" => __("Show all &rarr;", 'medicenter')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Url", 'medicenter'),
			"param_name" => "url",
			"value" => "blog"
		)
	)
));

//sentence
function theme_sentence($atts)
{
	extract(shortcode_atts(array(
		"title" => "Sample Sentence Text",
		"author" => ""
	), $atts));
	return '<h3 class="sentence">' . do_shortcode($title) . '</h3>' . ($author!="" ? '<div class="clearfix"><span class="sentence_author">' . $author . '</span></div>' : '');
}
add_shortcode("sentence", "theme_sentence");
//visual composer
wpb_map( array(
	"name" => __("Sentence", 'medicenter'),
	"base" => "sentence",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-sentence",
	"category" => __('MediCenter', 'medicenter'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'medicenter'),
			"param_name" => "title",
			"value" => "Sample Sentence Text"
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Author", 'medicenter'),
			"param_name" => "author",
			"value" => ""
		)
	)
));

//sidebar box
function theme_sidebar_box($atts, $content)
{
	extract(shortcode_atts(array(
		"first" => false
	), $atts));
	return '<div class="sidebar_box' . ($first ? ' first' : '') . '">' . do_shortcode($content) . '</div>';
}
add_shortcode("sidebar_box", "theme_sidebar_box");

//scroll top
function theme_scroll_top($atts, $content)
{
	extract(shortcode_atts(array(
		"title" => "Scroll to top",
		"label" => "Top"
	), $atts));
	
	return '<a class="scroll_top icon_small_arrow top_white" href="#top" title="' . esc_attr($title) . '">' . esc_attr($label) . '</a>';
}
add_shortcode("scroll_top", "theme_scroll_top");

//box_header
function theme_info_text($atts, $content)
{
	extract(shortcode_atts(array(
		"color" => "white",
		"class" => ""
	), $atts));
	return '<h4 class="info_' . $color . ' ' . $class . '">' . do_shortcode($content) . '</h4>';
}
add_shortcode("info_text", "theme_info_text");
?>