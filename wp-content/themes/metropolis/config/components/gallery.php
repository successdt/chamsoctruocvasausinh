<?php
	$gallery = thb_get_post_gallery($size);
	if(!empty($gallery)) :
?>
	<div class="post-gallery item-image flexslider" id="gallery-post-<?php echo get_the_ID(); ?>">
		<?php echo $gallery; ?>
	</div>
<?php endif; ?>