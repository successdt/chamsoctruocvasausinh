<?php
$works_per_page = thb_get_option("_works_per_page");
$works_orderby = thb_get_option("_works_order");
$works_order = "desc";
if( $works_orderby == "title" )
	$works_order = "asc";

$works = thb_get_posts("works", array(
	"posts_per_page" => !empty($works_per_page) ? $works_per_page : 9,
	"orderby" => $works_orderby,
	"order" => $works_order
));

$terms = get_terms("types");

if( $works->have_posts() && count($terms) > 0 ) :
?>
	<div id="filter">
		<?php
			$default_filter = thb_get_option("_works_default_filter");
		?>	
		<ul id="filterlist">
			<li <?php if(!isset($default_filter) || $default_filter == 0) : ?>class="current"<?php endif; ?>><a href="#all"><?php echo __("All", THEMENAME); ?></a></li>
			<?php
				foreach($terms as $term) :
			?>
			<li <?php if($default_filter == $term->term_id) : ?>class="current"<?php endif; ?>><a href="#<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>