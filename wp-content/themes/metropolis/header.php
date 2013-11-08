<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

$_site_author             = thb_get_option("_site_author");
$_site_description        = thb_get_option("_site_description");
$_keywords                = thb_get_option("_keywords");
$_google_verification     = thb_get_option("_google_verification");
$stylesheet_uri           = get_stylesheet_uri();
$stylesheet_directory_uri = get_stylesheet_directory_uri();
$body_classes             = get_custom_body_classes();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta name="themeversion" value="<?php echo THEMEVERSION; ?>" />
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<?php thb_component("seo"); ?>

		<title><?php thb_page_title(); ?></title>
		
		<!-- Custom favicon -->
		<?php get_template_part("config/resources/custom-favicon"); ?>

		<!-- Custom Apple Touch Icon -->
		<?php get_template_part("config/resources/custom-apple-touch-icon"); ?>

		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<meta name="viewport" content="width=device-width, maximum-scale=1.0">
		
		<!-- Main stylesheets -->
		<link rel="stylesheet" media="all" href="<?php echo $stylesheet_uri; ?>" />
		<link rel="stylesheet" media="all" href="<?php echo $stylesheet_directory_uri; ?>/css/reset.css" />
		<link rel="stylesheet" media="all" href="<?php echo $stylesheet_directory_uri; ?>/css/framework.css" />
		<link rel="stylesheet" media="all" href="<?php echo $stylesheet_directory_uri; ?>/css/layout.css" />
		<link rel="stylesheet" media="all" href="<?php echo $stylesheet_directory_uri; ?>/css/print.css" />
		<!-- Plugins stylesheets -->
		<link rel="stylesheet" media="all" href="<?php echo $stylesheet_directory_uri; ?>/css/prettyPhoto.css" />
		<link rel="stylesheet" media="all" href="<?php echo $stylesheet_directory_uri; ?>/css/flexslider.css" />
		<link rel="stylesheet" media="all" href="<?php echo $stylesheet_directory_uri; ?>/css/ewp.css" />
		<!-- Custom stylesheets -->
		<link rel="stylesheet" media="all" href="<?php echo custom_resource_link("custom-styles"); ?>" />

		<?php
			/* IE fixes */
			thb_ie(7, "ie");
			thb_ie(8, "ie8");
			include RESOURCES . "/ie_html5_fix.php";

			/* Javascript */ 
			wp_enqueue_script('jquery');  // jQuery including by wordpress 
			wp_enqueue_script('flexslider'); // jQuery Cycle plugin
			wp_enqueue_script('cycle'); // jQuery Flexslider plugin
			wp_enqueue_script('prettyphoto'); // Prettyphoto plugin
			wp_enqueue_script('thb-lib'); // Main theme settings file
			wp_enqueue_script('swfobject'); // Swfobject lib
			wp_enqueue_script('froogaloop'); // Froogaloop lib
			wp_enqueue_script('mobilemenu'); // mobile menu plugin
			wp_enqueue_script('theme-default'); // Main theme settings file

			/* Javascript support for comments */	
			if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }

			/* Plugin and theme output with wp_head() */
			wp_head();
		?>

		<!-- Custom feed URL -->
		<?php get_template_part("config/resources/custom-feed"); ?>
	</head>
	<body <?php body_class( implode(" ", $body_classes) ); ?> id="top">

	<?php if( thb_get_option("_top_menu_bar") == "1" ) : ?>
		<div id="top-bar">
			<div class="extended-container">
				<section class="content col span-12">
					
					<nav class="tertiary menu">
						<?php wp_nav_menu( array( 'container' => '', 'container_class' => '', 'theme_location' => 'tertiary' ) ); ?>
					</nav>

					<?php
						$icons_path = WIDGETSURL . "/social/icons";
						global $social_services;

						$social_services = array(
							"twitter"	=> "http://twitter.com/",
							"facebook"	=> "http://facebook.com/",
							"flickr"	=> "http://flickr.com/photos/",
							"forrst"	=> "http://forrst.com/people/",
							"dribbble"	=> "http://dribbble.com/",
							"delicious"	=> "http://delicious.com/",
							"youtube"	=> "http://youtube.com/",
							"vimeo"		=> "http://vimeo.com/",
							"digg"		=> "http://digg.com/",
							"linkedin"	=> "http://linkedin.com/in/",
							"picasa"	=> "http://picasaweb.google.com/",
							"googleplus"=> "https://profiles.google.com/",
							"pinterest" => "http://pinterest.com/"
						);
					?>

					<div class="social-top-bar">
						<ul>
							<?php foreach(array_keys($social_services) as $service) : ?>
								<?php if(thb_get_option("_social_".$service) != "") : ?>
									<li>
										<a href="<?php echo $social_services[$service] . thb_get_option("_social_".$service); ?>">
											<img src="<?php echo $icons_path; ?>/<?php echo $service; ?>.png" alt="" />
										</a>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>

				</section>
			</div>
		</div>
	<?php endif; ?>

	<div id="header" class="extended-container">

		<header>
			<?php
				$logo_position = thb_get_option("_logo_position");
				if( empty($logo_position) ) $logo_position = "left";
			?>
			<h1 id="logo" class="<?php echo $logo_position; ?>">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<nav id="main-nav" class="primary menu">
				<?php wp_nav_menu( array( 'container' => '', 'container_class' => '', 'theme_location' => 'primary' ) ); ?>
			</nav>
		</header>

	</div>

		<?php 
			if( in_array("w-slideshow", $body_classes) )
				get_template_part("loop/slideshow");
		?>
		
	<?php if( is_front_page() ) get_template_part("page-top-sidebar"); ?>

	<div id="main-container" class="extended-container">
		<section class="content-wrapper box-col span-<?php if( in_array("wout-sidebar", $body_classes) ) : ?>12<?php else : ?>8<?php endif; ?>">
			<div class="content col span-<?php if( in_array("wout-sidebar", $body_classes) ) : ?>12<?php else : ?>8<?php endif; ?>">