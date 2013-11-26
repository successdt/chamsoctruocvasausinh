<div class="<?php if(isset($rowclass)) echo $rowclass; ?> stripe">
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>

	<div class="select-wrapper">
		<select class="thb-input columns-number" name="<?php if(isset($k)) echo $k; ?>_columns_number">
			<?php
				$options = array(
					0 => "&mdash; No",
					1 => "1 column",
					2 => "2 columns",
					3 => "3 columns",
					4 => "4 columns"
				);
				echo getOptionsFromArray($options, get_option($k . "_columns_number"));
			?>
		</select>
	</div>
	
	<?php if(isset($help)) echo $help; ?>

	<div class="select-wrapper select-wrapper-columns-layout">
		<select class="thb-input columns-layout" name="<?php if(isset($k)) echo $k; ?>_columns_layout" data-selected="<?php echo get_option($k . "_columns_layout"); ?>"></select>
	</div>
	
</div>