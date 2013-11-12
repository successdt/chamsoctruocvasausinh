<?php
/*
	Description: Latest posts custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/
class WP_Widget_News extends WP_Widget {

	/**
	 * The widget's name
	 *
	 * @var string
	 **/
	var $name = "Latest posts";

	/**
	 * The widget's description
	 *
	 * @var string
	 **/
	var $description = 'Display the latest posts.';

	/**
	 * The widget's title
	 *
	 * @var string
	 **/
	var $title = 'Latest posts';

	/**
	 * Posts query filter
	 *
	 * @var array
	 **/
	var $filter = array();

	/**
	 * The posts
	 *
	 * @var array
	 **/
	var $posts = array();

	/**
	 * How many posts to be shown
	 *
	 * @var int
	 **/
	var $how_many_posts;
	
	/**
	 * Constructor
	 */
	function WP_Widget_News()
	{
		$widget_ops = array('classname' => 'widget_news', 'description' => $this->description );
		$this->WP_Widget('thb_news', "Latest posts", $widget_ops);
	}

	/**
	 * The widget's update function
	 *
	 * @return void
	 * @see WP_Widget::update
	 **/
	public function update($new_instance, $old_instance)
	{
		return $new_instance;
	}

	/**
	 * The conditions under which the widget is actually displayed
	 *
	 * @return boolean
	 **/
	public function showing_condition()
	{
		return true;
	}

	/**
	 * Displaying the widget
	 *
	 * @return void
	 * @see WP_Widget::widget
	 **/
	public function widget($args, $instance)
	{
		extract($args);

		// Data
		$title = apply_filters('widget_title', empty($instance['title']) ? $this->title : $instance['title']);
		$this->how_many_posts = !empty($instance['numposts']) ? $instance['numposts'] : 5;
		$showthumb = $instance['showthumb'];

		// Composing the query filter
		$this->compose_filter();

		// Let's grab the posts
		$this->get_posts();

		// Let's display the widget
		echo $before_widget;

			echo $before_title;
				echo $title;
			echo $after_title;

			if($this->posts->have_posts())
				$this->show_posts($showthumb);
			else
				echo "<p>" . __("There aren't posts to be shown.", THEMENAME) . "</p>";

		echo $after_widget;
	}

	/**
	 * Composing the query filter
	 *
	 * @return void
	 **/
	protected function compose_filter()
	{}

	/**
	 * Gets the posts
	 *
	 * @return array
	 **/
	protected function get_posts()
	{
		$this->filter['posts_per_page'] = $this->how_many_posts;

		$this->posts = thb_get_posts("post", $this->filter);
	}

	/**
	 * Displays the posts
	 *
	 * @return void
	 **/
	protected function show_posts($show_thumbnail)
	{
		if(empty($show_thumbnail)) $show_thumbnail = false;
		$post_class = "";
		if(!$show_thumbnail) $post_class = "no-image";

		while($this->posts->have_posts()) : $this->posts->the_post();

		?>

		<div class="side-post">
			<?php if($show_thumbnail) : ?>
				
				<?php
					$post_id = get_the_ID();
					$post_format = get_post_format();
					
					if( $post_format == "gallery" ) {
						$attachments =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $post_id );
						
						if(!empty($attachments)) {
							$attachment = reset($attachments);
							if($attachment->menu_order == 0)
								$attachment = end($attachments);
							else {
								foreach($attachments as $att) {
									if($att->menu_order == 1) {
										$attachment = $att;
										break;
									}
								}
							}
							
							$thumbnail = thb_get_image_size($attachment->guid, "micro");
						}	
					} else
						$thumbnail = thb_get_thumbnail($post_id, "micro");
				
				?>
				
				<?php if(!empty($thumbnail)) : ?>
					<a class="item-image" href="<?php the_permalink(); ?>">
						<img src="<?php echo $thumbnail; ?>" alt="" />
					</a>
				<?php else: ?>
					<span class="no-thumb"></span>
				<?php endif; ?>
			<?php endif; ?>
			<div class="post-head <?php echo $post_class; ?>">
				<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
				<p><?php echo get_the_date(); ?></p>
			</div>
		</div>

		<?php

		endwhile;

	}

	/**
	 * The widget's editing form
	 *
	 * @return void
	 * @see WP_Widget::form
	 **/
	public function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'numposts' => '', 'showthumb' => '', 'excerpt' => '' ) );

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

register_widget('WP_Widget_News');

/**
 * Latest posts shortcode
 */
function thb_latest_posts_shortcode($atts, $content=null) {
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

	$widget = new WP_Widget_News();
	$widget->widget($args, $atts);

	$clean = ob_get_clean(); // prevent widget wrong placement
	return $clean;
}

add_shortcode("thb_latest_posts", "thb_latest_posts_shortcode");