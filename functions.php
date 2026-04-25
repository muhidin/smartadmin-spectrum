<?php
/**
 * SmartAdmin Spectrum functions and definitions
 *
 * @package SmartAdmin_Spectrum
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

if ( ! function_exists( 'smartadmin_spectrum_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function smartadmin_spectrum_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Custom logo support.
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Register navigation menus.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'smartadmin_spectrum' ),
    ) );

    // Switch default core markup to output valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add support for core custom logo.
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'custom-background' );
    
    // Add support for custom header
    add_theme_support( 'custom-header', array(
        'default-image'          => '',
        'default-text-color'     => '000000',
        'width'                  => 1920,
        'height'                 => 400,
        'flex-height'            => true,
        'flex-width'             => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
        'video'                  => false,
    ) );
    
    add_editor_style( 'style.css' );
}
endif;
add_action( 'after_setup_theme', 'smartadmin_spectrum_setup' );

/**
 * Enqueue scripts and styles.
 */
function smartadmin_spectrum_enqueue_assets() {
    // Enqueue main stylesheet.
    wp_enqueue_style( 'smartadmin-spectrum-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Enqueue Swiper CSS
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0' );

    // Enqueue Swiper JS
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true );

    // Custom script for slider initialization
    wp_enqueue_script( 'smartadmin-spectrum-swiper-init', get_template_directory_uri() . '/js/swiper-init.js', array('swiper-js'), '1.0.0', true );

    // Enqueue comment reply script on singular pages with open comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'smartadmin_spectrum_enqueue_assets' );

/**
 * Register widget areas.
 */
function smartadmin_spectrum_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar Widget Area', 'smartadmin_spectrum' ),
        'id'            => 'primary-sidebar',
        'description'   => esc_html__( 'Widgets will appear in the footer. Add widgets via Appearance → Widgets', 'smartadmin_spectrum' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'smartadmin_spectrum_widgets_init' );

/**
 * Register Customizer settings.
 */
function smartadmin_spectrum_customize_register( $wp_customize ) {

    // 1. Create Header Settings section.
    $wp_customize->add_section( 'smartadmin_spectrum_header_section', array(
        'title'    => esc_html__( 'Header Settings', 'smartadmin_spectrum' ),
        'priority' => 30,
    ) );

    // 2. Setting: Header Display Type (Logo/Text/Both).
    $wp_customize->add_setting( 'smartadmin_spectrum_header_display_type', array(
        'default'           => 'both',
        'sanitize_callback' => 'smartadmin_spectrum_sanitize_header_display',
    ) );
    $wp_customize->add_control( 'smartadmin_spectrum_header_display_type_control', array(
        'label'    => esc_html__( 'Header Display Type', 'smartadmin_spectrum' ),
        'section'  => 'smartadmin_spectrum_header_section',
        'settings' => 'smartadmin_spectrum_header_display_type',
        'type'     => 'select',
        'choices'  => array(
            'both' => esc_html__( 'Logo and Text', 'smartadmin_spectrum' ),
            'logo' => esc_html__( 'Logo Only', 'smartadmin_spectrum' ),
            'text' => esc_html__( 'Text Only', 'smartadmin_spectrum' ),
        ),
    ) );

    // 3. Setting: Header Layout Position (Stacked/Inline).
    $wp_customize->add_setting( 'smartadmin_spectrum_header_layout_position', array(
        'default'           => 'brand-stacked',
        'sanitize_callback' => 'smartadmin_spectrum_sanitize_layout_position',
    ) );
    $wp_customize->add_control( 'smartadmin_spectrum_header_layout_position_control', array(
        'label'    => esc_html__( 'Logo & Text Position', 'smartadmin_spectrum' ),
        'section'  => 'smartadmin_spectrum_header_section',
        'settings' => 'smartadmin_spectrum_header_layout_position',
        'type'     => 'radio',
        'choices'  => array(
            'brand-stacked' => esc_html__( 'Stacked (Top/Bottom)', 'smartadmin_spectrum' ),
            'brand-inline'  => esc_html__( 'Inline (Side by Side)', 'smartadmin_spectrum' ),
        ),
    ) );

    // 4. Setting: Header Background Image
    $wp_customize->add_setting( 'smartadmin_spectrum_header_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'smartadmin_spectrum_header_background_image_control', array(
        'label'    => esc_html__( 'Header Background Image', 'smartadmin_spectrum' ),
        'section'  => 'smartadmin_spectrum_header_section',
        'settings' => 'smartadmin_spectrum_header_background_image',
    ) ) );

    $wp_customize->add_section( 'smartadmin_spectrum_slider_section', array(
        'title'    => esc_html__( 'Hero Slider Settings', 'smartadmin_spectrum' ),
        'priority' => 31,
    ) );

    // Setting: Enable/Disable Hero Slider
    $wp_customize->add_setting( 'smartadmin_spectrum_hero_slider_enabled', array(
        'default'           => '1',
        'sanitize_callback' => 'smartadmin_spectrum_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'smartadmin_spectrum_hero_slider_enabled_control', array(
        'label'    => esc_html__( 'Enable Hero Slider', 'smartadmin_spectrum' ),
        'section'  => 'smartadmin_spectrum_slider_section',
        'settings' => 'smartadmin_spectrum_hero_slider_enabled',
        'type'     => 'checkbox',
    ) );

    // Setting: Slider Style
    $wp_customize->add_setting( 'smartadmin_spectrum_slider_style', array(
        'default'           => 'fade',
        'sanitize_callback' => 'smartadmin_spectrum_sanitize_slider_style',
    ) );
    $wp_customize->add_control( 'smartadmin_spectrum_slider_style_control', array(
        'label'    => esc_html__( 'Slider Style', 'smartadmin_spectrum' ),
        'section'  => 'smartadmin_spectrum_slider_section',
        'settings' => 'smartadmin_spectrum_slider_style',
        'type'     => 'select',
        'choices'  => array(
            'fade'     => esc_html__( 'Fade Transition', 'smartadmin_spectrum' ),
            'slide'    => esc_html__( 'Slide Transition', 'smartadmin_spectrum' ),
            'cube'     => esc_html__( 'Cube Effect', 'smartadmin_spectrum' ),
            'flip'     => esc_html__( 'Flip Effect', 'smartadmin_spectrum' ),
        ),
    ) );

    // Setting: Grid Columns
    $wp_customize->add_setting( 'smartadmin_spectrum_grid_columns', array(
        'default'           => '3',
        'sanitize_callback' => 'smartadmin_spectrum_sanitize_grid_columns',
    ) );
    $wp_customize->add_control( 'smartadmin_spectrum_grid_columns_control', array(
        'label'    => esc_html__( 'Grid Columns', 'smartadmin_spectrum' ),
        'section'  => 'smartadmin_spectrum_slider_section',
        'settings' => 'smartadmin_spectrum_grid_columns',
        'type'     => 'select',
        'choices'  => array(
            '1' => esc_html__( '1 Column', 'smartadmin_spectrum' ),
            '2' => esc_html__( '2 Columns', 'smartadmin_spectrum' ),
            '3' => esc_html__( '3 Columns', 'smartadmin_spectrum' ),
        ),
    ) );

    // Setting: Layout Container
    $wp_customize->add_setting( 'smartadmin_spectrum_layout_container', array(
        'default'           => 'container',
        'sanitize_callback' => 'smartadmin_spectrum_sanitize_layout_container',
    ) );
    $wp_customize->add_control( 'smartadmin_spectrum_layout_container_control', array(
        'label'    => esc_html__( 'Layout Container', 'smartadmin_spectrum' ),
        'section'  => 'smartadmin_spectrum_slider_section',
        'settings' => 'smartadmin_spectrum_layout_container',
        'type'     => 'select',
        'choices'  => array(
            'container'      => esc_html__( 'Boxed Container', 'smartadmin_spectrum' ),
            'container-full' => esc_html__( 'Full Width Container', 'smartadmin_spectrum' ),
        ),
    ) );

    for ( $i = 1; $i <= 5; $i++ ) {
        $wp_customize->add_setting( 'smartadmin_spectrum_hero_slide_' . $i, array(
            'default'           => get_template_directory_uri() . '/images/slider' . $i . '.jpg',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'smartadmin_spectrum_hero_slide_' . $i . '_control', array(
            'label'    => sprintf( esc_html__( 'Slide Image %d', 'smartadmin_spectrum' ), $i ),
            'section'  => 'smartadmin_spectrum_slider_section',
            'settings' => 'smartadmin_spectrum_hero_slide_' . $i,
        ) ) );
    }
}
add_action( 'customize_register', 'smartadmin_spectrum_customize_register' );

