<?php

	global $page_id;

	/**
	 * Check if the blog is filtered by category
	 */
	$cat = thb_get_post_meta($page_id, "_page_blog_category_filter");

	/**
	 * Building the posts query
	 */
	$args = array();
	if( !empty($cat) ) {
		$args["cat"] = $cat;
	}

	/**
	 * Getting the posts
	 */
	$blog_posts = thb_get_posts("post", $args);

	/**
	 * Starting the loop
	 */
	$i=1;
	if( $blog_posts->have_posts() ) : while( $blog_posts->have_posts() ) : $blog_posts->the_post(); 
	
	/**
	 * Retrieving post data
	 */
	$post_id     = get_the_ID();
	$post_format = get_post_format();
	$image       = thb_get_featured_image($post_id, "small");
	$image_full  = thb_get_featured_image($post_id, "full");

	/**
	 * Adding post classes
	 */
	$post_classes = array();
	$post_classes[] = "list";
	$post_classes[] = "type-3";
	if($i == 1 ) 						$post_classes[] = "first";
	if($i == $blog_posts->post_count) 	$post_classes[] = "last";
	if($i % 2 == 0) 					$post_classes[] = "n2";
?>

<?php // Post template ================================================================== ?>

<article id="post-<?php echo $post_id; ?>" <?php post_class($post_classes); ?>>

	<?php switch( $post_format ) :

		// Post format gallery ==========================================================

		case 'gallery': ?>
		
			<?php
				thb_component("gallery", array(
					"size" => "small"
				));

				break;
			?>

		<?php // Post format default ==================================================== ?>

		<?php default: ?>

			<?php if( !empty($image) ) : ?>
				<a href="<?php the_permalink(); ?>" class="item-image" title="<?php the_title(); ?>">
					<span class="overlay"></span>
					<img src="<?php echo $image; ?>" alt="">
				</a>
			<?php endif; ?>

			<?php break; ?>

	<?php endswitch; ?>
	<div class="item-wrapper <?php if( empty($image) && $post_format != "gallery" ) : ?>no-thumb<?php endif; ?>">
		<?php // Post header ================================================================ ?>

		<footer>
			<time pubdate class="pubdate">
				<em><span class="icon date"></span><?php echo get_the_date("F jS, Y"); ?></em>
			</time>
			<cite class="author">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><span class="icon user"></span><?php the_author(); ?></a>
			</cite>
			<span class="comments">
				<a href="<?php comments_link(); ?>" title="<?php comments_number(__('0', THEMENAME), __('1', THEMENAME), '%'); ?>"><span class="icon bubble"></span><?php comments_number(__('0', THEMENAME), __('1', THEMENAME), '%'); ?></a>
			</span>
		</footer>
		
		<header class="item-header">
			<h1>
				<a href="<?php the_permalink(); ?>" rel="permalink"><?php the_title(); ?></a>
			</h1>
		</header>

		<?php // Post content =============================================================== ?>

		<div class="text">
			<?php
				$excerpt = get_the_excerpt();
				$excerpt = thb_truncate($excerpt, 200);
				echo apply_filters('the_content', $excerpt);
			?>
		</div>
	</div> <!-- #item-wrapper -->
</article>

<?php $i++; endwhile; ?>

	<?php // Navigation between posts ======================================================= ?>

	<?php
		$wp_pagenavi = function_exists("wp_pagenavi");
		$navigation_classes = array();
		if( $wp_pagenavi ) $navigation_classes[] = "pagenavi";
	?>

	<nav role="navigation" class="navigation page-nav <?php implode(" ", $navigation_classes); ?>">
		<?php if( function_exists("wp_pagenavi") ) : ?>
			<?php wp_pagenavi( array('query' => $blog_posts) ); ?>
		<?php else : ?>
			<ul>
				<li class="nav-previous">
					<?php thb_previous_posts_link(__('Previous entries &raquo;', THEMENAME), $blog_posts); ?>
				</li>
				<li class="nav-next">
					<?php thb_next_posts_link(__('&laquo; Next entries', THEMENAME), $blog_posts); ?>
				</li>
			</ul>
		<?php endif; ?>
	</nav>
		
<?php else : ?>

	<?php // No posts found ============================================================= ?>

	<div class="notice warning">
		<p><?php _e("Sorry, there aren't posts to be shown!", THEMENAME); ?></p>
	</div>

<?php endif; ?>