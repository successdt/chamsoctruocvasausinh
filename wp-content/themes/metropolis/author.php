<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

get_header();
	
$sidebar = thb_get_option("_sidebar_archivesearch_id");

?>
	<?php
		if(have_posts()) : 
			the_post();

			$pagetitle = get_the_author();
			$pagesubtitle = __("Author", THEMENAME);
		?>
		
		<?php get_template_part("loop/page-header"); ?>

	<?php endif;
		
		rewind_posts();
		get_template_part("loop/archive");
	?>

	</div><!-- closing the content section -->
</section><!-- closing the content-wrapper section -->

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>

<?php get_footer(); ?>