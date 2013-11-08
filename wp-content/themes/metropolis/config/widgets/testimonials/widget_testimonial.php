<?php
/*
	Description: Testimonial custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

class WP_Widget_Testimonial extends WP_Widget {

	function WP_Widget_Testimonial() {
		$widget_ops = array('classname' => 'widget_testimonial', 'description' => "" );
		$this->WP_Widget('thb_testimonial', 'Single testimonial', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);

		$testimonial_id = $instance['testimonial_id'];
		$testimonial_style = $instance['testimonial_style'];
		$title = $instance['title'];

		echo do_shortcode("[testimonial style='{$testimonial_style}' id='{$testimonial_id}' title='{$title}' before_widget='{$before_widget}' after_widget='{$after_widget}' before_title='{$before_title}' after_title='{$after_title}']");
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'testimonial_id' => '', 'title' => '', 'testimonial_style' => 1 ) );
		$testimonial_id = strip_tags($instance['testimonial_id']);
		$testimonial_style = strip_tags($instance['testimonial_style']);
		$title = strip_tags($instance['title']);
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('testimonial_id'); ?>"><?php echo 'Testimonial:'; ?></label>
				<select id="<?php echo $this->get_field_id('testimonial_id'); ?>" name="<?php echo $this->get_field_name('testimonial_id'); ?>">
					<?php
						$testimonials = thb_get_posts("testimonials", array("posts_per_page" => 99));
						echo getOptionsFromArray( adminpage::prepare_for_select($testimonials), $testimonial_id );
					?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('testimonial_style'); ?>">Style:</label>
				<select id="<?php echo $this->get_field_id('testimonial_style'); ?>" name="<?php echo $this->get_field_name('testimonial_style'); ?>">
					<?php
						echo getOptionsFromArray( array(
							1 => "Quote",
							2 => "Bubble"
						), $testimonial_style );
					?>
				</select>
			</p>
		<?php
	}
}

register_widget('WP_Widget_Testimonial');