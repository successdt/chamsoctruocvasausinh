<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 * Template Name: Contact
 */

/*
 * Send mail script.
 */
$mail_message = send_mail();
if(!empty($mail_message)) : ?>
	<div class="notice <?php echo $mail_message['type']; ?>">
		<p><?php echo $mail_message['message']; ?></p>
	</div>
<?php
die();

endif;

get_header();

$page_id = get_the_ID();
$sidebar = thb_get_post_meta($page_id, "_page_sidebar");

$pagetitle = get_the_title();
$pagesubtitle =  thb_get_post_meta($page_id, "_page_subtitle");

$address = thb_get_option("_contact_address");
$phone = thb_get_option("_contact_phone");
$mobile = thb_get_option("_contact_mobile");
$fax = thb_get_option("_contact_fax");
$email = thb_get_option("_contact_email");
$latlong = thb_get_option('_contact_lat_long');
$zoom = thb_get_option("_gmap_zoom");

?>
	<?php get_template_part("loop/page-header"); ?>
	
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			
	<?php if(get_the_content() != "") : ?>
		<div class="text">
			<?php the_content(); ?>
		</div>
	<?php endif; ?>

	<?php // Map ========================================================================

		if( !empty($latlong) ) {

			thb_component('map', array(
				'latlong' => $latlong,
				'address' => str_replace(array("\r\n", "\n", "\r"), " ", $address),
				'zoom' => empty($zoom) ? 10 : $zoom
			));

		}
	?>

	<?php if( !empty($address) || !empty($phone) || !empty($mobile) || !empty($fax) || !empty($email) ) : ?>
	<div id="address" class="content-one-third">
		<h3><?php _e("Contact info", THEMENAME); ?></h3>
		<?php if( contact_field_check() ) : ?>
			<div class="contact">
				<?php echo apply_filters('the_content', $address); ?>
				<dl>
					<?php if( !empty($phone) ) { ?>
						<dt><?php _e("Phone: ", THEMENAME); ?></dt>
						<dd><?php echo $phone; ?></dd>
					<?php } ?>
					<?php if( !empty($mobile) ) { ?>
						<dt><?php _e("Mobile: ", THEMENAME); ?></dt>
						<dd><?php echo $mobile; ?></dd>
					<?php } ?>
					<?php if( !empty($fax) ) { ?>
						<dt><?php _e("Fax: ", THEMENAME); ?></dt>
						<dd><?php echo $fax; ?></dd>
					<?php } ?>
					<?php if( !empty($email) ) { ?>
						<dt><?php _e("Email: ", THEMENAME); ?></dt>
						<dd><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></dd>		
					<?php } ?>
				</dl>
			</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<div id="contactform" class="secondary <?php if( !empty($address) || !empty($phone) || !empty($mobile) || !empty($fax) || !empty($email) ) : ?>content-two-third last<?php else : ?>content-full<?php endif; ?>">
		<h3><?php _e("Send a message", THEMENAME); ?></h3>
		<?php get_template_part("config/resources/contact-form"); ?>
	</div>

<?php endwhile; endif; ?>

	</div><!-- closing the content section -->
</section><!-- closing the content-wrapper section -->

	<?php if( !empty($sidebar) ) thb_get_sidebar($sidebar); ?>

<?php get_footer(); ?>