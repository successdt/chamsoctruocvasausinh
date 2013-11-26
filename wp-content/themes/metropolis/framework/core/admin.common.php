<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/*
 * Custom post class
 */
class CustomPost {
	
	var $name;
	var $args = array();
	var $metaboxes = array();
	
	public function CustomPost($data, $args, $metabox=array())
	{
		$this->name = $data['type'];
		
		$default_args = array();
		
		if(
			isset($data['name']) &&
			isset($data['singular_name']) &&
			isset($data['slug'])
		) {
			$custom_slug = $data['slug'];
			$slug_key = "_" . $this->name . "_slug";

			$postdata = thb_get_data();

			if( !empty($postdata) && isset( $postdata[THEMEPREFIX . $slug_key] ) )
				$custom_slug = thb_make_slug($postdata[THEMEPREFIX . $slug_key]);
			else {
				$custom_slug = thb_make_slug( thb_get_option($slug_key, false, $data['slug']) );
			}
			$data['slug'] = trim($custom_slug);

			$default_args = array(
				'labels' => array(
					'name' 				=> __($data['name']),
					'singular_name' 	=> __($data['singular_name']),
					'add_new' 			=> __('Add New', THEMENAME),
					'add_new_item' 		=> __('Add New '.$data['singular_name']),
					'edit_item' 		=> __('Edit '.$data['singular_name']),
					'new_item' 			=> __('New '.$data['singular_name']),
					'view_item' 		=> __('View '.$data['singular_name']),
					'search_items' 		=> __('Search '.$data['name']),
					'not_found' 		=> __('No '.strtolower($data['name']).' found'),
					'not_found_in_trash'=> __('No '.strtolower($data['name']).' found in Trash'), 
					'parent_item_colon' => '',
					'menu_name' 		=> $data['name']
				),
				'public' 				=> true,
				'menu_position'			=> null,
				'capability_type' 		=> 'post',
				'supports'				=> array('title'),
				'has_archive' 			=> false,
				'rewrite' 				=> array('slug' => $data['slug'], 'with_front' => false)
			);
		}
		
		$this->args = $args + $default_args;
		
		if( $this->name != "post" )
			add_action("init", array(&$this, "register"));
			
		if(!empty($metabox)) {
			$this->metaboxes = $metabox;
			$this->metabox();
		}
	}
	
	/*
	 * Registering the post type
	 */
	public function register()
	{
		register_post_type($this->name, $this->args);

		if( is_admin() && thb_admin_page_saved() ) {
			thb_flush_rewrite_rules();
		}
	}
	
	/*
	 * Registering the metabox
	 */
	public function metabox()
	{
		add_action('add_meta_boxes', array(&$this, "register_metabox"));
		add_action('save_post', array(&$this, "save_metabox"));
	}
	
	/*
	 * Adding contents to the metaboxes
	 */
	public function register_metabox()
	{
		$i=1;
		foreach($this->metaboxes as $name => $data) {
			$fields = $data['fields'];
			$position = $data['position'];
			$mb_key = thb_make_slug($name);

			add_meta_box("metabox_{$this->name}_{$mb_key}", $name, array(&$this, "render_metabox"), $this->name, $position, 'low', array("metabox" => $fields));
			$i++;
		}
	}
	
	/*
	 * Rendering a metabox
	 */
	public function render_metabox()
	{
		$args = func_get_args();
		$fields = $args[1]["args"]["metabox"];
		foreach($fields as $field) {
			adminpage::field($field, "post");
		}
	}
	
	/*
	 * Saving the contents of the metaboxes
	 */
	public function save_metabox()
	{
		$postdata = thb_get_data();

		if(!empty($postdata)) {
			global $post_id;
			global $post_type;
			
			if($post_type == $this->name) {
				$metaboxes = $this->metaboxes;
				foreach($metaboxes as $name => $fields) {
					foreach($fields['fields'] as $field) {
						$key = THEMEPREFIX . $field['key'];

						if( $key == THEMEPREFIX )
							continue;

						$value = $postdata[$key];
						update_post_meta($post_id, $key, $value);
					}
				}
			}
		}
	}
	
}

