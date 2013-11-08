<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

/******************************************************************************
 * Global constants
 ******************************************************************************/
$stylesheet_path = get_stylesheet_directory() . "/style.css";
$theme_data = get_theme_data($stylesheet_path);

define("THEMENAME", $theme_data['Name']);
define("THEMEVERSION", $theme_data['Version']);
define("THEMEPREFIX", "met");

/******************************************************************************
 * Global notifications constants (do not modify!)
 ******************************************************************************/
define("NOTIFICATIONFOLDER", "metropolis");
define("NOTIFICATIONSURL", "http://thehappybit.com/themes/updates");

/******************************************************************************
 * Framework
 ******************************************************************************/
require_once TEMPLATEPATH . "/config/config.php";
require_once TEMPLATEPATH . "/framework/init.php";

/******************************************************************************
 * Register scripts
 ******************************************************************************/
if(!function_exists("theme_scripts")) {
	function theme_scripts() {
		$stylesheet_directory = get_template_directory_uri();
		
		wp_register_script( 'theme-default', $stylesheet_directory. '/js/script.js', 'jquery', "1.0", false );
		wp_register_script( 'prettyphoto', $stylesheet_directory. '/js/jquery.prettyPhoto.js', 'jquery', "3.1.3", false );
		wp_register_script( 'cycle', $stylesheet_directory. '/js/jquery.cycle.all.min.js', 'jquery', "3.1.3", false );
		wp_register_script( 'flexslider', $stylesheet_directory. '/js/jquery.flexslider-min.js', 'jquery', "3.1.3", false );
		wp_register_script( 'mobilemenu', $stylesheet_directory. '/js/jquery.mobilemenu.js', 'jquery', "1.0", false );
	}
}
add_action('init', 'theme_scripts');

/******************************************************************************
 * Gets the custom body classes
 ******************************************************************************/
function get_background_image_options() {
	$options = array(
		"0" => "&mdash; No",
		"1" => "Entry slideshow",
		"2" => "Global slideshow"
	);
	return $options;
}

function get_slideshow_metabox() {
	$num = ENTRY_SLIDES_NUM;
	$metabox = array(
		"position" => "normal",
		"priority" => "high",
		"fields" => array()
	);

	for( $i=1; $i<$num+1; $i++ ) {
		$metabox["fields"][] = array (
			"type" => "field_container_open",
			"name" => "",
			"key" => "",
			"parameters" => array(
				"class" => "super_container"
			)
		);
			$metabox["fields"][] = array (
				"name" => "Slide #{$i}",
				"desc" => "",
				"key" => "_slide_{$i}",
				"type" => "upload",
				"std" => "",
				"rowclass" => " firstrow clear"
			);
			$metabox["fields"][] = array (
				"type" => "field_container_open",
				"name" => "",
				"key" => ""
			);
			$metabox["fields"][] = array (
				"name" => "Title",
				"desc" => "",
				"key" => "_slide_{$i}_title",
				"type" => "text",
				"std" => "",
				"rowclass" => "notitle"
			);
			$metabox["fields"][] = array (
				"name" => "URL",
				"desc" => "",
				"key" => "_slide_{$i}_url",
				"type" => "text",
				"std" => "",
				"rowclass" => "notitle"
			);
			$metabox["fields"][] = array (
				"name" => "Video URL",
				"desc" => "",
				"key" => "_slide_{$i}_video",
				"type" => "text",
				"std" => "",
				"rowclass" => "notitle"
			);
			$metabox["fields"][] = array (
				"name" => "Caption",
				"desc" => "",
				"key" => "_slide_{$i}_caption",
				"type" => "textarea",
				"std" => "",
				"rowclass" => "notitle lastrow"
			);
			$metabox["fields"][] = array (
				"type" => "field_container_close",
				"name" => "",
				"key" => ""
			);
		$metabox["fields"][] = array (
			"type" => "field_container_close",
			"name" => "",
			"key" => ""
		);
	}

	return $metabox;
}

