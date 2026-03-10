<?php
/**
 * Front Page (Homepage) Template
 *
 * @package PachamalaTemple
 */

get_header(); ?>

<!-- =========================================================
     1. HERO SECTION
     ========================================================= -->
<?php get_template_part( 'template-parts/hero' ); ?>

<!-- =========================================================
     2. WELCOME STRIP (3-column info bar)
     ========================================================= -->
<section class="welcome-strip">
    <div class="container">
        <div class="welcome-grid">
            <div class="welcome-item">
                <div class="welcome-icon">ॐ</div>
                <h3>Sacred Shrine</h3>
                <p lang="ta">அருள்மிகு ஆதிரீஸ்வரர்<br>அனுசியாம்பாள் திருக்கோவில்</p>
            </div>
            <div class="welcome-item">
                <div class="welcome-icon">&#127774;</div>
                <h3>Daily Poojas</h3>
                <p>Daily rituals performed with devotion from early morning to night. Experience divine blessings.</p>
            </div>
            <div class="welcome-item">
                <div class="welcome-icon">&#127880;</div>
                <h3>Festivals &amp; Events</h3>
                <p>Grand celebrations of Tamil Hindu festivals throughout the year. Join us in devotion.</p>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     3. TODAY'S POOJA TIMINGS + UPCOMING EVENTS
     ========================================================= -->
<section class="today-section section-padding" id="pooja-timings">
    <div class="container">
        <h2 class="section-title">Daily Worship &amp; Events</h2>
        <p class="section-subtitle" lang="ta">தினசரி வழிபாடு மற்றும் நிகழ்வுகள்</p>
        <div class="today-grid">
            <div class="today-poojas">
                <?php get_template_part( 'template-parts/pooja-timings' ); ?>
            </div>
            <div class="upcoming-events-col">
                <?php get_template_part( 'template-parts/upcoming-events' ); ?>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     4. DEITIES SECTION
     ========================================================= -->
<section class="deities-section section-padding" id="deities">
    <div class="container">
        <h2 class="section-title">Our Deities</h2>
        <p class="section-subtitle" lang="ta">இறைவன் — இறைவி</p>
        <?php get_template_part( 'template-parts/deity-card' ); ?>
    </div>
</section>

<!-- =========================================================
     5. GALLERY PREVIEW
     ========================================================= -->
<?php
$gallery_query = new WP_Query( [
    'post_type'      => 'gallery_item',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
] );

if ( $gallery_query->have_posts() ) : ?>
<section class="gallery-preview-section section-padding" id="gallery">
    <div class="container">
        <h2 class="section-title">Temple Gallery</h2>
        <p class="section-subtitle" lang="ta">கோவில் படங்கள்</p>
        <?php get_template_part( 'template-parts/gallery-grid', null, [ 'query' => $gallery_query ] ); ?>
        <div class="text-center" style="margin-top:2rem">
            <a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>" class="btn btn-primary">
                View All Photos
            </a>
        </div>
    </div>
</section>
<?php
wp_reset_postdata();
endif;
?>

<!-- =========================================================
     6. DONATION CTA
     ========================================================= -->
<section class="donation-cta-section section-padding">
    <div class="container">
        <h2>Support the Temple</h2>
        <p>Your contribution helps us maintain the sanctity of this sacred shrine, conduct daily poojas, and celebrate grand festivals.</p>
        <p lang="ta" style="color:rgba(255,255,255,.65);font-size:.9rem;margin-bottom:1.5rem">
            உங்கள் கொடை கோவிலை காக்கும்
        </p>
        <a href="<?php echo esc_url( home_url( '/donations' ) ); ?>" class="btn btn-gold">
            Donate Now
        </a>
    </div>
</section>

<?php get_footer(); ?>
