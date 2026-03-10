/**
 * main.js — Pachamala Temple Theme
 * Navigation toggle, scroll effects, gallery filter
 */

(function ($) {
    'use strict';

    /* =========================================================
       MOBILE NAV TOGGLE
       ========================================================= */
    var $toggle  = $('#nav-toggle');
    var $navMenu = $('#primary-menu');

    $toggle.on('click', function () {
        var expanded = $toggle.attr('aria-expanded') === 'true';
        $toggle.toggleClass('active');
        $toggle.attr('aria-expanded', !expanded);
        $navMenu.toggleClass('open');
    });

    // Close nav when clicking outside
    $(document).on('click touchstart', function (e) {
        if ($navMenu.hasClass('open') &&
            !$(e.target).closest('.primary-nav').length) {
            $toggle.removeClass('active').attr('aria-expanded', 'false');
            $navMenu.removeClass('open');
        }
    });

    // Close nav on ESC key
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $navMenu.hasClass('open')) {
            $toggle.removeClass('active').attr('aria-expanded', 'false');
            $navMenu.removeClass('open');
        }
    });

    /* =========================================================
       STICKY HEADER SHADOW ON SCROLL
       ========================================================= */
    var $header = $('.site-header');

    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 10) {
            $header.addClass('scrolled');
        } else {
            $header.removeClass('scrolled');
        }
    });

    /* =========================================================
       SMOOTH SCROLL FOR ANCHOR LINKS
       ========================================================= */
    $('a[href*="#"]').not('[href="#"]').on('click', function (e) {
        var target = this.hash;
        if (!target) return;

        var $target = $(target);
        if ($target.length) {
            e.preventDefault();
            var offset = $header.outerHeight() + 20;
            $('html, body').animate({
                scrollTop: $target.offset().top - offset
            }, 600, 'swing');
        }
    });

    /* =========================================================
       GALLERY FILTER (category tabs)
       ========================================================= */
    $(document).on('click', '.filter-btn', function () {
        var filter = $(this).data('filter');

        // Update active state
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        var $items = $('.gallery-item');

        if (filter === 'all') {
            $items.show().css('opacity', '1');
        } else {
            $items.each(function () {
                var cats = $(this).data('category') || '';
                if (cats.indexOf(filter) !== -1) {
                    $(this).show().css('opacity', '1');
                } else {
                    $(this).hide().css('opacity', '0');
                }
            });
        }
    });

    /* =========================================================
       FADE-IN ON SCROLL (intersection observer for .temple-card)
       ========================================================= */
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity   = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        // Apply to cards that aren't hero content
        $('.temple-card, .deity-card, .gallery-item, .event-card').each(function (i) {
            var el = this;
            // Stagger delay
            el.style.opacity    = '0';
            el.style.transform  = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease ' + (i * 0.05) + 's, transform 0.5s ease ' + (i * 0.05) + 's';
            observer.observe(el);
        });
    }

})(jQuery);
