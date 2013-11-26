<div id="hb-wrapper" class="admin-page <?php echo $_GET['page']; ?>">
	<?php if(isset($message)) echo $message; ?>
	<div id="hb-header">
		<h2>
			<?php if(isset($themename)) echo $themename; ?>
			<?php if(isset($pagetitle) && isset($themename) && $pagetitle != '' && $pagetitle != $themename) : ?>
				&raquo; <?php echo $pagetitle; ?>
			<?php endif; ?>
		</h2>
		<p>version <?php if(isset($themeversion)) echo $themeversion; ?></p>
	</div>
	<div class="hb-panel <?php if(isset($pagetype)) echo $pagetype; ?>-page">
		<?php if(isset($content)) echo $content; ?>
	</div>
	<div id="hb-credits">
		<p><?php if(isset($frameworkname)) echo $frameworkname; ?>, v.<?php if(isset($frameworkversion)) echo $frameworkversion; ?></p>
	</div>
</div>