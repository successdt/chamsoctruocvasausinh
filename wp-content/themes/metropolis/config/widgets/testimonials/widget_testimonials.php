<?php
/*
	Description: Testimonials custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

class WP_Widget_Testimonials extends WP_Widget {

	function WP_Widget_Testimonials() {
		$widget_ops = array('classname' => 'widget_testimonials', 'description' => "" );
		$this->WP_Widget('thb_testimonials', 'Testimonials', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);

		$title = $instance['title'];
		$numposts = $instance['numposts'];
		$testimonial_style = $instance['testimonial_style'];

		echo do_shortcode("[testimonial style='{$testimonial_style}' items='{$numposts}' title='{$title}' before_widget='{$before_widget}' after_widget='{$after_widget}' before_title='{$before_title}' after_title='{$after_title}']");
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'numposts' => 3, 'testimonial_style' => 1 ) );
		$title = strip_tags($instance['title']);
		$numposts = strip_tags($instance['numposts']);
		$testimonial_style = strip_tags($instance['testimonial_style']);
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('numposts'); ?>"><?php echo 'How many testimonials:'; ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('numposts'); ?>" name="<?php echo $this->get_field_name('numposts'); ?>" type="text" value="<?php echo esc_attr($numposts); ?>" />
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

register_widget('WP_Widget_Testimonials');