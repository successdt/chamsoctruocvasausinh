<?php
class appointment_widget extends WP_Widget 
{
	/** constructor */
    function appointment_widget() 
	{
		$widget_options = array(
			'classname' => 'appointment_widget',
			'description' => 'Displays Appointment Box'
		);
		$control_options = array('width' => 632);
        parent::WP_Widget('medicenter_appointment', __('Appointment', 'medicenter'), $widget_options, $control_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
		extract($args);

		//these are our widget options
		$title = $instance['title'];
		$sentence = $instance['sentence'];
		$content = $instance['content'];
		$icon_type = $instance["icon_type"];
		$icon_color = $instance["icon_color"];
		$icon_value = $instance["icon_value"];
		//$icon_target = $instance["icon_target"];

		echo $before_widget;
		if($title) 
		{
			echo $before_title . $title . $after_title;
		} 
		if($sentence!="")
			echo '<h3 class="sentence">' . $sentence . '</h3>';
		if($content!="")
			echo do_shortcode($content);
		$arrayEmpty = true;
		for($i=0; $i<count($icon_type); $i++)
		{
			if($icon_type[$i]!="")
				$arrayEmpty = false;
		}
		if(!$arrayEmpty):
		?>
		<ul class="contact_data page_margin_top">
			<?php
			for($i=0; $i<count($icon_type); $i++)
			{
				if($icon_type[$i]!=""):
			?>
			<li class="clearfix"><span class="social_icon" style="background-image: url('<?php echo get_template_directory_uri() . "/images/social_body/" . $icon_color[$i] . "/" . $icon_type[$i] . ".png');"; ?>"></span><p class="value"><?php echo $icon_value[$i];?></p></li>
			<?php
				endif;
			}
			?>
		</ul>
		<?php
		endif;
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['sentence'] = $new_instance['sentence'];
		$instance['content'] = $new_instance['content'];
		$icon_type = (array)$new_instance['icon_type'];
		while(end($icon_type)==="")
			array_pop($icon_type);
		$instance['icon_type'] = $icon_type;
		$instance['icon_color'] = $new_instance['icon_color'];
		$instance['icon_value'] = $new_instance['icon_value'];
		//$instance['icon_target'] = $new_instance['icon_target'];
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		$title = $instance['title'];
		$sentence = $instance['sentence'];
		$content = $instance['content'];
		$icon_type = $instance["icon_type"];
		$icon_color = $instance["icon_color"];
		$icon_value = $instance["icon_value"];
		//$icon_target = $instance["icon_target"];
		$icons = array(
			"blogger",
			"deviantart",
			"dribbble",
			"envato",
			"facebook",
			"flickr",
			"form",
			"forrst",
			"googleplus",
			"linkedin",
			"mail",
			"myspace",
			"phone",
			"picasa",
			"skype",
			"soundcloud",
			"stumbleupon",
			"tumblr",
			"twitter",
			"vimeo",
			"xing",
			"youtube"
		);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('sentence'); ?>"><?php _e('Sentence', 'medicenter'); ?></label>
			<textarea rows="6" class="widefat" id="<?php echo $this->get_field_id('sentence'); ?>" name="<?php echo $this->get_field_name('sentence'); ?>"><?php echo esc_attr($sentence); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Content', 'medicenter'); ?></label>
			<textarea rows="6" class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo esc_attr($content); ?></textarea>
		</p>
		<?php
		for($i=0; $i<(count($icon_type)<4 ? 4 : count($icon_type)); $i++)
		{
		?>
		<p>
			<label for="<?php echo $this->get_field_id('icon_type') . $i; ?>"><?php _e('Icon type', 'medicenter'); ?></label>
			<select id="<?php echo $this->get_field_id('icon_type') . $i; ?>" name="<?php echo $this->get_field_name('icon_type'); ?>[]">
				<option value="">-</option>
				<?php for($j=0; $j<count($icons); $j++)
				{
				?>
				<option value="<?php echo $icons[$j]; ?>"<?php echo ($icons[$j]==$icon_type[$i] ? " selected='selected'" : "") ?>><?php echo $icons[$j]; ?></option>
				<?php
				}
				?>
			</select>
			<label for="<?php echo $this->get_field_id('icon_color') . $i; ?>"><?php _e('color', 'medicenter'); ?></label>
			<select id="<?php echo $this->get_field_id('icon_color') . $i; ?>" name="<?php echo $this->get_field_name('icon_color'); ?>[]">
				<option value="blue_light"<?php echo ($icon_color[$i]=="blue_light" ? ' selected="selected"' : ''); ?>><?php _e('light blue', 'medicenter'); ?></option>
				<option value="blue"<?php echo ($icon_color[$i]=="blue" ? ' selected="selected"' : ''); ?>><?php _e('blue', 'medicenter'); ?></option>
				<option value="blue_dark"<?php echo ($icon_color[$i]=="blue_dark" ? ' selected="selected"' : ''); ?>><?php _e('dark blue', 'medicenter'); ?></option>
				<option value="black"<?php echo ($icon_color[$i]=="black" ? ' selected="selected"' : ''); ?>><?php _e('black', 'medicenter'); ?></option>
				<option value="gray"<?php echo ($icon_color[$i]=="gray" ? ' selected="selected"' : ''); ?>><?php _e('gray', 'medicenter'); ?></option>
				<option value="gray_dark"<?php echo ($icon_color[$i]=="gray_dark" ? ' selected="selected"' : ''); ?>><?php _e('dark gray', 'medicenter'); ?></option>
				<option value="gray_light"<?php echo ($icon_color[$i]=="gray_light" ? ' selected="selected"' : ''); ?>><?php _e('light gray', 'medicenter'); ?></option>
				<option value="green"<?php echo ($icon_color[$i]=="green" ? ' selected="selected"' : ''); ?>><?php _e('green', 'medicenter'); ?></option>
				<option value="green_dark"<?php echo ($icon_color[$i]=="green_dark" ? ' selected="selected"' : ''); ?>><?php _e('dark green', 'medicenter'); ?></option>
				<option value="green_light"<?php echo ($icon_color[$i]=="green_light" ? ' selected="selected"' : ''); ?>><?php _e('light green', 'medicenter'); ?></option>
				<option value="orange"<?php echo ($icon_color[$i]=="orange" ? ' selected="selected"' : ''); ?>><?php _e('orange', 'medicenter'); ?></option>
				<option value="orange_dark"<?php echo ($icon_color[$i]=="orange_dark" ? ' selected="selected"' : ''); ?>><?php _e('dark orange', 'medicenter'); ?></option>
				<option value="orange_light"<?php echo ($icon_color[$i]=="orange_light" ? ' selected="selected"' : ''); ?>><?php _e('light orange', 'medicenter'); ?></option>
				<option value="red"<?php echo ($icon_color[$i]=="red" ? ' selected="selected"' : ''); ?>><?php _e('red', 'medicenter'); ?></option>
				<option value="red_dark"<?php echo ($icon_color[$i]=="red_dark" ? ' selected="selected"' : ''); ?>><?php _e('dark red', 'medicenter'); ?></option>
				<option value="red_light"<?php echo ($icon_color[$i]=="red_light" ? ' selected="selected"' : ''); ?>><?php _e('light red', 'medicenter'); ?></option>
				<option value="turquoise"<?php echo ($icon_color[$i]=="turquoise" ? ' selected="selected"' : ''); ?>><?php _e('turquoise', 'medicenter'); ?></option>
				<option value="turquoise_dark"<?php echo ($icon_color[$i]=="turquoise_dark" ? ' selected="selected"' : ''); ?>><?php _e('dark turquoise', 'medicenter'); ?></option>
				<option value="turquoise_light"<?php echo ($icon_color[$i]=="turquoise_light" ? ' selected="selected"' : ''); ?>><?php _e('light turquoise', 'medicenter'); ?></option>
				<option value="violet"<?php echo ($icon_color[$i]=="violet" ? ' selected="selected"' : ''); ?>><?php _e('violet', 'medicenter'); ?></option>
				<option value="violet_dark"<?php echo ($icon_color[$i]=="violet_dark" ? ' selected="selected"' : ''); ?>><?php _e('dark violet', 'medicenter'); ?></option>
				<option value="violet_light"<?php echo ($icon_color[$i]=="violet_light" ? ' selected="selected"' : ''); ?>><?php _e('light violet', 'medicenter'); ?></option>
				<option value="white"<?php echo ($icon_color[$i]=="white" ? ' selected="selected"' : ''); ?>><?php _e('white', 'medicenter'); ?></option>
				<option value="yellow"<?php echo ($icon_color[$i]=="yellow" ? ' selected="selected"' : ''); ?>><?php _e('yellow', 'medicenter'); ?></option>
			</select>
			<input style="width: 300px;" type="text" class="regular-text" value="<?php echo esc_attr($icon_value[$i]); ?>" name="<?php echo $this->get_field_name('icon_value'); ?>[]">
			<?php /*<select name="<?php echo $this->get_field_name('icon_target'); ?>[]">
				<option value="same_window"<?php echo ($icon_target[$i]=="same_window" ? " selected='selected'" : ""); ?>>same window</option>
				<option value="new_window"<?php echo ($icon_target[$i]=="new_window" ? " selected='selected'" : ""); ?>>new window</option>
			</select> */?>
		</p>
		<?php
		}
		?>
		<p>
			<input type="button" class="button" name="<?php echo $this->get_field_name('add_new_button'); ?>" id="<?php echo $this->get_field_id('add_new_button'); ?>" value="<?php _e('Add icon', 'medicenter'); ?>" />
		</p>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$("#<?php echo $this->get_field_id('add_new_button'); ?>").click(function(){
				$(this).parent().before($(this).parent().prev().clone().wrap('<div>').parent().html());
				$(this).parent().prev().find("input, select").val('');
			});
		});
		</script>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("appointment_widget");'));
?>