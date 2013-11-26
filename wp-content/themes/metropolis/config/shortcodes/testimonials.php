<?php

/**
 * Testimonials shortcode
 */
function shortcode_testimonial( $atts, $content=null )
{
	global $theme;
	$sidebar_template = $theme['sidebar_template'];

	// Atts
	extract( shortcode_atts( array(
		'title' => '',
		'id' => 0,
		'items' => 3,
		'style' => 1,
		'showexcerpt' => 1,
		'before_widget' => $sidebar_template['before_widget'],
		'after_widget' => $sidebar_template['after_widget'],
		'before_title' => $sidebar_template['before_title'],
		'after_title' => $sidebar_template['after_title']
	), $atts ) );

	// Shortcode mode
	$shortcode_mode = $id != 0 ? 'single' : 'list';

	// Get testimonials
	$args = array(
		"posts_per_page" => $shortcode_mode == 'single' ? 1 : $items
	);

	if( $shortcode_mode == 'single' ) {
		$args['p'] = $id;
	}

	$entries = thb_get_posts("testimonials", $args);

	// Shortcode output
	$output="";

	$output .= $before_widget;

		$output .= $before_title . $title . $after_title;

		if( $entries->have_posts() ) {
			while( $entries->have_posts() ) {
				$entries->the_post();

				$output .= "<div class='item testimonials-box style-". $style ."'>";

					// Promotion variables ------------------------------------
					$id = get_the_ID();
					$excerpt = get_the_excerpt();
					// $content = get_the_content();
					$permalink = get_permalink($id);
					$title = get_the_title();
					$featured_image = thb_get_featured_image($id, "thumbnail");
					$company = thb_get_post_meta($id, "_company");

					// Promotion body -----------------------------------------
					if( !empty($excerpt) ) {
						$output .= '<p class="testimonial-msg">' . $excerpt . '</p>';
					}

					$output .= '<p class="testimonial-sign">';
						$output .= "" . $title;
						if( !empty($company) ) {
							$output .= " &mdash; " . $company;
						}
					$output .= '</p>';

					// --------------------------------------------------------

				$output .= "</div>";
			}
		}

	$output .= $after_widget;

	return $output;
}
add_shortcode("thb_testimonials", "shortcode_testimonial");