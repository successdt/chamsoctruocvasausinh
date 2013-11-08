<?php global $theme; ?>

    <div <?php post_class('post post-single clearfix'); ?> id="post-<?php the_ID(); ?>">
    
        <h2 class="title sigle-post"><?php the_title(); ?></h2>
        <?php /*
        <div class="postmeta-primary">
    
            <span class="meta_date"><?php echo get_the_date(); ?></span>
           &nbsp; <span class="meta_categories"><?php the_category(', '); ?></span>
    
                <?php if(comments_open( get_the_ID() ))  {
                    ?> &nbsp; <span class="meta_comments"><?php comments_popup_link( __( 'No comments', 'themater' ), __( '1 Comment', 'themater' ), __( '% Comments', 'themater' ) ); ?></span><?php
                }
                
                if(is_user_logged_in())  {
                    ?> &nbsp; <span class="meta_edit"><?php edit_post_link(); ?></span><?php
                } ?> 
        </div>
        */ ?>
        <div class="entry clearfix">
            
            <?php
                if(has_post_thumbnail())  {
                    the_post_thumbnail(
                        array($theme->get_option('featured_image_width_single'), $theme->get_option('featured_image_height_single')),
                        array("class" => $theme->get_option('featured_image_position_single') . " featured_image")
                    );
                }
            ?>
            
            <?php
                the_content('');
                wp_link_pages( array( 'before' => '<p><strong>' . __( 'Pages:', 'themater' ) . '</strong>', 'after' => '</p>' ) );
            ?>
    
        </div>
        
        <?php if(get_the_tags()) {
                ?><div class="postmeta-secondary"><span class="meta_tags"><?php the_tags('', ', ', ''); ?></span></div><?php
            }
        ?> 
        
    
    </div><!-- Post ID <?php the_ID(); ?> -->
    
    <?php 
        if(comments_open( get_the_ID() ))  {
            comments_template('', true); 
        }
    ?> 
    	<div class="related-posts">
			<h2 class="page-title">Xem nhiều hơn</h2>
	    	<ul>
				<?php do_action(
				    'related_posts_by_category',
				    array(
				        'orderby' => 'RAND',
				        'order' => 'DESC',
				        'limit' => 5,
				        'echo' => true,
				        'before' => '<li>',
				        'inside' => '&raquo; ',
				        'outside' => '',
				        'after' => '</li>',
				        'rel' => 'nofollow',
				        'type' => 'post',
				        'message' => 'No matches'
				  	)
				) ?>		
			
			</ul>
		</div>

