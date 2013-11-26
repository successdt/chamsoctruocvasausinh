<div class="<?php if(isset($rowclass)) echo $rowclass; ?> font" data-switch='<?php if(isset($dataswitch)) echo $dataswitch; ?>'>

	<label for="<?php if(isset($k)) echo $k; ?>" id="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>

	<label for="<?php if(isset($k)) echo $k; ?>_family"><?php if(isset($family)) echo $family; ?></label>
	<?php
		$value = get_option($k.'_color');
	?>
	<select name="<?php if(isset($k)) echo $k; ?>" id="<?php if(isset($k)) echo $k; ?>" class="fontface">
		<?php foreach($options as $key => $value) : ?>
			<?php
				$selected = "";
				if($v == $key)
					$selected = " selected";
			?>
			<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
		<?php endforeach; ?>
	</select>

	
	<div class="font-options-container">

		<div class="font-weight">
			<label for="<?php if(isset($k)) echo $k; ?>_weight"><?php if(isset($weight)) echo $weight; ?></label>
			<?php
				$value = get_option($k.'_weight');
			?>
			<select name="<?php if(isset($k)) echo $k; ?>_weight" id="<?php if(isset($k)) echo $k; ?>_weight">
				<option value="normal" <?php echo $value=="normal" ? "selected" : ""; ?>>Normal</option>
				<option value="bold" <?php echo $value=="bold" ? "selected" : ""; ?>>Bold</option>
			</select>
		</div>
		
		<div class="font-style">
			<label for="<?php if(isset($k)) echo $k; ?>_style"><?php if(isset($style)) echo $style; ?></label>
			<?php
				$value = get_option($k.'_style');
			?>
			<select name="<?php if(isset($k)) echo $k; ?>_style" id="<?php if(isset($k)) echo $k; ?>_style">
				<option value="normal" <?php echo $value=="normal" ? "selected" : ""; ?>>Normal</option>
				<option value="italic" <?php echo $value=="italic" ? "selected" : ""; ?>>Italic</option>
			</select>
		</div>
		
		<div class="font-size">
			<label for="<?php if(isset($k)) echo $k; ?>_size"><?php if(isset($size)) echo $size; ?></label>
			<?php
				$value = get_option($k.'_size');
			?>
			<input type="text" name="<?php if(isset($k)) echo $k; ?>_size" value="<?php if(isset($value)) echo $value; ?>" size="6">
		</div>
		
	</div><!-- /.font-options-container -->

	<div class="fontpreview">
		<p class="support"></p>
	</div>
	

	<?php // if(isset($help)) echo $help; ?>

</div>