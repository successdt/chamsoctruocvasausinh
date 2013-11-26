<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
	Description: Logic utility functions.
*/

/**
 * Checks if all of the passed variables is empty, returns TRUE if all the variables aren't empty.
 *
 * @param mixed
 * @return boolean
 **/
function notEmpty() {
	if( func_num_args() == 0 ) return true;
	$arguments = func_get_args();
	foreach( $arguments as $argument )
		if( empty($argument) )
			return false;

	return true;
}

/**
 * Checks if any of the passed variables is empty, returns TRUE if any the variables aren't empty.
 *
 * @param mixed
 * @return boolean
 **/
function anyNotEmpty() {
	if( func_num_args() == 0 ) return true;
	$arguments = func_get_args();
	foreach( $arguments as $argument )
		if( !empty($argument) )
			return true;

	return false;
}