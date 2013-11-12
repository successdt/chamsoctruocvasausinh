<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

function shortcode_col( $atts, $content = null, $shortcodename ="" ){
	$class = "content-$shortcodename";
	if(is_array($atts) and count($atts) > 0) {
		foreach($atts as $a)
			$class .= " " . $a;
	}
	return '<div class="box-col '.$class.'">' . wptexturize(do_shortcode($content)) . '</div>';
}

add_shortcode( 'one-third', 'shortcode_col' ); // 1-3
add_shortcode( 'two-third', 'shortcode_col' ); // 2-3
add_shortcode( 'one-fourth', 'shortcode_col' ); // 1-4
add_shortcode( 'two-fourth', 'shortcode_col' ); // 2-4
add_shortcode( 'three-fourth', 'shortcode_col' ); // 3-4
add_shortcode( 'one-fifth', 'shortcode_col' ); // 1-5
add_shortcode( 'two-fifth', 'shortcode_col' ); // 2-5
add_shortcode( 'three-fifth', 'shortcode_col' ); // 3-5
add_shortcode( 'four-fifth', 'shortcode_col' ); // 4-5
add_shortcode( 'full', 'shortcode_col' ); // full width

?>