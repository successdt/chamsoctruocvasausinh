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

		if(have_posts()) : while(have_posts()) : the_post();
			$pagetitle = get_the_title();
			$pagesubtitle = "";
			if(!empty($post->post_parent)) {

				$post_link = get_permalink( $post->post_parent );
				$link_text = sprintf( __( 'Return to %s', THEMENAME ), get_the_title( $post->post_parent ) );
				
				$pagesubtitle = '<a href="' . $post_link . '">' . $link_text . '</a>';

			}
		endwhile; endif; 

	?>

	<?php get_template_part("loop/page-header"); ?>
	
	<?php
		rewind_posts();
		get_template_part("loop/attachments");
	?>
	
	</div><!-- closing the content section -->
</section><!-- closing the content-wrapper section -->

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>

<?php get_footer(); ?>