<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

get_header();

$sidebar = thb_get_option("_sidebar_archivesearch_id");
$pagesubtitle = __("Archives", THEMENAME);

if ( is_day() )
	$pagetitle = get_the_date();
elseif ( is_month() )
	$pagetitle = get_the_date( 'F Y' );
elseif ( is_year() )
	$pagetitle = get_the_date( 'Y' );
else
	$pagetitle = __( 'Archives', THEMENAME);

?>
	<?php get_template_part("loop/page-header"); ?>

	<?php get_template_part("loop/blog"); ?>
	
	</div><!-- closing the content section -->
</section><!-- closing the content-wrapper section -->

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>
	
<?php get_footer(); ?>