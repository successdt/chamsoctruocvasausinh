<?php
class footer_box_widget extends WP_Widget 
{
	/** constructor */
    function footer_box_widget() 
	{
		global $themename;
		$widget_options = array(
			'classname' => 'footer_box_widget',
			'description' => 'Displays Box with some content'
		);
		$control_options = array('width' => 342);
        parent::WP_Widget('medicenter_footer_box', __('Footer Box', 'medicenter'), $widget_options, $control_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
		global $themename;
        extract($args);

		//these are our widget options
		$title = $instance['title'];
		$title_color = $instance['title_color'];
		$url = $instance['url'];
		$more_label = $instance['more_label'];
		$content = $instance['content'];
		$text_color = $instance['text_color'];
		$color = $instance['color'];
		$custom_color = $instance['custom_color'];

		echo $before_widget;
		?>
		<li class="footer_banner_box"<?php echo ($custom_color!="" ? ' style="background-color: #' . $custom_color . '"' : ''); ?>>
			<?php
			if($title) 
			{
				if($title_color!="")
					$before_title = str_replace(">", " style='color: #" . $title_color . ";'>",$before_title);
				echo $before_title . ($url!="" ? '<a href="' . esc_attr($url) . '"' . ($title_color!="" ? ' style="color: #' . $title_color . ';"' : '') . ' title="' . $title . '">' : '') . $title . ($url!="" ? '</a>' : '') . $after_title;
			}
			?>
			<?php if($content!="" || $url!=""):	?>
			<p<?php echo ($text_color!="" ? " style='color: #" . $text_color . ";'" : ""); ?>>	
			<?php 
			if($content!="")
				echo do_shortcode($content); 
			if($url!=""): ?>
			<a class="icon_small_arrow right_white" href="<?php echo esc_attr($url); ?>" title="<?php echo esc_attr($more_label); ?>"><?php echo esc_attr($more_label); ?></a>
			<?php endif;
			endif; ?>
			</p>
		</li>
		<?php
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['title_color'] = strip_tags($new_instance['title_color']);
		$instance['url'] = strip_tags($new_instance['url']);
		$instance['more_label'] = strip_tags($new_instance['more_label']);
		$instance['content'] = $new_instance['content'];
		$instance['text_color'] = $new_instance['text_color'];
		$instance['color'] = strip_tags($new_instance['color']);
		$instance['custom_color'] = strip_tags($new_instance['custom_color']);
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		global $themename;
		$title = esc_attr($instance['title']);
		$title_color = esc_attr($instance['title_color']);
		$url = esc_attr($instance['url']);
		$more_label = esc_attr($instance['more_label']);
		$content = esc_attr($instance['content']);
		$text_color = esc_attr($instance['text_color']);
		$color = esc_attr($instance['color']);
		$custom_color = esc_attr($instance['custom_color']);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title_color'); ?>"><?php _e('Title color', 'medicenter'); ?></label>
			<input class="widefat color" id="<?php echo $this->get_field_id('title_color'); ?>" name="<?php echo $this->get_field_name('title_color'); ?>" type="text" value="<?php echo $title_color; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('More link url', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('more_label'); ?>"><?php _e('More link label', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('more_label'); ?>" name="<?php echo $this->get_field_name('more_label'); ?>" type="text" value="<?php echo $more_label; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Content', 'medicenter'); ?></label>
			<textarea rows="10" class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $content; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text_color'); ?>"><?php _e('Text color', 'medicenter'); ?></label>
			<input class="widefat color" id="<?php echo $this->get_field_id('text_color'); ?>" name="<?php echo $this->get_field_name('text_color'); ?>" type="text" value="<?php echo $text_color; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Color', 'medicenter'); ?></label>
			<select id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>">
				<option value="42b3e5"<?php echo ($color=="42b3e5" ? ' selected="selected"' : ''); ?>><?php _e('light blue', 'medicenter'); ?></option>
				<option value="0384ce"<?php echo ($color=="0384ce" ? ' selected="selected"' : ''); ?>><?php _e('blue', 'medicenter'); ?></option>
				<option value="3156a3"<?php echo ($color=="3156a3" ? ' selected="selected"' : ''); ?>><?php _e('dark blue', 'medicenter'); ?></option>
				<option value="000000"<?php echo ($color=="000000" ? ' selected="selected"' : ''); ?>><?php _e('black', 'medicenter'); ?></option>
				<option value="aaaaaa"<?php echo ($color=="aaaaaa" ? ' selected="selected"' : ''); ?>><?php _e('gray', 'medicenter'); ?></option>
				<option value="444444"<?php echo ($color=="444444" ? ' selected="selected"' : ''); ?>><?php _e('dark gray', 'medicenter'); ?></option>
				<option value="cccccc"<?php echo ($color=="cccccc" ? ' selected="selected"' : ''); ?>><?php _e('light gray', 'medicenter'); ?></option>
				<option value="43a140"<?php echo ($color=="43a140" ? ' selected="selected"' : ''); ?>><?php _e('green', 'medicenter'); ?></option>
				<option value="008238"<?php echo ($color=="008238" ? ' selected="selected"' : ''); ?>><?php _e('dark green', 'medicenter'); ?></option>
				<option value="7cba3d"<?php echo ($color=="7cba3d" ? ' selected="selected"' : ''); ?>><?php _e('light green', 'medicenter'); ?></option>
				<option value="f17800"<?php echo ($color=="f17800" ? ' selected="selected"' : ''); ?>><?php _e('orange', 'medicenter'); ?></option>
				<option value="cb451b"<?php echo ($color=="cb451b" ? ' selected="selected"' : ''); ?>><?php _e('dark orange', 'medicenter'); ?></option>
				<option value="ffa800"<?php echo ($color=="ffa800" ? ' selected="selected"' : ''); ?>><?php _e('light orange', 'medicenter'); ?></option>
				<option value="db5237"<?php echo ($color=="db5237" ? ' selected="selected"' : ''); ?>><?php _e('red', 'medicenter'); ?></option>
				<option value="c03427"<?php echo ($color=="c03427" ? ' selected="selected"' : ''); ?>><?php _e('dark red', 'medicenter'); ?></option>
				<option value="f37548"<?php echo ($color=="f37548" ? ' selected="selected"' : ''); ?>><?php _e('light red', 'medicenter'); ?></option>
				<option value="0097b5"<?php echo ($color=="0097b5" ? ' selected="selected"' : ''); ?>><?php _e('turquoise', 'medicenter'); ?></option>
				<option value="006688"<?php echo ($color=="006688" ? ' selected="selected"' : ''); ?>><?php _e('dark turquoise', 'medicenter'); ?></option>
				<option value="00b6cc"<?php echo ($color=="00b6cc" ? ' selected="selected"' : ''); ?>><?php _e('light turquoise', 'medicenter'); ?></option>
				<option value="6969b3"<?php echo ($color=="6969b3" ? ' selected="selected"' : ''); ?>><?php _e('violet', 'medicenter'); ?></option>
				<option value="3e4c94"<?php echo ($color=="3e4c94" ? ' selected="selected"' : ''); ?>><?php _e('dark violet', 'medicenter'); ?></option>
				<option value="9187c4"<?php echo ($color=="9187c4" ? ' selected="selected"' : ''); ?>><?php _e('light violet', 'medicenter'); ?></option>
				<option value="ffffff"<?php echo ($color=="ffffff" ? ' selected="selected"' : ''); ?>><?php _e('white', 'medicenter'); ?></option>
				<option value="fec110"<?php echo ($color=="fec110" ? ' selected="selected"' : ''); ?>><?php _e('yellow', 'medicenter'); ?></option>
			</select>
			<?php _e('or pick custom one: ', 'medicenter');?>
			<span class="color_preview" style="background-color: #<?php echo ($custom_color!="" ? $custom_color : '42b3e5'); ?>;"></span>
			<input type="text" class="regular-text color" value="<?php echo $custom_color; ?>" id="<?php echo $this->get_field_id('custom_color'); ?>" name="<?php echo $this->get_field_name('custom_color'); ?>" data-default-color="42b3e5">
		</p>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$("[id$='<?php echo $this->id; ?>'] .color").ColorPicker({
				onChange: function(hsb, hex, rgb, el) {
					$(el).val(hex);
					$(el).prev(".color_preview").css("background-color", "#" + hex);
				},
				onSubmit: function(hsb, hex, rgb, el){
					$(el).val(hex);
					$(el).ColorPickerHide();
				},
				onBeforeShow: function (){
					var color = (this.value!="" ? this.value : $(this).attr("data-default-color"));
					$(this).ColorPickerSetColor(color);
					$(this).prev(".color_preview").css("background-color", color);
				}
			}).on('keyup', function(event, param){
				$(this).ColorPickerSetColor(this.value);

				var default_color = $(this).attr("data-default-color");
				$(this).prev(".color_preview").css("background-color", (this.value!="none" ? "#" + (this.value!="" ? (typeof(param)=="undefined" ? $(".colorpicker:visible .colorpicker_hex input").val() : this.value) : default_color) : "transparent"));
			});
			$("#<?php echo $this->get_field_id('color'); ?>").change(function(){
				$(this).next().next().val($(this).val()).trigger("keyup", [1]);
			});
		});
		</script>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("footer_box_widget");'));
?>