<?php
/*
	Description: Map custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

function map_details($width, $height, $latlong='', $zoom=10){
	?>	
	<div class="map-container">
		<?php 
			$address = thb_get_option("_contact_address");
			if(!empty($latlong)) : 
		?>
			<?php
				thb_component('map', array(
					'latlong' => $latlong,
					'address' => str_replace(array("\r\n", "\n", "\r"), " ", $address),
					'zoom' => empty($zoom) ? 10 : $zoom,
					'height' => $height,
					'width' => $width
				));
			?>
		<?php endif; ?>
	</div>
	<?php
}

class WP_Widget_Map extends WP_Widget {

	function WP_Widget_Map() {
		$widget_ops = array('classname' => 'widget_map', 'description' => "A Google map" );
		$this->WP_Widget('thb_map', 'Map', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Map' : $instance['title']);
		$height = isset($instance['height']) ? $instance['height'] : 120;
		$width = isset($instance['width']) ? $instance['width'] : '';
		$latlong = isset($instance['latlong']) && !empty($instance['latlong']) ? $instance['latlong'] : '';
		$zoom = isset($instance['zoom']) ? $instance['zoom'] : '10';

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
			map_details($width, $height, $latlong, $zoom);
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'height' => '', 'width' => '', 'latlong' => '', 'zoom' => '' ) );
		$title = strip_tags($instance['title']);
		$height = strip_tags($instance['height']);
		$latlong = strip_tags($instance['latlong']);
		$zoom = strip_tags($instance['zoom']);
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('height'); ?>"><?php echo 'Height:'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('latlong'); ?>"><?php echo 'Lat &amp; long:'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('latlong'); ?>" name="<?php echo $this->get_field_name('latlong'); ?>" type="text" value="<?php echo esc_attr($latlong); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('zoom'); ?>"><?php echo 'Zoom:'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('zoom'); ?>" name="<?php echo $this->get_field_name('zoom'); ?>" type="text" value="<?php echo esc_attr($zoom); ?>" />
		</p>
<?php
	}
}

register_widget('WP_Widget_Map');

/**
 * Map shortcode
 */
function thb_map_shortcode($atts, $content=null) {
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
		'title'  => '',
		'height' => 200,
		'width'  => '',
		'latlong' => '',
		'zoom' => 12
	), $atts );

	$widget = new WP_Widget_Map();
	$widget->widget($args, $atts);

	$clean = ob_get_clean(); // prevent widget wrong placement
	return $clean;
}

add_shortcode("thb_map", "thb_map_shortcode");