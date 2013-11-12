<?php

/**
 * Pricing table shortcode.
 * 
 * @param  array $atts         
 * @param  string $content=null 
 * @return string
 */
function thb_pricingtable( $atts, $content=null ) {

	// Atts
	extract( shortcode_atts( array(
		'cols' => 4
	), $atts ) );

	$output = '<section class="pricing-table col-' . $cols . '">';
		$output .= wptexturize(wpautop(do_shortcode($content)));
	$output .= '</section>';

	return $output;

}

// Register the shortcode
add_shortcode("pricingtable", "thb_pricingtable");

/**
 * Pricing table plan shortcode.
 * 
 * @param  array $atts         
 * @param  string $content=null 
 * @return string
 */
function thb_pricingtable_plan( $atts, $content=null ) {

	// Atts
	extract( shortcode_atts( array(
		'title'        => '',
		'price'        => '',
		'price_tag'    => '',
		'button_url'   => '',
		'button_text'  => '',
		'button_color' => '',
		'color'        => '',
		'head_color'   => ''
	), $atts ) );

	$class="";
	if( isset($atts[0]) && $atts[0] == 'featured' )
		$class = "featured";

	$border_color = "";
	if( !empty($color)  && $class=="featured") {
		$border_color = 'style="border-color: '.$color.'"';
	}

	$output = '<section class="plan '.$class.'" '.$border_color.'>';

		$head_style = "";
		if( !empty($color) ) {
			$head_style .= 'background-color: '.$color.';';
			$head_style .= 'border-bottom-color: '.$color.';';
		}
		if( !empty($head_color) ) {
			$head_style .= 'color: '.$head_color.';';
		}

		$output .= '<header class="plan-head" style="'.$head_style.'">';
			if( !empty($title) ) {
				$output .= '<h1>' . $title . '</h1>';
			}

			if( !empty($price) ) {
				$output .= '<h2 class="price">' . $price;
				if( !empty($price_tag) ) {
					$output .= ' <span>' . $price_tag . '</span>';
				}
				$output .= '</h2>';
			}
		$output .= '</header>';
		$output .= '<section class="plan-content">';
			$output .= apply_filters('the_content', $content);
		$output .= '</section>';
		$output .= '<section class="plan-footer">';
			if( !empty($button_url) && !empty($button_text) ) {

				$button_size = "small";
				if( $class == "featured" )
					$button_size = "medium";

				$output .= '<a href="' . $button_url . '" class="btn ' . $button_color . ' ' . $button_size . '">' . $button_text . '</a>';
			}
		$output .= '</section>';
	$output .= '</section>';

	return $output;
	
}

// Register the shortcode
add_shortcode("plan", "thb_pricingtable_plan");