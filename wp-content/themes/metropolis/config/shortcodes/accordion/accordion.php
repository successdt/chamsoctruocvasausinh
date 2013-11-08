<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

function shortcode_accordion_container($atts, $content=null) {
	$open = (is_array($atts) && !empty($atts) && in_array("first_element_opened", $atts)) ? "first_element_opened" : "";

	$accordion_container = "<div class='accordion $open'>";
		$accordion_container .= do_shortcode($content);
	$accordion_container .= "</div>";

	return $accordion_container;
}

function shortcode_accordion_item( $atts, $content = null ){
	$title = $atts["title"];

	$accordion_item = "<div class='acc_item'>";
		$accordion_item .= '<h2 class="acc_trigger"><a href="#"><span class="toggle"></span>'.$title.'</a></h2><div class="acc_container">' . do_shortcode(wptexturize(wpautop($content))) . '</div>';
	$accordion_item .= "</div>";

	return $accordion_item;
}

function shortcode_nested_accordion( $atts, $content = null ){
	$title = $atts["title"];

	$accordion_item = "<div class='acc_item_sub'>";
		$accordion_item .= '<h2 class="acc_trigger_sub"><a href="#"><span class="toggle"></span>'.$title.'</a></h2><div class="acc_container_sub">' . do_shortcode(wptexturize(wpautop($content))) . '</div>';
	$accordion_item .= "</div>";

	return $accordion_item;
}

add_shortcode( 'nested-accordion', 'shortcode_nested_accordion' );
add_shortcode( 'accordion', 'shortcode_accordion_item' );
add_shortcode( 'accordion_container', 'shortcode_accordion_container' );