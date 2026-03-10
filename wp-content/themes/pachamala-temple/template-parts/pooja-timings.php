<?php
/**
 * Pooja Timings Widget — Template Part
 *
 * @package PachamalaTemple
 */

$today     = date( 'l' ); // e.g. "Monday"
$pq        = pkt_get_pooja_timings( $today );
$has_data  = $pq->have_posts();
?>
<div class="pooja-timings-widget">
    <div class="widget-header">
        <span class="header-icon" aria-hidden="true">&#9719;</span>
        <h3><?php esc_html_e( "Today's Pooja Timings", 'pachamala-temple' ); ?></h3>
    </div>

    <?php if ( $has_data ) : ?>
    <table class="pooja-table">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Pooja', 'pachamala-temple' ); ?></th>
                <th><?php esc_html_e( 'Time', 'pachamala-temple' ); ?></th>
                <th><?php esc_html_e( 'Type', 'pachamala-temple' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php while ( $pq->have_posts() ) : $pq->the_post();
                $start = get_post_meta( get_the_ID(), 'pooja_start_time', true );
                $end   = get_post_meta( get_the_ID(), 'pooja_end_time',   true );
                $type  = get_post_meta( get_the_ID(), 'pooja_type',       true );
                $slug  = sanitize_title( $type );
            ?>
            <tr>
                <td><?php the_title(); ?></td>
                <td class="pooja-time">
                    <?php
                    echo esc_html( pkt_format_time( $start ) );
                    if ( $end ) echo ' – ' . esc_html( pkt_format_time( $end ) );
                    ?>
                </td>
                <td>
                    <?php if ( $type ) : ?>
                        <span class="pooja-type-badge pooja-type-<?php echo esc_attr( strtolower( str_replace( ' ', '-', explode( ' ', $type )[0] ) ) ); ?>">
                            <?php echo esc_html( $type ); ?>
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; wp_reset_postdata(); ?>
        </tbody>
    </table>

    <?php else : ?>
    <!-- Default timings when no CPT data entered yet -->
    <table class="pooja-table">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Pooja', 'pachamala-temple' ); ?></th>
                <th><?php esc_html_e( 'Time', 'pachamala-temple' ); ?></th>
                <th><?php esc_html_e( 'Type', 'pachamala-temple' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $defaults = [
                [ 'Thiruvanandal', '6:00 AM', '8:00 AM', 'Morning Pooja' ],
                [ 'Kalasandhi',    '8:00 AM', '9:30 AM', 'Morning Pooja' ],
                [ 'Uchikalam',    '12:00 PM','1:00 PM',  'Noon Pooja'    ],
                [ 'Sayarakshai',   '6:00 PM', '7:30 PM', 'Evening Pooja' ],
                [ 'Ardhajamam',    '8:30 PM', '9:30 PM', 'Night Pooja'   ],
            ];
            foreach ( $defaults as $d ) :
                $type_class = strtolower( str_replace( ' ', '-', explode( ' ', $d[3] )[0] ) );
            ?>
            <tr>
                <td><?php echo esc_html( $d[0] ); ?></td>
                <td class="pooja-time"><?php echo esc_html( $d[1] ); ?> – <?php echo esc_html( $d[2] ); ?></td>
                <td><span class="pooja-type-badge pooja-type-<?php echo esc_attr( $type_class ); ?>"><?php echo esc_html( $d[3] ); ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <div style="padding:.75rem 1rem;text-align:right;border-top:1px solid var(--color-border)">
        <a href="<?php echo esc_url( home_url( '/pooja-timings' ) ); ?>" style="font-size:.8rem;color:var(--color-primary)">
            <?php esc_html_e( 'View Full Schedule', 'pachamala-temple' ); ?> &rarr;
        </a>
    </div>
</div>
