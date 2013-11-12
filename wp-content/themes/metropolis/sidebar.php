<?php if (function_exists('dynamic_sidebar') && is_active_sidebar( $sidebar ) ) : ?>
	<aside id="<?php echo $type; ?>-sidebar" class="box-col span-4 sidebar <?php echo $class; ?>">
		<div class="col span-4">		
			<?php dynamic_sidebar($sidebar); ?>
		</div>
	</aside>
<?php endif; ?>