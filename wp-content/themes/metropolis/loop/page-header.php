<?php
	global $pagetitle, $pagesubtitle;
?>
<?php
	if( !is_front_page() || is_front_page() && thb_get_option("_homepage_pageheader") == "0" ) :
?>
	<?php if( isset($pagetitle) ) : ?>
			<header class="page-header">
				<h1><?php echo $pagetitle; ?></h1>
				<?php if( isset($pagesubtitle) && !empty($pagesubtitle) ) : ?>
					<h2><?php echo $pagesubtitle; ?></h2>
				<?php endif; ?>
			</header>
	<?php endif; ?>
<?php endif; ?>