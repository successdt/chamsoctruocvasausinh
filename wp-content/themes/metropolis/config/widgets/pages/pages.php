<?php
/*
	Description: Page custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/
class custom_page_widget extends WP_Widget {

	/**
	 * The widget's name
	 *
	 * @var string
	 **/
	var $name = "Page";

	/**
	 * The widget's description
	 *
	 * @var string
	 **/
	var $description = 'Display the excerpt of a page.';
	
	/**
	 * Constructor
	 */
	function custom_page_widget()
	{
		$widget_ops = array('classname' => 'widget_page', 'description' => $this->description );
		$name = $this->name;
		$this->WP_Widget('thb_page', $name, $widget_ops);
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

		// Data
		$page_id = $instance["page_id"];
		$showthumb = $instance["showthumb"];

		echo do_shortcode("[page id='{$page_id}' showthumb='{$showthumb}' before_widget='{$before_widget}' after_widget='{$after_widget}' before_title='{$before_title}' after_title='{$after_title}']");
	}

	/**
	 * The widget's editing form
	 *
	 * @return void
	 * @see WP_Widget::form
	 **/
	public function form($instance)
	{
		$page_id    = isset($instance["page_id"]) ? esc_attr($instance["page_id"]) : "";
		$field_id   = $this->get_field_id('page_id');
		$field_name = $this->get_field_name('page_id');
		$showthumb  = isset($instance["showthumb"]) ? esc_attr($instance["showthumb"]) : "0";
		?>

		<p>
			<label for="<?php echo $field_name; ?>">Page</label>
			<select name="<?php echo $field_name; ?>" id="<?php echo $field_id; ?>">
				<?php echo getPagesOptions($page_id); ?>
			</select>
		</p>
		<p>
			<input type="hidden" name="<?php echo $this->get_field_name('showthumb'); ?>" value="0">
			<input class="checkbox" id="<?php echo $this->get_field_id('showthumb'); ?>" name="<?php echo $this->get_field_name('showthumb'); ?>" type="checkbox" value="1" <?php echo (esc_attr($showthumb) == 1) ? 'checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('showthumb'); ?>"><?php echo 'Show thumbnail'; ?></label>
		</p>

		<?php
	}

}

/**
 * Register the widget
 */
register_widget("custom_page_widget");

/**
 * Page shortcode
 */
function shortcode_page( $atts, $content=null )
{
	global $theme;
	$sidebar_template = $theme['sidebar_template'];

	// Atts
	extract( shortcode_atts( array(
		'title' => '',
		'id' => 0,
		'showthumb' => 1,
		'before_widget' => $sidebar_template['before_widget'],
		'after_widget' => $sidebar_template['after_widget'],
		'before_title' => $sidebar_template['before_title'],
		'after_title' => $sidebar_template['after_title']
	), $atts ) );

	// Page variables
	$page = get_page($id);
	if( !$page )
		return "";

	$page_url = get_permalink($id);
	$featured_image = thb_get_featured_image($id, "");

	if( empty($title) )
		$title = $page->post_title;

	// Shortcode output
	$output="";

	$output .= $before_widget;

		$output .= $before_title . $title . $after_title;

		// Featured image
		if( $showthumb == 1 && !empty($featured_image) ) {
			$output .= "<div class='preload'>";
				$output .= "<img src='" . $featured_image . "'>";
			$output .= "</div>";
		}

		if(!empty($page->post_excerpt))
			$text = $page->post_excerpt;
		else
			$text = thb_truncate($page->post_content, 200);

		$output .= "<div class='textwidget'>";
			$output .= apply_filters('the_content', $text);
			$output .= "<p><a class='readmore' href='{$page_url}'>" . __("Read more", THEMENAME) . "</a></p>";
		$output .= "</div>";

	$output .= $after_widget;

	return $output;
}
add_shortcode("thb_page", "shortcode_page");