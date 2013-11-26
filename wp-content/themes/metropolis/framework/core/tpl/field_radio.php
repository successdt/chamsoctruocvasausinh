<div class="<?php if(isset($rowclass)) echo $rowclass; ?>">
	<label for="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>
	<span class="clear"></span>
	<div class="radio-container <?php if(isset($divclass)) echo $divclass; ?>">
		
	<?php $i=1; ?>
	<?php foreach($options as $key => $value) : ?>
		<?php
			$checked="";
			if($v == $key)
				$checked = " checked";
		?>
		<div class="radio-opt">
			<?php if(isset($value['image']) && $value['image'] != '') : ?>
				<img src="<?php echo $value['image']; ?>" alt="" title="<?php echo isset($value['name']) ? $value['name'] : ""; ?>" />					
			<?php endif; ?>
			<input type="radio" id="<?php if(isset($k)) echo $k; ?>-<?php echo $i; ?>" name="<?php if(isset($k)) echo $k; ?>" value="{$key}" <?php echo $checked; ?>>
			<p><?php echo isset($value['name']) ? $value['name'] : ""; ?></p>	
		</div>
		<?php $i++; ?>
	<?php endforeach; ?>
	
	</div>
	
	<?php if(isset($help)) echo $help; ?>
</div>