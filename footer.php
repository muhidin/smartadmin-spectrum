<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the body and html tags.
 *
 * @package SmartAdmin_Spectrum
 */

?>

    <?php
    // Display widgets if available
    if ( is_active_sidebar( 'primary-sidebar' ) ) {
        echo '<aside class="site-widgets">';
        dynamic_sidebar( 'primary-sidebar' );
        echo '</aside>';
    }
    ?>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="site-info">
                <p>
                    &copy; <?php echo date('Y'); ?> 
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                    <span class="sep"> | </span>
                    <?php
                    /* translators: %s: WordPress */
                    printf( esc_html__( 'Proudly powered by %s', 'smartadmin-spectrum' ), 'WordPress' );
                    ?>
                </p>
            </div><!-- .site-info -->
        </div>
    </footer>
    <?php wp_footer(); ?>

</body>
</html>