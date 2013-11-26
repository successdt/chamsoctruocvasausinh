<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
	Description: Templating utility functions.
*/

// Post functions =================================================================================

/**
 * Gets a post's featured image.
 * 
 * @param int $post_id The post's ID.
 * @param string $size The image size.
 * @return string
 **/
function thb_get_thumbnail($post_id, $size="full")
{
	$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
	return $thumbnail[0];
}

/**
 * Gets a post's featured image (alias for thb_get_thumbnail).
 *
 * @param int $post_id The post's ID.
 * @param string $size The image size.
 * @return string
 **/
function thb_get_featured_image( $post_id, $size="full" )
{
	return thb_get_thumbnail($post_id, $size);
}

/**
 * Gets a post's gallery.
 *
 * @param string $size The thumbnail size.
 * @param int $columns The number of columns.
 * @return string
 **/
function thb_get_post_gallery( $size, $columns=1 )
{
	global $post;

	$gallery = do_shortcode('[thb_gallery link="file" size="' . $size . '"]');

	return $gallery;
}

/**
 * Gets a post's meta field.
 *
 * @param int $post_id The post's ID.
 * @param string $key The option key without the THEMEPREFIX.
 * @param boolean $single If set to true, the function returns the first value of the specified key (not in an array).
 * @return string
 * @see http://codex.wordpress.org/Function_Reference/get_post_meta
 **/
function thb_get_post_meta( $post_id, $key, $single=true )
{
	return get_post_meta($post_id, THEMEPREFIX.$key, $single);
}

/**
 * Gets the date ready for microformats use
 *
 * @return string
 **/
function thb_get_the_date_microformatted()
{
	global $post;

	return get_the_date("Y-m-d");
}

/**
 * Returns the date in the requested format.
 *
 * @param string $date The date to translate.
 * @return array
 **/
function thb_get_the_date( $date=null )
{
	if( !$date )
		$date = date("Y-m-d");

	$timestamp = strtotime($date);

	$formatted_date = array(
		"day" => strftime('%d', $timestamp),
		"month" => strftime('%b', $timestamp),
		"year" => strftime('%Y', $timestamp)
	);

	return $formatted_date;
}

/**
 * Checks if the current post has a previous one.
 *
 * @return boolean
 **/
function thb_post_has_previous()
{
	global $post;

	$thb_content = "";
	ob_start();
	previous_post_link('%link');
	$thb_content = ob_get_contents();
	ob_end_clean();

	return !empty($thb_content);
}

/**
 * Checks if the current post has a next one.
 *
 * @return boolean
 **/
function thb_post_has_next()
{
	global $post;

	$thb_content = "";
	ob_start();
	next_post_link('%link');
	$thb_content = ob_get_contents();
	ob_end_clean();

	return !empty($thb_content);
}

// Pagination =====================================================================================

/**
 * Gets a page link.
 *
 * @param string $link The page number.
 * @return string
 **/
function thb_get_page_link( $link )
{
	global $page_id, $post;
	$post = get_post( $page_id );

	if( $page_id == 0 ) {
		// Static home page
		$url = add_query_arg( 'page', $link, home_url() );
		if( $link == 1 )
			$url = remove_query_arg('page', $url);
	} else {
		$url = preg_replace('!">$!','',_wp_link_page($link));
		$url = preg_replace('!^<a href="!','',$url);
	}

	return $url;
}

/**
 * Gets a previous/next pagination link.
 *
 * @param string $linkText The link text.
 * @param WP_Query $query The query object to paginate.
 * @param string $type The link type (prev/next).
 * @return void
 **/
function thb_get_navigation_link( $linkText, $query, $type )
{
	$numPages = $query->max_num_pages;
	if( empty($numPages) )
		$numPages = 1;
	
	// Current page
	$currentPage = 1;
	if (get_query_var('paged'))
		$currentPage = get_query_var('paged');
	elseif (get_query_var('page'))
		$currentPage = get_query_var('page');
	
	// Show condition
	$show = false;

	// Type
	switch($type) {
		case 'next':
			$linkPage = $currentPage - 1;
			$show = !( $currentPage == 1 );
			break;
		case 'prev':
			$linkPage = $currentPage + 1;
			$show = !( $numPages == 1 || $currentPage >= $numPages );
			break;
	}

	if( $show ) {
		$url = thb_get_page_link($linkPage);
		$link = "<a href=\"{$url}\">{$linkText}</a>";
		echo $link;
	}
}

/**
 * Gets a "previous" pagination link.
 *
 * @param string $linkText The link text.
 * @param WP_Query $query The query object to paginate.
 * @return void
 **/
function thb_previous_posts_link( $linkText, $query )
{
	thb_get_navigation_link($linkText, $query, "prev");
}

/**
 * Gets a "next" pagination link.
 *
 * @param string $linkText The link text.
 * @param WP_Query $query The query object to paginate.
 * @return void
 **/
function thb_next_posts_link($linkText, $query)
{
	thb_get_navigation_link($linkText, $query, "next");
}

// Global template functions ======================================================================

/**
 * Returns a custom resource link.
 * 
 * @param string $name The custom resource name.
 * @return string
 */
