<?php
	/**
	 * Starting the loop
	 */
	$i=0;
	if( have_posts() ) : while( have_posts() ) : the_post(); 
	
	/**
	 * Retrieving post data
	 */
	$post_id     = get_the_ID();
	$post_format = get_post_format();
	$image       = thb_get_featured_image($post_id, "thumbnail");
	$image_full  = thb_get_featured_image($post_id, "full");

	/**
	 * Adding post classes
	 */
	$post_classes = array();
	$post_classes[] = "list";
	$post_classes[] = "type-1";
	if($i == 0 ) 						$post_classes[] = "first";
	if($i == $wp_query->post_count-1) $post_classes[] = "last";
?>

<?php // Post template ================================================================== ?>

<article id="post-<?php echo $post_id; ?>" <?php post_class($post_classes); ?>>

	<?php switch( $post_format ) :

		// Post format gallery ==========================================================

		case 'gallery': ?>
		
			<?php
				thb_component("gallery", array(
					"size" => "thumbnail"
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

		<header class="item-header">
			<h1>
				<a href="<?php the_permalink(); ?>" rel="permalink"><?php the_title(); ?></a>
			</h1>
		</header>

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

		<?php // Post content =============================================================== ?>

		<div class="text">
			<?php
				$excerpt = get_the_excerpt();
				$excerpt = thb_truncate($excerpt, 150);
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
			<?php wp_pagenavi(); ?>
		<?php else : ?>
			<ul>
				<li class="nav-previous"><?php next_posts_link(__('Previous Entries &raquo;', THEMENAME)) ?></li>
				<li class="nav-next"><?php previous_posts_link(__('&laquo; Next Entries', THEMENAME)) ?></li>
			</ul>
		<?php endif; ?>
	</nav>
		
<?php else : ?>

	<?php // No posts found ============================================================= ?>

	<div class="notice warning">
		<p><?php _e("Sorry, there aren't posts to be shown!", THEMENAME); ?></p>
	</div>

<?php endif; ?>