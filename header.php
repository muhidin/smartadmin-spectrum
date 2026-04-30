<?php
/**
 * Copyright 2026 Muhidin Saimin
 *
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
<a class="skip-link screen-reader-text" href="#primary-content">
    <?php esc_html_e( 'Skip to content', 'smartadmin-spectrum' ); ?>
</a>

<!-- Top Header Menu -->
<div class="top-header">
    <div class="<?php echo esc_attr( get_theme_mod( 'smartadmin_spectrum_layout_container', 'container' ) ); ?>">
        <nav id="top-navigation" class="top-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'top',
                'menu_id'        => 'top-menu',
                'container'      => false,
                'menu_class'     => 'top-nav-list',
                'depth'          => 1,
                'fallback_cb'    => false,
            ) );
            ?>
        </nav>
    </div>
</div>

<?php
    // Get header background image
    $header_bg_image = get_theme_mod( 'smartadmin_spectrum_header_background_image', '' );
    $header_style = '';
    if ( $header_bg_image ) {
        $header_style = 'style="background-image: url(\'' . esc_url( $header_bg_image ) . '\'); background-size: cover; background-position: center; background-repeat: no-repeat;"';
    }
?>
<header id="masthead" class="site-header" <?php echo $header_style; ?>>
    <div class="<?php echo esc_attr( get_theme_mod( 'smartadmin_spectrum_layout_container', 'container' ) ); ?> header-flex">
        <?php
            // Get settings from Customizer
            $display_type = get_theme_mod( 'smartadmin_spectrum_header_display_type', 'both' );
            $layout_pos   = get_theme_mod( 'smartadmin_spectrum_header_layout_position', 'brand-stacked' );

            // Determine display variables
            $show_logo = ( 'both' === $display_type || 'logo' === $display_type );
            $show_text = ( 'both' === $display_type || 'text' === $display_type );

            // Default logo only appears if "logo display is allowed" AND "user hasn't uploaded logo"
            $default_logo_file = ( 'brand-inline' === $layout_pos ) ? 'logo2.png' : 'logo.png';
            $default_logo_url  = get_template_directory_uri() . '/images/' . $default_logo_file;

            // Prioritize user input for title and tagline.
            $site_title   = get_bloginfo( 'name', 'display' );
            $site_tagline = get_bloginfo( 'description', 'display' );

            if ( ! $site_title && ! $site_tagline ) {
                $site_title   = esc_html__( 'SmartAdmin Spectrum', 'smartadmin-spectrum' );
                $site_tagline = esc_html__( 'Digital Office Specialist', 'smartadmin-spectrum' );
            }
        ?>

        <div class="brand-wrapper <?php echo esc_attr( $layout_pos ); ?>">
            
            <?php if ( $show_logo ) : ?>
                <div class="site-logo">
                    <?php 
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        // Display default RGI logo only if logo mode is active
                        echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
                        echo '<img src="' . esc_url( $default_logo_url ) . '" alt="' . esc_attr( $site_title ) . '">';
                        echo '</a>';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php if ( $show_text ) : ?>
                <div class="brand-text">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <span class="text-blue-red-dynamic">
                            <?php echo esc_html( $site_title ); ?>
                        </span>
                    </a>
                    
                    <?php if ( $site_tagline ) : ?>
                        <div class="site-tagline">
                            <?php echo esc_html( $site_tagline ); ?>
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
                'depth'          => 5,
                'fallback_cb'    => false,
            ) );
            ?>
            
            <div class="search-inline">
                <form role="search" method="get" class="search-form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <label class="screen-reader-text" for="search-field-inline"><?php esc_html_e( 'Search for:', 'smartadmin-spectrum' ); ?></label>
                    <input type="search" id="search-field-inline" class="search-field-inline" placeholder="<?php esc_attr_e( 'Search...', 'smartadmin-spectrum' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                    <button type="submit" class="search-submit-inline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
        </nav>
    </div>
</header>

<!-- Bottom Header Menu -->
<div class="bottom-header">
    <div class="<?php echo esc_attr( get_theme_mod( 'smartadmin_spectrum_layout_container', 'container' ) ); ?>">
        <nav id="bottom-navigation" class="bottom-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'bottom',
                'menu_id'        => 'bottom-menu',
                'container'      => false,
                'menu_class'     => 'bottom-nav-list',
                'depth'          => 1,
                'fallback_cb'    => false,
            ) );
            ?>
        </nav>
    </div>
</div>