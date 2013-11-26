<div class="<?php if(isset($rowclass)) echo $rowclass; ?>" id="<?php if(isset($k)) echo $k; ?>">
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>

	<div class="number-wrapper">
		<input 
			type="text" 
			name="<?php if(isset($k)) echo $k; ?>" 
			value="<?php if(isset($v)) echo $v; ?>" 
			class="numberfield" 
			size="4"
			<?php if(isset($param_min)) : ?>data-min="<?php echo $param_min; ?>"<?php endif; ?>
			<?php if(isset($param_max)) : ?>data-max="<?php echo $param_max; ?>"<?php endif; ?>
			<?php if(isset($param_step)) : ?>data-step="<?php echo $param_step; ?>"<?php endif; ?>
		>
	</div>

	<?php if(isset($help)) echo $help; ?>
</div>