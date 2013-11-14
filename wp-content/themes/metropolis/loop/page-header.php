<?php
	global $pagetitle, $pagesubtitle;
?>
<?php
	if( !is_front_page() || is_front_page() && thb_get_option("_homepage_pageheader") == "0" ) :
	$categoryBanner = array(
		93 => '/wp-content/uploads/2013/11/dich-vu.png',
		94 => '/wp-content/uploads/2013/11/dich-vu.png',
		95 => '/wp-content/uploads/2013/11/dich-vu.png',
		96 => '/wp-content/uploads/2013/11/dich-vu.png',
		97 => '/wp-content/uploads/2013/11/nguyelieu.png',
		98 => '/wp-content/uploads/2013/11/blog.png',
		101 => '/wp-content/uploads/2013/11/blog.png'
	);
?>
	<?php if( isset($pagetitle) ) : ?>
			<header class="page-header">
				<?php if (is_category() && key_exists(get_query_var('cat'), $categoryBanner)):  ?>
					<img src="<?php echo $categoryBanner[get_query_var('cat')]; ?>" alt="<?php echo $pagetitle ?>" class="category-image" />
				<?php endif; ?>
				<h1><?php echo $pagetitle; ?></h1>
				<?php if( isset($pagesubtitle) && !empty($pagesubtitle) ) : ?>
					<?php /*<h2><?php echo $pagesubtitle; ?></h2>*/ ?>
				<?php endif; ?>
				<?php if (function_exists('ewp_get_child_categories')): ?>
					<div class="child-cats">
						<?php echo ewp_get_child_categories(); ?>
					</div>
					
				<?php endif; ?>
			</header>
	<?php endif; ?>
<?php endif; ?>