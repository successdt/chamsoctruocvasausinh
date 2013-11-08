<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

function shortcode_h1( $atts, $content = null) {
	return '<h1>' . wptexturize($content) . '</h1>';
}
add_shortcode('h1', 'shortcode_h1');

function shortcode_h2( $atts, $content = null) {
	return '<h2>' . wptexturize($content) . '</h2>';
}
add_shortcode('h2', 'shortcode_h2');

function shortcode_h3( $atts, $content = null) {
	return '<h3>' . wptexturize($content) . '</h3>';
}
add_shortcode('h3', 'shortcode_h3');

function shortcode_h4( $atts, $content = null) {
	return '<h4>' . wptexturize($content) . '</h4>';
}
add_shortcode('h4', 'shortcode_h4');

function shortcode_h5( $atts, $content = null) {
	return '<h5>' . wptexturize($content) . '</h5>';
}
add_shortcode('h5', 'shortcode_h5');

function shortcode_medium( $atts, $content = null) {
	return '<p class="medium">' . wptexturize($content) . '</p>';
}
add_shortcode('medium', 'shortcode_medium');

function shortcode_code( $atts, $content = null) {
	return '<pre><code>' . wptexturize($content) . '</code></pre>';
}
add_shortcode('code', 'shortcode_code');

function shortcode_cite( $atts, $content = null) {
	$link = $atts["link"];
	$author = $atts["author"];	
	return '<cite><a href="'.$link.'">'.$author.'</a>, ' . wptexturize($content) . '</cite>';
}
add_shortcode('cite', 'shortcode_cite');

function shortcode_highlight( $atts, $content = null) {
	return '<ins>' . wptexturize($content) . '</ins>';
}
add_shortcode('highlight', 'shortcode_highlight');

function shortcode_acronym( $atts, $content = null) {
	$title = $atts["title"];
	return '<acronym title="'.$title.'">' . wptexturize($content) . '</acronym>';
}
add_shortcode('acronym', 'shortcode_acronym');

function shortcode_abbr( $atts, $content = null) {
	$title = $atts["title"];
	return '<abbr title="'.$title.'">' . wptexturize($content) . '</abbr>';
}
add_shortcode('abbr', 'shortcode_abbr');

function shortcode_del( $atts, $content = null) {
	return '<del>' . wptexturize($content) . '</del>';
}
add_shortcode('del', 'shortcode_del');

function shortcode_divider( $atts, $content = null) {
	return '<span class="divider"></span>';
}
add_shortcode('divider', 'shortcode_divider');

function shortcode_video($atts, $content = null) {
	$id = $atts['id'];
	$width = isset($atts['width']) ? $atts['width'] : "";
	$height = isset($atts['height']) ? $atts['height'] : "";

	if($width == "" && $height == "") {
		$width = 640;
		$height = 390;
	};

	$video_code = getVideoCode($id);
	$code = "";
	
	if(is_youtube($id)) {
		$wmode = "?wmode_transparent";
		if( strpos($video_code, "?") !== false ) {
			$wmode = "&wmode_transparent";
		}

		$code = '<iframe style="width:'.$width.'px !important; height:'.$height.'px !important;" width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video_code.$wmode.'" frameborder="0" allowfullscreen></iframe>';
	}
	elseif(is_vimeo($id)) {
		$code = '<iframe style="width:'.$width.'px !important; height:'.$height.'px !important;" src="http://player.vimeo.com/video/'.$video_code.'?title=0&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';
	}

	return $code;
}

add_shortcode("video", "shortcode_video");

function shortcode_widget_icon( $atts, $content = null) {
	$url = isset($atts["url"]) ? $atts["url"] : "";
	return '<img class="widget-icon" src="'.$url.'" alt="" />';
}
add_shortcode('icon', 'shortcode_widget_icon');

function shortcode_dropcap_colored( $atts, $content = null) {
	return '<span class="dropcap1">' . wptexturize($content) . '</span>';
}
add_shortcode('dropcap1', 'shortcode_dropcap_colored');

function shortcode_dropcap_colored_custom( $atts, $content = null) {
	$color = $atts['color'];
	return '<span class="dropcap3" style="background-color: '.$color.'">' . wptexturize($content) . '</span>';
}
add_shortcode('dropcap3', 'shortcode_dropcap_colored_custom');

function shortcode_dropcap_bigletter( $atts, $content = null) {
	return '<span class="dropcap2">' . wptexturize($content) . '</span>';
}
add_shortcode('dropcap2', 'shortcode_dropcap_bigletter');

function shortcode_iconbox( $atts, $content = null) {

	// Atts
	extract( shortcode_atts( array(
		'title'    => '',
		'iconsize' => '',
		'url'      => ''
	), $atts ) );

	$iconsize = $iconsize + 15;

	$output = "";

	$class="";
	if( isset($atts[0]) && $atts[0] == 'center' )
		$class = "center";

	$output .= '<div class="icon-box '.$class.'"';

	if( !isset($atts[0]) || $atts[0] != 'center' ) {

		if( !empty($iconsize) ) {
			$output.= 'style="padding-left:'.$iconsize.'px;"';
		}

	}

	$output .= '>';

	if( !empty($url) ) {
		$output .= '<img class="widget-icon" src="'.$url.'" alt="" ';
	}

	if( !isset($atts[0]) || $atts[0] != 'center' ) {
	
		if ( !empty($iconsize) ) {
			$output .= 'style="margin-left: -'.$iconsize.'px;"';
		}
	
	}
	
	$output .= ' />';

	if( !empty($title) ) {
		$output .= '<h3>'.$title.'</h3>';
	}

	$output .= wptexturize($content);

	$output .= '</div>';

	return $output;
}
add_shortcode('iconbox', 'shortcode_iconbox');