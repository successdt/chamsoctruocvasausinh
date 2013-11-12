<?php
/*
	Description: Popular posts custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/
class WP_Widget_PopularPosts extends WP_Widget_News {

	var $name = "Popular posts";
	var $description = 'Display the popular posts.';
	var $title = "Popular posts";

	/**
	 * Constructor
	 */
	function WP_Widget_PopularPosts()
	{
		$widget_ops = array('classname' => 'widget_popularposts', 'description' => "Display the popular posts." );
		$this->WP_Widget('thb_popular', "Popular posts", $widget_ops);
	}

	protected function compose_filter()
	{
		$this->filter['orderby'] = 'comment_count';
	}

}

register_widget('WP_Widget_PopularPosts');

/**
 * Popular posts shortcode
 */
function thb_popular_posts_shortcode($atts, $content=null) {
	global $theme;
	$sidebar_template = $theme['sidebar_template'];
	ob_start(); // prevent widget wrong placement

	$args = array(
		'before_widget' => $sidebar_template['before_widget'],
		'after_widget' => $sidebar_template['after_widget'],
		'before_title' => $sidebar_template['before_title'],
		'after_title' => $sidebar_template['after_title']
	);

	$atts = shortcode_atts( array(
		'title' => '',
		'numposts' => 3,
		'showthumb' => 0
	), $atts );

	$widget = new WP_Widget_PopularPosts();
	$widget->widget($args, $atts);

	$clean = ob_get_clean(); // prevent widget wrong placement
	return $clean;
}

add_shortcode("thb_popular_posts", "thb_popular_posts_shortcode");