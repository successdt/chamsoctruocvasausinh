<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

$stylesheet_directory = get_template_directory_uri();

/*
 * Global constants
 */
define("FRAMEWORKPATH", TEMPLATEPATH . "/framework");
define("FRAMEWORKURL", $stylesheet_directory . "/framework");
define("HELP", TEMPLATEPATH . "/help");
define("FRAMEWORKNAME", "HappyFramework by <a href='http://thehappybit.com'>The Happy Bit</a>");
define("FRAMEWORKVERSION", "0.5");
define("CONFIG_FOLDER", "config");

/*
 * Theme constants
 */
define("CONFIG", TEMPLATEPATH . "/" . CONFIG_FOLDER);
define("CONFIGURL", $stylesheet_directory . "/" . CONFIG_FOLDER);
define("PAGES", CONFIG . "/pages");
define("PAGESURL", CONFIGURL . "/pages");
define("POST_TYPES", CONFIG . "/post_types");
define("POST_TYPESURL", CONFIGURL . "/post_types");
define("STYLEURL", CONFIGURL . "/style");
define("STYLE", CONFIG . "/style");
define("FONTSURL", STYLEURL . "/i/fonts");
define("FONTS", STYLE . "/i/fonts");
define("BACKGROUNDSURL", STYLEURL . "/i/backgrounds");
define("BACKGROUNDS", STYLE . "/i/backgrounds");
define("PATTERNS", STYLE . "/i/patterns");
define("PATTERNSURL", STYLEURL . "/i/patterns");
define("TAXONOMIES", CONFIG . "/taxonomies");
define("WIDGETS", CONFIG . "/widgets");
define("WIDGETSURL", CONFIGURL . "/widgets");
define("SHORTCODES", CONFIG . "/shortcodes");
define("TEMPLATES", TEMPLATEPATH . "/templates");
define("COMPONENTS", CONFIG . "/components");
define("RESOURCES", CONFIG . "/resources");
define("FRONTENDURL", FRAMEWORKURL . "/frontend");

/**
 * Admin constants
 */
define("CORE", FRAMEWORKPATH . "/core");
define("LIB", FRAMEWORKPATH . "/lib");
define("HELPERS", FRAMEWORKPATH . "/helpers");
define("LIBURL", FRAMEWORKURL . "/lib");
define("ADMIN_RESOURCES", FRAMEWORKURL . "/resources");

/**
 * Duplicable fields types
 */
define("SLIDESHOW", "slideshow");
define("SIDEBAR", "sidebar");
define("STRIPE", "stripe");
define("CUSTOMFONT", "customfont");

/**
 * Logic constants
 */
define("THB_ADMIN_PAGE_SAVED", "thb_admin_page_saved");

/**
 * Theme updates
 */
require LIB . "/update-notifier.php";

/*
 * Database migrations
 */
include CORE . "/db/migrations.php";
thb_execute_migration();

/*
 * Admin includes
 */
include CORE . "/admin.common.php";
include CORE . "/admin.page.php";
include CORE . "/admin.resources.php";
include CORE . "/logic.common.php";

/*
 * Frontend includes
 */
include CORE . "/frontend.common.php";
include CORE . "/slideshow.php";

/*
 * Custom/Third party libraries
 */
include LIB . "/thb.tpl.class.php";
include LIB . "/color.class.php";

/*
 * THB TPL initialization
 */
THBTpl::configure("tpl_dir", CORE . "/tpl/");

/*
 * Theme sidebars
 */
foreach($theme['sidebars'] as $sidebar) {
	register_sidebar($sidebar);
}

if( isset($theme['system_sidebars']) ) {
	foreach($theme['system_sidebars'] as $sidebar) {
		register_sidebar($sidebar);
	}
}

/**
 * User-created sidebars
 */
$return = array();
$items = thb_get_duplicable(SIDEBAR);
foreach($items as $item) {
	$sidebar = $theme['sidebar_template'];
	$sidebar['name'] = $item['title'];
	$sidebar['id'] = $item['name'];
	register_sidebar($sidebar);
}

/**
 * Homepage builder-created sidebars
 */
