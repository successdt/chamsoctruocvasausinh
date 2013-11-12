<?php 

get_header(); 
$body_classes = get_custom_body_classes();
$sidebar = thb_get_option("_sidebar_post");
	
?>

<?php while(have_posts()) : the_post(); ?>

<?php

/**
 * Retrieving post data
 */
$post_id     = get_the_ID();
$post_format = get_post_format();
$image       = thb_get_featured_image($post_id, "large");
$image_full  = thb_get_featured_image($post_id, "full");
$pagetitle = get_the_title();
?>

<?php // Post template ================================================================== ?>

<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>

	<?php // Post header ================================================================ ?>

	<?php if( isset($pagetitle) ) : ?>
			<header class="page-header">
				<h1><?php echo $pagetitle; ?></h1>
				<h2><em><?php _e("by", THEMENAME); ?></em> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author"><?php the_author(); ?></a></h2>
			</header>
	<?php endif; ?>

	<?php switch( $post_format ) :

		// Post format gallery ==========================================================

		case 'gallery': ?>

			<?php
				thb_component("gallery", array(
					"size" => "large"
				));

				break;
			?>

		<?php // Post format default ==================================================== ?>

		<?php default: ?>

			<?php if( !empty($image) ) : ?>
				<a href="<?php echo $image_full; ?>" class="item-image" rel="prettyPhoto" title="<?php the_title(); ?>">
					<span class="overlay"></span>
					<img src="<?php echo $image; ?>" alt="">
				</a>
			<?php endif; ?>

			<?php break; ?>

	<?php endswitch; ?>

	<?php // Post content =============================================================== ?>

	<div class="text">
		<?php the_content(); ?>
		<?php 
			wp_link_pages(array(
				'pagelink' => '<span>%</span>',
				'before'   => '<div id="page-links"><p><span class="pages">'. __('Pages', THEMENAME).'</span>',
				'after'    => '</p></div>'
			));
		?>
	</div>

	<?php // Post details =============================================================== ?>

	<div class="meta">
		<ul>
			<?php // Post date ================================================================== ?>
			<li class="published">
				<time pubdate datetime="<?php echo thb_get_the_date_microformatted(); ?>">
					<span class="value-title" title="<?php echo thb_get_the_date_microformatted(); ?>"><?php _e("Posted on", THEMENAME); ?></span>
					<?php echo get_the_date(); ?>
				</time>
			</li>

			<?php // Post comments number =============================================== ?>

			<li class="comments-number">
				<a href="<?php comments_link(); ?>" title="<?php comments_number(__('0 comments', THEMENAME), __('1 comment', THEMENAME), '% comments'); ?>">
					<?php comments_number(__('0 comments', THEMENAME), __('1 comment', THEMENAME), '% comments'); ?>
				</a>
			</li>

			<?php // Post categories ==================================================== ?>

			<li class="categories">
				<span><?php _e("in", THEMENAME); ?> <?php the_category(', '); ?></span>
			</li>

			<?php // Post tags ========================================================== ?>

			<?php $tags = get_the_tags(); if( !empty($tags) ) : ?>
			<li class="tags">
				<span><?php _e("Tags : ", THEMENAME); ?> <?php the_tags('', ', '); ?></span>
			</li>
			<?php endif; ?>

			<?php // Post author ========================================================== ?>

			<li class="author">
				<span><?php _e("by", THEMENAME); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author"><?php the_author(); ?></a></span>
			</li>

		</ul>
	</div>

	<?php // Navigation between posts =============================================== ?>

	<?php if( thb_get_option("_post_shownav") == "1" ) : ?>
		<nav role="navigation" class="navigation post-nav">
			<ul class="items-arrows">
				<?php if(thb_post_has_previous()) : ?>
					<li class="previous-arrow"><span>&larr;</span><?php previous_post_link('%link'); ?></li>
				<?php endif; ?>
				<?php if(thb_post_has_next()) : ?>
					<li class="next-arrow"><?php next_post_link('%link'); ?><span>&rarr;</span></li>
				<?php endif; ?>
			</ul>
		</nav>
	<?php endif; ?>

</article>

</div><!-- closing the content section -->

<section class="secondary box-col span-<?php if( in_array("wout-sidebar", $body_classes) ) : ?>12<?php else : ?>8<?php endif; ?>">
<?php // Post secondary content ===================================================== ?>
	
	<?php // Posts comments ========================================================= ?>
	
	<?php comments_template("", true); ?>

	<?php // Posts comments form ==================================================== ?>
	
	<?php if( have_comments() == "" ) : ?>
		<div class="no-comments col span-<?php if( in_array("wout-sidebar", $body_classes) ) : ?>12<?php else : ?>8<?php endif; ?>">
			<?php comment_form(); ?>
		</div>
	<?php else : ?>
		<div class="col span-<?php if( in_array("wout-sidebar", $body_classes) ) : ?>12<?php else : ?>8<?php endif; ?>">
			<?php comment_form(); ?>
		</div>
	<?php endif; ?>

	<?php // Posts related items ==================================================== ?>
	
	<?php if( thb_get_option("_post_related") == 1 ) : ?>
		<?php
			thb_component("related-entries", array(
				"post_type" => "post"
			));
		?>
	<?php endif; ?>

</section>
<?php endwhile; ?>
</section> <!-- closing content-wrapper section -->

<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>
	
<?php get_footer(); ?>