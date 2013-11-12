<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

/******************************************************************************
 * Core helpers
 ******************************************************************************/

require_once HELPERS . "/system.helper.php";
require_once HELPERS . "/text.helper.php";
require_once HELPERS . "/logic.helper.php";
require_once HELPERS . "/css.helper.php";
require_once HELPERS . "/query.helper.php";
require_once HELPERS . "/image.helper.php";
require_once HELPERS . "/template.helper.php";
require_once HELPERS . "/sidebar.helper.php";
require_once HELPERS . "/upload.helper.php";

// LAYOUT FUNCTIONS ===========================================================

/**
 * Gets the sidebar's width in columns
 */
function thb_sidebar_width() {
	return "span-" . SIDEBAR_WIDTH;
}

/**
 * Gets the main's width in columns
 */
function thb_main_width() {
	return "span-" . (THEME_COLUMNS - SIDEBAR_WIDTH);
}

/**
 * Gets the full width in columns
 */
function thb_full_width() {
	return "span-" . THEME_COLUMNS;
}

// HOME PAGE STRIPES ==========================================================

/**
 * Gets the stripes
 */
function thb_get_stripes() {
	$return = array();
	$stripes = thb_get_duplicable(STRIPE);
	foreach($stripes as $stripe) {
		$infos = json_decode(stripslashes($stripe['caption']), true);

		$s = new stdClass;
		$s->id = $stripe['name'];
		$s->cols = $infos['n'];
		$s->sizes = explode(",",$infos['sizes']);
		$s->style = $infos['style'];

		$return[] = $s;
	}

	return $return;
}

/**
 * Gets the widget IDs of the specified sidebar
 */
function thb_get_sidebar_widgets($sidebar) {
	$widgets = wp_get_sidebars_widgets();
	if(isset($widgets[$sidebar]))
		return $widgets[$sidebar];

	return array();
}

/**
 * Gets the widget class from its ID
 */
function thb_get_widget_class($widget_id) {
	global $wp_registered_widgets;
	$widget = $wp_registered_widgets[$widget_id];
	$key = isset($widget['callback_wl_redirect']) ? 'callback_wl_redirect' : 'callback';

	$class = get_class($widget[$key][0]);
	return $class;
}

/**
 * Gets the widget ID number
 */
function thb_get_widget_id($widget_id) {
	$id = explode("-", $widget_id);
	return end($id);
}

/**
 * Gets the widget's type
 */
function thb_get_widget_type($widget_id) {
	global $wp_registered_widgets;
	$widget = $wp_registered_widgets[$widget_id];
	$key = isset($widget['callback_wl_redirect']) ? 'callback_wl_redirect' : 'callback';

	return $widget[$key][0]->option_name;
}

/**
 * Gets the widget instance options
 */
function thb_get_widget_options($widget_type, $widget_id) {
	$opts = get_option($widget_type);
	$id = thb_get_widget_id($widget_id);
	return $opts[$id];
}

function thb_the_widget($widget_id, $sidebar) {
	$widget_type = thb_get_widget_type($widget_id);
	$id = thb_get_widget_id($widget_id);
	$opts = thb_get_widget_options($widget_type, $id);

	error_reporting(E_ALL ^ E_NOTICE);
	the_widget(
		thb_get_widget_class($widget_id),
		$opts,
		array(
			'before_widget' => $sidebar['before_widget'],
			'after_widget' => $sidebar['after_widget'],
			'before_title' => $sidebar['before_title'],
			'after_title' => $sidebar['after_title']
		)
	);
}

// POST FUNCTIONS =============================================================

/**
 * Gets the related posts
 */
function thb_get_related_posts($post_id, $args=array()) {
	
	$post = get_post($post_id);
	$taxonomies = thb_get_taxonomies($post->post_type);

	$args['post__not_in'] = array($post_id);
	
	$tax_query = array();
	$tax_query['relation'] = 'OR';
	foreach($taxonomies as $key => $name) {
		$terms = wp_get_post_terms($post_id, $key, array('fields' => 'ids'));
		if(!empty($terms)) {
			$tax_query[] = array(
				'taxonomy' => $key,
				'field' => 'id',
				'terms' => $terms,
				'operator' => 'IN'
			);
		}
	}
	
	$args['tax_query'] = $tax_query;

	return thb_get_posts($post->post_type, $args);
}

/**
 * Gets the taxonomies associated to a custom post type
 */
function thb_get_taxonomies($post_type) {
	return get_taxonomies(
		array(
			'object_type' => array($post_type)
		)
	);
}

// UTILITIES ==================================================================

/**
 * Gets a default fonts stack
 */
function getFontStack($category) {
	$fontStack = array(
		"Sans" => "Helvetica, Arial, sans-serif",
		"Serif" => "Georgia, Times, serif",
		"Script and decorative" => "script",
		"Handwritten" => "script"
	);

	if( isset($fontStack[$category]) )
		return $fontStack[$category];

	return "";
}

