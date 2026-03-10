<?php
/**
 * Gallery Grid — Template Part
 *
 * Accepts optional $args['query'] (WP_Query object).
 *
 * @package PachamalaTemple
 */

$gallery_query = $args['query'] ?? null;
if ( ! $gallery_query ) {
    $gallery_query = new WP_Query( [
        'post_type'      => 'gallery_item',
        'posts_per_page' => 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ] );
}
?>
<?php if ( $gallery_query->have_posts() ) : ?>
<div class="gallery-grid">
    <?php while ( $gallery_query->have_posts() ) : $gallery_query->the_post();
        $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'gallery-thumb' );
        $full_url  = get_the_post_thumbnail_url( get_the_ID(), 'full' );
        $cats      = get_the_terms( get_the_ID(), 'gallery_category' );
        $cat_slugs = $cats ? implode( ' ', array_map( fn($c) => $c->slug, $cats ) ) : '';
    ?>
    <div class="gallery-item <?php echo esc_attr( $cat_slugs ); ?>">
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
            <div style="background:var(--color-bg-dark);width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:2rem;min-height:200px">
                🏛
            </div>
        <?php endif; ?>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
</div>
<?php endif; ?>
