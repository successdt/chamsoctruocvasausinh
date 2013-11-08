<?php
/*
	Description: Posts from a category custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/
class WP_Widget_CategoryPosts extends WP_Widget_News {

	function WP_Widget_CategoryPosts() {
        $widget_ops = array('classname' => 'widget_categorynews', 'description' => 'Display the latest posts from a category.' );
        $this->WP_Widget('thb_categorynews', "Posts from category", $widget_ops);
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $category_id = isset($instance["category_id"]) ? esc_attr($instance["category_id"]) : "";
        $category_count = isset($instance["category_count"]) ? esc_attr($instance["category_count"]) : "";
		$category_title = isset($instance["category_title"]) ? esc_attr($instance["category_title"]) : "";
		$category_showthumb = isset($instance["category_showthumb"]) ? esc_attr($instance["category_showthumb"]) : "";

		$categories = get_terms("category");
		$categories_options = array();
		foreach($categories as $term) {
			$categories_options[$term->term_id] = $term->name;
		}
		
        ?>
			<p><label for="<?php echo $this->get_field_id('category_title'); ?>">Title<input class="widefat" id="<?php echo $this->get_field_id('category_title'); ?>" name="<?php echo $this->get_field_name('category_title'); ?>" type="text" value="<?php echo $category_title; ?>" /></label></p>
            <p>
            	<label for="<?php echo $this->get_field_id('category_id'); ?>">Category</label><br>
        		<select id="<?php echo $this->get_field_id('category_id'); ?>" name="<?php echo $this->get_field_name('category_id'); ?>">
        			<?php foreach($categories_options as $value => $name) : ?>
        				<?php
        					$selected = "";
        					if($value == $category_id)
        						$selected = "selected";
        				?>
        				<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
        			<?php endforeach; ?>
        		</select>
            </p>
			<p>
				<label for="<?php echo $this->get_field_id('category_count'); ?>"><?php echo 'How many posts:'; ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('category_count'); ?>" name="<?php echo $this->get_field_name('category_count'); ?>" type="text" value="<?php echo esc_attr($category_count); ?>" />
			</p>
			<p>
				<input type="hidden" name="<?php echo $this->get_field_name('category_showthumb'); ?>" value="0">
				<input class="checkbox" id="<?php echo $this->get_field_id('category_showthumb'); ?>" name="<?php echo $this->get_field_name('category_showthumb'); ?>" type="checkbox" value="1" <?php echo (esc_attr($category_showthumb) == 1) ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id('category_showthumb'); ?>"><?php echo 'Show thumbnail'; ?></label>
			</p>
        <?php 
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

		// The category
		$category_id = $instance['category_id'];

		// Data
		$title = apply_filters('widget_title', empty($instance['category_title']) ? get_cat_name($category_id) : $instance['category_title']);
		$how_many_posts = !empty($instance['category_count']) ? $instance['category_count'] : 5;
		$showthumb = $instance['category_showthumb'];

		// The posts
		$this->posts = thb_get_posts("post", array(
			"posts_per_page" => $how_many_posts,
			"cat" => $category_id
		));

		// Let's display the widget
		echo $before_widget;

			echo $before_title;
				echo $title;
			echo $after_title;

			if($this->posts->have_posts()) {
				$this->show_posts($showthumb);
			}
			else
				echo "<p>" . __("There aren't posts to be shown.", THEMENAME) . "</p>";

		echo $after_widget;
	}

}

register_widget('WP_Widget_CategoryPosts');

/**
 * Latest posts shortcode
 */
function thb_category_posts_shortcode($atts, $content=null) {
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
		'showthumb' => 0,
		'cat' => '0'
	), $atts );

	$atts['category_count'] = $atts['numposts'];
	$atts['category_title'] = $atts['title'];
	$atts['category_showthumb'] = $atts['showthumb'];
	$atts['category_id'] = $atts['cat'];

	$widget = new WP_Widget_CategoryPosts();
	$widget->widget($args, $atts);

	$clean = ob_get_clean(); // prevent widget wrong placement
	return $clean;
}

add_shortcode("thb_category_posts", "thb_category_posts_shortcode");