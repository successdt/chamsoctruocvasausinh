<?php
/*
Plugin Name: Float Ads Fixed Position
Plugin URI: http://blog.casanova.vn/float-ads-fixed-position/
Description: This plugin usefull for advertising on sidebar. Ads will drift vertically down to the footer, ads will disappear. The position of ads always fixed while it appear. See the demo of script here: http://logoart.vn/files/admicro.html
Version: 1.0
Author: Nguyen Duc Manh
Author URI: http://casanova.vn
License: GPLv2 or later
*/
class Float_Ads_Fixed_Position extends WP_Widget {
 
    function Float_Ads_Fixed_Position(){
        parent::WP_Widget('Float_Ads_Fixed_Position',
            'Float Ads Fixed Position',
            array('description' => 'Float ads fixed posiotion'));
    }
	
	function widget( $args, $instance ) {
		extract($args);
		$title = $instance['title'];
		echo $before_widget;
		if ( !empty( $title ) ) { 
			echo $before_title . $title . $after_title; } ?>	
            <style type="text/css">
            #floatDiv<?php echo $id; ?>.fixed {
				position:fixed;
				top:<?php echo $instance['marginTop']?$instance['marginTop']:0; ?>px;
			}
            </style>
			<div id='floatDiv<?php echo $id; ?>'> 
            	<?php echo $instance['ads_content']; ?>
        	</div>
            <script type='text/javascript'>//<![CDATA[
			jQuery(document).ready(function(){var documentHeight=jQuery(document).height();if(documentHeight><?php echo $instance['documentHeight'] ?>){
			 var bottomHeight=<?php echo $instance['bottomHeight'] ?>;/*var authorUrl	=	"http://logoart.vn";please don't remove author url of this plugin. Thank!*/ var msie6=jQuery.browser=='msie'&&jQuery.browser.version<7;if(!msie6){var top=jQuery('#floatDiv<?php echo $id; ?>').offset().top-parseFloat(jQuery('#floatDiv<?php echo $id; ?>').css('margin-top').replace(/auto/,0));jQuery(window).scroll(function(event){var y=jQuery(this).scrollTop();if(y>=top&&y<=(documentHeight-bottomHeight)){jQuery('#floatDiv<?php echo $id; ?>').addClass('fixed')}else{jQuery('#floatDiv<?php echo $id; ?>').removeClass('fixed')}})}}});
			//]]></script> 
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
	
	function form( $instance ) {
		$title = strip_tags($instance['title']);
?>
	  
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php _e('Title:'); ?> </label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
				name="<?php echo $this->get_field_name('title'); ?>" type="text" 
				value="<?php echo  esc_attr($title);?>" />
		</p>
        
        <p><label for="<?php echo $this->get_field_id('ads_content'); ?>">
				<?php _e('Banner content'); ?></label>
        	<textarea class="widefat" id="<?php echo $this->get_field_id('ads_content'); ?>" 
				name="<?php echo $this->get_field_name('ads_content'); ?>" rows="7" ><?php echo  esc_attr($instance['ads_content']);?></textarea>
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id('documentHeight'); ?>">
				<?php _e('Document Height:'); ?> <a href="javascript:void(0);" title="Mean: if your document height > <?php echo  esc_attr($instance['documentHeight'])?esc_attr($instance['documentHeight']):1200;?>px, it will float, else it doesn't float">(?)</a></label>
			<input  size="5" maxlength="5" id="<?php echo $this->get_field_id('documentHeight'); ?>" 
				name="<?php echo $this->get_field_name('documentHeight'); ?>" type="text" 
				value="<?php echo  esc_attr($instance['documentHeight'])?esc_attr($instance['documentHeight']):1200;?>" /> px 
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('bottomHeight'); ?>">
				<?php _e('Bottom Height:'); ?> <a href="javascript:void(0);" title="Minimum = Footer height+ Banner content height">(?)</a></label>
			<input  size="5" maxlength="5" id="<?php echo $this->get_field_id('bottomHeight'); ?>" 
				name="<?php echo $this->get_field_name('bottomHeight'); ?>" type="text" 
				value="<?php echo  esc_attr($instance['bottomHeight'])?esc_attr($instance['bottomHeight']):500;?>" /> px
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id('marginTop'); ?>">
				<?php _e('Margin Top:'); ?> <a href="javascript:void(0);" title="Banner margin top. Give 0 to remove margin">(?)</a></label>
			<input  size="5" maxlength="5" id="<?php echo $this->get_field_id('marginTop'); ?>" 
				name="<?php echo $this->get_field_name('marginTop'); ?>" type="text" 
				value="<?php echo  esc_attr($instance['marginTop'])?esc_attr($instance['marginTop']):0;?>" /> px
		</p>
        
<?php
	}
}//--- End class

add_action('init', 'header_script');
function header_script()
{
	wp_enqueue_script( 'jquery' );	
}

add_action('wp_footer', 'footer_script');
function footer_script()
{
	?>
    <script type='text/javascript'>//<![CDATA[
	var s=true;
	function doBlink(){
		jQuery('.blink').css('display',function(index,val){s=!s;return (s)?'block':'none';})}
		jQuery(document).ready(function() {setInterval("doBlink()",0)});
	//]]></script>
    <?php		
}

add_action( 'widgets_init', create_function('', 'return register_widget("Float_Ads_Fixed_Position");') );
?>