/**
 * Gets a list of available Google WebFonts
 */
function getFonts() {
	$fontArray = array(
		"Sans" => array(
			'Arial'				  => 'Arial',	
			'Helvetica'           => 'Helvetica',
			'Verdana'             => 'Verdana',
			'Tahoma'              => 'Tahoma',
			'Trebuchet MS'        => 'Trebuchet MS',
			"Asap"                => 'Asap',
			"Dosis"               => "Dosis",
			"Droid+Sans"          => "Droid Sans",
			"Exo"                 => "Exo",
			"Open+Sans"           => "Open Sans",
			"Open+Sans+Condensed" => "Open Sans Condensed",
			"Yanone+Kaffeesatz"   => "Yanone Kaffeesatz",
			"PT+Sans"             => "PT Sans",
			"PT+Sans+Caption"     => "PT Sans Caption",
			"Ubuntu"              => "Ubuntu",
			"Ubuntu+Condensed"    => "Ubuntu Condensed",
			"Lato"                => "Lato",
			"Abel"                => "Abel",
			"Anton"               => "Anton",
			"Amaranth"            => "Amaranth",
			"Muli"                => "Muli",
			"Varela+Round"        => "Varela Round",
			"Questrial"           => "Questrial",
			"Montserrat"          => "Montserrat",
			"Paytone+One"         => "Paytone One",
			"Quicksand"           => "Quicksand",
			"Quattrocento+Sans"   => "Quattrocento Sans",
			"Josefin+Sans"        => "Josefin Sans",
			"Raleway"             => "Raleway",
			"Six+Caps"            => "Six Caps",
			"Maven+Pro"           => "Maven Pro",
			"Cabin"               => "Cabin",
			"Cabin+Condensed"     => "Cabin Condensed",
			"Snippet"             => "Snippet",
			"Oswald"              => "Oswald"
		),
		"Serif" => array(
			'Georgia'       => 'Georgia',
			"Alegreya"      => "Alegreya",
			"Alfa+Slab+One" => "Alfa Slab One",
			"Arvo"          => "Arvo",
			"Bree+Serif"    => "Bree Serif",
			"Crimson+Text"  => "Crimson Text",
			"Droid+Serif"   => "Droid Serif",
			"Gentium+Basic" => "Gentium Basic",
			"Trocchi"       => "Trocchi",
			"Mate+SC"       => "Mate SC",
			"Cutive"        => "Cutive",
			"PT+Serif"      => "PT Serif",
			"Ultra"         => "Ultra",
			"Bitter"        => "Bitter",
			"Neuton"        => "Neuton",
			"Quattrocento"  => "Quattrocento",
			"Vollkorn"      => "Vollkorn",
			"Prociono"      => "Prociono",
			"Rokkitt"       => "Rokkitt",
			"Bevan"         => "Bevan",
			"Lora"          => "Lora",
			"Copse"         => "Copse",
			"Kreon"         => "Kreon",
			"Josefin+Slab"  => "Josefin Slab",
			"Patua+One"     => "Patua One",
			"Merriweather"  => "Merriweather"
		),
		"Script and decorative" => array(
			"Cookie"             => "Cookie",
			"Leckerli+One"       => "Leckerli One",
			"Lobster"            => "Lobster",
			"Lobster+Two"        => "Lobster Two",
			"Parisienne"         => "Parisienne",
			"Pinyon+Script"      => "Pinyon Script",
			"Crushed"            => "Crushed",
			"Cabin+Sketch"       => "Cabin Sketch",
			"Special+Elite"      => "Special Elite",
			"Fugaz+One"          => "Fugaz One",
			"Sansita+One"        => "Sansita One",
			"Nixie+One"          => "Nixie One",
			"Bangers"            => "Bangers",
			"Metamorphous"       => "Metamorphous",
			"UnifrakturMaguntia" => "UnifrakturMaguntia",
			"Sarina"             => "Sarina"
		),
		"Handwritten" => array(
			"Coming+Soon"         => "Coming Soon",
			"Crafty+Girls"        => "Crafty Girls",
			"Rock+Salt"           => "Rock Salt",
			"Shadows+Into+Light"  => "Shadows Into Light",
			"Pacifico"            => "Pacifico",
			"Sunshiney"           => "Sunshiney",
			"Permanent+Marker"    => "Permanent Marker",
			"Architects+Daughter" => "Architects Daughter",
			"Indie+Flower"        => "Indie Flower",
			"Neucha"              => "Neucha",
			"Satisfy"             => "Satisfy",
			"Amatic+SC"           => "Amatic SC",
			"Sue+Ellen+Francisco" => "Sue Ellen Francisco",
			"Patrick+Hand"        => "Patrick Hand",
			"Over+the+Rainbow"    => "Over the Rainbow",
			"Delius+Swash+Caps"   => "Delius Swash Caps",
			"Walter+Turncoat"     => "Walter Turncoat"
		),
		"Custom" => array()
	);

	// Custom font array
	if( function_exists("getCustomFonts") ) {
		$custom_font_array = getCustomFonts();
		foreach( $custom_font_array as $category_name => $category_fonts ) {
			foreach( $category_fonts as $css => $name ) {
				$fontArray[$category_name][$css] = $name;
			}
		}
	}

	$items = thb_get_duplicable(CUSTOMFONT);
	foreach($items as $item) {
		$families = unserialize( $item['caption'] );
		if( is_array($families) ) {
			foreach( $families as $family ) {
				if( !isset($fontArray[$family]) )
					$fontArray['Custom'][$family] = $family;
			}
		}
	}

	return $fontArray;
}

