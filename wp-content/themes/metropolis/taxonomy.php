<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

get_header();

$sidebar = thb_get_option("_sidebar_archivesearch_id");

$pagetitle = single_cat_title( '', false );
$pagesubtitle = __("Taxonomy", THEMENAME);
?>
<section class="col span-12">

	<?php get_template_part("loop/page-header"); ?>

	<?php get_template_part("loop/archive"); ?>

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>

</section>

<?php get_footer(); ?>