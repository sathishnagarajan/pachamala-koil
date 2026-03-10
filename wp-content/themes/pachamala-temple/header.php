<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#b83f3f">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ========================================================
     TOP BAR
     ======================================================== -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-inner">
            <div class="top-bar-contact">
                <a href="tel:+914423456789">
                    <span>&#9742;</span> +91 44 2345 6789
                </a>
                <span class="address-item">
                    &#9873; Chennai, Tamil Nadu, India
                </span>
            </div>
            <div class="top-bar-social">
                <a href="#" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                    <span>f</span>
                </a>
                <a href="#" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
                    <span>&#9654;</span>
                </a>
                <a href="#" aria-label="WhatsApp" target="_blank" rel="noopener noreferrer">
                    <span>&#128172;</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================
     SITE HEADER
     ======================================================== -->
<header class="site-header" role="banner">
    <div class="header-inner">

        <!-- Logo -->
        <a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php bloginfo( 'name' ); ?>">
            <?php
            $logo_url = PKT_ASSETS_URI . '/images/logo/athireeswarar-anushiyambal-logo.png';
            if ( has_custom_logo() ) :
                the_custom_logo();
            else : ?>
                <img src="<?php echo esc_url( $logo_url ); ?>"
                     alt="<?php bloginfo( 'name' ); ?>"
                     width="140" height="70"
                     onerror="this.style.display='none'">
                <div class="temple-name-wrap">
                    <span class="temple-name-en">Pachaimalai Athireeswarar</span>
                    <span class="temple-name-tamil" lang="ta">பச்சைமலை ஆதிரீஸ்வரர் கோவில்</span>
                </div>
            <?php endif; ?>
        </a>

        <!-- Navigation -->
        <nav class="primary-nav" role="navigation" aria-label="Primary Navigation">
            <!-- Mobile toggle -->
            <button class="nav-toggle" id="nav-toggle" aria-expanded="false" aria-controls="primary-menu" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'container'      => false,
                'menu_class'     => 'nav-menu',
                'fallback_cb'    => 'pkt_fallback_nav',
            ] );
            ?>
        </nav>

    </div><!-- .header-inner -->
</header>

<!-- Gold gradient border under header -->
<div class="header-gold-border" aria-hidden="true"></div>

<!-- ========================================================
     MAIN CONTENT
     ======================================================== -->
<main id="main" class="site-main" role="main">
<?php

/**
 * Fallback navigation when no menu is assigned.
 */
function pkt_fallback_nav() {
    echo '<ul class="nav-menu" id="primary-menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
    wp_list_pages( [
        'title_li' => '',
        'depth'    => 2,
        'echo'     => true,
    ] );
    echo '</ul>';
}
