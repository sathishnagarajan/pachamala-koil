<?php
/**
 * Widget Area Registration
 *
 * @package PachamalaTemple
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function pkt_register_widget_areas() {
    // Sidebar — Pooja Timings
    register_sidebar( [
        'name'          => __( 'Pooja Timings Sidebar', 'pachamala-temple' ),
        'id'            => 'sidebar-pooja',
        'description'   => 'Displayed in the sidebar of inner pages.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );

    // Footer columns
    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( [
            'name'          => sprintf( __( 'Footer Column %d', 'pachamala-temple' ), $i ),
            'id'            => "footer-widget-{$i}",
            'description'   => sprintf( 'Footer column %d widget area.', $i ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ] );
    }
}
add_action( 'widgets_init', 'pkt_register_widget_areas' );
