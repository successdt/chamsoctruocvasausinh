<?php
	$tab = 1;
	if( isset($_GET['tab']) )
		$tab = $_GET['tab'];
?>
<div class="hb-nav">
	<ul>
		<?php
			$i=1;
			foreach($sections as $key => $value) :
			$section_slug = thb_make_slug($key);
		?>
		<li class="<?php echo $tab == $i ? 'active' : ''; ?>">
			<a href="#section-<?php echo $i; ?>"><img src="<?php echo $pageimage.$section_slug.$pageimage_ext; ?>" alt="" /><?php echo $key; ?></a>
			<span></span>
		</li>
		<?php $i++; endforeach; ?>
	</ul>
</div>