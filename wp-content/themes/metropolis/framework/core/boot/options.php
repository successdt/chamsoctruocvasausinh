<?php

define("THEME_INSTALLATION_KEY", THEMEPREFIX . "_theme_installation");

function thb_execute_default_configuration() {
	global $theme;
	$pages = $theme['menu'];

	$new_installation = !optionpage::isOptionPresent(THEME_INSTALLATION_KEY);

	if( $new_installation ) {
		foreach( $pages as $page ) {
			include(PAGES . "/general-options.php");
			if( isset($sections) ) {
				foreach( $sections as $section_name => $section ) {
					if( isset($section['fields']) ) {
						foreach( $section['fields'] as $field ) {
							$key = THEMEPREFIX.$field['key'];
							if( !optionpage::isOptionPresent($key) ) {
								if( isset($field['std']) )
									update_option($key, $field['std']);
							}
						}
					}
				}
			}
		}

		// Custom fonts
		if( function_exists("thb_execute_theme_setup") ) {
			thb_execute_theme_setup();
		}

		// Registering the installation
		update_option(THEME_INSTALLATION_KEY, "1");
	}
	
}