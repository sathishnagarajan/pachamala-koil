</main><!-- #main -->

<!-- Decorative border above footer -->
<div class="header-gold-border" aria-hidden="true"></div>

<!-- ========================================================
     SITE FOOTER
     ======================================================== -->
<footer class="site-footer" role="contentinfo">

    <!-- Footer Widgets -->
    <div class="footer-widgets-area">
        <div class="container">
            <div class="footer-grid">

                <!-- Column 1: Temple about -->
                <div class="footer-col footer-about">
                    <div class="footer-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo esc_url( PKT_ASSETS_URI . '/images/logo/athireeswarar-anushiyambal-logo.webp' ); ?>"
                                 alt="<?php bloginfo( 'name' ); ?>" height="70"
                                 onerror="this.style.display='none'">
                        </a>
                    </div>
                    <p class="footer-about-text" lang="ta">
                        அருள்மிகு பச்சைமலை ஆதிரீஸ்வரர் திருக்கோவில் — சென்னை.
                    </p>
                    <p class="footer-about-text">
                        A sacred Shiva temple dedicated to Lord Athireeswarar and Goddess Anushiyambal, serving devotees with daily poojas and festivals.
                    </p>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="footer-col">
                    <h4 class="footer-col-title"><?php esc_html_e( 'Quick Links', 'pachamala-temple' ); ?></h4>
                    <ul class="footer-nav-list">
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pachamala-temple' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About the Temple', 'pachamala-temple' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/deities' ) ); ?>"><?php esc_html_e( 'Deities', 'pachamala-temple' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/pooja-timings' ) ); ?>"><?php esc_html_e( 'Pooja Timings', 'pachamala-temple' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/events' ) ); ?>"><?php esc_html_e( 'Festivals &amp; Events', 'pachamala-temple' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>"><?php esc_html_e( 'Gallery', 'pachamala-temple' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/donations' ) ); ?>"><?php esc_html_e( 'Donations', 'pachamala-temple' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'pachamala-temple' ); ?></a></li>
                    </ul>
                </div>

                <!-- Column 3: Pooja Timings widget area -->
                <div class="footer-col">
                    <?php if ( is_active_sidebar( 'footer-widget-3' ) ) :
                        dynamic_sidebar( 'footer-widget-3' );
                    else : ?>
                        <h4 class="footer-col-title"><?php esc_html_e( 'Temple Timings', 'pachamala-temple' ); ?></h4>
                        <ul class="footer-nav-list">
                            <li><?php esc_html_e( 'Morning: 6:00 AM – 12:00 PM', 'pachamala-temple' ); ?></li>
                            <li><?php esc_html_e( 'Evening: 4:00 PM – 9:00 PM', 'pachamala-temple' ); ?></li>
                            <li><?php esc_html_e( 'Friday: Special Pooja 7:00 PM', 'pachamala-temple' ); ?></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Column 4: Contact -->
                <div class="footer-col">
                    <h4 class="footer-col-title"><?php esc_html_e( 'Contact Us', 'pachamala-temple' ); ?></h4>
                    <div class="footer-contact-item">
                        <span class="footer-contact-icon">&#9873;</span>
                        <address style="font-style:normal">
                            Pachaimalai Athireeswarar Temple<br>
                            Chennai, Tamil Nadu<br>
                            India
                        </address>
                    </div>
                    <div class="footer-contact-item">
                        <span class="footer-contact-icon">&#9742;</span>
                        <a href="tel:+914423456789">+91 44 2345 6789</a>
                    </div>
                    <div class="footer-contact-item">
                        <span class="footer-contact-icon">&#9993;</span>
                        <a href="mailto:info@pachaimalaiathireeswarar.org">info@pachaimalaiathireeswarar.org</a>
                    </div>
                </div>

            </div><!-- .footer-grid -->
        </div><!-- .container -->
    </div><!-- .footer-widgets-area -->

    <!-- Footer Bottom Bar -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <p class="footer-copyright">
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?>
                    <?php bloginfo( 'name' ); ?>.
                    <?php esc_html_e( 'All Rights Reserved.', 'pachamala-temple' ); ?>
                    &nbsp;|&nbsp;
                    <span style="font-size:.75rem">
                        Ubayam: <a href="https://bytesbrothers.com" target="_blank" rel="noopener noreferrer" style="color:rgba(255,255,255,.5)">bytesbrothers.com</a>
                    </span>
                </p>
                <nav class="footer-bottom-nav" aria-label="Footer Navigation">
                    <?php
                    wp_nav_menu( [
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-bottom-menu',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ] );
                    ?>
                </nav>
            </div>
        </div>
    </div>

</footer><!-- .site-footer -->

<!-- ========================================================
     DEVOTIONAL AUDIO PLAYER (fixed bottom-right)
     ======================================================== -->
<div id="audio-player" class="temple-audio-player" role="region" aria-label="Devotional Music Player">
    <audio id="devotional-audio" loop preload="none">
        <source src="<?php echo esc_url( PKT_ASSETS_URI . '/audio/devotional.mp3' ); ?>" type="audio/mpeg">
    </audio>
    <button id="audio-toggle" class="audio-btn" aria-label="Play Devotional Music" aria-pressed="false">
        <span class="audio-icon" aria-hidden="true">&#9834;</span>
        <span class="audio-label"><?php esc_html_e( 'Devotional Music', 'pachamala-temple' ); ?></span>
    </button>
</div>

<?php wp_footer(); ?>
</body>
</html>
