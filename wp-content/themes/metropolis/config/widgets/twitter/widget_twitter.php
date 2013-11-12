<?php
/*
	Description: Twitter custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/
class twitter_widget extends WP_Widget {

	/**
	 * The widget's name
	 *
	 * @var string
	 **/
	var $name = "Twitter";

	/**
	 * The widget's description
	 *
	 * @var string
	 **/
	var $description = 'Display your latest tweets.';
	
	/**
	 * Constructor
	 */
	function twitter_widget()
	{
		parent::WP_Widget(
			false, 
			$this->name, 
			array(
				"description" => $this->description
			)
		); 

		$widget_ops = array('classname' => 'widget_twitter', 'description' => 'Display your latest tweets.' );
		$this->WP_Widget('thb_twitter', "Twitter", $widget_ops);
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
	 * Displaying the widget
	 *
	 * @return void
	 * @see WP_Widget::widget
	 **/
	public function widget($args, $instance)
	{
		extract($args);

		// Twitter data
		$twitter_id = $instance["twitter_id"];
		$how_many_tweets = $instance["twitter_count"];

		// Let's display the widget
		echo $before_widget;
			echo $before_title;
				?>
				<a href="http://twitter.com/<?php echo $twitter_id; ?>" target="_blank" rel="nofollow">
					 <?php echo (empty($instance['title'])) ? "Twitter" : $instance['title']; ?>
				</a>
				<?php
			echo $after_title;
			?>
			<div id="twitter_update_list">
				<ul>
					<li id="twitter-load"><?php _e('...loading Twitter Stream', THEMENAME); ?></li>
				</ul>
			</div>
			<script src="http://twitterjs.googlecode.com/svn/trunk/src/twitter.min.js" type="text/javascript"></script>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					getTwitters('twitter_update_list', { 
						id: '<?php echo $twitter_id; ?>', 
						count: <?php echo $how_many_tweets+1; ?>, 
						enableLinks: true, 
						ignoreReplies: true, 
						clearContents: true,
						template: '<a href="http://twitter.com/%user_screen_name%/statuses/%id_str%/">%time%</a> <span>"%text%"</span>'
					});
				});
			</script>
			<?php
		echo $after_widget;
	}

	/**
	 * The widget's editing form
	 *
	 * @return void
	 * @see WP_Widget::form
	 **/
	public function form($instance)
	{
		$title = isset($instance["title"]) ? esc_attr($instance["title"]) : "";
		$twitter_id = isset($instance["twitter_id"]) ? esc_attr($instance["twitter_id"]) : "";
		$how_many_tweets = isset($instance['twitter_count']) ? esc_attr($instance["twitter_count"]) : "";

		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('twitter_id'); ?>">Twitter ID<input class="widefat" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" type="text" value="<?php echo $twitter_id; ?>" /></label></p>
		<p>
			<label for="<?php echo $this->get_field_id('twitter_count'); ?>">Tweet Count</label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('twitter_count'); ?>" name="<?php echo $this->get_field_name('twitter_count'); ?>">
				<?php
					echo getOptionsFromArray(
						array(1,2,3,4,5,8,10),
						$how_many_tweets
					);
				?>
			</select>
		</p>
		<?php
	}

}

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("twitter_widget");'));

/**
 * Twitter shortcode
 */
function thb_twitter_shortcode($atts, $content=null) {
	global $theme;
	ob_start(); // prevent widget wrong placement

	$sidebar_template = $theme['sidebar_template'];

	$args = array(
		'before_widget' => $sidebar_template['before_widget'],
		'after_widget' => $sidebar_template['after_widget'],
		'before_title' => $sidebar_template['before_title'],
		'after_title' => $sidebar_template['after_title']
	);

	$atts = shortcode_atts( array(
		'title' => '',
		'twitter_id' => '',
		'twitter_count' => 3
	), $atts );

	$atts["twitter_count"] = $atts['twitter_count'] - 1;

	$widget = new twitter_widget();
	$widget->widget($args, $atts);

	$clean = ob_get_clean(); // prevent widget wrong placement
	return $clean;
}

add_shortcode("thb_twitter", "thb_twitter_shortcode");