/**
 * Imports a Google WebFont
 */
function importGoogleWebFont($family, $fonts=null) {

	if( !$fonts )
		$fonts = getFonts();

	$font = filterWebFont($fonts, $family);

	$prohibitedFonts = array("Georgia", "Helvetica", "Verdana", "Tahoma", "Trebuchet MS");

	$items = thb_get_duplicable(CUSTOMFONT);
	foreach($items as $item) {
		$families = unserialize( $item['caption'] );
		if( is_array($families) ) {
			foreach( $families as $family ) {
				if( !isset($fontArray[$family]) )
					$prohibitedFonts[] = $family;
					// $fontArray['Custom'][$family] = $family;
			}
		}
	}

	if( $font && !in_array($font, $prohibitedFonts) ) {
		echo "@import url(http://fonts.googleapis.com/css?family={$font}:100,300,normal,italic,bold,bolditalic);\n";
	}
}

/**
 * Filters a Google WebFonts request
 */
function filterWebFont($fonts, $family) {

	if( !$fonts )
		$fonts = getFonts();

	foreach( $fonts as $category => $cat_fonts ) {
		foreach( $cat_fonts as $font_css_name => $font_name ) {
			if( $font_css_name == $family ) {
				return $font_css_name;
			}
		}
	}

	return null;
}

/**
 * Get font-family declaration
 */
function getFontFamily($css_name, $fonts=null, $encode=false) {

	if( !$fonts )
		$fonts = getFonts();

	if( $encode ) {
		$css_name = urlencode($css_name);
	}

	foreach( $fonts as $category => $cat_fonts ) {
		foreach( $cat_fonts as $font_css_name => $font_name ) {
			if( $font_css_name == $css_name ) {
				$fontStack = getFontStack($category);
				$family = "'" . $font_name . "'";
				if( !empty($fontStack) ) {
					$family .= ", " . $fontStack;
				}
				return $family;
			}
		}
	}

	return "";
}

// ============================================================================

// add_filter('the_content', 'thb_shortcode_empty_paragraph_fix');
function thb_shortcode_empty_paragraph_fix($content)
{
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $array);

	return $content;
}

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @return string "Continue Reading" link
 */
function thb_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', THEMENAME ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @return string An ellipsis
 */
function thb_auto_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'thb_auto_excerpt_more' );

/**
* Method: xss_protect
*    Purpose: Attempts to filter out code used for cross-site scripting attacks
*    @param $data - the string of data to filter
*    @param $strip_tags - true to use PHP's strip_tags function for added security
*    @param $allowed_tags - a list of tags that are allowed in the string of data
*    @return a fully encoded, escaped and (optionally) stripped string of data
*/
function xss_protect($data, $strip_tags = false, $allowed_tags = "") { 
    if($strip_tags) {
        $data = strip_tags($data, $allowed_tags . "<b>");
    }

    if(stripos($data, "script") !== false) { 
        $result = str_replace("script","scr<b></b>ipt", htmlentities($data, ENT_QUOTES)); 
    } else { 
        $result = htmlentities($data, ENT_QUOTES); 
    } 

    return $result;
}

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function thb_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'thb_remove_gallery_css' );


/**
 * Makes some changes to the <title> tag, by filtering the output of wp_title().
 *
 * If we have a site description and we're viewing the home page or a blog posts
 * page (when using a static front page), then we will add the site description.
 *
 * If we're viewing a search result, then we're going to recreate the title entirely.
 * We're going to add page numbers to all titles as well, to the middle of a search
 * result title and the end of all other titles.
 *
 * The site title also gets added to all titles.
 *
 * @param string $title Title generated by wp_title()
 * @param string $separator The separator passed to wp_title(). Twenty Ten uses a
 * 	vertical bar, "|", as a separator in header.php.
 * @return string The new title, ready for the <title> tag.
 */
function thb_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', THEMENAME ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', THEMENAME ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', THEMENAME ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'thb_filter_wp_title', 10, 2 );