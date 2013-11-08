<?php 
	$favicon = thb_get_option('_favicon');
	if(!empty($favicon)) : 
?>
	<link rel="shortcut icon" href="<?php echo $favicon; ?>" />
<?php endif; ?>