<?php
/**
 * Archive Template — handles temple_event archives and more
 *
 * @package PachamalaTemple
 */

get_header();

$pt = get_post_type();
?>

<!-- Page Banner -->
<div class="page-banner">
    <div class="container">
        <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
        <?php the_archive_description( '<p style="color:rgba(255,255,255,.7);margin-top:.5rem">', '</p>' ); ?>
        <?php pkt_breadcrumbs(); ?>
    </div>
</div>

<section class="page-content-section">
    <div class="container">
        <div class="content-grid">
            <main class="main-content">
                <?php if ( have_posts() ) : ?>
                    <?php if ( $pt === 'temple_event' ) : ?>
                        <!-- Events layout -->
                        <div style="display:grid;gap:var(--space-lg)">
                            <?php while ( have_posts() ) : the_post();
                                $event_date  = get_post_meta( get_the_ID(), 'event_date',  true );
                                $event_time  = get_post_meta( get_the_ID(), 'event_time',  true );
                                $significance = get_post_meta( get_the_ID(), 'event_significance', true );
                            ?>
                            <article class="temple-card" style="display:flex;gap:var(--space-lg)">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div style="flex-shrink:0;width:200px">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'event-banner', [ 'style' => 'width:100%;height:150px;object-fit:cover;border-radius:var(--radius-sm)' ] ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div style="flex:1">
                                    <h2 style="font-size:1.2rem;margin-bottom:.5rem">
                                        <a href="<?php the_permalink(); ?>" style="color:var(--color-primary)"><?php the_title(); ?></a>
                                    </h2>
                                    <?php if ( $event_date ) : ?>
                                        <p style="font-size:.85rem;color:var(--color-secondary);margin-bottom:.5rem">
                                            📅 <?php echo esc_html( pkt_format_event_date( $event_date ) ); ?>
                                            <?php if ( $event_time ) echo ' &nbsp;⏰ ' . esc_html( $event_time ); ?>
                                        </p>
                                    <?php endif; ?>
                                    <p style="margin:0;font-size:.9rem;color:var(--color-text-muted)"><?php the_excerpt(); ?></p>
                                    <?php if ( $significance ) : ?>
                                        <p style="font-family:var(--font-tamil);font-size:.85rem;color:var(--color-text-muted);margin-top:.5rem" lang="ta">
                                            <?php echo esc_html( $significance ); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </article>
                            <?php endwhile; ?>
                        </div>

                    <?php else : ?>
                        <!-- Generic archive layout -->
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:var(--space-lg)">
                            <?php while ( have_posts() ) : the_post(); ?>
                            <article class="temple-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'card-thumb', [ 'style' => 'width:100%;height:180px;object-fit:cover;border-radius:var(--radius-sm) var(--radius-sm) 0 0;margin:-1.5rem -1.5rem 1rem;width:calc(100% + 3rem)' ] ); ?>
                                    </a>
                                <?php endif; ?>
                                <h3 style="font-size:1.1rem;margin-bottom:.5rem">
                                    <a href="<?php the_permalink(); ?>" style="color:var(--color-primary)"><?php the_title(); ?></a>
                                </h3>
                                <p style="font-size:.8rem;color:var(--color-text-muted);margin-bottom:.75rem"><?php echo esc_html( get_the_date() ); ?></p>
                                <p style="font-size:.9rem"><?php the_excerpt(); ?></p>
                            </article>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                    <div style="margin-top:var(--space-xl)">
                        <?php the_posts_pagination( [
                            'mid_size'  => 2,
                            'prev_text' => '&laquo; ' . esc_html__( 'Previous', 'pachamala-temple' ),
                            'next_text' => esc_html__( 'Next', 'pachamala-temple' ) . ' &raquo;',
                        ] ); ?>
                    </div>

                <?php else : ?>
                    <div class="temple-card" style="text-align:center;padding:3rem">
                        <p style="font-size:3rem;margin-bottom:1rem">🙏</p>
                        <p><?php esc_html_e( 'No content found in this archive.', 'pachamala-temple' ); ?></p>
                    </div>
                <?php endif; ?>
            </main>

            <aside class="content-sidebar">
                <?php dynamic_sidebar( 'sidebar-pooja' ); ?>
            </aside>
        </div>
    </div>
</section>

<?php get_footer(); ?>
