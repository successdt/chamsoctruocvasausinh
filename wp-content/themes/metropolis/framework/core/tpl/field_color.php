<div class="<?php if(isset($rowclass)) echo $rowclass; ?>">
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>
	<input type="text" size="<?php if(isset($size)) echo $size; ?>" class="color {required:false}" id="<?php if(isset($k)) echo $k; ?>" name="<?php if(isset($k)) echo $k; ?>" value="<?php if(isset($v)) echo $v; ?>">
	<?php if(isset($help)) echo $help; ?>
</div>