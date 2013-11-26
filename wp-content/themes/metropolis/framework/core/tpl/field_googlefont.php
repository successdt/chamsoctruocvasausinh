<div class="<?php if(isset($rowclass)) echo $rowclass; ?> googlefont <?php echo $basekey; ?>" data-switch='<?php if(isset($dataswitch)) echo $dataswitch; ?>'>

	<label for="<?php if(isset($k)) echo $k; ?>" id="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>

	<div class="font-face-container">
		<label for="<?php if(isset($k)) echo $k; ?>_family"><?php if(isset($family)) echo $family; ?></label>
		<?php
			$value = get_option($k.'_color');
		?>
		<div class="select-wrapper">
			<select name="<?php if(isset($k)) echo $k; ?>" id="<?php if(isset($k)) echo $k; ?>" class="fontface thb-input">
				<?php echo getStructuredOptionsFromArray($options, $v); ?>
			</select>
		</div>
	</div>
	
	<div class="font-options-container">

		<div class="font-weight">
			<label for="<?php if(isset($k)) echo $k; ?>_weight"><?php if(isset($weight)) echo $weight; ?></label>
			<?php
				$value = get_option($k.'_weight');
			?>
			<span class="weight-switchbutton btn bold" data-value="<?php echo $value; ?>" data-name="<?php if(isset($k)) echo $k; ?>_weight" data-values="normal,bold">B</span>
		</div>
		
		<div class="font-style">
			<label for="<?php if(isset($k)) echo $k; ?>_style"><?php if(isset($style)) echo $style; ?></label>
			<?php
				$value = get_option($k.'_style');
			?>
			<span class="style-switchbutton btn italic" data-value="<?php echo $value; ?>" data-name="<?php if(isset($k)) echo $k; ?>_style" data-values="normal,italic">I</span>
		</div>
		
		<div class="font-size">
			<label for="<?php if(isset($k)) echo $k; ?>_size"><?php if(isset($size)) echo $size; ?></label>
			<?php
				$value = get_option($k.'_size');
			?>
			<div class="number-wrapper">
				<input size="2" type="text" name="<?php if(isset($k)) echo $k; ?>_size" value="<?php if(isset($value)) echo $value; ?>" class="numberfield">
			</div>
		</div>

		<div class="font-lineheight">
			<label for="<?php if(isset($k)) echo $k; ?>_lineheight"><?php if(isset($lineheight)) echo $lineheight; ?></label>
			<?php
				$value = get_option($k.'_lineheight');
			?>
			<div class="number-wrapper">
				<input size="2" data-min="0.0" data-step="0.05" type="text" name="<?php if(isset($k)) echo $k; ?>_lineheight" value="<?php if(isset($value)) echo $value; ?>" class="numberfield">
			</div>
		</div>

		<div class="font-color">
			<label for="<?php if(isset($k)) echo $k; ?>_color">Color</label>
			<?php
				$value = get_option($k.'_color');
			?>
			<input size="5" type="text" class="color {required:false}" id="<?php if(isset($k)) echo $k; ?>_color" name="<?php if(isset($k)) echo $k; ?>_color" value="<?php if(isset($value)) echo $value; ?>">
		</div>
		
	</div><!-- /.font-options-container -->

	<div class="fontpreview">
		Font preview
	</div>
	

	<?php // if(isset($help)) echo $help; ?>

</div>