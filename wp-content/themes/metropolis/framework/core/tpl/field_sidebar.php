<div class="<?php if(isset($rowclass)) echo $rowclass; ?> sidebar">
	<label for="<?php if(isset($k)) echo $k; ?>_title[]"><?php if(isset($title)) echo $title; ?></label>
	<input type="text" id="<?php if(isset($k)) echo $k; ?>_title[]" name="<?php if(isset($k)) echo $k; ?>_title[]" value="<?php if(isset($v['title'])) echo $v['title']; ?>">
	<input type="hidden" id="<?php if(isset($k)) echo $k; ?>_name[]" name="<?php if(isset($k)) echo $k; ?>_name[]" value="<?php if(isset($v['name'])) echo $v['name']; ?>">
	<input type="hidden" name="<?php if(isset($k)) echo $k; ?>_ord[]" value="<?php if(isset($v['ord'])) echo $v['ord']; ?>" class="order">

	<div class="contextual">
		<span class="control remove-duplicable-item">&times;</span>
	</div>
</div>