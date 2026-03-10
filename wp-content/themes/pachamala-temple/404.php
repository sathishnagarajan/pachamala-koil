<?php
/**
 * 404 Not Found Template
 *
 * @package PachamalaTemple
 */

get_header(); ?>

<section class="page-content-section">
    <div class="container">
        <div class="error-404 content-grid full-width" style="text-align:center;padding:var(--space-2xl) 0">
            <div class="error-code" style="font-size:8rem;font-family:var(--font-heading);color:var(--color-primary);line-height:1;opacity:.15;pointer-events:none">
                404
            </div>
            <div style="margin-top:-4rem;position:relative;z-index:1">
                <p style="font-size:3rem;margin-bottom:var(--space-md)">ॐ</p>
                <h1 style="font-family:var(--font-tamil);color:var(--color-primary);font-size:1.8rem;margin-bottom:var(--space-sm)" lang="ta">
                    பக்கம் கிடைக்கவில்லை
                </h1>
                <h2 style="color:var(--color-text-muted);font-size:1.2rem;font-weight:400;margin-bottom:var(--space-lg)">
                    <?php esc_html_e( 'The page you are looking for could not be found.', 'pachamala-temple' ); ?>
                </h2>
                <div style="display:flex;gap:var(--space-md);justify-content:center;flex-wrap:wrap">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                        &larr; <?php esc_html_e( 'Return Home', 'pachamala-temple' ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-outline-gold">
                        <?php esc_html_e( 'Contact Us', 'pachamala-temple' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
