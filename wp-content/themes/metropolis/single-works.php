<?php 

get_header(); 
$body_classes = get_custom_body_classes();
$sidebar = thb_get_option("_sidebar_works");
	
?>

<?php while(have_posts()) : the_post(); ?>

<?php
	/**
	 * Retrieving post data
	 */
	$post_id      = get_the_ID();
	$post_format = get_post_format();
	$image      = thb_get_featured_image( $post_id, "portfolio-large" );
	$image_full = thb_get_featured_image( $post_id, "full" );
	$video = thb_get_post_meta($post_id, "_video_url");
	$work_types = wp_get_object_terms( $post_id, "types" );
	$skills     = wp_get_object_terms( $post_id, "skills" );
	$side_info  = thb_get_post_meta( $post_id, "_side_info" );

	$types = array();
	if( !empty($work_types) )
		foreach($work_types as $type)
			$types[] = $type->name;

	$types_skill = array();
	if( !empty($skills) )
		foreach($skills as $skill)
			$types_skill[] = $skill->name;

	$pagetitle = get_the_title();
?>

<?php // Post template ================================================================== ?>

<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>

	<?php // Post header ================================================================ ?>

	<?php if( isset($pagetitle) ) : ?>
			<header class="page-header">
				<hgroup class="head-wrapper">
					<h1><?php echo $pagetitle; ?></h1>
					<h2><?php echo join($types, ", "); ?></h2>
				</hgroup>

				<?php // Navigation between posts =============================================== ?>

				<?php if( thb_get_option("_work_hidenav") != "1" ) : ?>
					<nav role="navigation" class="navigation work-nav">
						<ul class="items-arrows">
							<?php if(thb_post_has_previous()) : ?>
								<li class="previous-arrow"><?php previous_post_link('%link', '&lsaquo;'); ?></li>
							<?php endif; ?>
							<?php if(thb_post_has_next()) : ?>
								<li class="next-arrow"><?php next_post_link('%link', '&rsaquo;'); ?></li>
							<?php endif; ?>
						</ul>
					</nav>
				<?php endif; ?>
				<span class="clear"></span>
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

			<?php if( !empty($image) && empty($video) ) : ?>
				<a href="<?php echo $image_full; ?>" class="item-image" rel="prettyPhoto" title="<?php the_title(); ?>">
					<span class="overlay"></span>
					<img src="<?php echo $image; ?>" alt="">
				</a>
			<?php elseif( !empty($video) ) : ?>
				<?php
					echo do_shortcode('[video id="' . $video . '"]');
				?>
			<?php endif; ?>

			<?php break; ?>

	<?php endswitch; ?>

	<?php // Post content =============================================================== ?>

	<div class="text">
		<?php the_content(); ?>
	</div>

	<?php // Post details =============================================================== ?>

	<div class="meta">
		<ul>
			<?php // Post date ================================================================== ?>
			<li class="published">
				<time pubdate datetime="<?php echo thb_get_the_date_microformatted(); ?>">
					<em><?php _e("Date :", THEMENAME); ?></em>
					<?php echo get_the_date(); ?>
				</time>
			</li>

			<?php // Post tags ========================================================== ?>

			<?php if ( !empty($skills) ) : ?>
			<li class="skills">
				<span><em><?php _e("Skills : ", THEMENAME); ?></em> <?php echo join($types_skill, ", "); ?></span>
			</li>
			<?php endif; ?>

			<?php if ( !empty($side_info) ) : ?>
			<li>
				<?php
					$side_info = stripslashes($side_info);
					echo wptexturize(wpautop(do_shortcode($side_info)))
				?>
			</li>
			<?php endif; ?>

		</ul>
	</div>

</article>

</div><!-- closing the content section -->

<section class="secondary box-col span-<?php if( in_array("wout-sidebar", $body_classes) ) : ?>12<?php else : ?>8<?php endif; ?>">
<?php // Post secondary content ===================================================== ?>
	
	<?php // Posts comments ========================================================= ?>
	
	<?php if( thb_get_option("_works_comments") == 1 ) : ?>
		<?php comments_template("", true); ?>
		
		<?php if(have_comments() == ""): ?>
			<div class="no-comments">
				<?php comment_form(); ?>
			</div>
		<?php else : ?>
			<?php comment_form(); ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php // Posts related items ==================================================== ?>
	
	<?php if( thb_get_option("_work_related") == 1 ) : ?>
		<?php
			thb_component("related-entries", array(
				"post_type" => "works"
			));
		?>
	<?php endif; ?>

</section>
<?php endwhile; ?>
</section> <!-- closing content-wrapper section -->

<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>
	
<?php get_footer(); ?>