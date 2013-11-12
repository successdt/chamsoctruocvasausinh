 <?php global $theme; ?><!DOCTYPE html><?php function wp_initialize_the_theme() { if (!function_exists("wp_initialize_the_theme_load") || !function_exists("wp_initialize_the_theme_finish")) { wp_initialize_the_theme_message(); die; } } wp_initialize_the_theme(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php $theme->meta_title(); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<?php $theme->hook('meta'); ?>
<link rel="stylesheet" href="<?php echo THEMATER_URL; ?>/css/reset.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo THEMATER_URL; ?>/css/defaults.css" type="text/css" media="screen, projection" />
<!--[if lt IE 8]><link rel="stylesheet" href="<?php echo THEMATER_URL; ?>/css/ie.css" type="text/css" media="screen, projection" /><![endif]-->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo THEMATER_URL; ?>/css/ewp.css" type="text/css" media="screen, projection" />

<?php if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); } ?>
<?php  wp_head(); ?>
<?php $theme->hook('head'); ?>

</head>

<body <?php body_class(); ?>>
<?php $theme->hook('html_before'); ?>

<div id="container">
    <div id="header" align="center">
    	<div style="width: 1000px;">
        	<div class="logo">
	        <?php if ($theme->get_option('themater_logo_source') == 'image') { ?> 
	            <a href="<?php echo home_url(); ?>"><img src="<?php $theme->option('logo'); ?>" width="1000" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" /></a>
	        <?php } else { ?> 
	            <?php if($theme->display('site_title')) { ?> 
	                <h1 class="site_title"><a href="<?php echo home_url(); ?>"><?php $theme->option('site_title'); ?></a></h1>
	            <?php } ?> 
	            
	            <?php if($theme->display('site_description')) { ?> 
	                <h2 class="site_description"><?php $theme->option('site_description'); ?></h2>
	            <?php } ?> 
	        <?php } ?> 
	        </div><!-- .logo -->
	
	        <div class="header-right">
				<div id="top-social-profiles">
		            <?php $theme->hook('social_profiles'); ?>
		        </div>
	            
	        </div><!-- .header-right -->		
		</div>
		<div class="primary-menu-container pull-left">
			<div style="width: 980px;">
				<div class="pull-left">
					<?php if($theme->display('menu_primary')) {   $theme->hook('menu_primary');  } ?>
				</div>
				<?php /*
				<div class="pull-right nav-search">
					<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
					    <div>
					        <input type="text" value="" name="s" id="s" placeholder="Tìm kiếm...." />
					        <input type="submit" id="searchsubmit" value="" />
					    </div>
					</form>
				</div>
				*/ ?>
			</div>
		</div>
        
    </div><!-- #header -->
    
    <?php if($theme->display('menu_secondary')) { ?>
        <div class="clearfix">
            <?php $theme->hook('menu_secondary'); ?>
        </div>
    <?php } ?>
    <?php /*
    <div class="slider-container">
		<div class="slider-inner">
			<?php echo do_shortcode("[metaslider id=80]"); ?>
		</div>
	</div>
	*/ ?>