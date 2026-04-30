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

    <?php
    // Get footer customization settings
    $footer_display_mode = get_theme_mod( 'smartadmin_spectrum_footer_display_mode', 'default' );
    $footer_layout = get_theme_mod( 'smartadmin_spectrum_footer_layout', 'center' );
    $footer_custom_text = get_theme_mod( 'smartadmin_spectrum_footer_custom_text', '' );
    $show_wp_attribution = get_theme_mod( 'smartadmin_spectrum_footer_show_wp', '1' );
    
    // Only show footer if not hidden
    if ( $footer_display_mode !== 'hidden' ) :
?>
    <footer id="colophon" class="site-footer footer-<?php echo esc_attr( $footer_layout ); ?>">
        <div class="<?php echo esc_attr( get_theme_mod( 'smartadmin_spectrum_layout_container', 'container' ) ); ?>">
            <!-- Footer Menu -->
            <nav id="footer-navigation" class="footer-navigation">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu',
                    'container'      => false,
                    'menu_class'     => 'footer-nav-list',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ) );
                ?>
            </nav>
            
            <div class="site-info">
                <?php
                $footer_content = '';
                
                switch ( $footer_display_mode ) {
                    case 'site_only':
                        $footer_content = '&copy; ' . date('Y') . ' <a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a>';
                        break;
                        
                    case 'custom':
                        if ( ! empty( $footer_custom_text ) ) {
                            // Replace placeholders
                            $footer_content = $footer_custom_text;
                            $footer_content = str_replace( '{year}', date('Y'), $footer_content );
                            $footer_content = str_replace( '{site}', get_bloginfo( 'name' ), $footer_content );
                            // Allow HTML but sanitize
                            $footer_content = wp_kses_post( $footer_content );
                        } else {
                            // Fallback to site name if custom text is empty
                            $footer_content = '&copy; ' . date('Y') . ' <a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a>';
                        }
                        break;
                        
                    case 'default':
                    default:
                        $footer_content = '&copy; ' . date('Y') . ' <a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a>';
                        
                        if ( $show_wp_attribution ) {
                            $footer_content .= ' <span class="sep"> | </span>';
                            /* translators: %s: WordPress */
                            $footer_content .= sprintf( esc_html__( 'Proudly powered by %s', 'smartadmin-spectrum' ), 'WordPress' );
                        }
                        break;
                }
                
                echo '<p>' . $footer_content . '</p>';
                ?>
            </div><!-- .site-info -->
        </div>
    </footer>
<?php endif; ?>
    <?php wp_footer(); ?>

</body>
</html>