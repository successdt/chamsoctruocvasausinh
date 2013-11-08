<div class="<?php if(isset($rowclass)) echo $rowclass; ?> customfont">
	<label for="<?php if(isset($k)) echo $k; ?>_title[]"><?php if(isset($title)) echo $title; ?></label>

	<?php
		$display = !empty($v['url']) ? "none" : "block";
	?>

	<input type="file" name="<?php echo THEMEPREFIX . '_customfont[]'; ?>" style="display: <?php echo $display; ?>" />

	<?php if( $display == "none" ) : ?>
		<span class="families">
			<?php 
				$families = unserialize(htmlspecialchars_decode($v['caption']));
				echo implode(", ", $families);
			?>
		</span>
	<?php endif; ?>

	<input type="hidden" id="<?php if(isset($k)) echo $k; ?>_title[]" name="<?php if(isset($k)) echo $k; ?>_title[]" value="<?php if(isset($v['title'])) echo $v['title']; ?>">
	<input type="hidden" id="<?php if(isset($k)) echo $k; ?>_url[]" name="<?php if(isset($k)) echo $k; ?>_url[]" value="<?php if(isset($v['url'])) echo $v['url']; ?>">
	<input type="hidden" id="<?php if(isset($k)) echo $k; ?>_caption[]" name="<?php if(isset($k)) echo $k; ?>_caption[]" value="<?php if(isset($v['caption'])) echo $v['caption']; ?>">
	<input type="hidden" id="<?php if(isset($k)) echo $k; ?>_name[]" name="<?php if(isset($k)) echo $k; ?>_name[]" value="<?php if(isset($v['name'])) echo $v['name']; ?>">
	<input type="hidden" name="<?php if(isset($k)) echo $k; ?>_ord[]" value="<?php if(isset($v['ord'])) echo $v['ord']; ?>" class="order">

	<div class="contextual">
		<span class="control remove-duplicable-item">&times;</span>
	</div>
</div>