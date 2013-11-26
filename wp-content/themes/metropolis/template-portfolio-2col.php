<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 * Template Name: Portfolio 2 col
 */

get_header();

$page_id = get_the_ID();
$sidebar = thb_get_option("_sidebar_works");
$pagetitle = get_the_title();
$pagesubtitle =  thb_get_post_meta($page_id, "_page_subtitle");

/**
 * Check if the blog is filtered by category
 */
$portfolio_type = thb_get_post_meta($page_id, "_page_portfolio_category_filter");

?>
	<?php get_template_part("loop/page-header"); ?>

	<?php
		if( have_posts() ) : while( have_posts() ) : the_post(); 
		$content = get_the_content(); ?>

		<?php if( !empty($content) ) : ?>
		<div class="text">
			<?php the_content(); ?>
			<span class="divider"></span>
		</div>
		<?php endif; ?>

	<?php endwhile; endif; ?>

	<?php if( empty($portfolio_type) )
			get_template_part("loop/portfolio-filter"); ?>
	</div><!-- closing the content section -->

	<?php get_template_part("loop/portfolio-2"); ?>
		
</section><!-- closing the content-wrapper section -->

<?php get_footer(); ?>