<?php
/*
	Description: Theme option page.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

// FONTS ======================================================================

$fonts = getFonts();

// SECTIONS ===================================================================

$sections = array(
	"General" => array(
		"fields" => array(
			array( 
				"name" => "Custom CSS",
				"desc" => "If you need to quickly edit small bits of your site's style, paste your custom CSS code here. For bigger changes we recommend modifying the <code>style.css</code> file.",
				"key" => "_custom_css",
				"type" => "textareacode",
				"rows" => 15,
				"std" => ""
			)
		)
	),
	"Colors" => array(
		"fields" => array(
			array( 
				"name" => "Highlight color",
				"desc" => "This is the color of your links and higlighted parts.",
				"key" => "_main_color",
				"type" => "color",
				"std" => ""
			),
			array(
				"name" => "Layout background colors",
				"desc" => "",
				"key" => "",
				"type" => "heading"
			),
			array( 
				"name" => "Top bar",
				"desc" => "This is the background color of the top bar.",
				"key" => "_topbar_background_color",
				"type" => "color",
				"std" => ""
			),
			array( 
				"name" => "Menu",
				"desc" => "This is the background color of the menu.",
				"key" => "_menu_background_color",
				"type" => "color",
				"std" => ""
			),
			array( 
				"name" => "Sub menu",
				"desc" => "This is the background color of the sub menu.",
				"key" => "_submenu_background_color",
				"type" => "color",
				"std" => ""
			),
			array( 
				"name" => "Top widget area",
				"desc" => "This is the background color of the top widget area.",
				"key" => "_topwidgetarea_background_color",
				"type" => "color",
				"std" => ""
			),
			array( 
				"name" => "Main container",
				"desc" => "This is the background color of the page container.",
				"key" => "_body_background_color",
				"type" => "color",
				"std" => ""
			),
			array( 
				"name" => "Footer widget area",
				"desc" => "This is the background color of the footer widget area.",
				"key" => "_footerwidgetarea_background_color",
				"type" => "color",
				"std" => ""
			),
		)
	),
	"Typography" => array(
		"fields" => array(
			array( 
				"name" => "Page title",
				"desc" => "",
				"key" => "_font_pagetitle",
				"type" => "googlefont",
				"options" => $fonts,
				"std" => ""
			),
			array( 
				"name" => "Page subtitle",
				"desc" => "",
				"key" => "_font_pagesubtitle",
				"type" => "googlefont",
				"options" => $fonts,
				"std" => ""
			),
			array( 
				"name" => "Text",
				"desc" => "",
				"key" => "_font_text",
				"type" => "googlefont",
				"options" => $fonts,
				"std" => ""
			),
			array( 
				"name" => "Footer text",
				"desc" => "",
				"key" => "_font_footertext",
				"type" => "googlefont",
				"options" => $fonts,
				"std" => ""
			),
			array( 
				"name" => "Slide heading",
				"desc" => "",
				"key" => "_font_slideheading",
				"type" => "googlefont",
				"options" => $fonts,
				"std" => ""
			),
			array(
				"name" => "Menu",
				"desc" => "",
				"key" => "",
				"type" => "heading"
			),
			array( 
				"name" => "Main",
				"desc" => "",
				"key" => "_font_menu",
				"type" => "googlefont",
				"options" => $fonts,
				"std" => ""
			),
			array( 
				"name" => "Submenu",
				"desc" => "",
				"key" => "_font_submenu",
				"type" => "googlefont",
				"options" => $fonts,
				"std" => ""
			),
			array(
				"name" => "Widget areas headings",
				"desc" => "",
				"key" => "",
				"type" => "heading"
			),
			array( 
				"name" => "Main sidebar widget headings",
				"desc" => "",
				"key" => "_font_widgetheadings",
				"type" => "googlefont",
				"options" => $fonts,
				"std" => ""
			),
			array( 
				"name" => "Top area widget headings",
				"desc" => "",
				"key" => "_font_topareawidgetheadings",
				"type" => "googlefont",
				"options" => $fonts,
				"std" => ""
			),
			array( 
				"name" => "Footer area widget headings",
				"desc" => "",
				"key" => "_font_footerareawidgetheadings",
				"type" => "googlefont",
				"options" => $fonts,
				"std" => ""
			)
		)
	)
);

$Style_builder = new optionpage($sections);
$message = $Style_builder->save();

$Style_builder->setMessage($message);
$Style_builder->render();

$items = thb_get_duplicable(CUSTOMFONT);
foreach($items as $item) {
	$url = $item['url'];
	echo "<link rel='stylesheet' href='" . $url . "'>";
}