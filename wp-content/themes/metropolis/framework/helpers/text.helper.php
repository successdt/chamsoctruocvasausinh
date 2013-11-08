<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
	Description: Text utility functions.
*/

/**
 * Checks if a string contains another string
 *
 * @param string $haystack The string to be searched.
 * @param string $needle The string to search for.
 * @return boolean
 **/
function contains( $haystack, $needle )
{
	return strlen(strstr($haystack, $needle))>0;
}

/**
 * Strips a string of quotes and slashes.
 *
 * @param string $value The string to be searched.
 * @return string
 **/
function thb_getvalue( $value ) {
	return htmlspecialchars(stripslashes($value), ENT_QUOTES);
}

/**
 * Checks if a string starts with another string.
 *
 * @param string $haystack The string to be searched.
 * @param string $needle The string to search for.
 * @return boolean
 **/
function startsWith( $haystack, $needle )
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

/**
 * Checks if a string ends with another string.
 *
 * @param string $haystack The string to be searched.
 * @param string $needle The string to search for.
 * @return boolean
 **/
function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);
}

/**
 * Truncates a text after $max chars.
 *
 * @param string $string The string to be truncated.
 * @param int $max How many chars to leave.
 * @param string $replacement Chars to be appended upon truncating.
 * @return string
 **/
function thb_truncate( $string, $max, $replacement = " &hellip;" ) {
	if (strlen($string) <= $max)
		return $string;

	$leave = $max - 1;
	return substr_replace($string, $replacement, $leave);
}

/**
 * Transforms a string into its slug.
 *
 * @param string $str The string to be slugifiyed.
 * @return string
 **/
function thb_make_slug( $str ) {
	return sanitize_title($str);
}