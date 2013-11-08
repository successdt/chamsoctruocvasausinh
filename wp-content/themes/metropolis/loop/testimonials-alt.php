<?php 
	$testimonials = thb_get_posts("testimonials", array("posts_per_page" => 99, "orderby" => "post_date")); 
	if($testimonials->have_posts()) : 
?>
	
	<?php 

		while($testimonials->have_posts()) : $testimonials->the_post(); 

			$post_id = get_the_ID();
			echo do_shortcode("[thb_testimonials id='$post_id' style='2' showthumb='1' before_widget='' after_widget='' before_title='' after_title='']");

		endwhile;

	?>

<?php else : ?>
	<p><?php _e( 'Sorry, but there aren\'t testimonials to show.', THEMENAME ); ?></p>
<?php endif; ?>