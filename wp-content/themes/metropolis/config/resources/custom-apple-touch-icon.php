<?php 
	$icon = thb_get_option('_apple_touch_icon');
	if(!empty($icon)) : 
?>
	<link rel="apple-touch-icon" href="<?php echo $icon; ?>" />
<?php endif; ?>