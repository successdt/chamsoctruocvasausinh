<?php
	$tab = 1;
	if( isset($_GET['tab']) )
		$tab = $_GET['tab'];
?>
<div class="hb-content">
	<div id="section-<?php echo $index; ?>" class="hb-section <?php echo $tab == $index ? 'on' : ''; ?>">
		<form method="post" enctype="multipart/form-data" action="<?php echo $action; ?>?page=<?php echo $page; ?>&amp;tab=<?php echo $index; ?>">
			<input type="hidden" name="thb_admin_page_saved" value="1">