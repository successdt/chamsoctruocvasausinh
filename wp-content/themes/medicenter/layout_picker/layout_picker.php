<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/layout_picker/layout_picker.css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/layout_picker/layout_picker.js"></script>
<div class="layout_picker">
	<div class="layout_picker_icon">
		&nbsp;
	</div>
	<div class="layout_picker_content">
		<h3 class="layout_picker_header"><?php _e("Layout", 'medicenter'); ?></h3>
		<ul class="layout_picker_layout_list">
			<li>
				<a href="#" id="layout_picker_fw"<?php echo (!isset($_COOKIE['mc_layout']) || $_COOKIE['mc_layout']=="" ? ' class="selected"' : ''); ?>>
					<?php _e("Wide", 'medicenter'); ?>
				</a>
			</li>
			<li>
				<a href="#" id="layout_picker_bx"<?php echo ($_COOKIE['mc_layout']=="boxed" ? ' class="selected"' : ''); ?>>
					<?php _e("Boxed", 'medicenter'); ?>
				</a>
			</li>
		</ul>
		<h3 class="layout_picker_header"><?php _e("Color Skin", 'medicenter'); ?></h3>
		<?php
		$site_url_explode = explode("/", site_url());
		$current = array_pop($site_url_explode);
		$site_url = implode("/", $site_url_explode) . "/";
		?>
		<ul class="color_skin_list">
			<li>
				<a href="<?php echo $site_url; ?>medicenter/" class="mc_skin_blue<?php echo ($current=="medicenter" ? ' selected' : ''); ?>"></a>
			</li>
			<li>
				<a href="<?php echo $site_url; ?>medicenter-green/" class="mc_skin_green<?php echo ($current=="medicenter-green" ? ' selected' : ''); ?>"></a>
			</li>
			<li class="last">
				<a href="<?php echo $site_url; ?>medicenter-orange/" class="mc_skin_orange<?php echo ($current=="medicenter-orange" ? ' selected' : ''); ?>"></a>
			</li>
			<li>
				<a href="<?php echo $site_url; ?>medicenter-red/" class="mc_skin_red<?php echo ($current=="medicenter-red" ? ' selected' : ''); ?>"></a>
			</li>
			<li>
				<a href="<?php echo $site_url; ?>medicenter-turquoise/" class="mc_skin_turquoise<?php echo ($current=="medicenter-turquoise" ? ' selected' : ''); ?>"></a>
			</li>
			<li class="last">
				<a href="<?php echo $site_url; ?>medicenter-violet/" class="mc_skin_violet<?php echo ($current=="medicenter-violet" ? ' selected' : ''); ?>"></a>
			</li>
		</ul>
	</div>
</div>
