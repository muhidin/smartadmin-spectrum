<?php
if ( post_password_required() ) { return; }
?>
<div id="comments" class="comments-area container">
    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php echo esc_html( get_comments_number() ) . ' Comments'; ?>
        </h2>
        <ul class="comment-list">
            <?php wp_list_comments( array( 'style' => 'ul', 'short_ping' => true ) ); ?>
        </ul>
        <?php the_comments_navigation(); ?>
    <?php endif; ?>

    <?php if ( ! comments_open() ) : ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'smartadmin_spectrum' ); ?></p>
    <?php endif; ?>

    <?php comment_form(); ?>
</div>