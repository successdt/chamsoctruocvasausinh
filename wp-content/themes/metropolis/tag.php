<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

get_header();

$sidebar = thb_get_option("_sidebar_archivesearch_id");

$pagetitle = single_tag_title( '', false );
$pagesubtitle = __("Tag", THEMENAME);

?>
	<?php get_template_part("loop/page-header"); ?>

	<?php get_template_part("loop/archive"); ?>

	</div><!-- closing the content section -->
</section><!-- closing the content-wrapper section -->

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>

<?php get_footer(); ?>