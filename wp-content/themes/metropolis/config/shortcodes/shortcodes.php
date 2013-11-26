<?php 
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

add_action('init', 'add_button_shortcodes');  

function add_button_shortcodes() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_plugin_shortcodes');
     add_filter('mce_buttons', 'register_button_shortcodes');
   }
}

function register_button_shortcodes($buttons) {
	array_push($buttons, '|', "shortcodes");
    return $buttons;
}

function add_plugin_shortcodes($plugin_array) {
	$plugin_array['shortcodes'] = get_template_directory_uri(). '/config/shortcodes/shortcodes.js';
	return $plugin_array;
}
?>