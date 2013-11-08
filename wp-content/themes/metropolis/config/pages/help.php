<?php
/*
	Description: Theme help page.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

$Help = new helppage();

$content = file_get_contents(HELP . "/" . THEMENAME . ", v" . THEMEVERSION . "_help.html");
$content = str_replace("i/", get_template_directory_uri() . "/help/i/", $content);

$Help->setHelpText($content);
$Help->render();