<?php
/*
Plugin Name: Zoom Image
Plugin URI: http://www.outsourcing-webdesign.com
Description: Add zoom efect over WooCommerce featured image and thumbnails in a simple and elegant mode.
Author: Alexandru Muscalu
Version: 1.2
Author URI: http://www.outsourcing-webdesign.com
License: GPLv2 or later
*/
class TccZoom {
	var $pluginPath;
	var $pluginUrl;
	
	public function __construct()
	{
		// Set Plugin Path
		$this->pluginPath = dirname(__FILE__);
	
		// Set Plugin URL
		$this->pluginUrl = WP_PLUGIN_URL . '/zoom-image';
		
		
		
		add_filter('woocommerce_product_thumbnails', array( &$this, 'apply_zoom') );
		add_action('woocommerce_product_thumbnails', array( &$this, 'add_scripts') );
		
        if(is_admin()){
			add_action('admin_menu', array(&$this, 'add_zoom_image_plugin_page'));
			add_action('admin_init', array(&$this, 'zoom_image_init'));
			
			add_action( 'admin_enqueue_scripts',  array(&$this, 'wp_enqueue_color_picker') );
		}
	}
	
	static function install() {
		add_option('zoom_image_options', array('zoom_thumbnails'=>'1'));	
	}
	
	function wp_enqueue_color_picker( ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker-script', plugins_url('/js/colorPicker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	}	
	
    public function add_zoom_image_plugin_page(){
        // This page will be under "Settings"
	add_options_page('Zoom Image Settings', 'Zoom Image', 'manage_options', 'zoom-image', array($this, 'create_zoom_image_page'));
    }

    public function create_zoom_image_page(){
        ?>
	<div class="wrap">
	    <?php screen_icon(); ?>
	    <h2>Zoom Image Settings</h2>		
	    <form method="post" action="options.php">
	        <?php
                    // This prints out all hidden setting fields
		    settings_fields('zoom_image_group');	
		    do_settings_sections('zoom_image_settings');
		?>
	        <?php submit_button(); ?>
	    </form>
	</div>
	<?php
    }
	
    public function zoom_image_init(){		
	
		register_setting('zoom_image_group', 'zoom_image_options', array($this, 'check_zoom_image_options'));
		
        add_settings_section(
	    'general_zoom_settings',
	    'Zoom image options',
	    array($this, 'print_section_info'),
	    'zoom_image_settings'
		);	
		
		add_settings_field(
			'zoom_thumbnails', 
			'Zoom over thumbnails ?', 
			array($this, 'create_zoom_thumbnails_field'), 
			'zoom_image_settings',
			'general_zoom_settings'			
		);		
		/*
		add_settings_field(
			'zoom_level', 
			'Zoom level', 
			array($this, 'create_zoom_level_field'), 
			'zoom_image_settings',
			'general_zoom_settings'			
		);		
		*/
		add_settings_field(
			'zoom_type', 
			'Zoom type', 
			array($this, 'create_zoom_inner_field'), 
			'zoom_image_settings',
			'general_zoom_settings'			
		);		
		/*
		add_settings_field(
			'zoom_background_color', 
			'Background color', 
			array($this, 'create_zoom_color_field'), 
			'zoom_image_settings',
			'general_zoom_settings'			
		);		
		*/
		
		
    }
	
    public function check_zoom_image_options($input){
		
		if(!in_array($input['zoom_thumbnails'],array(0,1)))
		{
			$input['zoom_thumbnails'] = '';
		}
		
		if(!in_array($input['zoom_level'],array(0.5,1,2)))
		{
			$input['zoom_level'] = '';
		}
		
		if(!in_array($input['zoom_type'],array('window','inner','lens')))
		{
			$input['zoom_type'] = '';
		}
		
		return $input;
		
    }
	
    public function print_section_info(){
	//print 'Enter your setting below:';
    }
	
    public function create_zoom_thumbnails_field(){
		
		$options =  get_option('zoom_image_options');
    ?>
	
    <input type="checkbox" id="zoom_over_thumbnails" name="zoom_image_options[zoom_thumbnails]" value="1" <?php if($options['zoom_thumbnails']==1) { ?> checked="checked" <?php } ?> />
    
	<?php
    }
	
