<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

add_action('admin_enqueue_scripts', 'appendThemeInstance');
add_action('admin_init', 'appendAdminStyleSheet');
add_action('admin_init', 'appendJSON');
add_action('admin_init', 'appendAdminScripts');
add_action('admin_init', 'appendColorPicker');
add_action('admin_init', 'appendjQueryUI');
add_action('admin_init', 'appendjQueryTmpl');

if(function_exists("getFonts"))
	add_action('admin_enqueue_scripts', 'appendCustomFonts');

function appendThemeInstance() {
	?>
	<script type="text/javascript">
		var themeprefix = "<?php echo THEMEPREFIX; ?>";
		var wpdateformat = "<?php echo get_option('date_format'); ?>";
	</script>
	<?php
}

function appendCustomFonts() {
	?>
	<script type="text/javascript">
		var customfonts = <?php echo json_encode(getFonts()); ?>;
	</script>
	<?php
}

function appendAdminStyleSheet() {
	wp_enqueue_style('thickbox');
	
	wp_register_style('thbAdminStyleSheet', ADMIN_RESOURCES.'/css/admin.css');
	wp_enqueue_style("thbAdminStyleSheet");
	
	wp_register_style('thbAdminIconsStyleSheet', POST_TYPESURL.'/i/icons.css');
	wp_enqueue_style("thbAdminIconsStyleSheet");

	if( file_exists(STYLE . '/fonts.css') ) {
		wp_register_style('thbAdminFontsStyleSheet', STYLEURL.'/fonts.css');
		wp_enqueue_style("thbAdminFontsStyleSheet");
	}
	
	wp_register_style('thbAdminStyle', STYLEURL.'/adminstyle.css');
	wp_enqueue_style("thbAdminStyle");
}

function appendAdminScripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	
	wp_register_script('thbAdminScript', ADMIN_RESOURCES.'/js/admin.js');
	wp_enqueue_script("thbAdminScript");
}

function appendColorPicker() {
	wp_register_script('thbColorPickerScript', ADMIN_RESOURCES.'/js/jscolor.js');
	wp_enqueue_script("thbColorPickerScript");
}

function appendjQueryUI() {
	wp_enqueue_script("jquery-ui-sortable");
	wp_enqueue_script("jquery-ui-datepicker");
}

function appendJSON() {
	wp_register_script('JSONScript', ADMIN_RESOURCES.'/js/json.js');
	wp_enqueue_script("JSONScript");
}

function appendjQueryTmpl() {
	wp_register_script('thbjQueryTmplScript', ADMIN_RESOURCES.'/js/jquery.tmpl.min.js');
	wp_enqueue_script("thbjQueryTmplScript");
}