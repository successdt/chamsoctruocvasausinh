<?php 
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

function shortcode_tabs($atts, $content = null) {
	$tab_content="";
	$tabs = array();
	preg_match_all('/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);
	if(isset($matches[1]) && !empty($matches[1]))
		$tabs = $matches[1];
	else
		return;
		
	$tab_content .= '<div class="tabs">
		<ul class="t-nav">';
		foreach($tabs as $tab) {
			$tab_title = $tab[0];
			$tab_slug = thb_make_slug($tab_title);
			$tab_content .= '<li><a href="#'.$tab_slug.'">'.$tab_title.'</a></li>';
		}
		$tab_content .= '</ul>
		<div class="t-container">' . do_shortcode($content) . '
		</div>
	</div>';
	
	return $tab_content;
}
add_shortcode('tabs', 'shortcode_tabs');

function shortcode_tab($atts, $content=null) {
	if(!isset($atts['title']))
		return;
	$tab_title = $atts['title'];
	$tab_slug = thb_make_slug($tab_title);
	
	$tab_content = '<div id="'.$tab_slug.'" class="tab-content">'.wptexturize(wpautop(do_shortcode($content))) . '</div>';
	return $tab_content;
}
add_shortcode('tab', 'shortcode_tab');