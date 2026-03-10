<?php
/**
 * Pachamala Temple Theme — Functions
 *
 * @package PachamalaTemple
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// -----------------------------------------------------------------
// Constants
// -----------------------------------------------------------------
define( 'PKT_VERSION',    '1.0.0' );
define( 'PKT_THEME_DIR',   get_template_directory() );
define( 'PKT_THEME_URI',   get_template_directory_uri() );
define( 'PKT_ASSETS_URI',  PKT_THEME_URI . '/assets' );

// -----------------------------------------------------------------
// Include modules
// -----------------------------------------------------------------
require_once PKT_THEME_DIR . '/inc/enqueue.php';
require_once PKT_THEME_DIR . '/inc/custom-post-types.php';
require_once PKT_THEME_DIR . '/inc/meta-boxes.php';
require_once PKT_THEME_DIR . '/inc/widgets.php';
require_once PKT_THEME_DIR . '/inc/helpers.php';

// -----------------------------------------------------------------
// Theme Setup
// -----------------------------------------------------------------
function pkt_theme_setup() {
    // Core supports
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // Custom logo
    add_theme_support( 'custom-logo', [
        'height'      => 140,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    // Custom image sizes
    add_image_size( 'deity-portrait',  400, 600, true );
    add_image_size( 'gallery-thumb',   400, 400, true );
    add_image_size( 'event-banner',    800, 400, true );
    add_image_size( 'hero-full',      1920, 800, true );
    add_image_size( 'card-thumb',      600, 400, true );

    // Navigation menus
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'pachamala-temple' ),
        'footer'  => __( 'Footer Links',        'pachamala-temple' ),
        'top-bar' => __( 'Top Bar Menu',         'pachamala-temple' ),
    ] );

    // Content width
    $GLOBALS['content_width'] = 1200;

    // Load text domain
    load_theme_textdomain( 'pachamala-temple', PKT_THEME_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'pkt_theme_setup' );

// -----------------------------------------------------------------
// Body class — add page-specific class
// -----------------------------------------------------------------
function pkt_body_classes( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'is-front-page';
    }
    if ( is_singular() ) {
        $classes[] = 'is-singular';
    }
    return $classes;
}
add_filter( 'body_class', 'pkt_body_classes' );

// -----------------------------------------------------------------
// Excerpt length
// -----------------------------------------------------------------
function pkt_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'pkt_excerpt_length' );

function pkt_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'pkt_excerpt_more' );

// -----------------------------------------------------------------
// Keep admin in English regardless of site language
// -----------------------------------------------------------------
add_filter( 'determine_locale', function( $locale ) {
    if ( is_admin() ) {
        return 'en_US';
    }
    return $locale;
} );
