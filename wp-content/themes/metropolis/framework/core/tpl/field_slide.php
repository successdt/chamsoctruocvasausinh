<?php
	$img = "";
	$img_class = "";
	$upload_button_class = "hidden";

	if( !empty($v['src']) ) {
		$att_id = get_attachment_id($v['src']);
		$attachment = wp_get_attachment_image_src($att_id);
		$img_src = $att_id != false ? $attachment[0] : $v['src'];

		$img = thb_get_image_size($img_src, "thumbnail");
	}
	else {
		$img_class = "hidden";
		$upload_button_class = "";
	}
?>

<div class="<?php echo $rowclass; ?> slide slide-type-<?php echo $v['subtype']; ?>" data-slide-type="<?php echo $v['subtype']; ?>">
	<label id="<?php echo $k; ?>" for="<?php echo $k; ?>"><?php echo $name; ?></label>
	<input type="hidden" name="<?php echo $k; ?>_src[]" value="<?php echo $v['src']; ?>" class="image">
	<input type="hidden" name="<?php echo $k; ?>_ord[]" value="<?php echo $v['ord']; ?>" class="order">

	<div class="upload-container">
		<div class="img-container">
			<img src="<?php echo $img; ?>" alt="" class="<?php echo $img_class; ?>">
			<span class="reset-upload-btn <?php echo $img_class; ?>">&times;</span>
			<span class="upload-btn <?php echo $upload_button_class; ?>"><?php _e("Upload", THEMENAME); ?></span>
		</div>
		<div class="fields-container">
			<div class="sub-field sub-field-subtype">
				<label for="<?php echo $k; ?>_subtype"><?php _e("Type", THEMENAME); ?></label>
				<div class="select-wrapper">
					<select class="thb-input" name="<?php echo $k; ?>_subtype[]">
						<?php 
							$options = array(
								"picture" 	=> __("Picture", THEMENAME),
								"video" 	=> __("Video", THEMENAME)
							);
							
							echo getOptionsFromArray($options, $v['subtype']);
						?>
					</select>
				</div>
			</div>
			<div class="sub-field sub-field-title">
				<label for="<?php echo $k; ?>_title"><?php _e("Title", THEMENAME); ?></label>
				<input type="text" name="<?php echo $k; ?>_title[]" value="<?php echo $v['title']; ?>">
			</div>
			<div class="sub-field sub-field-url">
				<label for="<?php echo $k; ?>_url"><?php _e("URL", THEMENAME); ?></label>
				<input type="text" name="<?php echo $k; ?>_url[]" value="<?php echo $v['url']; ?>">
			</div>
			<div class="sub-field sub-field-caption">
				<label for="<?php echo $k; ?>_caption"><?php _e("Text", THEMENAME); ?></label>
				<textarea name="<?php echo $k; ?>_caption[]"><?php echo $v['caption']; ?></textarea>
			</div>
		</div>
	</div>

	<div class="contextual">
		<span class="control move-duplicable-item">&equiv;</span>
		<span class="control remove-duplicable-item">&times;</span>
	</div>
</div>