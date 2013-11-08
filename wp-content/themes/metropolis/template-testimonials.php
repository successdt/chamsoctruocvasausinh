<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 * Template Name: Testimonials quote
 */

get_header();

$page_id = get_the_ID();
$sidebar = thb_get_option("_sidebar_testimonials");
$pagetitle = get_the_title();
$pagesubtitle =  thb_get_post_meta($page_id, "_page_subtitle");

?>
	<?php get_template_part("loop/page-header"); ?>
	
	<?php get_template_part("loop/testimonials"); ?>

	</div><!-- closing the content section -->
</section><!-- closing the content-wrapper section -->

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>

<?php get_footer(); ?>