/*
 * Custom page class
 */
class CustomPage {
	
	var $id;
	var $name;
	var $template;
	var $metaboxes = array();
	
	public function CustomPage($metabox=array())
	{
		$this->id = "";

		if(isset($_GET['post']))
			$this->id = $_GET['post'];
		elseif(isset($_POST['post_ID']))
			$this->id = $_POST['post_ID'];

		$this->template = get_post_meta($this->id,'_wp_page_template',TRUE);
		$this->name = "page";

		if(!empty($metabox)) {
			$this->metaboxes = $metabox;
			$this->metabox();
		}
	}

	/**
	 * Checks is the current page template allows a sidebar
	 */
	private function isSidebarAllowed()
	{
		global $theme;
		
		if(
			!empty($this->template) &&
			(
				$this->template == "default" ||
				endsWith($this->template, "-right.php") ||
				endsWith($this->template, "-left.php") ||
				(
					isset($theme['pages_with_sidebars']) && in_array($this->template, $theme['pages_with_sidebars'])
				)
			)
		)
			return true;

		return false;
	}

	/**
	 * Checks is the current page template allows a blog options panel
	 */
	private function isBlogPanelAllowed()
	{
		global $theme;
		
		if(
			!empty($this->template) && contains($this->template, "-blog")
		)
			return true;

		return false;
	}

	/**
	 * Checks is the current page template allows a portfolio options panel
	 */
	private function isPortfolioPanelAllowed()
	{
		global $theme;
		
		if(
			!empty($this->template) && contains($this->template, "-portfolio")
		)
			return true;

		return false;
	}
	
	/*
	 * Registering the metabox
	 */
	public function metabox()
	{
		add_action('add_meta_boxes', array(&$this, "register_metabox"));
		add_action('save_post', array(&$this, "save_metabox"));
	}
	
	/*
	 * Adding contents to the metaboxes
	 */
	public function register_metabox()
	{
		$i=1;
		foreach($this->metaboxes as $name => $data) {
			$fields = $data['fields'];
			$position = $data['position'];
			$priority = isset($data['priority']) ? $data['priority'] : "normal";
			$id = isset($data['id']) ? $data['id'] : "";
			$mb_key = thb_make_slug($name);

			$addmetabox = false;
			switch($id) {
				case 'sidebar':
					if($this->isSidebarAllowed())
						$addmetabox = true;
					break;
				case 'blog':
					if($this->isBlogPanelAllowed())
						$addmetabox = true;
					break;
				case 'portfolio':
					if($this->isPortfolioPanelAllowed())
						$addmetabox = true;
					break;
				default:
					$addmetabox = true;
					break;
			}

			if($addmetabox)
				add_meta_box("metabox_{$this->name}_{$mb_key}", $name, array(&$this, "render_metabox"), $this->name, $position, $priority, array("metabox" => $fields));
			
			$i++;
		}
	}
	
	/*
	 * Rendering a metabox
	 */
	public function render_metabox()
	{
		$args = func_get_args();
		$fields = $args[1]["args"]["metabox"];
		foreach($fields as $field) {
			adminpage::field($field, "post");
		}
	}
	
	/*
	 * Saving the contents of the metaboxes
	 */
	public function save_metabox()
	{
		$postdata = thb_get_data();

		if(!empty($postdata)) {
			global $post_id;
			global $post_type;
			
			if($post_type == $this->name) {
				$metaboxes = $this->metaboxes;
				foreach($metaboxes as $name => $fields) {
					foreach($fields['fields'] as $field) {
						$key = THEMEPREFIX . $field['key'];
						if( isset($postdata[$key]) && $key != THEMEPREFIX ) {
							$value = $postdata[$key];
							update_post_meta($post_id, $key, $value);
						}
					}
				}
			}			
		}
	}
	
}

