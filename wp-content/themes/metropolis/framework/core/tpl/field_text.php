<div class="<?php if(isset($rowclass)) echo $rowclass; ?>" id="<?php if(isset($k)) echo $k; ?>">
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>
	<input type="text" <?php if(isset($size)) : ?>size="<?php echo $size; ?>"<?php endif; ?> name="<?php if(isset($k)) echo $k; ?>" value="<?php if(isset($v)) echo $v; ?>">
	<?php if(isset($help)) echo $help; ?>
</div>