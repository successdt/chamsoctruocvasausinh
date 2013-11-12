<?php
/*
	Description: Slideshow option page.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

$field = array(
	"Slideshow" => array(
		"infobox" => "<p>To manage your custom collection of slides, go to the 'Slideshow' Shutter's option page. Upon clicking the 'Add' button, a panel is presented to you with the ability to choose the type of the slide, being it Picture or Video.<br /><br />
		
		<strong>Note</strong>: keep in mind that Video slides are only supported when using the 'Cycle' slideshow type.</p>
		
		<p>When choosing 'Picture' from the 'Type' select element:</p>
		
		<ul>
			<li>Upload a new picture, or pick an existing one from the Media Gallery by clicking the 'Upload' button.</li>
			<li>Select a Title for your picture (optional)</li>
			<li>If you want the title to be clickable, enter the destination URL (optional)</li>
			<li>You can also enter a brief caption of the picture (optional)</li>
		</ul>

		<p>Otherwise, selecting 'Video':</p>
		
		<ul>
			<li>Select a Title for your video (optional)</li>
			<li>Enter the full URL of the video, with it being from either YouTube or Vimeo</li>
		</ul>",
		"field" => array(
			"name" => "",
			"key" => "_thb_slideshow",
			"type" => "slide",
			"group" => SLIDESHOW,
			"std" => ""
		)	
	),
);

$Slideshow = new duplicablepage($field);

$alert = false;
if(!empty($_POST)) {
	$data = adminpage::clearPostData($_POST);
	$keys = array("title", "name", "ord", "url", "caption", "subtype", "src");
	$fields = array_keys($data);
	if(isset($fields[0]) && isset($data[$fields[0]])) {
		$num_items = count($data[$fields[0]]);
		for($i=0; $i<$num_items; $i++) {
			$key = THEMEPREFIX . $field['Slideshow']['field']['key'] . "_";

			if($data[$key.'subtype'][$i] == 'picture') {
				if(trim($data[$key.'src'][$i]) == "") {
					$alert = true;
					foreach($keys as $k)
						unset($_POST[$key.$k][$i]);
				}
			} elseif( $data[$key.'subtype'][$i] == 'custom' ) {
			} else {
				$_POST[$key."src"][$i] = "";
				if(trim($data[$key.'url'][$i]) == "") {
					$alert = true;
					foreach($keys as $k)
						unset($_POST[$key.$k][$i]);
				}
			}
		}
	}
}
$message = $Slideshow->save();

if($alert) {
	$message .= "<br>" . "Warning: one or more fields were empty, thus not saved.";
}

$Slideshow->setMessage($message);
$Slideshow->render();