<?php
/**
 * SmartAdmin Spectrum functions and definitions
 *
 * @package SmartAdmin_Spectrum
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

if ( ! function_exists( 'sas_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function sas_setup() {
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
        'primary' => esc_html__( 'Primary Menu', 'smartadmin-spectrum' ),
    ) );

    // Register widget areas.
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar Widget Area', 'smartadmin-spectrum' ),
        'id'            => 'primary-sidebar',
        'description'   => esc_html__( 'Widgets will appear in the footer. Add widgets via Appearance → Widgets', 'smartadmin-spectrum' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
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
    add_editor_style( 'style.css' );
}
endif;
add_action( 'after_setup_theme', 'sas_setup' );

/**
 * Enqueue scripts and styles.
 */
function sas_enqueue_assets() {
    // Enqueue main stylesheet.
    wp_enqueue_style( 'sas-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Enqueue Swiper CSS
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0' );

    // Enqueue Swiper JS
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true );

    // Custom script for slider initialization
    wp_enqueue_script( 'sas-swiper-init', get_template_directory_uri() . '/js/swiper-init.js', array('swiper-js'), '1.0.0', true );

    // Enqueue comment reply script on singular pages with open comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'sas_enqueue_assets' );

/**
 * Register Customizer settings.
 */
function sas_customize_register( $wp_customize ) {

    // 1. Create Header Settings section.
    $wp_customize->add_section( 'sas_header_section', array(
        'title'    => esc_html__( 'Header Settings', 'smartadmin-spectrum' ),
        'priority' => 30,
    ) );

    // 2. Setting: Header Display Type (Logo/Text/Both).
    $wp_customize->add_setting( 'header_display_type', array(
        'default'           => 'both',
        'sanitize_callback' => 'sas_sanitize_header_display',
    ) );
    $wp_customize->add_control( 'header_display_type_control', array(
        'label'    => esc_html__( 'Header Display Type', 'smartadmin-spectrum' ),
        'section'  => 'sas_header_section',
        'settings' => 'header_display_type',
        'type'     => 'select',
        'choices'  => array(
            'both' => esc_html__( 'Logo and Text', 'smartadmin-spectrum' ),
            'logo' => esc_html__( 'Logo Only', 'smartadmin-spectrum' ),
            'text' => esc_html__( 'Text Only', 'smartadmin-spectrum' ),
        ),
    ) );

    // 3. Setting: Header Layout Position (Stacked/Inline).
    $wp_customize->add_setting( 'header_layout_position', array(
        'default'           => 'brand-stacked',
        'sanitize_callback' => 'sas_sanitize_layout_position',
    ) );
    $wp_customize->add_control( 'header_layout_position_control', array(
        'label'    => esc_html__( 'Logo & Text Position', 'smartadmin-spectrum' ),
        'section'  => 'sas_header_section',
        'settings' => 'header_layout_position',
        'type'     => 'radio',
        'choices'  => array(
            'brand-stacked' => esc_html__( 'Stacked (Top/Bottom)', 'smartadmin-spectrum' ),
            'brand-inline'  => esc_html__( 'Inline (Side by Side)', 'smartadmin-spectrum' ),
        ),
    ) );

    // 4. Setting: Header Background Image
    $wp_customize->add_setting( 'sas_header_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sas_header_background_image_control', array(
        'label'    => esc_html__( 'Header Background Image', 'smartadmin-spectrum' ),
        'section'  => 'sas_header_section',
        'settings' => 'sas_header_background_image',
    ) ) );

    $wp_customize->add_section( 'sas_slider_section', array(
        'title'    => esc_html__( 'Hero Slider Settings', 'smartadmin-spectrum' ),
        'priority' => 31,
    ) );

    // Setting: Enable/Disable Hero Slider
    $wp_customize->add_setting( 'sas_hero_slider_enabled', array(
        'default'           => '1',
        'sanitize_callback' => 'sas_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'sas_hero_slider_enabled_control', array(
        'label'    => esc_html__( 'Enable Hero Slider', 'smartadmin-spectrum' ),
        'section'  => 'sas_slider_section',
        'settings' => 'sas_hero_slider_enabled',
        'type'     => 'checkbox',
    ) );

    // Setting: Slider Style
    $wp_customize->add_setting( 'sas_slider_style', array(
        'default'           => 'fade',
        'sanitize_callback' => 'sas_sanitize_slider_style',
    ) );
    $wp_customize->add_control( 'sas_slider_style_control', array(
        'label'    => esc_html__( 'Slider Style', 'smartadmin-spectrum' ),
        'section'  => 'sas_slider_section',
        'settings' => 'sas_slider_style',
        'type'     => 'select',
        'choices'  => array(
            'fade'     => esc_html__( 'Fade Transition', 'smartadmin-spectrum' ),
            'slide'    => esc_html__( 'Slide Transition', 'smartadmin-spectrum' ),
            'cube'     => esc_html__( 'Cube Effect', 'smartadmin-spectrum' ),
            'flip'     => esc_html__( 'Flip Effect', 'smartadmin-spectrum' ),
        ),
    ) );

    // Setting: Grid Columns
    $wp_customize->add_setting( 'sas_grid_columns', array(
        'default'           => '3',
        'sanitize_callback' => 'sas_sanitize_grid_columns',
    ) );
    $wp_customize->add_control( 'sas_grid_columns_control', array(
        'label'    => esc_html__( 'Grid Columns', 'smartadmin-spectrum' ),
        'section'  => 'sas_slider_section',
        'settings' => 'sas_grid_columns',
        'type'     => 'select',
        'choices'  => array(
            '1' => esc_html__( '1 Column', 'smartadmin-spectrum' ),
            '2' => esc_html__( '2 Columns', 'smartadmin-spectrum' ),
            '3' => esc_html__( '3 Columns', 'smartadmin-spectrum' ),
        ),
    ) );

    // Setting: Layout Container
    $wp_customize->add_setting( 'sas_layout_container', array(
        'default'           => 'container',
        'sanitize_callback' => 'sas_sanitize_layout_container',
    ) );
    $wp_customize->add_control( 'sas_layout_container_control', array(
        'label'    => esc_html__( 'Layout Container', 'smartadmin-spectrum' ),
        'section'  => 'sas_slider_section',
        'settings' => 'sas_layout_container',
        'type'     => 'select',
        'choices'  => array(
            'container'      => esc_html__( 'Boxed Container', 'smartadmin-spectrum' ),
            'container-full' => esc_html__( 'Full Width Container', 'smartadmin-spectrum' ),
        ),
    ) );

    for ( $i = 1; $i <= 5; $i++ ) {
        $wp_customize->add_setting( 'hero_slide_' . $i, array(
            'default'           => get_template_directory_uri() . '/images/slider' . $i . '.jpg',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_slide_' . $i . '_control', array(
            'label'    => sprintf( esc_html__( 'Slide Image %d', 'smartadmin-spectrum' ), $i ),
            'section'  => 'sas_slider_section',
            'settings' => 'hero_slide_' . $i,
        ) ) );
    }
}
add_action( 'customize_register', 'sas_customize_register' );

