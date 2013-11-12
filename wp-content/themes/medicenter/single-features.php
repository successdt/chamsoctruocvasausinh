<?php
/*
Template Name: Single features
*/
get_header();
setPostViews(get_the_ID());
?>
<div class="theme_page relative">
	<div class="page_layout page_margin_top clearfix">
		<div class="page_header clearfix">
			<div class="page_header_left">
				<h1 class="page_title"><?php the_title(); ?></h1>
				<ul class="bread_crumb">
					<li>
						<a href="<?php echo get_home_url(); ?>" title="<?php _e('Home', 'medicenter'); ?>">
							<?php _e('Home', 'medicenter'); ?>
						</a>
					</li>
					<li class="separator icon_small_arrow right_gray">
						&nbsp;
					</li>
					<li>
						<?php the_title(); ?>
					</li>
				</ul>
			</div>
			<?php
			/*get page with single post template set*/
			$post_template_page_array = get_pages(array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'number' => 1,
				'meta_key' => '_wp_page_template',
				'meta_value' => 'single-features.php'
			));
			$post_template_page = $post_template_page_array[0];
			$sidebar = get_post(get_post_meta($post_template_page->ID, "page_sidebar_header", true));
			if(!(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
			?>
			<div class="page_header_right">
				<?php
				dynamic_sidebar($sidebar->post_name);
				?>
			</div>
			<?php
			endif;
			?>
		</div>
		<div class="clearfix">
			<?php
			echo wpb_js_remove_wpautop(apply_filters('the_content', $post_template_page->post_content));
			global $post;
			$post = $post_template_page;
			setup_postdata($post);
			?>
		</div>
	</div>
</div>
<?php
get_footer();
?>