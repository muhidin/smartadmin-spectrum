<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <header>
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SmartAdmin_Spectrum
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header">
    <div class="container header-flex">
        <?php 
            // Fetch Customizer settings
            $display_type = get_theme_mod( 'header_display_type', 'both' );
            $layout_pos   = get_theme_mod( 'header_layout_position', 'brand-stacked' );
            
            // Determine default logo based on position
            $default_logo_file = ( 'brand-inline' === $layout_pos ) ? 'logo2.png' : 'logo.png';
            $default_logo_url  = get_template_directory_uri() . '/images/' . $default_logo_file;
        ?>

        <div class="brand-wrapper <?php echo esc_attr( $layout_pos ); ?>">
            
            <?php if ( 'both' === $display_type || 'logo' === $display_type ) : ?>
                <div class="site-logo">
                    <?php 
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
                        echo '<img src="' . esc_url( $default_logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
                        echo '</a>';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php if ( 'both' === $display_type || 'text' === $display_type ) : ?>
                <div class="brand-text">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <span class="text-blue-red-dynamic">
                            <?php 
                            $site_title = get_bloginfo( 'name', 'display' );
                            if ( ! empty( $site_title ) ) :
                                echo esc_html( $site_title );
                            else :
                                echo esc_html__( 'SmartAdmin Spectrum', 'smartadmin-spectrum' );
                            endif; 
                            ?>
                        </span>
                    </a>
                    
                    <?php
                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) : ?>
                        <div class="site-tagline">
                            <?php 
                            if ( ! empty( $description ) ) :
                                echo esc_html( $description );
                            else :
                                echo esc_html__( 'Digital Office Specialist', 'smartadmin-spectrum' );
                            endif;
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
        <nav id="site-navigation" class="main-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'container'      => false,
                'menu_class'     => 'main-nav-list',
                'depth'          => 2,
                'fallback_cb'    => false,
            ) );
            ?>
        </nav>
    </div>
</header>