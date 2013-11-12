<?php global $theme; ?>
<div id="horizontal-scroll">
	<h1 class="page-title">Thương hiệu</h1>
	<?php echo do_shortcode('[ihrss-gallery type="GROUP1" w="820" h="34" speed="1" bgcolor="#FFFFFF" gap="5" random="YES"]'); ?> 
</div>

<?php if($theme->display('footer_widgets')) { ?>
    <div id="footer-widgets" class="clearfix">
    	<div class="footer-widgets-inner">
	        <?php
	        /**
	        * Footer  Widget Areas. Manage the widgets from: wp-admin -> Appearance -> Widgets 
	        */
	        /*
	        ?>
	        <div class="footer-widget-box">
	            <?php
	                if(!dynamic_sidebar('footer_1')) {
	                    $theme->hook('footer_1');
	                }
	            ?>
	        </div>
	        
	        <div class="footer-widget-box">
	            <?php
	                if(!dynamic_sidebar('footer_2')) {
	                    $theme->hook('footer_2');
	                }
	            ?>
	        </div>
	        
	        <div class="footer-widget-box footer-widget-box-last">
	            <?php
	                if(!dynamic_sidebar('footer_3')) {
	                    $theme->hook('footer_3');
	                }
	            ?>
	        </div>		
			*/ ?>
			<?php
                if(!dynamic_sidebar('footer_1')) {
                    $theme->hook('footer_1');
                }
	       ?>
		</div>

        
    </div>
<?php  } ?>
	<?php /*
    <div id="footer">
    
        <div id="copyrights">
            <?php
                if($theme->display('footer_custom_text')) {
                    $theme->option('footer_custom_text');
                } else { 
                    ?> &copy; <?php echo date('Y'); ?>  <a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a><?php
                }
            ?> 
        </div>
        <div id="credits">Powered by <a href="http://wordpress.org/"><strong>WordPress</strong></a> | Designed by: <a href="http://www.icarter4.com">carte r4</a> | Thanks to <a href="http://www.ir4isdhc.fr">r4 sdhc</a>, <a href="http://www.r4-3ds.fr">r4</a> and <a href="http://www.r4ifr.fr">r4i</a></div><!-- #credits -->
 
    </div><!-- #footer -->
    */ ?>
</div><!-- #container -->

<?php wp_footer(); ?>
<?php $theme->hook('html_after'); ?>
</body>
</html>