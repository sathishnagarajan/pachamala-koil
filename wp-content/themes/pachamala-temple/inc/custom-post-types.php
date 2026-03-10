<?php
/**
 * Custom Post Types & Taxonomies
 * - Pooja Timings
 * - Temple Events
 * - Gallery Items
 *
 * @package PachamalaTemple
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// =============================================================
// CPT 1: Pooja Timings
// =============================================================
function pkt_register_pooja_timing() {
    $labels = [
        'name'               => 'Pooja Timings',
        'singular_name'      => 'Pooja Timing',
        'menu_name'          => 'Pooja Timings',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Pooja',
        'edit_item'          => 'Edit Pooja Timing',
        'new_item'           => 'New Pooja',
        'view_item'          => 'View Pooja',
        'search_items'       => 'Search Pooja Timings',
        'not_found'          => 'No pooja timings found',
        'not_found_in_trash' => 'No pooja timings in trash',
    ];

    register_post_type( 'pooja_timing', [
        'labels'        => $labels,
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-clock',
        'menu_position' => 20,
        'supports'      => [ 'title', 'editor', 'thumbnail' ],
        'has_archive'   => false,
        'rewrite'       => [ 'slug' => 'pooja-timings', 'with_front' => false ],
        'show_in_rest'  => true,
        'capability_type' => 'post',
    ] );
}
add_action( 'init', 'pkt_register_pooja_timing' );


// =============================================================
// CPT 2: Temple Events
// =============================================================
function pkt_register_temple_event() {
    $labels = [
        'name'               => 'Temple Events',
        'singular_name'      => 'Temple Event',
        'menu_name'          => 'Events & Festivals',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Event',
        'edit_item'          => 'Edit Event',
        'new_item'           => 'New Event',
        'view_item'          => 'View Event',
        'search_items'       => 'Search Events',
        'not_found'          => 'No events found',
        'not_found_in_trash' => 'No events in trash',
        'all_items'          => 'All Events',
    ];

    register_post_type( 'temple_event', [
        'labels'        => $labels,
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-calendar-alt',
        'menu_position' => 21,
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'events', 'with_front' => false ],
        'show_in_rest'  => true,
        'capability_type' => 'post',
    ] );

    // Event Category taxonomy
    register_taxonomy( 'event_category', 'temple_event', [
        'labels' => [
            'name'          => 'Event Categories',
            'singular_name' => 'Event Category',
            'add_new_item'  => 'Add New Category',
            'edit_item'     => 'Edit Category',
            'all_items'     => 'All Categories',
        ],
        'hierarchical'  => true,
        'public'        => true,
        'show_in_rest'  => true,
        'show_in_menu'  => true,
        'rewrite'       => [ 'slug' => 'event-type' ],
    ] );
}
add_action( 'init', 'pkt_register_temple_event' );


// =============================================================
// CPT 3: Gallery Items
// =============================================================
function pkt_register_gallery_item() {
    $labels = [
        'name'               => 'Gallery',
        'singular_name'      => 'Gallery Image',
        'menu_name'          => 'Gallery',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Photo',
        'edit_item'          => 'Edit Photo',
        'new_item'           => 'New Photo',
        'view_item'          => 'View Photo',
        'search_items'       => 'Search Gallery',
        'not_found'          => 'No photos found',
        'not_found_in_trash' => 'No photos in trash',
    ];

    register_post_type( 'gallery_item', [
        'labels'        => $labels,
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-format-gallery',
        'menu_position' => 22,
        'supports'      => [ 'title', 'thumbnail', 'excerpt' ],
        'has_archive'   => false,
        'rewrite'       => [ 'slug' => 'gallery', 'with_front' => false ],
        'show_in_rest'  => true,
        'capability_type' => 'post',
    ] );

    // Gallery Category taxonomy
    register_taxonomy( 'gallery_category', 'gallery_item', [
        'labels' => [
            'name'          => 'Gallery Categories',
            'singular_name' => 'Gallery Category',
            'add_new_item'  => 'Add New Category',
            'edit_item'     => 'Edit Category',
            'all_items'     => 'All Categories',
        ],
        'hierarchical' => true,
        'public'       => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'gallery-type' ],
    ] );
}
add_action( 'init', 'pkt_register_gallery_item' );


// =============================================================
// Flush rewrite rules on activation (run once)
// =============================================================
function pkt_flush_rewrite_rules() {
    pkt_register_pooja_timing();
    pkt_register_temple_event();
    pkt_register_gallery_item();
    flush_rewrite_rules();
}
register_activation_hook( PKT_THEME_DIR . '/functions.php', 'pkt_flush_rewrite_rules' );

// Also flush on theme switch
add_action( 'after_switch_theme', function() {
    flush_rewrite_rules();
} );
