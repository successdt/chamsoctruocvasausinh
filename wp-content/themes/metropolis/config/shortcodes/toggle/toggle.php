<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/
function shortcode_toggle( $atts, $content = null ){
	$title = $atts["title"];
	$open = in_array("open", $atts) ? "default_open" : "";
		
	return '<div class="shortcode_toggle"><h2 class="slide_trigger '.$open.'"><a href="#"><span class="toggle"></span>'.$title.'</a></h2><div class="slide_container"><div class="slide_inside">' . do_shortcode(wptexturize(wpautop($content))) . '</div></div></div>';
}

add_shortcode( 'toggle', 'shortcode_toggle' );