<?php
$body_classes = get_custom_body_classes();

$items = thb_get_related_posts(get_the_ID(), array(
	'posts_per_page' => 4
));

switch($post_type) {
	case 'works':
		$related_title = __(thb_get_option("_label_related_works", false, "Related works"), THEMENAME);
		break;
	default:
		$related_title = __(thb_get_option("_label_related_posts", false, "Did you like what you read? You might also like:"), THEMENAME);
}

?>

<?php if($items->have_posts()) : ?>
	<div class="related-container col span-<?php if( in_array("wout-sidebar", $body_classes) ) : ?>12<?php else : ?>8<?php endif; ?>">
		<h3><?php echo $related_title; ?></h3>
		<ul id="relatedlist">
			<?php $i=0; while($items->have_posts()) : $items->the_post(); ?>
			<li class="relatedlist-item <?php echo ($i==0) ? "first" : ""; ?> <?php echo ($i==3) ? "last" : ""; ?>">
				<h1><a href="<?php the_permalink(); ?>" title="<?php _e("Click for more details", THEMENAME); ?>"><?php the_title(); ?></a></h1>
				<p class="mark"><?php echo get_the_date("F jS, Y"); ?></p>
			</li>
			<?php $i++; endwhile; ?>
		</ul>
	</div>
<?php endif; ?>