function smartadmin_spectrum_sanitize_header_display( $input ) {
    $valid = array( 'both', 'logo', 'text' );
    return ( in_array( $input, $valid ) ? $input : 'both' );
}

function smartadmin_spectrum_sanitize_checkbox( $input ) {
    return $input ? '1' : '';
}

function smartadmin_spectrum_sanitize_slider_style( $input ) {
    $valid = array( 'fade', 'slide', 'cube', 'flip' );
    return ( in_array( $input, $valid ) ? $input : 'fade' );
}

function smartadmin_spectrum_sanitize_grid_columns( $input ) {
    $valid = array( '1', '2', '3' );
    return ( in_array( $input, $valid ) ? $input : '3' );
}

function smartadmin_spectrum_sanitize_layout_container( $input ) {
    $valid = array( 'container', 'container-full' );
    return ( in_array( $input, $valid ) ? $input : 'container' );
}

function smartadmin_spectrum_sanitize_layout_position( $input ) {
    $valid = array( 'brand-stacked', 'brand-inline' );
    return ( in_array( $input, $valid ) ? $input : 'brand-stacked' );
}

function smartadmin_spectrum_register_my_patterns() {
    register_block_pattern(
        'smartadmin-spectrum/cta-pattern',
        array(
            'title'       => __( 'Spectrum Learning Call to Action', 'smartadmin_spectrum' ),
            'description' => __( 'Call to action section to start learning.', 'smartadmin_spectrum' ),
            'content'     => '<div class="wp-block-group has-white-color has-primary-background-color has-text-color has-background has-link-color">
                              <h2 class="wp-block-heading has-text-align-center has-white-color">Siap Memulai Karir Digital?</h2><div class="wp-block-buttons"><div class="wp-block-button"><a class="wp-block-button__link has-black-color has-white-background-color has-text-color has-background wp-element-button">Daftar Sekarang</a></div></div></div>',
            'categories'  => array( 'buttons' ),
        )
    );
}
add_action( 'init', 'smartadmin_spectrum_register_my_patterns' );