function get_entry_slideshow($post_id) {
	$num = ENTRY_SLIDES_NUM;
	$slides = array();
	for( $i=1; $i<$num+1; $i++ ) {
		$resizedSrc = thb_get_post_meta($post_id, "_slide_{$i}");
		$title = thb_get_post_meta($post_id, "_slide_{$i}_title");
		$caption = thb_get_post_meta($post_id, "_slide_{$i}_caption");
		$url = thb_get_post_meta($post_id, "_slide_{$i}_url");
		$video = thb_get_post_meta($post_id, "_slide_{$i}_video");

		if( !empty($resizedSrc) || !empty($video) ) {
			$slide = new stdClass;
			$slide->resizedSrc = $resizedSrc;
			$slide->title = $title;
			$slide->caption = $caption;
			$slide->url = $url;

			$slide->type = "picture";
			if( !empty($video) ) {
				$slide->type = "video";
				$slide->url = $video;
			}

			$slides[] = $slide;
		}
	}

	return $slides;
}

/******************************************************************************
 * Gets the custom body classes
 ******************************************************************************/
if(!function_exists("get_custom_body_classes")) {
	function get_custom_body_classes() {
		$classes = array();

		/**
		 * Showing the slideshow in these two occasions:
		 * 1) I'm in the home page (not static), and the slideshow is active
		 * 2) I'm in a page and the relative options are on and the slideshow isn't empty
		 *
		 * In case of static home page, the background in the home page would work just like it's on a regular subpage.
		 */
		$has_slides = count(get_page_background()) > 0;
		$is_slideshow_on = (
			(is_front_page() && is_slideshow_on() && $has_slides) ||
			((is_page() || is_single()) && thb_get_post_meta(get_the_ID(), "_background") != "0" && $has_slides)
		);

		// Slideshow
		if( $is_slideshow_on ) {
			$classes[] = "w-slideshow";
			if( thb_get_option("_style_slideshow_height") == 0 ) {
				$classes[] = "fullscreen";
			}
			if( thb_get_option("_style_slideshow_appearance") == "boxed" ) {
				$classes[] = "fullscreen";
			}
			if( thb_get_option("_slideshow_caption_style") == "boxed" ) {
				$classes[] = "boxed-caption";
			}
		}
		else
			$classes[] = "wout-slideshow";

		// Sidebar
		$sidebar="";
		$template = thb_get_page_template();
		
		if( is_portfolio() )
			$sidebar_key = "_sidebar_works";
		elseif( is_archive_page() )
			$sidebar_key = "_sidebar_archivesearch_id";
		elseif( is_blog() )
			$sidebar_key = "_sidebar_post";
		elseif( is_testimonials() )
			$sidebar_key = "_sidebar_testimonials";
		elseif( is_404() ) {}
		elseif( is_front_page() ) {
			$page_id = get_the_ID();
			$sidebar = thb_get_post_meta($page_id, "_page_sidebar");
		}
		else {
			// Page
			$page_id = get_the_ID();
			if( !endsWith($template, "-full.php") )
				$sidebar = thb_get_post_meta($page_id, "_page_sidebar");
		}

		if( empty($sidebar) && isset($sidebar_key) )
			$sidebar = thb_get_option($sidebar_key);

		if( !empty($sidebar) && !endsWith($template, "-full.php") ) {
			$classes[] = "w-sidebar";

			$widgets = thb_get_sidebar_widgets($sidebar);

			if( !empty($widgets) ) {
				if(endsWith($template, "-right.php"))
					$position =  "right";
				elseif(endsWith($template, "-left.php"))
					$position =  "left";
				elseif(endsWith($template, "-full.php"))
					$position = "no";
				else
					$position = thb_get_option("_sidebar_position");
			} else {
				$position =  "right";
			}

			$classes[] = "sidebar-" . $position;
		}
		else
			$classes[] = "wout-sidebar";

		return $classes;
	}
}

/******************************************************************************
 * Checks if we're in a Portfolio page
 ******************************************************************************/
function is_portfolio() {
	$is_portfolio = false;
	global $post;

	$page_template = thb_get_page_template();

	// Pages that end with 'template-portfolio' or single works, not works archive
	if(
		startsWith($page_template, "template-portfolio") ||
		isset($post) && $post->post_type == "works" && !is_tax()
	)
		$is_portfolio = true;
	
	return $is_portfolio;
}

