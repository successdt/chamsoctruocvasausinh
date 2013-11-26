<ul id="worklist" class="portfolio three box-col span-12">
	
	<?php
		$works_per_page           = thb_get_option("_works_per_page");
		$works_orderby            = thb_get_option("_works_order");
		$works_featured_image_rel = thb_get_option("_work_enable_lightbox_photolist") == 1 ? "prettyPhoto" : "permalink";
		$works_order              = "desc";
		if( $works_orderby == "title" )
			$works_order = "asc";
	
		global $page_id;
		
		/**
		 * Check if the blog is filtered by category
		 */
		$portfolio_type = thb_get_post_meta($page_id, "_page_portfolio_category_filter");

		/**
		 * Default args
		 */
		$args = array(
			"posts_per_page" => !empty($works_per_page) ? $works_per_page : 9,
			"orderby" => $works_orderby,
			"order" => $works_order
		);

		/**
		 * Optional filter by work type
		 */
		if( !empty($portfolio_type) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'types',
					'field' => 'term_id',
					'terms' => $portfolio_type
				)
			);
		}
		
		$works = thb_get_posts("works", $args);
		if( $works->have_posts() ) : while( $works->have_posts() ) : $works->the_post();
	?>
	
		<?php
			$post_format = get_post_format();
			$work_thumbnail = thb_get_post_meta(get_the_ID(), "_work_thumbnail_image");
			$video = thb_get_post_meta(get_the_ID(), "_video_url");
			
			$photo = thb_get_thumbnail(get_the_ID(), "portfolio");
			$photo_full = thb_get_thumbnail(get_the_ID());

			$work_link = $photo_full;
			
			if( !empty($video) ) {
				$work_link = $video;

				if( !empty($work_thumbnail) )
					$photo = thb_get_image_size($work_thumbnail, "portfolio");
				else
					$photo = getVideoThumbnail($video, "thumbnail_large");
			}

			if( $works_featured_image_rel == "permalink" )
				$work_link = get_post_permalink();
				
			$itemclass=array();
			if( empty($photo) && empty($video) && $post_format != "gallery" )
				$itemclass[] = "noimg";
				
			$post_categories = wp_get_object_terms( get_the_ID(), "types" );
			$cats="";
			$cat_ids = array();
			foreach($post_categories as $cat) {
				$itemclass[] = $cat->slug;
				$cat_ids[] = $cat->name;
			}
		?>
	
		<li class="item <?php echo join(" ", $itemclass); ?>">
			
			<?php if( $post_format == "gallery" ) : ?>
				<?php
					thb_component("gallery", array(
						"size" => "portfolio",
						"class" => "front"
					));
				?>
			<?php else : ?>
				<?php if( !empty($photo) ) : ?>
					<a href="<?php echo $work_link; ?>" rel="<?php echo $works_featured_image_rel; ?>" class="list-thumb" title="<?php echo get_the_title(); ?>">
						<span class="overlay"></span>
						<img src="<?php echo $photo; ?>" alt="" class="front">
					</a>
				<?php endif; ?>
			<?php endif; ?>
			
			<article class="data">
				<header>
					<h1>
						<a href="<?php the_permalink(); ?>" rel="permalink">
							<?php the_title(); ?>
						</a>
					</h1>
					<h2><?php echo join($cat_ids, ", "); ?></h2>
				</header>
			</article>
		</li>
	
	<?php endwhile; endif; ?>
</ul>

<nav role="navigation" class="navigation page-nav nav-below col span-12">
	<?php if(function_exists("wp_pagenavi")) : ?>
		<?php wp_pagenavi(array('query' => $works)); ?>
	<?php else : ?>
	<ul>
		<li class="nav-previous"><?php thb_previous_posts_link(__('Previous Entries &raquo;', THEMENAME), $works) ?></li>
		<li class="nav-next"><?php thb_next_posts_link(__('&laquo; Next Entries', THEMENAME), $works) ?></li>
	</ul>
	<?php endif; ?>
</nav>