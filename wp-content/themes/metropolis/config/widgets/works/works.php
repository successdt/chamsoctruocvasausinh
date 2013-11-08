<?php
/*
	Description: Lastest works custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

function works($numposts, $showthumb) {
	if($numposts == "")
		$numposts = 5;
	if($showthumb == "")
		$showthumb = false;
	$works = thb_get_posts("works", array("posts_per_page" => $numposts)); 
	
	if($works->have_posts()) : 
?>
<div class="latest-works">		
<?php while($works->have_posts()) : $works->the_post(); ?>
	<div class="latest-works-container">		
	<?php if($showthumb == true) : ?>		
		<?php

			$thumbclass = "";

			$video = thb_get_post_meta(get_the_ID(), "_video_url");
			if(!empty($video)) {
				$thumbnail = getVideoThumbnail($video, "thumbnail_medium");
				$thumbclass = "video";
			}
			else
				$thumbnail = thb_get_thumbnail(get_the_ID(), "micro");

			if($thumbnail != "") : 
		?>
			<a class="item-image <?php echo $thumbclass; ?>" href="<?php the_permalink(); ?>">
				<img src="<?php echo $thumbnail; ?>" alt="" />
			</a>
		<?php else: ?>
			<span class="no-thumb"></span>
		<?php endif; ?>
	<?php endif; ?>
		<div class="post-head <?php if($showthumb == false) : ?>no-image<?php endif; ?>">
			<h4>
				<a href="<?php the_permalink(); ?>" title="<?php _e('Click for more details', THEMENAME); ?>">
					<?php the_title(); ?>
				</a>
			</h4>
			<?php
				$post_categories = wp_get_object_terms( get_the_ID(), "types" );
				if(count($post_categories) > 0) : 
				$c=array();
				foreach($post_categories as $cat)
					$c[] = $cat->name;
			?>
				<p><?php echo join($c,", "); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php endwhile; ?>
</div>
<?php endif; ?>
		
	
<?php }

class WP_Widget_Works extends WP_Widget {

	function WP_Widget_Works() {
		$widget_ops = array('classname' => 'widget_works', 'description' => "Latest works" );
		$this->WP_Widget('thb_works', 'Latest works', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Latest works' : $instance['title']);
		$numposts = $instance['numposts'];
		$showthumb = $instance['showthumb'];

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
			works($numposts,$showthumb);
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['numposts'] = strip_tags($new_instance['numposts']);
		$instance['showthumb'] = strip_tags($new_instance['showthumb']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'numposts' => '', 'showthumb' => '' ) );
		$title = strip_tags($instance['title']);
		$numposts = strip_tags($instance['numposts']);
		$showthumb = strip_tags($instance['showthumb']);
?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('numposts'); ?>"><?php echo 'How many posts:'; ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('numposts'); ?>" name="<?php echo $this->get_field_name('numposts'); ?>" type="text" value="<?php echo esc_attr($numposts); ?>" />
			</p>
			<p>
				<input type="hidden" name="<?php echo $this->get_field_name('showthumb'); ?>" value="0">
				<input class="checkbox" id="<?php echo $this->get_field_id('showthumb'); ?>" name="<?php echo $this->get_field_name('showthumb'); ?>" type="checkbox" value="1" <?php echo (esc_attr($showthumb) == 1) ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id('showthumb'); ?>"><?php echo 'Show thumbnail'; ?></label>
			</p>
<?php
	}
}

register_widget('WP_Widget_Works');

/**
 * Latest works shortcode
 */
function thb_latest_works_shortcode($atts, $content=null) {
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

	$widget = new WP_Widget_Works();
	$widget->widget($args, $atts);

	$clean = ob_get_clean(); // prevent widget wrong placement
	return $clean;
}

add_shortcode("thb_latest_works", "thb_latest_works_shortcode");