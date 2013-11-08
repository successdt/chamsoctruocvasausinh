<?php
/*
	Description: Sidebars option page.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

$field = array(
	"Sidebars" => array(
		"infobox" => "Clicking the '+' button on bottom will make a new sidebar panel appear where it'll be possible to insert the description of the sidebar. Clicking the 'Remove' button in the bottom right corner of the panel will instead delete the sidebar. All the changes will take effect upon pressing the 'Save' button.",
		"field" => array(
			"name" => "Sidebar",
			"key" => "_thb_sidebar",
			"type" => "sidebar",
			"group" => SIDEBAR,
			"std" => ""
		)	
	),
);

$Sidebars = new duplicablepage($field);

$alert = false;
if(!empty($_POST)) {
	$data = adminpage::clearPostData($_POST);
	$fields = array_keys($data);
	if(isset($fields[0]) && isset($data[$fields[0]])) {
		$num_items = count($data[$fields[0]]);
		for($i=0; $i<$num_items; $i++) {
			$key = THEMEPREFIX . $field['Sidebars']['field']['key'] . "_";
			if(trim($data[$key.'title'][$i]) == "") {
				$alert = true;
				unset($_POST[$key.'title'][$i]);
				unset($_POST[$key.'name'][$i]);
				unset($_POST[$key.'ord'][$i]);
			} else {
				if(empty($data[$key.'name'][$i])) {
					$slug = thb_make_slug($data[$key.'title'][$i]);
					$_POST[$key.'name'][$i] = $slug . md5($data[$key.'title'][$i] . time() . $i);
				}
			}
		}
	}
}

$message = $Sidebars->save();

if($alert) {
	$message .= "<br>" . "Warning: one or more fields were empty, thus not saved.";
}

$Sidebars->setMessage($message);
$Sidebars->render();