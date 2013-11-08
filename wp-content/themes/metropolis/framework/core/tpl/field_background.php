<div class="<?php if(isset($rowclass)) echo $rowclass; ?> background" data-context="<?php if(isset($k)) echo $k; ?>">
	<label for="<?php if(isset($k)) echo $k; ?>" id="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>

	<div class="colorstyle-container">
		<div class="color-background">
			<label for="<?php if(isset($k)) echo $k; ?>_background_color"><?php if(isset($color)) echo $color; ?></label>
			<?php $value = get_option($k.'_background_color'); ?>
			<input type="text" size="6" class="backgroundcolor color {required:false}" id="<?php if(isset($k)) echo $k; ?>_background_color" name="<?php if(isset($k)) echo $k; ?>_background_color" value="<?php if(isset($value)) echo $value; ?>">
		</div>

		<div class="color-pattern">
			<label for="<?php if(isset($k)) echo $k; ?>_pattern"><?php if(isset($pattern)) echo $pattern; ?></label>
			<?php
				$value = get_option($k.'_pattern');
			?>
			<select name="<?php if(isset($k)) echo $k; ?>_pattern" class="pattern">
				<option value="">- NO PATTERN/TEXTURE</option>
				<optgroup label="Patterns">
					<?php
						$images = getFiles(PATTERNS);
						$options = array();
						foreach($images as $image)
							$options[PATTERNSURL . "/" . $image] = normalizeFileName($image);

						echo getOptionsFromArray($options, $value);
					?>
				</optgroup>
				<optgroup label="Textures">
					<?php
						$images = getFiles(BACKGROUNDS);
						$options = array();
						foreach($images as $image)
							$options[BACKGROUNDSURL . "/" . $image] = normalizeFileName($image);

						echo getOptionsFromArray($options, $value);
					?>
				</optgroup>
			</select>
		</div>
	</div>

	<div class="colorstyle-container">
		<div class="color-text">
			<label for="<?php if(isset($k)) echo $k; ?>_color_text"><?php if(isset($text)) echo $text; ?></label>
			<?php $value = get_option($k.'_color_text'); ?>
			<input type="text" size="6" class="color {required:false}" id="<?php if(isset($k)) echo $k; ?>_color_text" name="<?php if(isset($k)) echo $k; ?>_color_text" value="<?php if(isset($value)) echo $value; ?>">
		</div>
		<div class="color-headline">
			<label for="<?php if(isset($k)) echo $k; ?>_color_headline"><?php if(isset($headline)) echo $headline; ?></label>
			<?php $value = get_option($k.'_color_headline'); ?>
			<input type="text" size="6" class="color {required:false}" id="<?php if(isset($k)) echo $k; ?>_color_headline" name="<?php if(isset($k)) echo $k; ?>_color_headline" value="<?php if(isset($value)) echo $value; ?>">
		</div>
		<div class="color-link">
			<label for="<?php if(isset($k)) echo $k; ?>_color_link"><?php if(isset($link)) echo $link; ?></label>
			<?php $value = get_option($k.'_color_link'); ?>
			<input type="text" size="6" class="color {required:false}" id="<?php if(isset($k)) echo $k; ?>_color_link" name="<?php if(isset($k)) echo $k; ?>_color_link" value="<?php if(isset($value)) echo $value; ?>">
		</div>
		<div class="color-hover">
			<label for="<?php if(isset($k)) echo $k; ?>_color_hover"><?php if(isset($hover)) echo $hover; ?></label>
			<?php $value = get_option($k.'_color_hover'); ?>
			<input type="text" size="6" class="color {required:false}" id="<?php if(isset($k)) echo $k; ?>_color_hover" name="<?php if(isset($k)) echo $k; ?>_color_hover" value="<?php if(isset($value)) echo $value; ?>">
		</div>
	</div>

	<div class="preview">
		<span class="text">a</span><span class="headline">h</span><a class="link">s</a>
	</div>

	<?php // if(isset($help)) echo $help; ?>
</div>