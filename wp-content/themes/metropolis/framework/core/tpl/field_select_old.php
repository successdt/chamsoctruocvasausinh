<div class="<?php if(isset($rowclass)) echo $rowclass; ?>" data-switch='<?php if(isset($dataswitch)) echo $dataswitch; ?>'>
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>
	<select name="<?php if(isset($k)) echo $k; ?>" id="<?php if(isset($k)) echo $k; ?>">
		<?php foreach($options as $key => $value) : ?>
			<?php
				$selected = "";
				if($v == $key)
					$selected = " selected";
			?>
			<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
		<?php endforeach; ?>
	</select>
	<?php if(isset($help)) echo $help; ?>
</div>