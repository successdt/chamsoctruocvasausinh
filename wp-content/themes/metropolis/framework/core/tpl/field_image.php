<div class="<?php if(isset($rowclass)) echo $rowclass; ?>">
	<div class="img-container">
		<img src="<?php if(isset($thumb)) echo $thumb; ?>" alt="" <?php if(isset($v) && $v == '') : ?>style="display:none"<?php endif; ?>>
	</div>
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>
	<input type="text" id="<?php if(isset($k)) echo $k; ?>" name="<?php if(isset($k)) echo $k; ?>" value="<?php if(isset($v)) echo $v; ?>" class="image">
	<?php if(isset($help)) echo $help; ?>
</div>