<?php
/**
 * Template Name: Donations Page
 *
 * @package PachamalaTemple
 */

get_header(); ?>

<!-- Page Banner -->
<div class="page-banner">
    <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <p style="color:rgba(255,255,255,.7);font-family:var(--font-tamil)" lang="ta">கோவிலுக்கு உதவுங்கள்</p>
        <?php pkt_breadcrumbs(); ?>
    </div>
</div>

<section class="page-content-section">
    <div class="container">
        <div class="content-grid">
            <main class="main-content">

                <!-- Page intro from WP editor -->
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php if ( get_the_content() ) : ?>
                        <div class="entry-content" style="margin-bottom:var(--space-xl)">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>

                <!-- Why Donate section -->
                <div class="temple-card" style="margin-bottom:var(--space-lg)">
                    <h2 style="color:var(--color-primary);margin-bottom:var(--space-md)"><?php esc_html_e( 'Why Donate?', 'pachamala-temple' ); ?></h2>
                    <p><?php esc_html_e( 'Your generous contribution goes directly towards:', 'pachamala-temple' ); ?></p>
                    <ul style="list-style:none;padding:0;margin:var(--space-md) 0 0">
                        <?php
                        $reasons = [
                            '🪔' => __( 'Daily pooja essentials — flowers, lamps, incense', 'pachamala-temple' ),
                            '🏛' => __( 'Temple maintenance and renovation', 'pachamala-temple' ),
                            '🥁' => __( 'Festival celebrations and cultural programmes', 'pachamala-temple' ),
                            '🍱' => __( 'Prasadam (sacred food) distribution to devotees', 'pachamala-temple' ),
                            '📚' => __( 'Temple education and cultural activities', 'pachamala-temple' ),
                        ];
                        foreach ( $reasons as $icon => $reason ) : ?>
                        <li style="display:flex;gap:.75rem;padding:.6rem 0;border-bottom:1px solid var(--color-bg-dark)">
                            <span style="font-size:1.2rem"><?php echo $icon; ?></span>
                            <span><?php echo esc_html( $reason ); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Donation options -->
                <h2 style="color:var(--color-primary);margin-bottom:var(--space-md)"><?php esc_html_e( 'Donation Options', 'pachamala-temple' ); ?></h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:var(--space-md);margin-bottom:var(--space-xl)">
                    <?php
                    $options = [
                        [ '₹101',   __( 'Lamp Sponsorship', 'pachamala-temple' ),     __( 'Sponsor a daily lamp in the temple sanctum', 'pachamala-temple' ) ],
                        [ '₹501',   __( 'Flower Archana', 'pachamala-temple' ),       __( 'Sponsor one day of flower decoration', 'pachamala-temple' ) ],
                        [ '₹1,001', __( 'Abhishekam', 'pachamala-temple' ),           __( 'Sponsor a special Abhishekam ritual', 'pachamala-temple' ) ],
                        [ '₹5,001', __( 'Festival Sponsorship', 'pachamala-temple' ), __( 'Contribute to a grand festival celebration', 'pachamala-temple' ) ],
                    ];
                    foreach ( $options as $opt ) : ?>
                    <div class="temple-card" style="text-align:center">
                        <div style="font-size:1.8rem;font-family:var(--font-heading);color:var(--color-secondary);margin-bottom:.5rem">
                            <?php echo esc_html( $opt[0] ); ?>
                        </div>
                        <h4 style="color:var(--color-primary);margin-bottom:.5rem"><?php echo esc_html( $opt[1] ); ?></h4>
                        <p style="font-size:.85rem;color:var(--color-text-muted);margin-bottom:var(--space-md)"><?php echo esc_html( $opt[2] ); ?></p>
                        <a href="#donate-form" class="btn btn-gold" style="width:100%;text-align:center"><?php esc_html_e( 'Donate', 'pachamala-temple' ); ?></a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Bank Transfer details -->
                <div class="temple-card" id="donate-form" style="border-top-color:var(--color-secondary)">
                    <h3 style="color:var(--color-primary);margin-bottom:var(--space-md)"><?php esc_html_e( 'Bank Transfer Details', 'pachamala-temple' ); ?></h3>
                    <table style="width:100%;border-collapse:collapse">
                        <?php
                        $bank = [
                            __( 'Account Name', 'pachamala-temple' )   => 'Pachaimalai Athireeswarar Temple Trust',
                            __( 'Account Number', 'pachamala-temple' ) => 'XXXX XXXX XXXX',
                            __( 'IFSC Code', 'pachamala-temple' )      => 'XXXXX0000000',
                            __( 'Bank Name', 'pachamala-temple' )      => 'State Bank of India',
                            __( 'Branch', 'pachamala-temple' )         => 'Chennai',
                        ];
                        foreach ( $bank as $label => $value ) : ?>
                        <tr style="border-bottom:1px solid var(--color-bg-dark)">
                            <td style="padding:.6rem;font-weight:700;width:40%;color:var(--color-text-muted);font-size:.9rem"><?php echo esc_html( $label ); ?></td>
                            <td style="padding:.6rem;font-size:.9rem"><?php echo esc_html( $value ); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <p style="margin-top:var(--space-md);font-size:.85rem;color:var(--color-text-muted)">
                        <?php esc_html_e( 'Please WhatsApp or email us your transaction details for acknowledgement and receipt.', 'pachamala-temple' ); ?>
                    </p>
                </div>

                <!-- Contact for donations -->
                <div class="temple-card" style="margin-top:var(--space-lg);background:var(--color-primary);color:var(--color-white);text-align:center">
                    <p style="color:rgba(255,255,255,.9);margin:0">
                        For large donations or to discuss sponsorship opportunities, please
                        <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" style="color:var(--color-gold-light)">contact us</a>
                        directly.
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