/**
 * Register block styles for better block theme compatibility.
 */
function smartadmin_spectrum_register_block_styles() {
    // Register block style for buttons
    register_block_style(
        'core/button',
        array(
            'name'         => 'spectrum-primary',
            'label'         => __( 'Spectrum Primary', 'smartadmin_spectrum' ),
            'inline_style' => '
                .wp-block-button.is-style-spectrum-primary {
                    background-color: #0073aa;
                    color: #ffffff;
                    border: none;
                    border-radius: 4px;
                    padding: 12px 24px;
                    font-weight: 600;
                }
                .wp-block-button.is-style-spectrum-primary:hover {
                    background-color: #005a87;
                }
            ',
        )
    );
    
    // Register block style for quotes
    register_block_style(
        'core/quote',
        array(
            'name'         => 'spectrum-highlight',
            'label'         => __( 'Spectrum Highlight', 'smartadmin_spectrum' ),
            'inline_style' => '
                .wp-block-quote.is-style-spectrum-highlight {
                    border-left: 4px solid #0073aa;
                    background-color: #f8f9fa;
                    padding: 20px;
                    margin: 20px 0;
                    font-style: italic;
                }
                .wp-block-quote.is-style-spectrum-highlight p {
                    margin-bottom: 0;
                }
            ',
        )
    );
    
    // Register block style for separators
    register_block_style(
        'core/separator',
        array(
            'name'         => 'spectrum-dotted',
            'label'         => __( 'Spectrum Dotted', 'smartadmin_spectrum' ),
            'inline_style' => '
                .wp-block-separator.is-style-spectrum-dotted {
                    border-bottom: 2px dotted #0073aa;
                    height: 2px;
                }
            ',
        )
    );
}
add_action( 'init', 'smartadmin_spectrum_register_block_styles' );

