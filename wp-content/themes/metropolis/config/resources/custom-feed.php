<?php $feed = thb_get_option("_feed"); ?>
<?php if(!empty($feed)) : ?>
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> <?php _e("Alternate RSS feed", THEMENAME); ?>" href="<?php echo $feed; ?>">
<?php endif; ?>