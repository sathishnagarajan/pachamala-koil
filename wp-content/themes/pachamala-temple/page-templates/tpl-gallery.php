<?php
/**
 * Template Name: Gallery Page
 *
 * @package PachamalaTemple
 */

get_header(); ?>

<!-- Page Banner -->
<div class="page-banner">
    <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <p style="color:rgba(255,255,255,.7);font-family:var(--font-tamil)" lang="ta">கோவில் படங்கள்</p>
        <?php pkt_breadcrumbs(); ?>
    </div>
</div>

<section class="page-content-section">
    <div class="container">

        <?php
        // Gallery category filter tabs
        $gallery_cats = get_terms( [
            'taxonomy'   => 'gallery_category',
            'hide_empty' => true,
        ] );
        ?>

        <?php if ( ! is_wp_error( $gallery_cats ) && ! empty( $gallery_cats ) ) : ?>
        <div class="gallery-filters" id="gallery-filters">
            <button class="filter-btn active" data-filter="all"><?php esc_html_e( 'All Photos', 'pachamala-temple' ); ?></button>
            <?php foreach ( $gallery_cats as $cat ) : ?>
                <button class="filter-btn" data-filter="<?php echo esc_attr( $cat->slug ); ?>">
                    <?php echo esc_html( $cat->name ); ?>
                    <span style="font-size:.75em;opacity:.7">(<?php echo esc_html( $cat->count ); ?>)</span>
                </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php
        // All gallery items
        $gallery_query = new WP_Query( [
            'post_type'      => 'gallery_item',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ] );
        ?>

        <?php if ( $gallery_query->have_posts() ) : ?>
        <div class="gallery-grid" id="gallery-masonry"
             style="grid-template-columns:repeat(auto-fill,minmax(240px,1fr))">
            <?php while ( $gallery_query->have_posts() ) : $gallery_query->the_post();
                $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'gallery-thumb' );
                $full_url  = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                $cats      = get_the_terms( get_the_ID(), 'gallery_category' );
                $cat_slugs = $cats && ! is_wp_error( $cats )
                    ? implode( ' ', array_map( fn( $c ) => $c->slug, $cats ) )
                    : '';
            ?>
            <div class="gallery-item <?php echo esc_attr( $cat_slugs ); ?>" data-category="<?php echo esc_attr( $cat_slugs ); ?>">
                <?php if ( $thumb_url ) : ?>
                    <a href="<?php echo esc_url( $full_url ?: $thumb_url ); ?>"
                       class="lightbox-trigger"
                       data-caption="<?php the_title_attribute(); ?>">
                        <img src="<?php echo esc_url( $thumb_url ); ?>"
                             alt="<?php the_title_attribute(); ?>"
                             loading="lazy">
                        <div class="gallery-overlay">
                            <span class="gallery-title"><?php the_title(); ?></span>
                        </div>
                    </a>
                <?php else : ?>
                    <div style="background:var(--color-bg-dark);display:flex;align-items:center;justify-content:center;height:100%;min-height:200px;font-size:3rem">
                        🏛
                    </div>
                <?php endif; ?>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <?php else : ?>
        <div class="temple-card" style="text-align:center;padding:3rem">
            <p style="font-size:3rem;margin-bottom:1rem">📷</p>
            <p><?php esc_html_e( 'Gallery photos will be added soon. Check back later!', 'pachamala-temple' ); ?></p>
        </div>
        <?php endif; ?>

    </div><!-- .container -->
</section>

<?php get_footer(); ?>
