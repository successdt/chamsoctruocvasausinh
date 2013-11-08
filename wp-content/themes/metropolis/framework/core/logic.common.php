<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.1
	
*/

function send_mail() {
	$postdata = thb_get_data();
	
	if(empty($postdata))
		return "";
		
	$result = array();
	
	$keys = array('contact_email', 'contact_name', 'contact_message');
	foreach($keys as $key) {
		if(!isset($postdata[$key]) or trim($postdata[$key]) == "") {
			$result['contact_email'] = $postdata['contact_email'];
			$result['contact_name'] = $postdata['contact_name'];
			$result['contact_message'] = $postdata['contact_message'];

			$result['type'] = 'error';
			$result['message'] = __("Please fill in all the required fields!", THEMENAME);
			return $result;
		}
	}
	
	$email = xss_protect($postdata['contact_email']);
	$name = xss_protect($postdata['contact_name']);
	
	if(thb_get_option('_contact_form_email') != "")
		$to = thb_get_option('_contact_form_email');
	elseif(thb_get_option('_contact_email') != "")
		$to = thb_get_option('_contact_email');
	else
		$to = get_option('admin_email');

	$subject = get_bloginfo('contact_name');
	$message = html_entity_decode(stripslashes(strip_tags($postdata['contact_message'])));
	
	$headers = 'From: '.$name.' <'.$email.'>' . "\r\n";

	add_filter('wp_mail_from','thb_wp_mail_from');
	function thb_wp_mail_from($content_type) {
		return xss_protect($postdata['contact_email']);
	}

	add_filter('wp_mail_from_name','thb_wp_mail_from_name');
	function thb_wp_mail_from_name($name) {
		return html_entity_decode(stripslashes(xss_protect($postdata['contact_name'])));
	}
	
	if(wp_mail($to, $subject, $message, $headers, array())) {
		$result['type'] = 'success';
		$result['message'] = __("Email sent successfully!", THEMENAME);
	} else {
		$result['type'] = 'error';
		$result['message'] = __("An error has occurred while sending your email!", THEMENAME);
	}
	
	return $result;
}