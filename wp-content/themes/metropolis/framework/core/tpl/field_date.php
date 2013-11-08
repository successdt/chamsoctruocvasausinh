<div class="<?php if(isset($rowclass)) echo $rowclass; ?>" id="<?php if(isset($k)) echo $k; ?>">
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>

	<input 
		type="text" 
		name="<?php if(isset($k)) echo $k; ?>" 
		value="<?php if(isset($v)) echo $v; ?>" 
		class="date" 
		size="8"
	>

	<?php if(isset($help)) echo $help; ?>
</div>