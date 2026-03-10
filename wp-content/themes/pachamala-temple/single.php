<?php
/**
 * Single Post Template
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

<section class="page-content-section">
    <div class="container">
        <div class="content-grid">
            <main class="main-content">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <!-- Post Meta -->
                        <div style="font-size:.85rem;color:var(--color-text-muted);margin-bottom:var(--space-md);display:flex;gap:var(--space-md);flex-wrap:wrap;font-family:var(--font-ui)">
                            <span><?php echo esc_html( get_the_date() ); ?></span>
                            <?php if ( get_the_category() ) : ?>
                                <span><?php the_category( ', ' ); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Featured Image -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div style="margin-bottom:var(--space-lg)">
                                <?php the_post_thumbnail( 'large', [ 'style' => 'width:100%;border-radius:var(--radius-md)' ] ); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>

                        <?php
                        wp_link_pages( [
                            'before' => '<nav class="page-links"><span>' . esc_html__( 'Pages:', 'pachamala-temple' ) . '</span>',
                            'after'  => '</nav>',
                        ] );
                        ?>

                        <!-- Post Navigation -->
                        <nav class="post-navigation" style="margin-top:var(--space-xl);display:flex;justify-content:space-between;gap:var(--space-md)">
                            <div><?php previous_post_link( '&laquo; %link', esc_html__( 'Previous', 'pachamala-temple' ) ); ?></div>
                            <div><?php next_post_link( '%link &raquo;', esc_html__( 'Next', 'pachamala-temple' ) ); ?></div>
                        </nav>

                    </article>
                <?php endwhile; ?>
            </main>

            <aside class="content-sidebar">
                <?php dynamic_sidebar( 'sidebar-pooja' ); ?>
            </aside>
        </div>
    </div>
</section>

<?php get_footer(); ?>
