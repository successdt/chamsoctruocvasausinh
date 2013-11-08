<?php
/*
	Description: Flickr custom widget.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

class flickr_widget extends WP_Widget {
    function flickr_widget() {
        $widget_ops = array('classname' => 'widget_flickr', 'description' => 'Display your latest Flickr Photos.' );
        $this->WP_Widget('thb_flickr', 'Flickr', $widget_ops);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
		$flickr_title = $instance["flickr_title"];
        $flickr_key = $instance["flickr_id"];
        $flickr_count = $instance["flickr_count"];
        $flickr_src  = "http://www.flickr.com/badge_code_v2.gne?count=".$flickr_count."&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=".$flickr_key;
        ?>
			<?php echo $before_widget; ?>
				<?php 
					if($flickr_title == "")
						$flickr_title = "Flickr";
					echo $before_title; ?>
					<a href="http://flickr.com/photos/<?php echo $flickr_key; ?>" target="_blank" rel="nofollow"><?php echo $flickr_title; ?></a>
					<?php echo $after_title; 
				?>
	            <div id="flickr_wrapper">
	                <script type="text/javascript" src="<?php echo $flickr_src ?>"></script>
	            </div>
	           	<span class="clear"></span>
			<?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $flickr_id = isset($instance["flickr_id"]) ? esc_attr($instance["flickr_id"]) : "";
        $flickr_count = isset($instance["flickr_count"]) ? esc_attr($instance["flickr_count"]) : "";
		$flickr_title = isset($instance["flickr_title"]) ? esc_attr($instance["flickr_title"]) : "";
		
        ?>
			<p><label for="<?php echo $this->get_field_id('flickr_title'); ?>">Title<input class="widefat" id="<?php echo $this->get_field_id('flickr_title'); ?>" name="<?php echo $this->get_field_name('flickr_title'); ?>" type="text" value="<?php echo $flickr_title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('flickr_id'); ?>">Flickr ID<input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $flickr_id; ?>" /></label></p>
			<p>Get your Flickr ID from <a href="http://idgettr.com/" target="_blank">idGettr</a></p>
           	<p>
            	<label for="<?php echo $this->get_field_id('flickr_count'); ?>">Image Count
                <select size="1" class="widefat" id="<?php echo $this->get_field_id('flickr_count'); ?>" name="<?php echo $this->get_field_name('flickr_count'); ?>">
                	<?php for($i = 1; $i < 11; $i++) : ?>
	                    <option <?php if($flickr_count == $i) : ?>selected="selected"<?php endif; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
			</p>
        <?php 
    }

} 

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("flickr_widget");'));

/**
 * Flickr shortcode
 */
function thb_flickr_shortcode($atts, $content=null) {
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
        'flickr_id' => '',
        'flickr_count' => 3
    ), $atts );

    $atts["flickr_title"] = $atts['title'];

    $widget = new flickr_widget();
    $widget->widget($args, $atts);

    $clean = ob_get_clean(); // prevent widget wrong placement
    return $clean;
}

add_shortcode("thb_flickr", "thb_flickr_shortcode");