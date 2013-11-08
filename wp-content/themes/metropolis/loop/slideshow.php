<?php 

$slides = get_page_background(); 
$slideshow_appearance = thb_get_option("_style_slideshow_appearance");
$background_container_height = thb_get_option("_style_slideshow_height");

?>
<div class="slideshow-wrapper <?php if($slideshow_appearance == "boxed") : ?>extended-container<?php endif; ?>">
<?php if( !empty($slides) ) : ?>
	
	<ul id="background_slider" class="background_container">
	<?php $i=0; foreach($slides as $slide) : ?>
		<?php
			if( !is_string($slide) )
				$type = $slide->type;
			else
				$type = "picture";
		?>
		<li class="slide slide_type_<?php echo $type; ?>" data-index="<?php echo $i; ?>">
			<?php if( !is_string($slide) ) : ?>
				<?php
					$title = "";
					if( !empty($slide->title) )
						$title = $slide->title;

					$caption = "";
					if( !empty($slide->caption) )
						$caption = $slide->caption;

					$url = "";
					if( !empty($slide->url) )
						$url = $slide->url;
				?>

				<?php if( $slide->type == "picture" ) : ?>
					<img src="<?php echo $slide->resizedSrc; ?>" alt="<?php echo $title; ?>" data-url="<?php echo $url; ?>" style="opacity: 0">
				<?php elseif( $slide->type == "custom" ) : ?>
					<?php if( !empty($slide->resizedSrc) ) : ?>
						<img src="<?php echo $slide->resizedSrc; ?>" alt="<?php echo $title; ?>" data-url="<?php echo $url; ?>" style="opacity: 0">
					<?php endif; ?>
				<?php else : ?>

					<?php
						$picture = getVideoThumbnail($slide->url, "thumbnail_large");
						$code = getVideoCode($slide->url);
					?>
					<img src="<?php echo $picture; ?>" alt="<?php echo $title; ?>" data-url="<?php echo $url; ?>" style="opacity: 0;">

					<?php if( is_youtube($slide->url) ) : ?>
						<div class="youtube" id="player<?php echo $i; ?>" data-video="<?php echo $code; ?>">
							<?php _e("You need Flash player 8+ and JavaScript enabled to view this video.", THEMENAME); ?>
						</div>
					<?php endif; ?>

					<?php if( is_vimeo($slide->url) ) : ?>
						<iframe class="vimeo" id="player<?php echo $i; ?>" src="http://player.vimeo.com/video/<?php echo $code; ?>?api=1&amp;player_id=player<?php echo $i; ?>&amp;color=ffffff" width="500" height="281" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>
					<?php endif; ?>

				<?php endif; ?>
			<?php else : ?>
				<img src="<?php echo $slide; ?>" alt="" data-url="" style="opacity: 0">
			<?php endif; ?>
		</li>
	<?php $i++; endforeach; ?>
	</ul>

	<?php if( thb_get_option("_background_pattern_overlay") != "0" ) : ?>
		<div class="background_overlay"></div>
	<?php endif; ?>

	<div class="slide-box-caption extended-container">

	<?php 

		if (!empty($slides) ) :
			$i=0;
			foreach($slides as $slide) :
		?>
		<?php if( !is_string($slide) ) : ?>
			<?php
				$title = "";
				if( !empty($slide->title) )
					$title = $slide->title;

				$caption = "";
				if( !empty($slide->caption) )
					$caption = $slide->caption;

				$url = "";
				if( !empty($slide->url) )
					$url = $slide->url;
			?>
			
			<?php if( !empty($title) || !empty($caption) || $slide->type == "video" ) : ?>

				<?php
					$slide_overlay_classes = array(
						thb_get_option("_slideshow_caption_effects"),
						"slide-overlay",
						"slide-overlay-" . $i,
						"slide-type-" . $slide->type,
						"col",
						"span-12",
						"text",
						thb_get_option("_slideshow_caption_style")
					);

					if( count($slides) > 1 )
						$slide_overlay_classes[] = "dynamic-slide";
					else
						$slide_overlay_classes[] = "static-slide";
				?>

				<div class="<?php echo implode(" ", $slide_overlay_classes); ?>">
					<?php if( !empty($title) ) : ?>
						<h1 class="slide-heading">
							<?php if( !empty($url) ) : ?><a href='<?php echo $url; ?>'><?php endif; ?>
								<?php echo $title; ?>
							<?php if( !empty($url) ) : ?></a><?php endif; ?>
						</h1>
					<?php endif; ?>
					<?php if( !empty($caption) ) : ?>
						<div class="slide-caption">
							<?php 
								$caption = stripslashes($caption);
								echo wptexturize(wpautop(do_shortcode($caption))); 
							?>
						</div>
					<?php endif; ?>
					<?php if( $slide->type == "video" ) : ?>
						<a href="#" class="playpause" data-index="<?php echo $i; ?>" data-text-play="<?php _e('Play', THEMENAME); ?>" data-text-pause="<?php _e('Pause', THEMENAME); ?>"><?php _e('Play', THEMENAME); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php $i++; endforeach; endif; ?>

	<?php if( count($slides) > 1 && $slideshow_appearance == "boxed" && $background_container_height != 0 ) : ?>
		<div class="controls-container <?php echo thb_get_option("_slideshow_caption_style"); ?>">
			<div class="nav-controls">
				<ul class="controls">
					<li><a class="bg-prev" href="#"><?php _e('Previous slide', THEMENAME); ?></a></li>
					<li><a class="bg-next" href="#"><?php _e('Next slide', THEMENAME); ?></a></li>
				</ul>
			</div>
		</div>
	<?php endif; ?>
	
	</div>

	<script type="text/javascript" src="<?php echo custom_resource_link("custom-slideshow"); ?>"></script>
<?php endif; ?>
</div>

<?php if( !empty($slides) && count($slides) > 1 && ($slideshow_appearance != "boxed" || $background_container_height == 0) ) : ?>
	<div class="controls-container external">
		<div class="nav-controls">
			<ul class="controls">
				<li><a class="bg-prev" href="#"><?php _e('Previous slide', THEMENAME); ?></a></li>
				<li><a class="bg-next" href="#"><?php _e('Next slide', THEMENAME); ?></a></li>
			</ul>
		</div>
	</div>
<?php endif; ?>