/**
 * Get theme description based on current language
 */
function smartadmin_spectrum_get_theme_description() {
    $current_lang = function_exists('get_locale') ? get_locale() : 'en_US';
    
    // Check if language is Indonesian
    if ( in_array( $current_lang, array( 'id_ID', 'id', 'indonesian' ) ) ) {
        return 'Tema WordPress yang ringan dan profesional dirancang khusus untuk portal pendidikan dan kelas Digital Office Specialist di Rumah Gemilang Indonesia. Dikembangkan oleh Muhidin Saimin, tema ini fokus pada pengalaman belajar yang bersih dengan sistem header yang dinamis. Pembaruan 1.1.1 memperkenalkan Hero Slider yang ditingkatkan dengan 5 slot gambar dan 4 efek transisi, Header Background Image dengan overlay kustom, sistem Widget dengan tampilan footer-only, dan opsi Full Width Container untuk layout lebar penuh. Tema ini juga mendukung berbagai efek 3D untuk slider dan desain yang responsif untuk semua ukuran layar.';
    } else {
        return 'A lightweight and professional WordPress theme specially designed for educational portals and Digital Office Specialist classes at Rumah Gemilang Indonesia. Developed by Muhidin Saimin, this theme focuses on a clean learning experience with a dynamic header system. The 1.1.1 update introduces an enhanced Hero Slider with 5 image slots and 4 transition effects, Header Background Image with customizable overlay, Widget system with footer-only display, and Full Width Container option for complete screen-width layouts. The theme also supports various 3D effects for sliders and responsive design for all screen sizes.';
    }
}

/**
 * Filter theme description to use bilingual version
 */
function smartadmin_spectrum_filter_theme_description( $description ) {
    return smartadmin_spectrum_get_theme_description();
}
add_filter( 'theme_description', 'smartadmin_spectrum_filter_theme_description' );

/**
 * Add custom action to display theme description in admin
 */
function smartadmin_spectrum_display_theme_description() {
    if ( is_admin() && function_exists('get_locale') ) {
        $current_lang = get_locale();
        if ( in_array( $current_lang, array( 'id_ID', 'id', 'indonesian' ) ) ) {
            // Override theme description in admin for Indonesian
            add_filter( 'wp_prepare_themes_for_js', function( $themes ) {
                if ( isset( $themes['smartadmin_spectrum'] ) ) {
                    $themes['smartadmin_spectrum']['description'] = smartadmin_spectrum_get_theme_description();
                }
                return $themes;
            });
        }
    }
}
add_action( 'admin_init', 'smartadmin_spectrum_display_theme_description' );

/**
 * Add footer customization settings to Customizer
 */