/******************************************************************************
 * Checks if we're in a Blog page
 ******************************************************************************/
function is_blog() {
	$is_blog = false;
	global $post;

	$page_template = thb_get_page_template();

	if(
		startsWith($page_template, "template-blog") ||
		(isset($post) && $post->post_type == "post")
	)
		$is_blog = true;
	
	return $is_blog;
}

/******************************************************************************
 * Checks if we're in a Testimonials page
 ******************************************************************************/
function is_testimonials() {
	$is_testimonials = false;
	global $post;

	$page_template = thb_get_page_template();

	if( 
		startsWith($page_template, "template-testimonials") ||
		(isset($post) && $post->post_type == "testimonials")
	)
		$is_testimonials = true;
	
	return $is_testimonials;
}

/******************************************************************************
 * Checks if we're in a Staff page
 ******************************************************************************/
function is_staff() {
	$is_staff = false;
	global $post;

	$page_template = thb_get_page_template();

	if( 
		startsWith($page_template, "template-staff") ||
		(isset($post) && $post->post_type == "staff")
	)
		$is_staff = true;
	
	return $is_staff;
}

/******************************************************************************
 * Checks if we're in a Events page
 ******************************************************************************/
function is_events() {
	$is_events = false;
	global $post;

	$page_template = thb_get_page_template();

	if( 
		startsWith($page_template, "template-events") ||
		(isset($post) && $post->post_type == "events")
	)
		$is_events = true;
	
	return $is_events;
}

/******************************************************************************
 * Checks if we're in a Promotions page
 ******************************************************************************/
function is_promotions() {
	$is_promotions = false;
	global $post;

	$page_template = thb_get_page_template();

	if( 
		startsWith($page_template, "template-promotions") ||
		(isset($post) && $post->post_type == "promotions")
	)
		$is_promotions = true;
	
	return $is_promotions;
}

/******************************************************************************
 * Checks if the slideshow is ON
 ******************************************************************************/
function is_slideshow_on() {
	$slideshow_activation = thb_get_option("_slideshow_activation");
	return $slideshow_activation == 1;
}

/******************************************************************************
 * Checks if the site is using 
 ******************************************************************************/
function is_static_home_page() {
	global $page_id;
	return is_front_page() && $page_id != 0;
}

/******************************************************************************
 * Check if contact field are empty
 ******************************************************************************/
function contact_field_check() {
	$address = thb_get_option("_contact_address");
	$phone = thb_get_option("_contact_phone");
	$mobile = thb_get_option("_contact_mobile");
	$fax = thb_get_option("_contact_fax");
	$email = thb_get_option("_contact_email");

	return anyNotEmpty($address, $phone, $mobile, $fax, $email);
}

// FONTS ------------------------------------------------------------------------------------------

function displayFontRules( $section ) {

	$encode_font_family = thb_is_debug() && isset($_GET[THEMEPREFIX . $section]);

	cssRule("font-family", getFontFamily( thb_get_option($section)), null, $encode_font_family );
	cssRule("font-weight", thb_get_option($section."_weight"));
	cssRule("font-style", thb_get_option($section."_style"));
	cssRule("font-size", thb_get_option($section."_size"), "px");
	cssRule("line-height", thb_get_option($section."_lineheight"));
	cssRule("color", "#" . thb_get_option($section."_color"));
}

// BACKGROUNDS & COLORS ---------------------------------------------------------------------------

/******************************************************************************
 * Gets the page's background
 ******************************************************************************/
