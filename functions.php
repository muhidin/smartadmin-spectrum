<?php
/**
 * SmartAdmin Spectrum functions and definitions
 *
 * @package SmartAdmin_Spectrum
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

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

    // Add support for core custom logo.
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

    // Switch default core markup for search form, comment form, etc to output valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    /** * ADDITIONAL SUPPORTS (REQUIRED/RECOMMENDED BY WP SCANNER)
     */
    
    // Add support for responsive embeds (YouTube, etc).
    add_theme_support( 'responsive-embeds' );

    // Add support for block styles (Gutenberg).
    add_theme_support( 'wp-block-styles' );

    // Add support for wide alignment for blocks.
    add_theme_support( 'align-wide' );

    // Add support for custom background.
    add_theme_support( 'custom-background' );

    // Add support for custom header images.
    add_theme_support( 'custom-header' );

    // Enqueue editor styles to match the frontend.
    add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'sas_setup' );

/**
 * Enqueue scripts and styles.
 */
function sas_enqueue_assets() {
    // Enqueue theme main stylesheet.
    wp_enqueue_style( 'sas-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Enqueue comment reply script if needed.
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'sas_enqueue_assets' );

/**
 * Register Customizer settings.
 */
function sas_customize_register( $wp_customize ) {
    
    // Header Settings Section.
    $wp_customize->add_section( 'sas_header_section', array(
        'title'    => esc_html__( 'Header Settings', 'smartadmin-spectrum' ),
        'priority' => 30,
    ) );

    // Setting: Header Display Type (Logo/Text/Both).
    $wp_customize->add_setting( 'header_display_type', array(
        'default'           => 'both',
        'sanitize_callback' => 'sas_sanitize_select',
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

    // Setting: Header Layout Position (Stacked/Inline).
    $wp_customize->add_setting( 'header_layout_position', array(
        'default'           => 'brand-stacked',
        'sanitize_callback' => 'sas_sanitize_select',
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
}
add_action( 'customize_register', 'sas_customize_register' );

/**
 * Sanitization callback for select and radio controls.
 */
function sas_sanitize_select( $input, $setting ) {
    $control = $setting->manager->get_control( $setting->id );
    $choices = $control->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}