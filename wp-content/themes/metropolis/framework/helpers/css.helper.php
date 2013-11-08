<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
	Description: CSS utility functions.
*/

/**
 * Outputs a CSS rule.
 *
 * @param string $rule A string representing the CSS rule to be outputted.
 * @param string $value The value of the CSS rule.
 * @param string $suffix A suffix for the value of the CSS rule (usually a unit measure).
 * @return void
 **/
function cssRule( $rule, $value, $suffix="" ) {
	if( !empty($value) && $value != "#" )
		echo $rule . ": " . $value . $suffix . ";\n";
	else {
		if( $value == "#" ) {
			$value = "transparent";
			echo $rule . ": " . $value . ";\n";
		}
	}
}

/**
 * Returns a color or its default.
 *
 * @param string $color A string representing the hex color.
 * @param string $value The default value of the color.
 * @return string
 **/
function color( $color, $default=null ) {
	$color = str_replace('#', '', $color);
	if(!empty($color))
		return "#" . $color;
	else {
		if($default)
			return color($default);
	}
	return "";
}

/**
 * Checks for a background repeat prefix.
 *
 * @param string $file The path to the image file.
 * @return string
 **/
function bgrepeat($file) {
  $file = end(explode("/", $file));

  if(startsWith($file, "repeat-x"))
    return "repeat-x";
  elseif(startsWith($file, "repeat-y"))
    return "repeat-y";
  elseif(startsWith($file, "no-repeat"))
    return "no-repeat";
  else
    return "repeat";
}

/**
 * Checks for a background position prefix.
 *
 * @param string $file The path to the image file.
 * @return string
 **/
function bgposition($file) {
  $file = end(explode("/", $file));
  
  if(
    startsWith($file, "repeat-x") ||
    startsWith($file, "repeat-y")
  )
    return "bottom left";
  elseif(
    startsWith($file, "no-repeat")
  )
    return "bottom center";
  else
    return "top left";
}

/**
 * Lightens a color.
 *
 * @param string $color A string representing the hex color.
 * @param int $dif The percentage representing the amount of light to be added to the $color.
 * @return string
 **/
function lighten($color, $dif=20) {

	if( !startsWith($color, "#") ) $color = "#" . $color;

	if( $color == "#" )
		return "";

	$dif = $dif / 100;

	$colorRgb = Color::hexToRgb($color);
	$colorHsl =  Color::rgbToHsl($colorRgb);

	// Lightness
	$colorHsl[2] += $dif;
	if( $colorHsl[2] > 100 )
		$colorHsl[2] = 100;

	$colorRgb = Color::hslToRgb($colorHsl);
	return Color::rgbToHex($colorRgb);

}

/**
 * Darkens a color.
 *
 * @param string $color A string representing the hex color.
 * @param int $dif The percentage representing the amount of light to be subtracted to the $color.
 * @return string
 **/
function darken($color, $dif=20) {

	if( !startsWith($color, "#") ) $color = "#" . $color;

	if( $color == "#" )
		return "";

	$dif = $dif / 100;

	$colorRgb = Color::hexToRgb($color);
	$colorHsl =  Color::rgbToHsl($colorRgb);

	// Lightness
	$colorHsl[2] -= $dif;
	if( $colorHsl[2] < 0 )
		$colorHsl[2] = 0;

	$colorRgb = Color::hslToRgb($colorHsl);
	return Color::rgbToHex($colorRgb);

}