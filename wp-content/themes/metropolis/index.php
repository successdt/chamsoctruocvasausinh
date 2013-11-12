<?php

$sidebar = thb_get_option("_sidebar_post");
get_header();

?>

<?php get_template_part("loop/blog"); ?>

	</div><!-- closing the content section -->
</section><!-- closing the content section -->

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>

<?php get_footer(); ?>