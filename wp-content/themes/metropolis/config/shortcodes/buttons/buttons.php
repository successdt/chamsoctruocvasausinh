<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

// Buttons
function shortcode_small_btn( $atts, $content = null) {
	$link = isset($atts["link"]) ? $atts["link"] : "";
	$color = isset($atts["color"]) ? $atts["color"] : "";
	return '<a class="small btn '.$color.'" href="'.$link.'">'. wptexturize($content) .'</a>';
}
add_shortcode('button-small', 'shortcode_small_btn');

function shortcode_medium_btn( $atts, $content = null) {
	$link = isset($atts["link"]) ? $atts["link"] : "";
	$color = isset($atts["color"]) ? $atts["color"] : "";
	return '<a class="medium btn '.$color.'" href="'.$link.'">'. wptexturize($content) .'</a>';
}
add_shortcode('button-medium', 'shortcode_medium_btn');

function shortcode_large_btn( $atts, $content = null) {
	$link = isset($atts["link"]) ? $atts["link"] : "";
	$color = isset($atts["color"]) ? $atts["color"] : "";
	return '<a class="big btn '.$color.'" href="'.$link.'">'. wptexturize($content) .'</a>';
}
add_shortcode('button-large', 'shortcode_large_btn');

function shortcode_custom_btn( $atts, $content = null) {
	$link = isset($atts["link"]) ? $atts["link"] : "";
	$color = isset($atts["color"]) ? $atts["color"] : "";
	return '<a class="custom-btn" href="'.$link.'" style="background-color:'.$color.';">'. wptexturize($content) .'</a>';
}
add_shortcode('button-custom', 'shortcode_custom_btn');