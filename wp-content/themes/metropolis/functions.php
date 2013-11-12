<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

require_once TEMPLATEPATH . "/config/thb_functions.php";

/*-----------------------------------------------------------------------------------*/
/* End Theme Load Functions - Add your custom functions below */
/*-----------------------------------------------------------------------------------*/

/******************************************************************************
 * Theme custom fonts
 ******************************************************************************/
function getCustomFonts() {
	$fontArray = array(
		"Sans" => array(
			
		),
		"Serif" => array(

		),
		"Script and decorative" => array(
			
		),
		"Handwritten" => array(
			
		)
	);

	return $fontArray;
}
function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');
/**
 * add Vietnam Dong
 * @author thanhdd@ecomwebpro.com
 */
add_filter( 'woocommerce_currencies', 'add_my_currency' );
 
function add_my_currency( $currencies ) {
 $currencies['Đồng'] = __( 'Viet Nam Dong', 'woocommerce' );
 return $currencies;
 }
 
add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);
 
function add_my_currency_symbol( $currency_symbol, $currency ) {
	switch( $currency ) {
		case 'Đồng': $currency_symbol = ' đ'; break;
	}
	return $currency_symbol;
}
// allow html in category and taxonomy descriptions
//	remove_filter( 'pre_term_description', 'wp_filter_kses' );
//	remove_filter( 'pre_link_description', 'wp_filter_kses' );
//	remove_filter( 'pre_link_notes', 'wp_filter_kses' );
//	remove_filter( 'term_description', 'wp_kses_data' );
//	add_filter('loop_shop_columns', 'loop_columns');

// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );


add_filter('woocommerce_free_price_html', 'changeFreePriceNotice', 10, 2);
function changeFreePriceNotice($price, $product) {
	return '0 VND';
}

add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
function sb_woo_remove_reviews_tab($tabs) {

		unset($tabs['reviews']);
	
	return $tabs;
}
add_filter('woocommerce_empty_price_html', 'custom_call_for_price');
 
function custom_call_for_price() {
     return 'Liên hệ';
}
