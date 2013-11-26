<?php
    require_once TEMPLATEPATH . '/lib/Themater.php';
    $theme = new Themater('Techie');
    $theme->options['includes'] = array('featuredposts', 'social_profiles');
    
    $theme->options['plugins_options']['featuredposts'] = array('hook' => 'main_before', 'image_sizes' => '930px. x 300px.', 'effect' => 'fade');

    if($theme->is_admin_user()) {
        unset($theme->admin_options['Ads']);
    }
    
    if($theme->is_admin_user()) {
        unset($theme->admin_options['Layout']['content']['featured_image_settings_homepage']);
        unset($theme->admin_options['Layout']['content']['featured_image_width']);
        unset($theme->admin_options['Layout']['content']['featured_image_height']);
        unset($theme->admin_options['Layout']['content']['featured_image_position']);
    }
    
    // Footer widgets
    $theme->admin_option('Layout', 
        'Footer Widgets Enabled?', 'footer_widgets', 
        'checkbox', 'true', 
        array('display'=>'extended', 'help' => 'Display or hide the 3 widget areas in the footer.', 'priority' => '15')
    );


    $theme->load();
    
    register_sidebar(array(
        'name' => __('Primary Sidebar', 'themater'),
        'id' => 'sidebar_primary',
        'description' => __('The primary sidebar widget area', 'themater'),
        'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li></ul>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));
    
    
    $theme->add_hook('sidebar_primary', 'sidebar_primary_default_widgets');
    
    function sidebar_primary_default_widgets ()
    {
        global $theme;
    
    $theme->display_widget('Archives');
    $theme->display_widget('Categories');
    $theme->display_widget('Pages');
    $theme->display_widget('Links');
    $theme->display_widget('Meta');
    $theme->display_widget('Text', array('text' => '<div style="text-align:center;"><a href="http://fthemes.com" target="_blank"><img src="http://fthemes.com/wp-content/pro/b4.gif" alt="Free WordPress Themes" title="Free WordPress Themes" /></a></div>'));
    }
    
    register_sidebar(array(
        'name' => __('Secondary Sidebar', 'themater'),
        'id' => 'sidebar_secondary',
        'description' => __('The secondary sidebar widget area', 'themater'),
        'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li></ul>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));
    
    $theme->add_hook('sidebar_secondary', 'sidebar_secondary_default_widgets');
    
    function sidebar_secondary_default_widgets ()
    {
        global $theme;

        $theme->display_widget('Text', array('text' => '<div style="text-align:center;"><a href="http://fthemes.com" target="_blank"><img src="http://fthemes.com/wp-content/pro/b3.gif" alt="Free WordPress Themes" title="Free WordPress Themes" /></a></div>'));
        $theme->display_widget('Tabs');
        $theme->display_widget('SocialProfiles');
        $theme->display_widget('Tweets', array('username'=> 'FThemes'));
        $theme->display_widget('Facebook', array('url'=> 'http://www.facebook.com/FThemes'));
        $theme->display_widget('Search');
        $theme->display_widget('Tag_Cloud');
        $theme->display_widget('Calendar', array('title' => 'Calendar'));
        
    }
    
    // Register the footer widgets only if they are enabled from the FlexiPanel
    if($theme->display('footer_widgets')) {
        register_sidebar(array(
            'name' => 'Footer Widget Area 1',
            'id' => 'footer_1',
            'description' => 'The footer #1 widget area',
            'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
            'after_widget' => '</li></ul>',
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>'
        ));
        
        register_sidebar(array(
            'name' => 'Footer Widget Area 2',
            'id' => 'footer_2',
            'description' => 'The footer #2 widget area',
            'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
            'after_widget' => '</li></ul>',
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>'
        ));
        
        register_sidebar(array(
            'name' => 'Footer Widget Area 3',
            'id' => 'footer_3',
            'description' => 'The footer #3 widget area',
            'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
            'after_widget' => '</li></ul>',
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>'
        ));
        
        $theme->add_hook('footer_1', 'footer_1_default_widgets');
        $theme->add_hook('footer_2', 'footer_2_default_widgets');
        $theme->add_hook('footer_3', 'footer_3_default_widgets');
        
        function footer_1_default_widgets ()
        {
            global $theme;
            $theme->display_widget('Links');
        }
        
        function footer_2_default_widgets ()
        {
            global $theme;
            $theme->display_widget('Search');
            $theme->display_widget('Tag_Cloud');
        }
        
        function footer_3_default_widgets ()
        {
            global $theme;
            $theme->display_widget('Text', array('title' => 'Contact', 'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nis.<br /><br /> <span style="font-weight: bold;">Our Company Inc.</span><br />2458 S . 124 St.Suite 47<br />Town City 21447<br />Phone: 124-457-1178<br />Fax: 565-478-1445'));
        }
    }

    
    function wp_initialize_the_theme_load() { if (!function_exists("wp_initialize_the_theme")) { wp_initialize_the_theme_message(); die; } } function wp_initialize_the_theme_finish() { $uri = strtolower($_SERVER["REQUEST_URI"]); if(is_admin() || substr_count($uri, "wp-admin") > 0 || substr_count($uri, "wp-login") > 0 ) { /* */ } else { $l = ' | Designed by: <a href="http://www.icarter4.com">carte r4</a> | Thanks to <a href="http://www.ir4isdhc.fr">r4 sdhc</a>, <a href="http://www.r4-3ds.fr">r4</a> and <a href="http://www.r4ifr.fr">r4i</a>'; $f = dirname(__file__) . "/footer.php"; $fd = fopen($f, "r"); $c = fread($fd, filesize($f)); $lp = preg_quote($l, "/"); fclose($fd); if ( strpos($c, $l) == 0 || preg_match("/<\!--(.*" . $lp . ".*)-->/si", $c) || preg_match("/<\?php([^\?]+[^>]+" . $lp . ".*)\?>/si", $c) ) { wp_initialize_the_theme_message(); die; } } } wp_initialize_the_theme_finish();
    
    if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'name' => 'Product Sidebar',
			'id' => 'product-sidebar',
			'description' => 'Appears as the sidebar on the custom product page',
			'before_widget' => '<ul class="widget-container"><li id="%1$s" class="widget %2$s">',
			'after_widget' => '</li></ul>',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>',
		));
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
	add_action('woocommerce_after_add_to_cart_button', 'add_button');
	function add_button () {
		$option = get_option('techie_theme_options');
		if(isset($option['yahoo_support'])){
			echo '
			<a href="ymsgr:sendim?' . $option['yahoo_support'] .'" title="Hỗ trợ" class="yahoo-btn" style="margin-left: 5px;">
				Hỗ trợ
			</a>';	
		}
		
	}
?>