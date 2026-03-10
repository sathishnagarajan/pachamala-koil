<?php
/**
 * Helper / Utility Functions
 *
 * @package PachamalaTemple
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get a page ID by slug.
 *
 * @param  string $slug
 * @return int|null
 */
function pkt_get_page_id( $slug ) {
    $page = get_page_by_path( $slug );
    return $page ? $page->ID : null;
}

/**
 * Render breadcrumbs for inner pages.
 */
function pkt_breadcrumbs() {
    $home = '<a href="' . esc_url( home_url() ) . '">' . esc_html__( 'Home', 'pachamala-temple' ) . '</a>';
    $sep  = '<span class="breadcrumb-sep"> › </span>';

    $crumbs = $home;

    if ( is_singular() ) {
        $post_type = get_post_type();
        if ( $post_type !== 'post' ) {
            $pt_obj = get_post_type_object( $post_type );
            if ( $pt_obj ) {
                $crumbs .= $sep . esc_html( $pt_obj->labels->name );
            }
        }
        $crumbs .= $sep . '<span class="current">' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_page() ) {
        $ancestors = get_post_ancestors( get_the_ID() );
        if ( $ancestors ) {
            foreach ( array_reverse( $ancestors ) as $ancestor ) {
                $crumbs .= $sep . '<a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a>';
            }
        }
        $crumbs .= $sep . '<span class="current">' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_archive() ) {
        $crumbs .= $sep . '<span class="current">' . esc_html( get_the_archive_title() ) . '</span>';
    } elseif ( is_search() ) {
        $crumbs .= $sep . '<span class="current">' . esc_html__( 'Search Results', 'pachamala-temple' ) . '</span>';
    } elseif ( is_404() ) {
        $crumbs .= $sep . '<span class="current">404</span>';
    }

    echo '<nav class="breadcrumbs" aria-label="Breadcrumb">' . $crumbs . '</nav>'; // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Format event date(s) for display.
 *
 * @param  string $start  date string (Y-m-d)
 * @param  string $end    date string (Y-m-d), optional
 * @return string
 */
function pkt_format_event_date( $start, $end = '' ) {
    if ( ! $start ) return '';

    $ts_start = strtotime( $start );
    $formatted = date_i18n( 'j M Y', $ts_start );

    if ( $end && $end !== $start ) {
        $ts_end    = strtotime( $end );
        $formatted .= ' — ' . date_i18n( 'j M Y', $ts_end );
    }

    return esc_html( $formatted );
}

/**
 * Format time string from HH:MM to 12-hour with AM/PM.
 *
 * @param  string $time  24-hr time string
 * @return string
 */
function pkt_format_time( $time ) {
    if ( ! $time ) return '';
    $ts = strtotime( $time );
    return $ts ? date_i18n( 'g:i A', $ts ) : esc_html( $time );
}

/**
 * Get upcoming temple events.
 *
 * @param  int $count
 * @return WP_Query
 */
function pkt_get_upcoming_events( $count = 4 ) {
    $today = date( 'Y-m-d' );

    return new WP_Query( [
        'post_type'      => 'temple_event',
        'posts_per_page' => $count,
        'meta_key'       => 'event_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'meta_query'     => [
            [
                'key'     => 'event_date',
                'value'   => $today,
                'compare' => '>=',
                'type'    => 'DATE',
            ],
        ],
    ] );
}

/**
 * Get all pooja timings ordered by start time.
 *
 * @param  string $day_type  optional filter: 'Daily', 'Monday', etc.
 * @return WP_Query
 */
function pkt_get_pooja_timings( $day_type = '' ) {
    $args = [
        'post_type'      => 'pooja_timing',
        'posts_per_page' => -1,
        'meta_key'       => 'pooja_start_time',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    ];

    if ( $day_type ) {
        $args['meta_query'] = [
            'relation' => 'OR',
            [
                'key'     => 'pooja_day_type',
                'value'   => 'Daily',
                'compare' => '=',
            ],
            [
                'key'     => 'pooja_day_type',
                'value'   => $day_type,
                'compare' => '=',
            ],
        ];
    }

    return new WP_Query( $args );
}