// $return = array();
// $query = "SELECT * FROM " . DUPLICABLE_TABLE . " WHERE type = '". STRIPE . "' ORDER BY ord";
// $items = $wpdb->get_results($query, ARRAY_A);
// foreach($items as $item) {
// 	$sidebar = $theme['sidebar_template'];
// 	$sidebar['name'] = $item['title'];
// 	$sidebar['id'] = $item['name'];
// 	register_sidebar($sidebar);
// }

/*
 * Custom taxonomies
 */
foreach($theme['taxonomies'] as $taxonomy) {
	$file = TAXONOMIES . "/" . $taxonomy . ".php";
	if(file_exists($file))
		include $file;
}

/*
 * Custom post types
 */
foreach($theme['post_types'] as $post_type) {
	$file = POST_TYPES . "/" . $post_type . ".php";
	if(file_exists($file))
		include $file;
}

/*
 * Post formats
 */
add_theme_support( 'post-formats', $theme['post_formats'] );

/*
 * WordPress custom menus
 */
if( !empty($theme['wp_menus']) ) {	
	register_nav_menus($theme['wp_menus']);
}

/*
 * Theme widgets
 */
foreach($theme['widgets'] as $widget) {
	$file = WIDGETS . "/" . $widget . ".php";
	if(file_exists($file))
		include $file;
}

/*
 * Theme shortcodes
 */
foreach($theme['shortcodes'] as $shortcode) {
	$file = SHORTCODES . "/" . $shortcode . ".php";
	if(file_exists($file))
		include $file;
}

/*
 * Custom image sizes
 */
foreach($theme['imagesizes'] as $size) {
	add_image_size($size[0], $size[1], $size[2], $size[3]);
}

/*
 * Admin actions
 */
add_action('admin_menu', 'add_admin_pages');

/*
 * Enabling post/page thumbnails
 */
add_theme_support('post-thumbnails');

/*
 * Enabling excerpts for pages too
 */
add_post_type_support('page', 'excerpt');

/*
 * Setting max content width
 */
if ( ! isset( $content_width ) ) $content_width = 940;

/* 
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
load_theme_textdomain( THEMENAME, TEMPLATEPATH . '/languages' );

/* 
 * Add default posts and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/**
 * Flush rewrite rules
 */
function thb_flush_rewrite_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/* 
 * Loads the custom comments template
 */
function thb_comment($comment, $args, $depth) {
	$file = TEMPLATEPATH . "/comment.php";
	if(file_exists($file))
		include $file;
}

/**
 * Default configuration
 */
include CORE . "/boot/options.php";
thb_execute_default_configuration();

/**
 * Custom login image
 * 
 * 326x67 default dimensions
 */
if(thb_get_option('_login_url') and thb_get_option("_login_url")!=""): 

	function custom_login_logo() {
		$logourl = thb_get_option("_login_url");
		$logopath = urlToPath($logourl);

		$logoinfos = getimagesize($logopath);

	  	echo '<style type="text/css">
	    	.login h1 a { 
	    		width: '. $logoinfos[0] .'px;
	    		height: '. $logoinfos[1] .'px;
	    		background-image: url("'. $logourl .'") !important;
	    	}
		</style>';
	}
	add_action('login_head', 'custom_login_logo');

endif;

/**
 * Analytics
 */
function thb_google_analytics() {
	$analytics = thb_get_option("_analytics", true);
	if( !empty($analytics) )
		echo $analytics;
}
add_action("wp_footer", "thb_google_analytics");

/**
 * Frontend
 */
function thb_frontend_scripts() {
	wp_register_script( 'thb-lib', FRONTENDURL. '/js/thb.lib.js', 'jquery', "1.0", false );
	wp_register_script( 'froogaloop', FRONTENDURL. '/js/froogaloop.js', '', "", false );
}
add_action('init', 'thb_frontend_scripts');

/**
 * Text
 */
function thb_upload_button_text( $translation, $original ) {
	if ( isset( $_REQUEST['type'] ) ) { return $translation; }

	if( $original == 'Insert into Post' ) {
		$translation = __( 'Use this Image', THEMENAME );

		if ( isset( $_REQUEST['title'] ) && $_REQUEST['title'] != '' ) { 
			$translation = sprintf( __( 'Use as %s', THEMENAME ), esc_attr( strtolower($_REQUEST['title']) ) );
		}
	}

	return $translation;
}
add_filter( 'gettext', 'thb_upload_button_text', null, 2 );