<div class="<?php if(isset($rowclass)) echo $rowclass; ?>">
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>
	<input type="hidden" name="<?php if(isset($k)) echo $k; ?>" value="0">
	<input type="checkbox" id="<?php if(isset($k)) echo $k; ?>" name="<?php if(isset($k)) echo $k; ?>" value="1" <?php if(isset($checked)) echo $checked; ?>>
	
	<?php if(isset($help)) echo $help; ?>
</div>