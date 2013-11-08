<?php

/**
 * Notice shortcode.
 * 
 * @param  array $atts         
 * @param  string $content=null 
 * @return string
 */
function thb_message( $atts, $content=null ) {

	// Atts
	extract( shortcode_atts( array(
		'type' => 'notice'
	), $atts ) );

	$output = '<div class="message-box ' . $type . '">';
		if( $type != 'notice' ) {
			$icon_src = CONFIGURL . "/shortcodes/messages/i/$type.png";
			$output .= '<img class="icon" src="'.$icon_src.'" />';
		}
		$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;

}

// Register the shortcode
add_shortcode("message", "thb_message");