function custom_resource_link( $name ) {
	$home_url = home_url();
	$symbol = "?";
	if( contains($home_url, "?") ) {
		$symbol = "&amp;";
	}

	$custom_resource_link = $home_url . $symbol . "thb_custom_resource=1&amp;resource_uri=" . $name;

	if( thb_is_debug() ) {
		if( !empty($_GET) ) {
			foreach( $_GET as $token => $value ) {
				$custom_resource_link .= "&amp;" . $token . "=" . urlencode($value);
			}
		}
	}

	return $custom_resource_link;

}

/**
 * Add the custom resource trigger to query_vars.
 *
 * @param array $vars The query_vars array.
 * @return array
 **/
if( !function_exists("custom_resource_add_trigger") ) {
	function custom_resource_add_trigger($vars) {
		$vars[] = 'thb_custom_resource';
		return $vars;
	}
}
add_filter('query_vars', 'custom_resource_add_trigger');

/**
 * Checks and includes the custom resource in the template.
 * 
 * @param string $resource_base_uri The resource base directory.
 * @return void
 **/
if( !function_exists("custom_resource_trigger_check") ) {
	function custom_resource_trigger_check() {
		if( intval(get_query_var('thb_custom_resource')) == 1 && isset($_GET['resource_uri']) ) {

			global $theme_data;

			$resource_base_dir="/config/resources";
			$resource_uri = $resource_base_dir . "/" . $_GET['resource_uri'] . ".php";

			$is_child_theme = !empty($theme_data['Template']);

			if( $is_child_theme && file_exists(get_stylesheet_directory() . $resource_uri) ) {
				$resource_directory = get_stylesheet_directory();
			}
			elseif( file_exists(get_template_directory() . $resource_uri) ) {
				$resource_directory = get_template_directory();
			}
			else
				$resource_directory = false;

			if( $resource_directory )
				include $resource_directory . $resource_uri;

			exit;
		}
	}
}
add_action('template_redirect', 'custom_resource_trigger_check');

/**
 * Outputs the page title.
 *
 * @param string $separator The separator between page title tokens.
 * @return void
 **/
function thb_page_title( $separator="|" ) {
	global $page, $paged;

	bloginfo( 'name' );
	if(!is_home()) {
		
		echo " " . $separator . " ";
		
		if( is_category() ) {
			_e("Category", THEMENAME);
			echo ": ";
			echo single_cat_title( '', false );
		}
		elseif( is_tag() ) {
			_e("Tag", THEMENAME);
			echo ": ";
			echo single_cat_title( '', false );
		}
		elseif( is_author() ) {
			_e("Author", THEMENAME);
			echo ": ";
			if(have_posts()) {
				the_post();
				the_author();
				rewind_posts();
			}
		}
		elseif( is_search() ) {
			printf( __( 'Search Results for: &ldquo;%s&rdquo;', THEMENAME ), get_search_query() );
		} 
		elseif( is_404() ) {
			_e("Not Found", THEMENAME);
		}
		else {
			the_title();
		}
		
	}

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', THEMENAME), max( $paged, $page ) );
}

/**
 * Checks if we're in the Archives page template.
 *
 * @return boolean
 **/
if( !function_exists("is_archives") ) {
	function is_archives()
	{
		$page_template = thb_get_page_template();
		return $page_template == "archives.php";
	}
}

/**
 * Checks if we're in an archive page.
 *
 * @return boolean
 **/
function is_archive_page() {
	return ( is_search() || is_archive() || is_category() || is_tag() || is_tax() || is_author() || is_404() || is_archives() || is_attachment() );
}

/**
 * Renders a block of content.
 *
 * @param string $name The name of the template part to load.
 * @param mixed $condition The condition to match in order for the block to be displayed.
 * @param string $ref The condition reference.
 * @return void
 **/
function thb_block( $name, $condition, $ref=null ) {
	if(is_string($condition)) {
		$option = thb_get_option($condition);
		if(
			($ref == null && $option != "1") || 
			($ref != null && $option != $ref)
		)
			return;
	} else {
		if(!$condition)
			return;
	}

	if(is_array($name))
		get_template_part($name[0], $name[1]);
	else
		get_template_part($name);
}

/**
 * Inserts a conditional comment to serve IE.
 *
 * @param int $version The IE version to target.
 * @param string $stylesheet The stylesheet to load.
 * @return void
 **/
function thb_ie( $version, $stylesheet="ie-" ) {
	if(!$stylesheet) {
		$stylesheet = "ie" . $version;
	}
	$stylesheet .= ".css";
	$stylesheet = get_template_directory_uri() . "/css/" . $stylesheet;

	if($version == 7) : ?>
	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo $stylesheet; ?>" type="text/css">
	<![endif]-->
	<?php endif; ?>

	<?php if($version == 8) : ?>
	<!--[if IE 8]>
		<link rel="stylesheet" href="<?php echo $stylesheet; ?>" type="text/css">
	<![endif]-->
	<?php endif;
}

/**
 * Inserts a templated piece of content.
 *
 * @param string $type The component's name.
 * @param array $params The component's params.
 * @return void
 **/
function thb_component( $type, $params=array() ) {
	$component_tpl = new THBTpl;
	$component_tpl->configure('tpl_dir', COMPONENTS.'/');
	foreach($params as $key => $value) {
		$component_tpl->assign($key, $value);
	}
	$component_tpl->draw($type);
}