function sas_sanitize_header_display( $input ) {
    $valid = array( 'both', 'logo', 'text' );
    return ( in_array( $input, $valid ) ? $input : 'both' );
}

function sas_sanitize_checkbox( $input ) {
    return $input ? '1' : '';
}

function sas_sanitize_slider_style( $input ) {
    $valid = array( 'fade', 'slide', 'cube', 'flip' );
    return ( in_array( $input, $valid ) ? $input : 'fade' );
}

function sas_sanitize_grid_columns( $input ) {
    $valid = array( '1', '2', '3' );
    return ( in_array( $input, $valid ) ? $input : '3' );
}

function sas_sanitize_layout_container( $input ) {
    $valid = array( 'container', 'container-full' );
    return ( in_array( $input, $valid ) ? $input : 'container' );
}

function sas_sanitize_layout_position( $input ) {
    $valid = array( 'brand-stacked', 'brand-inline' );
    return ( in_array( $input, $valid ) ? $input : 'brand-stacked' );
}

function sas_register_my_patterns() {
    register_block_pattern(
        'smartadmin-spectrum/cta-pattern',
        array(
            'title'       => __( 'Spectrum Learning Call to Action', 'smartadmin-spectrum' ),
            'description' => __( 'Call to action section to start learning.', 'smartadmin-spectrum' ),
            'content'     => '<div class="wp-block-group has-white-color has-primary-background-color has-text-color has-background has-link-color">
                              <h2 class="wp-block-heading has-text-align-center has-white-color">Siap Memulai Karir Digital?</h2><div class="wp-block-buttons"><div class="wp-block-button"><a class="wp-block-button__link has-black-color has-white-background-color has-text-color has-background wp-element-button">Daftar Sekarang</a></div></div></div>',
            'categories'  => array( 'buttons' ),
        )
    );
}
add_action( 'init', 'sas_register_my_patterns' );