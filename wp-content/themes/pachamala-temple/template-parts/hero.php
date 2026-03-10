<?php
/**
 * Hero Section Template Part
 *
 * @package PachamalaTemple
 */
?>
<section class="hero-section"
         style="background-image: url('<?php echo esc_url( get_header_image() ?: PKT_ASSETS_URI . '/images/temple-hero-bg.jpg' ); ?>'); background-size:cover; background-position:center center;">
    <div class="hero-overlay" aria-hidden="true"></div>
    <div class="hero-content">

        <!-- Om Symbol -->
        <div class="hero-om" aria-hidden="true">ॐ</div>

        <!-- Temple Name in Tamil -->
        <h1 class="hero-title-tamil" lang="ta">
            அருள்மிகு பச்சைமலை ஆதிரீஸ்வரர் திருக்கோவில்
        </h1>

        <!-- Consort Name -->
        <p class="hero-subtitle-tamil" lang="ta">
            அன்னை அனுசியாம்பாள் சமேத ஆதிரீஸ்வரர்
        </p>

        <!-- Decorative Divider -->
        <div class="hero-divider" aria-hidden="true">✦</div>

        <!-- English Subtitle -->
        <p class="hero-subtitle-en">
            Pachaimalai Athireeswarar Temple, Chennai
        </p>

        <!-- CTA Buttons -->
        <div class="hero-ctas">
            <a href="#pooja-timings" class="btn btn-gold">
                Today's Pooja Timings
            </a>
            <a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="btn btn-outline-white">
                About the Temple
            </a>
        </div>

    </div>
</section>
