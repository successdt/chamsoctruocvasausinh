<?php
	$template_directory = get_template_directory_uri();
?>
<script type="text/javascript" src="<?php echo $template_directory; ?>/js/jquery.validate.pack.js"></script>
<script type="text/javascript" src="<?php echo $template_directory; ?>/js/jquery.form.js"></script>
<script type="text/javascript">
	$j(document).ready(function() {
		thb_validate();
	});
</script>
<form class="contact-form" method="post" action="">
	<span id="name">
		<label for="contact_name"><?php echo __("Your name", THEMENAME); ?></label>
		<input type="text" name="contact_name" value="<?php if(isset($mail_message['contact_name'])) echo $mail_message['contact_name']; ?>" class="required" />
	</span>	
	<span id="email">
		<label for="contact_email"><?php echo __("Your email", THEMENAME); ?></label>
		<input type="text" name="contact_email" value="<?php if(isset($mail_message['contact_email'])) echo $mail_message['contact_email']; ?>" class="required email" />
	</span>

	<span id="message">
		<label for="contact_message"><?php echo __("Message", THEMENAME); ?></label>
		<textarea name="contact_message" rows="7" cols="" class="required"><?php if(isset($mail_message['contact_message'])) echo $mail_message['contact_message']; ?></textarea>
	</span>
	<input type="submit" value="<?php echo __("Send", THEMENAME); ?>" id="submit" class="medium" />
</form>
<div id="result"></div>