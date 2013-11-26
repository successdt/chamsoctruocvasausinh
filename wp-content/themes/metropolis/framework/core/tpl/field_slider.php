<div class="<?php if(isset($rowclass)) echo $rowclass; ?>">
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>
	<span class="clear"></span>
	<div class="slider-container">
		<div class="slider"></div>
		<input type="text" class="amount" id="<?php if(isset($k)) echo $k; ?>" name="<?php if(isset($k)) echo $k; ?>" />
	</div>
	<?php if(isset($help)) echo $help; ?>
</div>