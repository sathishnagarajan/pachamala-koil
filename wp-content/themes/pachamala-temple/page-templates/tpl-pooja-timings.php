<?php
/**
 * Template Name: Pooja Timings Page
 *
 * @package PachamalaTemple
 */

get_header(); ?>

<!-- Page Banner -->
<div class="page-banner">
    <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <p style="color:rgba(255,255,255,.7);font-family:var(--font-tamil)" lang="ta">தினசரி வழிபாட்டு நேரம்</p>
        <?php pkt_breadcrumbs(); ?>
    </div>
</div>

<section class="page-content-section">
    <div class="container">
        <div class="content-grid">
            <main class="main-content">

                <!-- Page intro content -->
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php if ( get_the_content() ) : ?>
                        <div class="entry-content" style="margin-bottom:var(--space-xl)">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>

                <?php
                // Group poojas by day type
                $all_poojas = pkt_get_pooja_timings();
                $groups     = [];

                if ( $all_poojas->have_posts() ) {
                    while ( $all_poojas->have_posts() ) {
                        $all_poojas->the_post();
                        $day = get_post_meta( get_the_ID(), 'pooja_day_type', true ) ?: 'Daily';
                        $groups[ $day ][] = [
                            'id'    => get_the_ID(),
                            'title' => get_the_title(),
                            'start' => get_post_meta( get_the_ID(), 'pooja_start_time', true ),
                            'end'   => get_post_meta( get_the_ID(), 'pooja_end_time',   true ),
                            'type'  => get_post_meta( get_the_ID(), 'pooja_type',       true ),
                        ];
                    }
                    wp_reset_postdata();
                }
                ?>

                <?php if ( ! empty( $groups ) ) : ?>
                    <?php foreach ( $groups as $day => $poojas ) : ?>
                    <div class="pooja-timings-widget" style="margin-bottom:var(--space-lg)">
                        <div class="widget-header">
                            <span class="header-icon" aria-hidden="true">&#9719;</span>
                            <h3><?php echo esc_html( $day ); ?> <?php esc_html_e( 'Pooja Schedule', 'pachamala-temple' ); ?></h3>
                        </div>
                        <table class="pooja-table">
                            <thead>
                                <tr>
                                    <th><?php esc_html_e( 'Pooja Name', 'pachamala-temple' ); ?></th>
                                    <th><?php esc_html_e( 'Time', 'pachamala-temple' ); ?></th>
                                    <th><?php esc_html_e( 'Type', 'pachamala-temple' ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $poojas as $p ) :
                                    $type_class = strtolower( str_replace( ' ', '-', explode( ' ', $p['type'] )[0] ?? '' ) );
                                ?>
                                <tr>
                                    <td><strong><?php echo esc_html( $p['title'] ); ?></strong></td>
                                    <td class="pooja-time">
                                        <?php
                                        echo esc_html( pkt_format_time( $p['start'] ) );
                                        if ( $p['end'] ) echo ' – ' . esc_html( pkt_format_time( $p['end'] ) );
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ( $p['type'] ) : ?>
                                            <span class="pooja-type-badge pooja-type-<?php echo esc_attr( $type_class ); ?>">
                                                <?php echo esc_html( $p['type'] ); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endforeach; ?>

                <?php else : ?>
                    <!-- Default pooja schedule when no CPT data entered -->
                    <div class="pooja-timings-widget">
                        <div class="widget-header">
                            <span class="header-icon" aria-hidden="true">&#9719;</span>
                            <h3><?php esc_html_e( 'Daily Pooja Schedule', 'pachamala-temple' ); ?></h3>
                        </div>
                        <table class="pooja-table">
                            <thead>
                                <tr><th><?php esc_html_e( 'Pooja Name', 'pachamala-temple' ); ?></th><th><?php esc_html_e( 'Time', 'pachamala-temple' ); ?></th><th><?php esc_html_e( 'Type', 'pachamala-temple' ); ?></th></tr>
                            </thead>
                            <tbody>
                                <?php
                                $defaults = [
                                    [ 'Thiruvanandal',  '6:00 AM',  '8:00 AM',  'Morning Pooja' ],
                                    [ 'Kalasandhi',     '8:00 AM',  '9:30 AM',  'Morning Pooja' ],
                                    [ 'Uchikalam',      '12:00 PM', '1:00 PM',  'Noon Pooja'    ],
                                    [ 'Sayarakshai',    '6:00 PM',  '7:30 PM',  'Evening Pooja' ],
                                    [ 'Irandham Kaalam','7:30 PM',  '8:30 PM',  'Evening Pooja' ],
                                    [ 'Ardhajamam',     '8:30 PM',  '9:30 PM',  'Night Pooja'   ],
                                ];
                                foreach ( $defaults as $d ) :
                                    $tc = strtolower( str_replace( ' ', '-', explode( ' ', $d[3] )[0] ) );
                                ?>
                                <tr>
                                    <td><strong><?php echo esc_html( $d[0] ); ?></strong></td>
                                    <td class="pooja-time"><?php echo esc_html( $d[1] ); ?> – <?php echo esc_html( $d[2] ); ?></td>
                                    <td><span class="pooja-type-badge pooja-type-<?php echo esc_attr( $tc ); ?>"><?php echo esc_html( $d[3] ); ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="temple-card" style="margin-top:var(--space-lg);background:var(--color-bg-dark)">
                        <h3 style="color:var(--color-primary);margin-bottom:var(--space-sm)"><?php esc_html_e( 'Special Friday Pooja', 'pachamala-temple' ); ?></h3>
                        <p><?php esc_html_e( 'Every Friday, special Abhishekam and Archana is performed with elaborate rituals. Devotees are encouraged to participate in the evening pooja starting at 7:00 PM.', 'pachamala-temple' ); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Note box -->
                <div class="temple-card" style="margin-top:var(--space-lg);border-top-color:var(--color-accent)">
                    <p style="margin:0;font-size:.9rem;color:var(--color-text-muted)">
                        <strong><?php esc_html_e( 'Note:', 'pachamala-temple' ); ?></strong> <?php esc_html_e( 'Temple timings may vary on festival days. Please contact us for special occasion schedules.', 'pachamala-temple' ); ?>
                    </p>
                </div>

            </main>
            <aside class="content-sidebar">
                <?php dynamic_sidebar( 'sidebar-pooja' ); ?>
            </aside>
        </div>
    </div>
</section>

<?php get_footer(); ?>