    public function create_zoom_inner_field(){
		
		$options =  get_option('zoom_image_options');
    ?>
	
    	<select name="zoom_image_options[zoom_type]">
            <option value="window" <?php if($options['zoom_type']=='window') { ?> selected="selected" <?php } ?>>Window</option>
        	<option value="lens" <?php if($options['zoom_type']=='lens') { ?> selected="selected" <?php } ?>>Lens</option>
        	<option value="inner" <?php if($options['zoom_type']=='inner') { ?> selected="selected" <?php } ?>>Inner</option>
        </select>
    
	<?php
    }
	
	
	public function create_zoom_level_field()
	{
		$options =  get_option('zoom_image_options');
	?>
    	<select name="zoom_image_options[zoom_level]">
            <option value="1" <?php if($options['zoom_level']==1) { ?> selected="selected" <?php } ?>>Normal zoom</option>
            <?php /*
        	<option value="0.5" <?php if($options['zoom_level']==0.5) { ?> selected="selected" <?php } ?>>Twice as big</option>
			*/ ?>
        	<option value="2" <?php if($options['zoom_level']==2) { ?> selected="selected" <?php } ?>>Twice as small</option>
        </select>
    <?php
	}
	
	
	public function create_zoom_color_field()
	{
		$options =  get_option('zoom_image_options');
	?>	
		<input type="text" id="zoom_background" class="wp-color-picker-field" name="zoom_image_options[zoom_background_color]" value="<?php echo esc_attr($options['zoom_background_color']); ?>" />
        <br />
        <span>Available only for Zoom type: window</span>
    <?php    
	}
	
	function apply_zoom()
	{
		
	
		global $post;
		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' );
	
		$options = get_option('zoom_image_options');
	
		ob_start();
	?>
    <script type="text/javascript">
    jQuery(document).ready(function($){
		$('.woocommerce-main-image img').attr('data-zoom-image','<?php echo $src[0]; ?>');
        $('.woocommerce-main-image img').elevateZoom({
			<?php if($options['zoom_level']) { ?>
			zoomLevel :	<?php echo strip_tags(trim($options['zoom_level'])); ?>,
			<?php }else { ?>
			zoomLevel :	1,
			<?php } ?>
			
			<?php
			switch ($options['zoom_type'])
			{
				case "window":
			?>
			zoomType  : "window",	
			lensShape : "square",	
			<?php	
				break;	
				case "lens":
			?>
			 zoomType	: "lens",
			 lensShape : "round",
			
			<?php	
				break;	
				case "inner":
			?>
			zoomType : "inner",
			cursor : "crosshair",
			<?php	
				break;	
				default:
			?>
			zoomType  : "window",	
			lensShape : "square",	
			<?php	
				break;
			}

				if(strlen(trim($options['zoom_background_color']))>1 && $options['zoom_type']=='window' ) { 
			?>
				tint:true, 
				tintColour:'<?php echo esc_attr($options['zoom_background_color']); ?>', 
				tintOpacity:0.5
			<?php
				}
			?>
		});
		
		<?php if($options['zoom_thumbnails']==1) { ?>
		$('.thumbnails .zoom img').each(function(){
				$(this).attr('data-zoom-image',$(this).parent().attr('href'));
		});
        $('.thumbnails .zoom img').elevateZoom({
			zoomType  : "window",
			lensShape : "square",
			lensSize  :	20,
			zoomWindowPosition: 16, 
			zoomWindowOffetx: 10,
			<?php if($options['zoom_level']) { ?>
			zoomLevel :	<?php echo strip_tags(trim($options['zoom_level'])); ?>,
			<?php }else { ?>
			zoomLevel :	1,
			<?php } ?>
			<?php
				if(strlen(trim($options['zoom_background_color']))>1) { 
			?>
				tint:true, 
				tintColour:'<?php echo esc_attr($options['zoom_background_color']); ?>', 
				tintOpacity:0.5
			<?php
				}
			?>
		});
		<?php } ?>
	
    })
	</script>
    <?php	
		echo ob_get_clean();
	}
	
	function add_scripts() {
		wp_enqueue_script( 'tcc-magnifier-js', $this->pluginUrl.'/js/jquery.elevateZoom-2.5.5.min.js', 'jquery' );
	}
	
	
	
	
}
$tcczoom = new TccZoom;
register_activation_hook( __FILE__, array('TccZoom', 'install') );