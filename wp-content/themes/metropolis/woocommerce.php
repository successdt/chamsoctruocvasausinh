<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

get_header();

$page_id      = get_the_ID();
$sidebar      = thb_get_post_meta($page_id, "_page_sidebar");
$image        = thb_get_featured_image($page_id, "large");
$image_full   = thb_get_featured_image($page_id, "full");
?>
		
		<?php
			$pagetitle    = get_the_title();
			$pagesubtitle =  thb_get_post_meta($page_id, "_page_subtitle");
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

		<?php if( !empty($image) ) : ?>
			<a href="<?php echo $image_full; ?>" class="item-image" rel="prettyPhoto" title="<?php the_title(); ?>">
				<span class="overlay"></span>
				<img src="<?php echo $image; ?>" alt="">
			</a>
		<?php endif; ?>

		<div class="text">
			<div class="woocommerce">
	           <?php if(function_exists('woocommerce_content')) { woocommerce_content(); } ?>
	       	</div>
		</div>

	</div><!-- closing the content section -->
</section><!-- closing the content-wrapper section -->

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>

<?php get_footer(); ?>