<?php
	$img = "";
	$img_class = "";
	$upload_button_class = "hidden";

	if( !empty($v) )
		$img = thb_get_image_size($v, "thumbnail");
	else {
		$img_class = "hidden";
		$upload_button_class = "";
	}
?>

<div class="<?php echo $rowclass; ?> upload" id="<?php if(isset($k)) echo $k; ?>">
	<label for="<?php echo $k; ?>"><?php echo $name; ?></label>
	<input type="hidden" name="<?php echo $k; ?>" value="<?php echo $v; ?>" class="image">

	<div class="upload-container">
		<div class="img-container">
			<img src="<?php echo $img; ?>" alt="" class="<?php echo $img_class; ?>">
			<span class="reset-upload-btn <?php echo $img_class; ?>">&times;</span>
			<span class="upload-btn <?php echo $upload_button_class; ?>"><?php _e("Upload", THEMENAME); ?></span>
		</div>
	</div>

	<?php echo $help; ?>
</div>