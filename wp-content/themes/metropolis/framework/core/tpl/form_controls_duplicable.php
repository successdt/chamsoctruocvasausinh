<div class="hb-apply <?php if(isset($position)) echo $position; ?>">	
	<div class="hb-add">
		<input type="button" class="add-btn" value="+" data-status="" data-template="<?php if(isset($template)) echo $template; ?>" />
	</div>
	<div class="hb-save">
		<input type="submit" name="save" class="button-primary" value="<?php if(isset($save)) echo $save; ?>" />
	</div>
</div>