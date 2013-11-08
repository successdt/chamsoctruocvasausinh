<?php
	$top_sidebar_layout_columns_number = thb_get_option("_top_sidebar_columns_number");
	$top_sidebar_layout_columns_layout = explode(",", thb_get_option("_top_sidebar_columns_layout"));

	if( $top_sidebar_layout_columns_number == 0 )
		return;

	$display_top_sidebar = false;
	for( $i=1; $i<=$top_sidebar_layout_columns_number; $i++ ) {
		if( !$display_top_sidebar && is_active_sidebar('top-page-widget-area-' . $i) )
			$display_top_sidebar = true;
	}

	if( !$display_top_sidebar )
		return;

	$spans = array(
		"full"         => "span-12",
		"one-fourth"   => "span-3",
		"two-fourth"   => "span-6",
		"one-half"     => "span-6",
		"three-fourth" => "span-9",
		"one-third"    => "span-4",
		"two-third"    => "span-8"
	);

?>

<div id="page-top-sidebar" class="extended-container">
	<section class="sidebar box-col span-12">

		<?php $i=1; foreach( $top_sidebar_layout_columns_layout as $class ) : ?>
			<?php if( is_active_sidebar('top-page-widget-area-' . $i) ) : ?>
				<section class="col <?php echo $spans[$class]; ?>">
					<?php dynamic_sidebar( 'top-page-widget-area-' . $i ); ?>
				</section>
			<?php endif; ?>
		<?php $i++; endforeach; ?>

	</section>
</div>