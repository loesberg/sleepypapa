<?php if ( 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) return; ?>

    <section id="comments">
        <?php 
        if ( have_comments() ) : 
        global $comments_by_type;
        $comments_by_type = &separate_comments( $comments );
        if ( ! empty( $comments_by_type['comment'] ) ) : 
        ?>

        <section id="comments-list" class="comments">
            <h3 class="comments-title"><?php comments_number(); ?></h3><?php if ( get_comment_pages_count() > 1 ) : ?>

            <nav id="comments-nav-above" class="comments-navigation" role="navigation">
                <div class="paginated-comments-links">
                    <?php paginate_comments_links(); ?>
                </div>
            </nav><?php endif; ?>

            <ul>
                <?php wp_list_comments( 'type=comment' ); ?>
            </ul><?php if ( get_comment_pages_count() > 1 ) : ?>

            <nav id="comments-nav-below" class="comments-navigation" role="navigation">
                <div class="paginated-comments-links">
                    <?php paginate_comments_links(); ?>
                </div>
            </nav><?php endif; ?>
        </section><?php 
        endif; 
        if ( ! empty( $comments_by_type['pings'] ) ) : 
        $ping_count = count( $comments_by_type['pings'] ); 
        ?>

        <section id="trackbacks-list" class="comments">
            <h3 class="comments-title"><?php echo '<span class="ping-count">' . $ping_count . '</span> ' . ( $ping_count > 1 ? __( 'Trackbacks', 'lsk' ) : __( 'Trackback', 'lsk' ) ); ?></h3>

            <ul>
                <?php wp_list_comments( 'type=pings&callback=lsk_custom_pings' ); ?>
            </ul>
        </section><?php 
        endif; 
        endif;
        if ( comments_open() ) {
	        
	        $args = array(
		        'fields' => array(
			      'author' => '<p><input id="author" placeholder="Name*" name="author" type="text" value="" size="30" maxlength="245" aria-required="true" required="required"></p>',
			      'email' => '<p><input id="email" placeholder="Email*" name="email" type="text" value="" size="30" maxlength="100" aria-describedby="email-notes" aria-required="true" required="required"></p>',
			      'url' => '<p><input id="url" placeholder="Website" name="url" type="text" value="" size="30" maxlength="200"></p>',  
		        ),
		        'comment_field' => '<p><textarea id="comment" placeholder="Comment*" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea></p>',
	        );
  	      comment_form($args);
        }
        
        
        ?>
    </section>