function get_page_background() {
	$bg_i = array();

	/**
	 * Global slideshow settings
	 */
	$type = thb_get_option("_slideshow_el");

	if( $type == "custom" || thb_get_option("_slideshow_el_num") == "" ) {
		$post_num = 999;
	} else {
		$post_num = thb_get_option("_slideshow_el_num");
	}

	$is_slideshow_page = ( is_front_page() && !is_static_home_page() ) || is_archive_page();

	if( $is_slideshow_page && is_slideshow_on() ) {
		$slideshow = new Slideshow($type, $post_num, null, null, "full");
		$bg_i = $slideshow->slides;
	} else {
		/**
		 * Post/page ID
		 */
		$id = get_the_ID();

		/**
		 * Checking what the user has selected to be the Post/page background
		 */
		$background_selection = thb_get_post_meta($id, "_background");

		switch( $background_selection ) {
			case 1:
				// Post/page slideshow
				$bg_i = get_entry_slideshow($id);
				break;
			case 2:
				// Global slideshow
				$slideshow = new Slideshow($type, $post_num, null, null, "full");
				$bg_i = $slideshow->slides;
				break;
			default:
				// No image/slideshow
				break;
		}
	}

	return $bg_i;
}

// Admin menu

function thb_admin_bar_custom_menu() {
	global $wp_admin_bar;
	
	// Slideshow submenu
	$slideshow_menu = array(
		'parent' => 'root_menu',
		'id' => 'slideshow', 
		'title' => "Slideshow",
		'href' => admin_url( 'admin.php?page=slideshow'),
		'meta' => false 
	);	
	$wp_admin_bar->add_menu( $slideshow_menu );
	
	// Sidebars submenu
	$sidebars_menu = array(
		'parent' => 'root_menu',
		'id' => 'sidebars',
		'title' => "Sidebars",
		'href' => admin_url( 'admin.php?page=sidebars'), 
		'meta' => false
	);	
	$wp_admin_bar->add_menu( $sidebars_menu );

	// Style customizer submenu
	$style_menu = array(
		'parent' => 'root_menu',
		'id' => 'style	',
		'title' => "Style",
		'href' => admin_url( 'admin.php?page=style'), 
		'meta' => false 
	);	
	$wp_admin_bar->add_menu( $style_menu );

	// Fonts submenu
	$style_menu = array(
		'parent' => 'root_menu',
		'id' => 'upload-your-fonts	',
		'title' => "Upload your fonts",
		'href' => admin_url( 'admin.php?page=upload-your-fonts'), 
		'meta' => false 
	);	
	$wp_admin_bar->add_menu( $style_menu );
	
	// Help submenu
	$help_menu = array(
		'parent' => 'root_menu',
		'id' => 'help',
		'title' => "Help",
		'href' => admin_url( 'admin.php?page=help'), 
		'meta' => false 
	);	
	$wp_admin_bar->add_menu( $help_menu );
		
}
add_action( 'wp_before_admin_bar_render', 'thb_admin_bar_custom_menu' );

/******************************************************************************
 * Adding the thumbnails & categories columns to the Works admin view
 ******************************************************************************/
if( isset($_GET['post_type']) && $_GET['post_type'] == "works" ) {
	add_filter('manage_posts_columns', 'posts_columns', 5);
	add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);

	function posts_columns($defaults) {
		$newColumns = array();

		foreach( $defaults as $key => $title ) {
			if( $key == 'title' )
				$newColumns['thb_post_thumbs'] = __('Image', THEMENAME);

			if( $key == 'date' )
				$newColumns['thb_post_categories'] = __('Types', THEMENAME);

			$newColumns[$key] = $title;
		}

	    return $newColumns;
	}

	function posts_custom_columns($column_name, $id) {
		if($column_name === 'thb_post_thumbs')
	        echo the_post_thumbnail( 'micro' );

	    if($column_name == 'thb_post_categories') {
	    	$eventcats = get_the_terms(get_the_ID(), "types");
            $eventcats_html = array();
            if ($eventcats) {
                foreach ($eventcats as $eventcat)
                	array_push($eventcats_html, $eventcat->name);
                echo implode($eventcats_html, ", ");
            } else {
            	_e('None', THEMENAME);
            }
	    }
	}
}

/******************************************************************************
 * Enabling custom backgrounds
 ******************************************************************************/
add_custom_background();

/******************************************************************************
 * This theme styles the visual editor with editor-style.css to match the theme style
 ******************************************************************************/
add_editor_style();

/******************************************************************************
 * Execute theme setup
 ******************************************************************************/
