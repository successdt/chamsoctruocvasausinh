	</div><!-- closing #main-container -->
	
	<?php get_template_part("page-footer"); ?>

	<div class="footer-container" align="center">
		
		<footer id="footer" class="col span-12">
			<nav id="sub-nav" class="secondary menu" align="center">
				<?php wp_nav_menu( array( 'container' => '', 'container_class' => '', 'theme_location' => 'secondary', 'depth' => 1 ) ); ?>
			</nav>		
			<small id="copyright">
				<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				<span>&copy; <?php echo date('Y'); ?></span>
				<?php $copyright = thb_get_option("_copyright", true); if( !empty($copyright) ) : ?>
				<span> &mdash; <?php echo $copyright; ?></span>
				<?php endif; ?>
			</small>
		</footer>	
	</div>	
		<?php wp_footer(); ?>
	</body>
</html>