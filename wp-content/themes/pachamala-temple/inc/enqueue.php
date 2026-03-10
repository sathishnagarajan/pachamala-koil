<?php
/**
 * Enqueue scripts and styles
 *
 * @package PachamalaTemple
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function pkt_enqueue_assets() {
    // Google Fonts: Tamil + English heading + body
    wp_enqueue_style(
        'pkt-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Noto+Serif:ital,wght@0,400;0,700;1,400&family=Noto+Serif+Tamil:wght@400;600;700&display=swap',
        [],
        null
    );

    // Theme stylesheet
    wp_enqueue_style(
        'pkt-style',
        get_stylesheet_uri(),
        [ 'pkt-google-fonts' ],
        PKT_VERSION
    );

    // Decorative CSS patterns
    wp_enqueue_style(
        'pkt-patterns',
        PKT_ASSETS_URI . '/css/temple-patterns.css',
        [ 'pkt-style' ],
        PKT_VERSION
    );

    // Main JS
    wp_enqueue_script(
        'pkt-main',
        PKT_ASSETS_URI . '/js/main.js',
        [ 'jquery' ],
        PKT_VERSION,
        true
    );

    // Audio player JS
    wp_enqueue_script(
        'pkt-audio',
        PKT_ASSETS_URI . '/js/audio-player.js',
        [ 'pkt-main' ],
        PKT_VERSION,
        true
    );

    // Pass data to JS
    wp_localize_script( 'pkt-main', 'PKT', [
        'ajaxurl'    => admin_url( 'admin-ajax.php' ),
        'site_url'   => site_url(),
        'assets_url' => PKT_ASSETS_URI,
        'nonce'      => wp_create_nonce( 'pkt_nonce' ),
        'home_url'   => home_url(),
    ] );

    // Comment reply script (only on singular with comments)
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'pkt_enqueue_assets' );

// jQuery UI datepicker for admin meta boxes
function pkt_enqueue_admin_assets( $hook ) {
    global $post_type;
    $cpts = [ 'temple_event', 'pooja_timing', 'gallery_item' ];
    if ( in_array( $hook, [ 'post.php', 'post-new.php' ], true ) && in_array( $post_type, $cpts, true ) ) {
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_style(
            'jquery-ui',
            'https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css',
            [],
            '1.13.2'
        );
        wp_enqueue_style(
            'pkt-admin',
            PKT_ASSETS_URI . '/css/admin.css',
            [],
            PKT_VERSION
        );
    }
}
add_action( 'admin_enqueue_scripts', 'pkt_enqueue_admin_assets' );
