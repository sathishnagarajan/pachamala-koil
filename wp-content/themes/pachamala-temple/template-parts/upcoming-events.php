<?php
/**
 * Upcoming Events Widget — Template Part
 *
 * @package PachamalaTemple
 */

$events = pkt_get_upcoming_events( 4 );
?>
<div class="events-widget">
    <div class="widget-header">
        <span class="header-icon" aria-hidden="true">&#128197;</span>
        <h3><?php esc_html_e( 'Upcoming Festivals &amp; Events', 'pachamala-temple' ); ?></h3>
    </div>

    <?php if ( $events->have_posts() ) : ?>
        <?php while ( $events->have_posts() ) : $events->the_post();
            $event_date = get_post_meta( get_the_ID(), 'event_date', true );
            $event_time = get_post_meta( get_the_ID(), 'event_time', true );
            $day   = $event_date ? date_i18n( 'j',   strtotime( $event_date ) ) : '—';
            $month = $event_date ? date_i18n( 'M',   strtotime( $event_date ) ) : '';
        ?>
        <a class="event-card" href="<?php the_permalink(); ?>">
            <div class="event-date-box">
                <span class="event-date-day"><?php echo esc_html( $day ); ?></span>
                <span class="event-date-month"><?php echo esc_html( $month ); ?></span>
            </div>
            <div class="event-info">
                <h4><?php the_title(); ?></h4>
                <?php if ( $event_time ) : ?>
                    <p><?php echo esc_html( $event_time ); ?></p>
                <?php else : ?>
                    <p><?php echo esc_html( get_the_excerpt() ); ?></p>
                <?php endif; ?>
            </div>
        </a>
        <?php endwhile; wp_reset_postdata(); ?>

    <?php else : ?>
        <!-- Placeholder events when no CPT data yet -->
        <?php
        $placeholders = [
            [ 'day' => '14', 'month' => 'Jan', 'title' => __( 'Pongal Celebration', 'pachamala-temple' ),   'desc' => __( 'Thai Pongal Festival', 'pachamala-temple' )            ],
            [ 'day' => '17', 'month' => 'Jan', 'title' => __( 'Thiruvadirai Festival', 'pachamala-temple' ),'desc' => __( 'Arudra Darshan', 'pachamala-temple' )                   ],
            [ 'day' => '01', 'month' => 'Feb', 'title' => __( 'Thai Poosam', 'pachamala-temple' ),          'desc' => __( 'Grand celebration for devotees', 'pachamala-temple' )  ],
            [ 'day' => '08', 'month' => 'Mar', 'title' => __( 'Maha Shivaratri', 'pachamala-temple' ),      'desc' => __( 'Night-long special poojas', 'pachamala-temple' )        ],
        ];
        foreach ( $placeholders as $p ) : ?>
        <div class="event-card" style="cursor:default">
            <div class="event-date-box">
                <span class="event-date-day"><?php echo esc_html( $p['day'] ); ?></span>
                <span class="event-date-month"><?php echo esc_html( $p['month'] ); ?></span>
            </div>
            <div class="event-info">
                <h4><?php echo esc_html( $p['title'] ); ?></h4>
                <p><?php echo esc_html( $p['desc'] ); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div style="padding:.75rem 1rem;text-align:right;border-top:1px solid var(--color-border)">
        <a href="<?php echo esc_url( home_url( '/events' ) ); ?>" style="font-size:.8rem;color:var(--color-primary)">
            <?php esc_html_e( 'View All Events', 'pachamala-temple' ); ?> &rarr;
        </a>
    </div>
</div>
