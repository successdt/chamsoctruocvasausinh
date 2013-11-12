<?php
/*
	Description: Contact details custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

function contact_details(){
	ob_start(); // prevent widget wrong placement
?>	
<div class="contact">
	<?php echo apply_filters('the_content', thb_get_option('_contact_address')); ?>
	<dl>
		<?php if(thb_get_option('_contact_phone') ) { ?>
			<dt><?php _e('Tel', THEMENAME); ?></dt>
			<dd><?php echo thb_get_option('_contact_phone'); ?></dd>
		<?php } ?>
		<?php if(thb_get_option('_contact_mobile') ) { ?>
			<dt><?php _e('Mobile', THEMENAME); ?></dt>
			<dd><?php echo thb_get_option('_contact_mobile'); ?></dd>
		<?php } ?>
		<?php if(thb_get_option('_contact_fax') ) { ?>
			<dt><?php _e('Fax', THEMENAME); ?></dt>
			<dd><?php echo thb_get_option('_contact_fax'); ?></dd>
		<?php } ?>
		<?php if(thb_get_option('_contact_email') ) { ?>
			<dt><?php _e('Email', THEMENAME); ?></dt>
			<dd><a href="mailto:<?php echo thb_get_option('_contact_email'); ?>"><?php echo thb_get_option('_contact_email'); ?></a></dd>		
		<?php } ?>
	</dl>
</div>
<?php
	$clean = ob_get_clean(); // prevent widget wrong placement
	return $clean;
}

add_shortcode('contact', 'contact_details');
add_filter('widget_text', 'do_shortcode');


class WP_Widget_Contact extends WP_Widget {

	function WP_Widget_Contact() {
		$widget_ops = array('classname' => 'widget_contact', 'description' => "Your contact details" );
		$this->WP_Widget('thb_contact', 'Contact details', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Contact us' : $instance['title']);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
			echo contact_details();
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
?>
			<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
<?php
	}
}

register_widget('WP_Widget_Contact');

?>