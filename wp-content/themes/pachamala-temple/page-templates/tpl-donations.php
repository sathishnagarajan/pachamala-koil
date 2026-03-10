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
                    <h2 style="color:var(--color-primary);margin-bottom:var(--space-md)">Why Donate?</h2>
                    <p>Your generous contribution goes directly towards:</p>
                    <ul style="list-style:none;padding:0;margin:var(--space-md) 0 0">
                        <?php
                        $reasons = [
                            '🪔' => 'Daily pooja essentials — flowers, lamps, incense',
                            '🏛' => 'Temple maintenance and renovation',
                            '🥁' => 'Festival celebrations and cultural programmes',
                            '🍱' => 'Prasadam (sacred food) distribution to devotees',
                            '📚' => 'Temple education and cultural activities',
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
                <h2 style="color:var(--color-primary);margin-bottom:var(--space-md)">Donation Options</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:var(--space-md);margin-bottom:var(--space-xl)">
                    <?php
                    $options = [
                        [ '₹101',   'Lamp Sponsorship',     'Sponsor a daily lamp in the temple sanctum' ],
                        [ '₹501',   'Flower Archana',       'Sponsor one day of flower decoration' ],
                        [ '₹1,001', 'Abhishekam',           'Sponsor a special Abhishekam ritual' ],
                        [ '₹5,001', 'Festival Sponsorship', 'Contribute to a grand festival celebration' ],
                    ];
                    foreach ( $options as $opt ) : ?>
                    <div class="temple-card" style="text-align:center">
                        <div style="font-size:1.8rem;font-family:var(--font-heading);color:var(--color-secondary);margin-bottom:.5rem">
                            <?php echo esc_html( $opt[0] ); ?>
                        </div>
                        <h4 style="color:var(--color-primary);margin-bottom:.5rem"><?php echo esc_html( $opt[1] ); ?></h4>
                        <p style="font-size:.85rem;color:var(--color-text-muted);margin-bottom:var(--space-md)"><?php echo esc_html( $opt[2] ); ?></p>
                        <a href="#donate-form" class="btn btn-gold" style="width:100%;text-align:center">Donate</a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Bank Transfer details -->
                <div class="temple-card" id="donate-form" style="border-top-color:var(--color-secondary)">
                    <h3 style="color:var(--color-primary);margin-bottom:var(--space-md)">Bank Transfer Details</h3>
                    <table style="width:100%;border-collapse:collapse">
                        <?php
                        $bank = [
                            'Account Name'   => 'Pachaimalai Athireeswarar Temple Trust',
                            'Account Number' => 'XXXX XXXX XXXX',
                            'IFSC Code'      => 'XXXXX0000000',
                            'Bank Name'      => 'State Bank of India',
                            'Branch'         => 'Chennai',
                        ];
                        foreach ( $bank as $label => $value ) : ?>
                        <tr style="border-bottom:1px solid var(--color-bg-dark)">
                            <td style="padding:.6rem;font-weight:700;width:40%;color:var(--color-text-muted);font-size:.9rem"><?php echo esc_html( $label ); ?></td>
                            <td style="padding:.6rem;font-size:.9rem"><?php echo esc_html( $value ); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <p style="margin-top:var(--space-md);font-size:.85rem;color:var(--color-text-muted)">
                        Please WhatsApp or email us your transaction details for acknowledgement and receipt.
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
