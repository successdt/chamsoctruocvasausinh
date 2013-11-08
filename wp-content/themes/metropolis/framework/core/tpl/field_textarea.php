<div class="<?php if(isset($rowclass)) echo $rowclass; ?>" id="<?php if(isset($k)) echo $k; ?>">
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>
	<textarea name="<?php if(isset($k)) echo $k; ?>" rows="<?php if(isset($rows)) echo $rows; ?>" class="<?php echo $textareaclass; ?>"><?php if(isset($v)) echo $v; ?></textarea>
	<?php if(isset($help)) echo $help; ?>
</div>