<?php
/*
	Description: Custom fonts option page.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

$field = array(
	"Fonts" => array(
		"infobox" => "Clicking the '+' button on bottom will make a new panel appear where it'll be possible to upload your <a href='http://www.fontsquirrel.com/'>Font Squirrel</a> font-face kit. Clicking the 'Remove' button in the bottom right corner of the panel will instead delete the uploaded fonts. All the changes will take effect upon pressing the 'Save' button.",
		"field" => array(
			"name" => "Custom font",
			"key" => "_thb_customfont",
			"type" => "customfont",
			"group" => CUSTOMFONT,
			"std" => ""
		)	
	),
);

$Customfonts = new duplicablepage($field);

$alert = false;
if(!empty($_POST)) {
	$key = THEMEPREFIX . $field['Fonts']['field']['key'] . "_";

	// -------- upload del font -------------
	if( !empty($_FILES) ) {
		foreach( $_FILES as $f ) {
			$count = count($f['name']);
			for( $i=0; $i<$count; $i++ ) {

				if( $f['name'][$i] != "" ) {
					$uploaded_file = array(
						'name' => $f['name'][$i],
						'type' => $f['type'][$i],
						'tmp_name' => $f['tmp_name'][$i],
						'error' => $f['error'][$i],
						'size' => $f['size'][$i]
					);

					$upload_dir = wp_upload_dir();
					$file = thb_upload($uploaded_file);

					// Unzip
					if( file_exists($file['file']['file']) ) {
						$archive_name = str_replace(".zip", "", basename($uploaded_file['name']));

						unzip($file['file']['file'], $upload_dir['basedir'] . "/fonts/" . $archive_name . "/");
						unlink($file['file']['file']);

						$css = file_get_contents($upload_dir['basedir'] . "/fonts/" . $archive_name . "/stylesheet.css");
						preg_match_all( '|font-family:(.*)$|mi', $css, $family );

						for($j=0; $j<count($family[1]); $j++) {
							$family[1][$j] = trim($family[1][$j]);
							$family[1][$j] = str_replace("'", "", $family[1][$j]);
							$family[1][$j] = str_replace(";", "", $family[1][$j]);
						}

						// Family name
						$_POST[$key.'title'][$i] = $family[1][0];
						$_POST[$key.'url'][$i] = $upload_dir['baseurl'] . "/fonts/" . $archive_name . "/stylesheet.css";
						$_POST[$key.'caption'][$i] = serialize($family[1]);

					}
				} else {
					$_POST[$key.'caption'][$i] = htmlspecialchars_decode(stripslashes($_POST[$key.'caption'][$i]));
				}

			}
				
		}
	}
}

$message = $Customfonts->save();

if($alert) {
	$message .= "<br>" . "Warning: one or more fields were empty, thus not saved.";
}

$Customfonts->setMessage($message);
$Customfonts->render();