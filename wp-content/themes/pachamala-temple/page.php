<?php
/**
 * Generic Page Template
 *
 * @package PachamalaTemple
 */

get_header(); ?>

<!-- Page Banner -->
<div class="page-banner">
    <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <?php pkt_breadcrumbs(); ?>
    </div>
</div>

<!-- Page Content -->
<section class="page-content-section">
    <div class="container">
        <div class="content-grid">
            <main class="main-content">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div style="margin-bottom:var(--space-lg)">
                            <?php the_post_thumbnail( 'large', [ 'style' => 'width:100%;border-radius:var(--radius-md)' ] ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <?php
                    wp_link_pages( [
                        'before' => '<nav class="page-links"><span>' . esc_html__( 'Pages:', 'pachamala-temple' ) . '</span>',
                        'after'  => '</nav>',
                    ] );
                    ?>
                <?php endwhile; ?>
            </main>

            <aside class="content-sidebar">
                <?php dynamic_sidebar( 'sidebar-pooja' ); ?>
            </aside>
        </div>
    </div>
</section>

<?php get_footer(); ?>
