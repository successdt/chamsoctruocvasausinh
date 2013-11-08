<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

get_header();

$sidebar = thb_get_option("_sidebar_archivesearch_id");
$pagetitle = sprintf( __( 'Search Results for: &ldquo;%s&rdquo;', THEMENAME ), '<span>' . get_search_query() . '</span>' );

?>
	<?php get_template_part("loop/page-header"); ?>
	<?php 
		if( have_posts()) : ?>
		<?php
			get_template_part("loop/archive");
		else : ?>

		<div class="text">
			<p class="sorry"><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', THEMENAME ); ?></p>
			<div class="search_404">
				<?php get_search_form(); ?>
			</div>
		</div>
	<?php endif; ?>
	
	</div><!-- closing the content section -->
</section><!-- closing the content-wrapper section -->

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>

<?php get_footer(); ?>