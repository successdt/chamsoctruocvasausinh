<?php
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	case '' :
?>

<li id="li-comment-<?php comment_ID(); ?>">
	<?php
		$is_admin = (1 == $comment->user_id);
		
		$class = "";
		if($is_admin) {
			$class .= " admin";
		}

		$args['reply_text'] = __('&mdash; Reply', THEMENAME);
	?>
	<section id="comment-<?php comment_ID(); ?>" class="comment <?php echo $class; ?>">
		<div class="comment_leftcol">
			<?php echo get_avatar( $comment, 40 ); ?>
		</div>
		<div class="comment_rightcol">
			<div class="comment_head">
				<p><span class="user"><?php echo get_comment_author_link(); ?></span> <?php printf( __('%1$s at %2$s', THEMENAME), get_comment_date(),  get_comment_time() ); ?> <?php echo get_comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></p>
			</div>
			<div class="comment_body">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p><em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', THEMENAME); ?></em></p>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
		</div>
	</section>
</li>

<?php
	break;
	case 'pingback'  :
	case 'trackback' :
?>
<li class="post pingback">
	<p><?php _e( 'Pingback:', THEMENAME); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', THEMENAME), ' ' ); ?></p>

<?php
	break;
	endswitch;
?>