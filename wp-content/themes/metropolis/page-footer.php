<?php
	$footer_layout_columns_number = thb_get_option("_footer_columns_number");
	$footer_layout_columns_layout = explode(",", thb_get_option("_footer_columns_layout"));

	if( $footer_layout_columns_number == 0 )
		return;

	$display_footer = false;
	for( $i=1; $i<=$footer_layout_columns_number; $i++ ) {
		if( !$display_footer && is_active_sidebar('footer-widget-area-' . $i) )
			$display_footer = true;
	}

	if( !$display_footer )
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

<div id="footer-sidebar" class="extended-container">
	<section class="sidebar box-col span-12">

		<?php $i=1; foreach( $footer_layout_columns_layout as $class ) : ?>
			<?php if( is_active_sidebar('footer-widget-area-' . $i) ) : ?>
				<section class="col <?php echo $spans[$class]; ?>">
					<?php dynamic_sidebar( 'footer-widget-area-' . $i ); ?>
				</section>
			<?php endif; ?>
		<?php $i++; endforeach; ?>

	</section>
</div>