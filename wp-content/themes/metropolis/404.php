<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */

get_header();

$sidebar = thb_get_option("_sidebar_archivesearch_id");

$pagetitle = __( 'Not Found', THEMENAME );
$pagesubtitle = __("Error 404", THEMENAME);

?>
	<?php get_template_part("loop/page-header"); ?>

	<div class="text">
		<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', THEMENAME ); ?></p>
		<?php get_search_form(); ?>
		<script type="text/javascript">
			// focus on search field after it has loaded
			document.getElementById('s') && document.getElementById('s').focus();
		</script>
	</div>

	</div><!-- closing the content section -->
</section><!-- closing the content-wrapper section -->

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>
	
<?php get_footer(); ?>