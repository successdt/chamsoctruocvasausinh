<?php
/*
Template Name: Archives
*/

$page_id = get_the_ID();
$sidebar = thb_get_option("_sidebar_archivesearch_id");

$pagetitle = get_the_title();
$pagesubtitle =  thb_get_post_meta($page_id, "_page_subtitle");

get_header(); ?>

	<?php get_template_part("loop/page-header"); ?>

	<div class="text">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; endif; ?>

		<h3><?php _e("Search:", THEMENAME); ?></h3>
		<div class="search_404">
			<?php get_search_form(); ?>
		</div>

		<div class="box-col content-two-fourth">
			<h3><?php _e("Last 30 posts:", THEMENAME); ?></h3>
			<?php
				$posts = thb_get_posts("post", array(
				     "posts_per_page" => 30
				));
				if( $posts->have_posts() ) : ?>
			<ul>
				<?php while( $posts->have_posts() ) : $posts->the_post(); ?>
				<li>
					<a href="<?php the_permalink(); ?>" rel="permalink"><?php the_title(); ?></a>
				</li>
				<?php endwhile; ?>
			</ul>
			<?php endif; ?>
		</div>
		<div class="box-col content-two-fourth last">
			<h3><?php _e("Archives by Month:", THEMENAME); ?></h3>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
			
			<h3><?php _e("Archives by Subject:", THEMENAME); ?></h3>
			<ul>
				 <?php wp_list_categories(array("title_li" => "")); ?>
			</ul>
		</div>
	</div>
	
	</div><!-- closing the content section -->
</section><!-- closing the content-wrapper section -->

<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>

<?php get_footer(); ?>