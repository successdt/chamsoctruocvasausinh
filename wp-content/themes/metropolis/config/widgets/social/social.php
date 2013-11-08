<?php
/*
	Description: Social links custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

$social_services = array(
	"twitter"	=> "http://twitter.com/",
	"facebook"	=> "http://facebook.com/",
	"flickr"	=> "http://flickr.com/photos/",
	"forrst"	=> "http://forrst.com/people/",
	"dribbble"	=> "http://dribbble.com/",
	"delicious"	=> "http://delicious.com/",
	"youtube"	=> "http://youtube.com/",
	"vimeo"		=> "http://vimeo.com/",
	"digg"		=> "http://digg.com/",
	"linkedin"	=> "http://linkedin.com/in/",
	"picasa"	=> "http://picasaweb.google.com/",
	"googleplus"=> "https://profiles.google.com/",
	"pinterest" => "http://pinterest.com/"
);

function social_bar() {
	$icons_path = WIDGETSURL . "/social/icons";
	global $social_services;
	?>
	<ul id="social">
		<?php foreach(array_keys($social_services) as $service) : ?>
			<?php if(thb_get_option("_social_".$service) != "") : ?>
				<li>
					<a href="<?php echo $social_services[$service] . thb_get_option("_social_".$service); ?>">
						<img src="<?php echo $icons_path; ?>/<?php echo $service; ?>.png" alt="" />
					</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
<?php }

class WP_Widget_Social extends WP_Widget {

	function WP_Widget_Social() {
		$widget_ops = array('classname' => 'widget_social', 'description' => "Social networks" );
		$this->WP_Widget('thb_social', 'Social Networks', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
	
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
			social_bar();
			echo '<span class="clear"></span>';
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

register_widget('WP_Widget_Social');

/**
 * Latest works shortcode
 */
function thb_social_shortcode($atts, $content=null) {
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
		'title' => ''
	), $atts );

	$widget = new WP_Widget_Social();
	$widget->widget($args, $atts);

	$clean = ob_get_clean(); // prevent widget wrong placement
	return $clean;
}

add_shortcode("thb_social", "thb_social_shortcode");