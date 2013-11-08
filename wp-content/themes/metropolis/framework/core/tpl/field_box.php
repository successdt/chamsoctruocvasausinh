<div class="<?php if(isset($rowclass)) echo $rowclass; ?> box">
	<label for="<?php if(isset($k)) echo $k; ?>" id="<?php if(isset($k)) echo $k; ?>"><?php if(isset($name)) echo $name; ?></label>

	<label for="<?php if(isset($k)) echo $k; ?>_text"><?php if(isset($text)) echo $text; ?></label>
	<?php
		$value = get_option($k.'_text');
	?>
	<input type="text" name="<?php if(isset($k)) echo $k; ?>_text" value="<?php echo thb_getvalue($value); ?>">

	<?php if(isset($help)) echo $help; ?>
	
	<span class="clear"></span>
	
	<label for="<?php if(isset($k)) echo $k; ?>_buttontext"><?php if(isset($buttontext)) echo $buttontext; ?></label>
	<?php
		$value = get_option($k.'_buttontext');
	?>
	<input type="text" name="<?php if(isset($k)) echo $k; ?>_buttontext" value="<?php echo thb_getvalue($value); ?>">
	
	<label for="<?php if(isset($k)) echo $k; ?>_target"><?php if(isset($target)) echo $target; ?></label>
	<select name="<?php if(isset($k)) echo $k; ?>_target"><?php echo getPagesOptions($k.'_target'); ?></select>

	<label for="<?php if(isset($k)) echo $k; ?>_url"><?php if(isset($url)) echo $url; ?></label>
	<?php
		$value = get_option($k.'_url');
	?>
	<input type="text" name="<?php if(isset($k)) echo $k; ?>_url" value="<?php echo thb_getvalue($value); ?>">
</div>