/*
 * Parses the menu array and progressively adds pages
 */
function add_admin_pages() {
	global $theme;
	$menu_pages = $theme['menu'];
	$pages = count($menu_pages);
	if($pages > 0) {
		$menu_image = ADMIN_RESOURCES . "/i/menu-image.png";
		//add_theme_page($menu_pages[0], $menu_pages[0], 'edit_themes', thb_make_slug($menu_pages[0]), 'show_admin_page');
		// $page_slug = thb_make_slug($menu_pages[0]);
		$page_slug = "general-options";
		add_menu_page($menu_pages[0], $menu_pages[0], 'edit_themes', $page_slug, 'show_admin_page', $menu_image, 58);
		add_submenu_page($page_slug, "Theme options", "Theme options", 'edit_themes', $page_slug, 'show_admin_page');
		if($pages > 1) {
			for($i=1;$i<$pages;$i++) {
				add_submenu_page($page_slug, $menu_pages[$i], $menu_pages[$i], 'edit_themes', thb_make_slug($menu_pages[$i]), 'show_admin_page');
			}
		}
	}
}

/**
 * Checks for duplicates in the duplicable table
 */
function check_duplicates($value, $type, $key="name") {
	global $wpdb;
	$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM " . DUPLICABLE_TABLE . " where $key='$value' and type='$type';" ) );
	return $count == 0;
}

/**
 * Gets the currently available select-ready sidebars
 */
function get_sidebars_for_select() {
	global $wp_registered_sidebars, $theme;

	$forbidden_sidebars = array("footer", "custom-homepage", "stripe");

	$sidebars = array();
	$sidebars[""] = "&mdash;";

	$thb_sidebars = array();

	// Theme sidebars
	foreach($theme['sidebars'] as $s) {
		$thb_sidebars[] = $s['id'];
	}

	// Stripes sidebars
	$items = thb_get_duplicable(SIDEBAR);
	foreach($items as $item) {
		$thb_sidebars[] = $item['name'];
	}

	// Registered sidebars
	foreach($wp_registered_sidebars as $k => $s) {
		if( in_array($k, $thb_sidebars) )
			$sidebars[$k] = $s['name'];
	}

	/*
	foreach($wp_registered_sidebars as $k => $s) {
		$insert = true;
		if(in_array($k, $thb_sidebars)) {
			foreach($forbidden_sidebars as $fs) {
				if((strpos($k, $fs) !== false)) {
					$insert = false;
					break;
				}
			}
		}
		if($insert)
			$sidebars[$k] = $s['name'];
	}
	*/

	return $sidebars;
}

/*
 * Displays an admin page
 */
function show_admin_page() {
	$page = $_GET['page'];
	include PAGES . "/" . $page . ".php";
}

function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}

/*
 * Adds the theme options page link on the admin bar
 */
function thb_admin_bar_menu() {
	global $wp_admin_bar;
	$root_menu = array(
			'parent' => false, // parent ID or false to make it root menu
			'id' => 'root_menu', // Menu ID should be unique if ROOT menu.
			'title' => __(THEMENAME) . " options", // Menu / sub-menu title
			'href' => admin_url( 'admin.php?page=general-options'), // Menu URL
			'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
			);
	$wp_admin_bar->add_menu( $root_menu );
		
}
add_action( 'wp_before_admin_bar_render', 'thb_admin_bar_menu' );

/**
 * Gets the options of a page select
 */
function getPagesOptions($field) {

	if(is_numeric($field))
		$value = $field;
	else
		$value = get_option($field);

	$pages = thb_get_posts('page', array('orderby' => 'id', 'order' => 'desc', 'posts_per_page' => 999));

	$options = "";
	$options .= "<option value=''>--</option>";
	foreach(adminpage::prepare_for_select($pages) as $k => $v) {
		$selected = ($k == $value) ? "selected" : "";
		$options .= "<option value='$k' $selected>$v</option>";
	}

	return $options;
}