function smartadmin_spectrum_footer_customize_register( $wp_customize ) {
    
    // Create Footer Settings section
    $wp_customize->add_section( 'smartadmin_spectrum_footer_section', array(
        'title'    => esc_html__( 'Footer Settings', 'smartadmin_spectrum' ),
        'priority' => 35,
    ) );
    
    // Setting: Footer Display Mode
    $wp_customize->add_setting( 'smartadmin_spectrum_footer_display_mode', array(
        'default'           => 'default',
        'sanitize_callback' => 'smartadmin_spectrum_sanitize_footer_display_mode',
    ) );
    $wp_customize->add_control( 'smartadmin_spectrum_footer_display_mode_control', array(
        'label'    => esc_html__( 'Footer Display Mode', 'smartadmin_spectrum' ),
        'section'  => 'smartadmin_spectrum_footer_section',
        'settings' => 'smartadmin_spectrum_footer_display_mode',
        'type'     => 'select',
        'choices'  => array(
            'default'   => esc_html__( 'Default (Site Name + WordPress)', 'smartadmin_spectrum' ),
            'site_only' => esc_html__( 'Site Name Only', 'smartadmin_spectrum' ),
            'custom'    => esc_html__( 'Custom Text', 'smartadmin_spectrum' ),
            'hidden'    => esc_html__( 'Hidden (No Footer)', 'smartadmin_spectrum' ),
        ),
    ) );
    
    // Setting: Custom Footer Text
    $wp_customize->add_setting( 'smartadmin_spectrum_footer_custom_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'smartadmin_spectrum_footer_custom_text_control', array(
        'label'       => esc_html__( 'Custom Footer Text', 'smartadmin_spectrum' ),
        'description' => esc_html__( 'HTML allowed. Use {year} for current year, {site} for site name.', 'smartadmin_spectrum' ),
        'section'     => 'smartadmin_spectrum_footer_section',
        'settings'    => 'smartadmin_spectrum_footer_custom_text',
        'type'        => 'textarea',
        'active_callback' => function( $control ) {
            return $control->manager->get_setting( 'smartadmin_spectrum_footer_display_mode' )->value() === 'custom';
        },
    ) );
    
    // Setting: Footer Layout
    $wp_customize->add_setting( 'smartadmin_spectrum_footer_layout', array(
        'default'           => 'center',
        'sanitize_callback' => 'smartadmin_spectrum_sanitize_footer_layout',
    ) );
    $wp_customize->add_control( 'smartadmin_spectrum_footer_layout_control', array(
        'label'    => esc_html__( 'Footer Layout', 'smartadmin_spectrum' ),
        'section'  => 'smartadmin_spectrum_footer_section',
        'settings' => 'smartadmin_spectrum_footer_layout',
        'type'     => 'select',
        'choices'  => array(
            'left'   => esc_html__( 'Left Aligned', 'smartadmin_spectrum' ),
            'center' => esc_html__( 'Center Aligned', 'smartadmin_spectrum' ),
            'right'  => esc_html__( 'Right Aligned', 'smartadmin_spectrum' ),
        ),
    ) );
    
    // Setting: Show/Hide WordPress Attribution
    $wp_customize->add_setting( 'smartadmin_spectrum_footer_show_wp', array(
        'default'           => '1',
        'sanitize_callback' => 'smartadmin_spectrum_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'smartadmin_spectrum_footer_show_wp_control', array(
        'label'       => esc_html__( 'Show "Powered by WordPress"', 'smartadmin_spectrum' ),
        'description' => esc_html__( 'Only applies to Default display mode.', 'smartadmin_spectrum' ),
        'section'     => 'smartadmin_spectrum_footer_section',
        'settings'    => 'smartadmin_spectrum_footer_show_wp',
        'type'        => 'checkbox',
        'active_callback' => function( $control ) {
            return $control->manager->get_setting( 'smartadmin_spectrum_footer_display_mode' )->value() === 'default';
        },
    ) );
}
add_action( 'customize_register', 'smartadmin_spectrum_footer_customize_register', 20 );

/**
 * Sanitize footer display mode
 */
function smartadmin_spectrum_sanitize_footer_display_mode( $input ) {
    $valid = array( 'default', 'site_only', 'custom', 'hidden' );
    return ( in_array( $input, $valid ) ? $input : 'default' );
}

/**
 * Sanitize footer layout
 */
function smartadmin_spectrum_sanitize_footer_layout( $input ) {
    $valid = array( 'left', 'center', 'right' );
    return ( in_array( $input, $valid ) ? $input : 'center' );
}

/**
 * Fallback menu function when no menu is assigned
 */
function smartadmin_spectrum_fallback_menu() {
    if ( current_user_can( 'edit_theme_options' ) ) {
        echo '<ul id="primary-menu" class="main-nav-list">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add a menu', 'smartadmin_spectrum' ) . '</a></li>';
        echo '</ul>';
    } else {
        echo '<ul id="primary-menu" class="main-nav-list">';
        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'smartadmin_spectrum' ) . '</a></li>';
        echo '</ul>';
    }
}