function thb_execute_theme_setup() {

	// Colors -----------------------------------------------------------------
	thb_update_option("_main_color", "FF644B");
	thb_update_option("_topbar_background_color", "333333");
	thb_update_option("_menu_background_color", "FFFFFF");
	thb_update_option("_submenu_background_color", "FFFFFF");
	thb_update_option("_body_background_color", "FFFFFF");
	thb_update_option("_topwidgetarea_background_color", "FFFFFF");
	
	// Fonts ------------------------------------------------------------------
	
	thb_update_option("_font_pagetitle", "Open+Sans");
	thb_update_option("_font_pagetitle_weight", "bold");
	thb_update_option("_font_pagetitle_style", "normal");
	thb_update_option("_font_pagetitle_size", "42");
	thb_update_option("_font_pagetitle_lineheight", "1.15");
	thb_update_option("_font_pagetitle_color", "111111");

	thb_update_option("_font_pagesubtitle", "Open+Sans");
	thb_update_option("_font_pagesubtitle_weight", "normal");
	thb_update_option("_font_pagesubtitle_style", "normal");
	thb_update_option("_font_pagesubtitle_size", "14");
	thb_update_option("_font_pagesubtitle_lineheight", "1.50");
	thb_update_option("_font_pagesubtitle_color", "666666");

	thb_update_option("_font_text", "Open+Sans");
	thb_update_option("_font_text_weight", "normal");
	thb_update_option("_font_text_style", "normal");
	thb_update_option("_font_text_size", "13");
	thb_update_option("_font_text_lineheight", "1.50");
	thb_update_option("_font_text_color", "333333");

	thb_update_option("_font_footertext", "Open+Sans");
	thb_update_option("_font_footertext_weight", "normal");
	thb_update_option("_font_footertext_style", "normal");
	thb_update_option("_font_footertext_size", "13");
	thb_update_option("_font_footertext_lineheight", "1.50");
	thb_update_option("_font_footertext_color", "333333");

	thb_update_option("_font_slideheading", "Open+Sans");
	thb_update_option("_font_slideheading_weight", "bold");
	thb_update_option("_font_slideheading_style", "normal");
	thb_update_option("_font_slideheading_size", "32");
	thb_update_option("_font_slideheading_lineheight", "1.00");
	thb_update_option("_font_slideheading_color", "ffffff");

	thb_update_option("_font_menu", "Open+Sans");
	thb_update_option("_font_menu_weight", "bold");
	thb_update_option("_font_menu_style", "normal");
	thb_update_option("_font_menu_size", "12");
	thb_update_option("_font_menu_lineheight", "1.15");
	thb_update_option("_font_menu_color", "111111");

	thb_update_option("_font_submenu", "Open+Sans");
	thb_update_option("_font_submenu_weight", "normal");
	thb_update_option("_font_submenu_style", "normal");
	thb_update_option("_font_submenu_size", "12");
	thb_update_option("_font_submenu_lineheight", "1.15");
	thb_update_option("_font_submenu_color", "111111");

	thb_update_option("_font_widgetheadings", "Open+Sans");
	thb_update_option("_font_widgetheadings_weight", "bold");
	thb_update_option("_font_widgetheadings_style", "normal");
	thb_update_option("_font_widgetheadings_size", "13");
	thb_update_option("_font_widgetheadings_lineheight", "1.50");
	thb_update_option("_font_widgetheadings_color", "111111");
	
	thb_update_option("_font_topareawidgetheadings", "Open+Sans");
	thb_update_option("_font_topareawidgetheadings_weight", "bold");
	thb_update_option("_font_topareawidgetheadings_style", "normal");
	thb_update_option("_font_topareawidgetheadings_size", "13");
	thb_update_option("_font_topareawidgetheadings_lineheight", "1.50");
	thb_update_option("_font_topareawidgetheadings_color", "111111");

	thb_update_option("_font_footerareawidgetheadings", "Open+Sans");
	thb_update_option("_font_footerareawidgetheadings_weight", "bold");
	thb_update_option("_font_footerareawidgetheadings_style", "normal");
	thb_update_option("_font_footerareawidgetheadings_size", "13");
	thb_update_option("_font_footerareawidgetheadings_lineheight", "1.50");
	thb_update_option("_font_footerareawidgetheadings_color", "111111");

}