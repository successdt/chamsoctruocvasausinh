<?php
/*
	Description: Tags custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/
class thb_tags_widget extends WP_Widget {

	/**
	 * The widget's name
	 *
	 * @var string
	 **/
	var $name = "Custom tag cloud";

	/**
	 * The widget's description
	 *
	 * @var string
	 **/
	var $description = 'Display your tags.';
	
	/**
	 * Constructor
	 */
	function thb_tags_widget()
	{
		parent::WP_Widget(
			false, 
			$this->name, 
			array(
				"description" => $this->description
			)
		); 

		$widget_ops = array('classname' => 'thb_tags_widget', 'description' => 'Display your tags.' );
		$this->WP_Widget('thb_tags_widget', "Custom tag cloud", $widget_ops);
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

		$title = $instance['title'];
		$how_many_tags = isset($instance["tags_count"]) ? $instance["tags_count"] : 0;
		$orderby = isset($instance['tags_orderby']) ? $instance['tags_orderby'] : "name";
		$order = isset($instance['tags_order']) ? $instance['tags_order'] : "ASC";

		// Let's display the widget
		echo $before_widget;
			if( !empty($title) ) {
				echo $before_title;
					echo $title;
				echo $after_title;
			}
			?>
			<div class="tagcloud">
				<?php wp_tag_cloud(array(
					"number" => $how_many_tags,
					"orderby" => $orderby,
					"order" => $order
				)); ?>
			</div>
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
		$how_many_tags = isset($instance['tags_count']) ? esc_attr($instance["tags_count"]) : "";
		$tags_orderby = isset($instance['tags_orderby']) ? esc_attr($instance["tags_orderby"]) : "";
		$tags_order = isset($instance['tags_order']) ? esc_attr($instance["tags_order"]) : "";

		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<p>
			<label for="<?php echo $this->get_field_id('tags_count'); ?>">How many tags</label>
			<input class="widefat" id="<?php echo $this->get_field_id('tags_count'); ?>" name="<?php echo $this->get_field_name('tags_count'); ?>" type="text" value="<?php echo $how_many_tags; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('tags_orderby'); ?>">Order by</label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('tags_orderby'); ?>" name="<?php echo $this->get_field_name('tags_orderby'); ?>">
				<?php
					echo getOptionsFromArray(
						array("name" => "Name", "count" => "Count"),
						$tags_orderby
					);
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('tags_order'); ?>">Order</label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('tags_order'); ?>" name="<?php echo $this->get_field_name('tags_order'); ?>">
				<?php
					echo getOptionsFromArray(
						array("ASC" => "Ascending", "DESC" => "Descending", "RAND" => "Random"),
						$tags_order
					);
				?>
			</select>
		</p>
		<?php
	}

}

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("thb_tags_widget");'));