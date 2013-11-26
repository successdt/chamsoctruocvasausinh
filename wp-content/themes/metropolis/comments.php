<?php
/**
 * @package WordPress
 * @subpackage Metropolis
 * @since Metropolis 1.0
 */
?>

<?php
	$body_classes = get_custom_body_classes();
?>
<section id="comments" class="col span-<?php if( in_array("wout-sidebar", $body_classes) ) : ?>12<?php else : ?>8<?php endif; ?>">

<?php if ( post_password_required() ) : ?>
	<div class="text">
		<p><?php _e( 'This post is password protected. Enter the password to view any comments.', THEMENAME ); ?></p>
	</div>
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>
<?php if ( have_comments() ) : ?>
	<h3 id="comments-title">
	<?php _e(thb_get_option("_label_comments_heading", false, "Join the discussion"), THEMENAME); ?> <span><?php comments_number(__('No Comments', THEMENAME), __('1 Comment', THEMENAME), '% '.__('Comments', THEMENAME)); ?></span></h3>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<?php previous_comments_link( __( '&larr; Older Comments', THEMENAME ) ); ?>
		<?php next_comments_link( __( 'Newer Comments &rarr;', THEMENAME ) ); ?>
	<?php endif; // check for comment navigation ?>

	<ol class="comments-container">
		<?php
			/* Loop through and list the comments. Tell wp_list_comments()
			 * to use twentyten_comment() to format the comments.
			 * If you want to overload this in a child theme then you can
			 * define twentyten_comment() and that will be used instead.
			 * See twentyten_comment() in twentyten/functions.php for more.
			 */
			wp_list_comments( array( 'callback' => 'thb_comment' ) );
		?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<?php previous_comments_link( __( '&larr; Older Comments', THEMENAME ) ); ?>
		<?php next_comments_link( __( 'Newer Comments &rarr;', THEMENAME ) ); ?>
	<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) : ?>
		<div class="text">
			<p><?php _e( 'Comments are closed.', THEMENAME ); ?></p>
		</div>
	<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>
</section>