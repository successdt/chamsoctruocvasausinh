<?php 
/*
Template Name: Home
*/
get_header(); 
$slider_id = get_post_meta(get_the_ID(), "main_slider", true);
echo do_shortcode("[slider id='" . $slider_id . "']");
?>
<div class="theme_page relative noborder">
	<?php
	if($theme_options["home_page_top_hint"]!=""): ?>
	<div class="top_hint">
		<?php echo $theme_options["home_page_top_hint"]; ?>
	</div>
	<?php
	endif;
	echo do_shortcode("[slider_content id='" . $slider_id . "']");
	?>
	<ul class="home_box_container_list clearfix">
	<?php
	$sidebar = get_post(get_post_meta(get_the_ID(), "page_sidebar_top", true));
	if(!(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name))
		dynamic_sidebar($sidebar->post_name);
	?>
	</ul>
	<div class="clearfix">
		<?php
		if(have_posts()) : while (have_posts()) : the_post();
			the_content();
		endwhile; endif;
		?>
	</div>
</div>
<?php
get_footer(); 
?>