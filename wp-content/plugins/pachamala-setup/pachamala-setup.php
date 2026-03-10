<?php
/**
 * Plugin Name: Pachamala Temple Setup
 * Plugin URI:  https://pachaimalaiathireeswarar.org
 * Description: One-click installer for Pachaimalai Athireeswarar Temple website. Activating this plugin creates all pages, menus, pooja timings, events, gallery categories and site settings automatically.
 * Version:     1.0.0
 * Author:      Bytes Brothers
 * Author URI:  https://bytesbrothers.com
 * Text Domain: pachamala-setup
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ──────────────────────────────────────────────────────────────────────────────
// 1. ADD ADMIN MENU PAGE
// ──────────────────────────────────────────────────────────────────────────────
add_action( 'admin_menu', function () {
    add_menu_page(
        'Temple Setup',
        'Temple Setup',
        'manage_options',
        'pachamala-setup',
        'pachamala_setup_page',
        'dashicons-admin-home',
        2
    );
} );

// ──────────────────────────────────────────────────────────────────────────────
// 2. ADMIN PAGE UI
// ──────────────────────────────────────────────────────────────────────────────
function pachamala_setup_page() {
    $installed = get_option( 'pachamala_setup_done' );
    ?>
    <div class="wrap">
        <h1 style="display:flex;align-items:center;gap:12px">
            🕉 Pachaimalai Athireeswarar Temple — Site Setup
        </h1>

        <?php if ( $installed ) : ?>
        <div class="notice notice-success" style="padding:12px 16px">
            <strong>✅ Setup already completed!</strong>
            All pages, menus, pooja timings, and events have been created.
            <br><a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank">View Site →</a>
        </div>
        <form method="post" style="margin-top:16px">
            <?php wp_nonce_field( 'pachamala_reset', 'pachamala_nonce' ); ?>
            <input type="hidden" name="pachamala_action" value="reset">
            <button type="submit" class="button button-secondary"
                    onclick="return confirm('This will delete all created pages and reset the setup. Are you sure?')">
                ↺ Reset &amp; Re-run Setup
            </button>
        </form>
        <?php else : ?>
        <div class="card" style="max-width:700px;padding:24px;margin-top:16px">
            <h2>Ready to install the full temple website</h2>
            <p>Clicking <strong>Run Setup</strong> will automatically:</p>
            <ul style="list-style:disc;padding-left:24px;line-height:2">
                <li>Create all 10 pages (Home, About, Deities, Pooja Timings, Gallery, Donations, Contact, etc.)</li>
                <li>Assign correct page templates (Gallery, Donations, Pooja Timings)</li>
                <li>Create Primary Navigation menu with Deities dropdown</li>
                <li>Create Footer menu</li>
                <li>Set Home as the static front page</li>
                <li>Add 6 daily pooja timings (Thiruvanandal → Ardhajamam)</li>
                <li>Add 3 upcoming festival events with Tamil significance</li>
                <li>Create Gallery categories (Deity Photos, Festivals, Architecture, Rituals, Devotees)</li>
                <li>Create Event categories (Major Festivals, Monthly Celebrations, Special Poojas)</li>
                <li>Configure site title and tagline</li>
                <li>Set permalink structure to post name</li>
            </ul>
            <form method="post" style="margin-top:20px">
                <?php wp_nonce_field( 'pachamala_run', 'pachamala_nonce' ); ?>
                <input type="hidden" name="pachamala_action" value="run">
                <button type="submit" class="button button-primary button-hero">
                    🚀 Run Setup Now
                </button>
            </form>
        </div>
        <?php endif; ?>

        <?php
        // Handle form submission
        if ( isset( $_POST['pachamala_action'] ) && check_admin_referer( 'pachamala_' . sanitize_text_field( $_POST['pachamala_action'] ), 'pachamala_nonce' ) ) {
            $action = sanitize_text_field( $_POST['pachamala_action'] );

            if ( $action === 'run' && ! $installed ) {
                $result = pachamala_run_setup();
                if ( $result['success'] ) {
                    echo '<div class="notice notice-success" style="padding:12px 16px;margin-top:16px"><strong>✅ Setup complete!</strong> <a href="' . esc_url( home_url( '/' ) ) . '" target="_blank">View your site →</a></div>';
                    echo '<ul style="list-style:disc;padding-left:32px;margin-top:8px">';
                    foreach ( $result['log'] as $msg ) {
                        echo '<li>' . esc_html( $msg ) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<div class="notice notice-error"><p>' . esc_html( $result['error'] ) . '</p></div>';
                }
                echo '<script>setTimeout(function(){ location.reload(); }, 1500);</script>';

            } elseif ( $action === 'reset' ) {
                delete_option( 'pachamala_setup_done' );
                echo '<div class="notice notice-warning"><p>Setup reset. Refresh the page to run again.</p></div>';
                echo '<script>setTimeout(function(){ location.reload(); }, 1000);</script>';
            }
        }
        ?>
    </div>
    <?php
}

// ──────────────────────────────────────────────────────────────────────────────
// 3. SETUP RUNNER
// ──────────────────────────────────────────────────────────────────────────────
function pachamala_run_setup() {
    $log = [];

    try {

        // ── Site Settings ───────────────────────────────────────────────────
        update_option( 'blogname',        'Pachaimalai Athireeswarar Temple' );
        update_option( 'blogdescription', 'Official Website of Pachaimalai Athireeswarar Temple, Chennai' );
        update_option( 'permalink_structure', '/%postname%/' );
        flush_rewrite_rules( true );
        $log[] = 'Site title and permalink structure set';

        // ── Pages ──────────────────────────────────────────────────────────
        $pages = pachamala_create_pages();
        $log[] = 'Created ' . count( $pages ) . ' pages';

        // ── Menus ──────────────────────────────────────────────────────────
        pachamala_create_menus( $pages );
        $log[] = 'Primary and Footer menus created and assigned';

        // ── Front Page ─────────────────────────────────────────────────────
        if ( ! empty( $pages['home'] ) ) {
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $pages['home'] );
            $log[] = 'Static front page set to Home';
        }

        // ── Pooja Timings ──────────────────────────────────────────────────
        $poojas = pachamala_create_pooja_timings();
        $log[] = 'Created ' . $poojas . ' pooja timing entries';

        // ── Event + Gallery Taxonomies ─────────────────────────────────────
        $terms = pachamala_create_taxonomy_terms();
        $log[] = 'Created ' . $terms . ' taxonomy categories';

        // ── Sample Events ──────────────────────────────────────────────────
        $events = pachamala_create_sample_events();
        $log[] = 'Created ' . $events . ' sample festival events';

        // ── Mark done ──────────────────────────────────────────────────────
        update_option( 'pachamala_setup_done', current_time( 'mysql' ) );

        return [ 'success' => true, 'log' => $log ];

    } catch ( Exception $e ) {
        return [ 'success' => false, 'error' => $e->getMessage() ];
    }
}

// ──────────────────────────────────────────────────────────────────────────────
// 4. CREATE PAGES
// ──────────────────────────────────────────────────────────────────────────────
function pachamala_create_pages() {
    $ids = [];

    $pages = [
        'home' => [
            'title'   => 'Home',
            'slug'    => 'home',
            'content' => '',
        ],
        'about' => [
            'title'   => 'About the Temple',
            'slug'    => 'about',
            'content' => '<h2>About Pachaimalai Athireeswarar Temple</h2>
<p>The Pachaimalai Athireeswarar Temple is an ancient Shiva temple located in Chennai, Tamil Nadu. The presiding deity is Lord Athireeswarar, a manifestation of Lord Shiva, worshipped along with his divine consort Goddess Anushiyambal.</p>
<p>This sacred temple holds immense significance for the devotees of Chennai and the surrounding regions. The green hills (Pachaimalai) are considered Lord Shiva\'s divine abode, symbolising his eternal presence amidst nature.</p>
<h2>History &amp; Significance</h2>
<p>The temple is built in the traditional Dravidian architectural style. The gopuram (temple tower), mandapam (pillared hall), and inner sanctum are adorned with intricate carvings depicting scenes from Hindu mythology.</p>
<p lang="ta">இந்த திருக்கோவில் சென்னை மக்களின் ஆன்மீக மையமாக திகழ்கிறது.</p>',
        ],
        'deities' => [
            'title'   => 'Deities',
            'slug'    => 'deities',
            'content' => '<p>Pachaimalai Athireeswarar Temple is home to two primary deities worshipped with great devotion.</p>',
        ],
        'pooja-timings' => [
            'title'    => 'Pooja Timings',
            'slug'     => 'pooja-timings',
            'template' => 'page-templates/tpl-pooja-timings.php',
            'content'  => '<p>The temple follows traditional Agama Shastra guidelines for all daily poojas. Timings may vary on festival days.</p>',
        ],
        'gallery' => [
            'title'    => 'Gallery',
            'slug'     => 'gallery',
            'template' => 'page-templates/tpl-gallery.php',
            'content'  => '<p>Browse our collection of photographs from the temple.</p>',
        ],
        'donations' => [
            'title'    => 'Donations',
            'slug'     => 'donations',
            'template' => 'page-templates/tpl-donations.php',
            'content'  => '<p>Your generous contribution helps maintain the sanctity of this sacred shrine.</p>',
        ],
        'contact' => [
            'title'   => 'Contact Us',
            'slug'    => 'contact',
            'content' => '<h2>Get in Touch</h2>
<p>We welcome all devotees and visitors.</p>
<h3>Temple Address</h3>
<p>Pachaimalai Athireeswarar Temple<br>Chennai, Tamil Nadu, India</p>
<h3>Temple Hours</h3>
<p>Morning: 6:00 AM – 12:00 PM<br>Evening: 4:00 PM – 9:00 PM</p>',
        ],
    ];

    // Create parent pages
    foreach ( $pages as $key => $data ) {
        // Check if page already exists
        $existing = get_page_by_path( $data['slug'] );
        if ( $existing ) {
            $ids[ $key ] = $existing->ID;
            continue;
        }

        $post_id = wp_insert_post( [
            'post_title'   => $data['title'],
            'post_name'    => $data['slug'],
            'post_content' => $data['content'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ] );

        if ( ! is_wp_error( $post_id ) ) {
            $ids[ $key ] = $post_id;
            if ( ! empty( $data['template'] ) ) {
                update_post_meta( $post_id, '_wp_page_template', $data['template'] );
            }
        }
    }

    // Deity child pages
    $deities_id = $ids['deities'] ?? 0;

    $deity_pages = [
        'athireeswarar' => [
            'title'   => 'Athireeswarar',
            'slug'    => 'athireeswarar',
            'parent'  => $deities_id,
            'content' => '<h2 lang="ta">அருள்மிகு ஆதிரீஸ்வரர்</h2>
<h3>Lord Athireeswarar — The Presiding Deity</h3>
<p>Lord Athireeswarar is the presiding deity of this temple, a powerful and benevolent form of Lord Shiva. Devotees believe that worshipping Lord Athireeswarar grants wisdom, prosperity, good health, and ultimately moksha.</p>
<p lang="ta">திங்கட்கிழமை சிறப்பு அபிஷேகம் காலை 7 மணி முதல் 9 மணி வரை நடைபெறும்.</p>',
        ],
        'anushiyambal' => [
            'title'   => 'Anushiyambal',
            'slug'    => 'anushiyambal',
            'parent'  => $deities_id,
            'content' => '<h2 lang="ta">அருள்மிகு அனுசியாம்பாள்</h2>
<h3>Goddess Anushiyambal — The Divine Consort</h3>
<p>Goddess Anushiyambal is the divine consort of Lord Athireeswarar, worshipped as Shakti. She blesses devotees with health, happiness, marital harmony, and prosperity.</p>
<p lang="ta">வெள்ளிக்கிழமை மாலை 7 மணிக்கு சிறப்பு குங்குமார்ச்சனை நடைபெறும்.</p>',
        ],
    ];

    foreach ( $deity_pages as $key => $data ) {
        $existing = get_page_by_path( $data['parent'] ? get_page_uri( $data['parent'] ) . '/' . $data['slug'] : $data['slug'] );
        if ( $existing ) {
            $ids[ $key ] = $existing->ID;
            continue;
        }

        $post_id = wp_insert_post( [
            'post_title'   => $data['title'],
            'post_name'    => $data['slug'],
            'post_content' => $data['content'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_parent'  => $data['parent'],
        ] );

        if ( ! is_wp_error( $post_id ) ) {
            $ids[ $key ] = $post_id;
        }
    }

    return $ids;
}

// ──────────────────────────────────────────────────────────────────────────────
// 5. CREATE MENUS
// ──────────────────────────────────────────────────────────────────────────────
function pachamala_create_menus( $pages ) {
    // Primary Navigation
    $primary_id = wp_create_nav_menu( 'Primary Navigation' );
    if ( ! is_wp_error( $primary_id ) ) {
        $items = [
            [ 'id' => $pages['home']           ?? 0, 'title' => 'Home',             'parent' => 0 ],
            [ 'id' => $pages['about']          ?? 0, 'title' => 'About the Temple', 'parent' => 0 ],
            [ 'id' => $pages['deities']        ?? 0, 'title' => 'Deities',          'parent' => 0 ],
            [ 'id' => $pages['athireeswarar']  ?? 0, 'title' => 'Athireeswarar',    'parent' => -3 ], // index -3 = Deities
            [ 'id' => $pages['anushiyambal']   ?? 0, 'title' => 'Anushiyambal',     'parent' => -3 ],
            [ 'id' => $pages['pooja-timings']  ?? 0, 'title' => 'Pooja Timings',    'parent' => 0 ],
            [ 'id' => $pages['gallery']        ?? 0, 'title' => 'Gallery',          'parent' => 0 ],
            [ 'id' => $pages['donations']      ?? 0, 'title' => 'Donations',        'parent' => 0 ],
            [ 'id' => $pages['contact']        ?? 0, 'title' => 'Contact Us',       'parent' => 0 ],
        ];

        $item_ids = [];
        $position = 1;
        foreach ( $items as $idx => $item ) {
            if ( ! $item['id'] ) continue;

            $parent_id = 0;
            if ( $item['parent'] === -3 ) {
                $parent_id = $item_ids[2] ?? 0; // Deities is index 2
            }

            $menu_item_id = wp_update_nav_menu_item( $primary_id, 0, [
                'menu-item-title'     => $item['title'],
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $item['id'],
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-position'  => $position++,
                'menu-item-parent-id' => $parent_id,
            ] );

            if ( ! is_wp_error( $menu_item_id ) ) {
                $item_ids[ $idx ] = $menu_item_id;
            }
        }

        // Assign to primary location
        $locations                = get_theme_mod( 'nav_menu_locations', [] );
        $locations['primary']     = $primary_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }

    // Footer Navigation
    $footer_id = wp_create_nav_menu( 'Footer Links' );
    if ( ! is_wp_error( $footer_id ) ) {
        $footer_pages = [ 'home', 'about', 'pooja-timings', 'gallery', 'donations', 'contact' ];
        $footer_titles = [ 'Home', 'About', 'Pooja Timings', 'Gallery', 'Donations', 'Contact Us' ];
        $pos = 1;
        foreach ( $footer_pages as $i => $key ) {
            if ( empty( $pages[ $key ] ) ) continue;
            wp_update_nav_menu_item( $footer_id, 0, [
                'menu-item-title'     => $footer_titles[ $i ],
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $pages[ $key ],
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-position'  => $pos++,
            ] );
        }

        $locations             = get_theme_mod( 'nav_menu_locations', [] );
        $locations['footer']   = $footer_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}

// ──────────────────────────────────────────────────────────────────────────────
// 6. CREATE POOJA TIMINGS
// ──────────────────────────────────────────────────────────────────────────────
function pachamala_create_pooja_timings() {
    $timings = [
        [ 'Thiruvanandal',   '06:00', '08:00', 'Morning Pooja', 'Daily' ],
        [ 'Kalasandhi',      '08:00', '09:30', 'Morning Pooja', 'Daily' ],
        [ 'Uchikalam',       '12:00', '13:00', 'Noon Pooja',    'Daily' ],
        [ 'Sayarakshai',     '18:00', '19:30', 'Evening Pooja', 'Daily' ],
        [ 'Irandham Kaalam', '19:30', '20:30', 'Evening Pooja', 'Daily' ],
        [ 'Ardhajamam',      '20:30', '21:30', 'Night Pooja',   'Daily' ],
    ];

    $count = 0;
    foreach ( $timings as $t ) {
        // Skip if already exists
        $existing = get_page_by_title( $t[0], OBJECT, 'pooja_timing' );
        if ( $existing ) continue;

        $id = wp_insert_post( [
            'post_title'  => $t[0],
            'post_status' => 'publish',
            'post_type'   => 'pooja_timing',
        ] );

        if ( ! is_wp_error( $id ) ) {
            update_post_meta( $id, 'pooja_start_time', $t[1] );
            update_post_meta( $id, 'pooja_end_time',   $t[2] );
            update_post_meta( $id, 'pooja_type',       $t[3] );
            update_post_meta( $id, 'pooja_day_type',   $t[4] );
            $count++;
        }
    }
    return $count;
}

// ──────────────────────────────────────────────────────────────────────────────
// 7. CREATE TAXONOMY TERMS
// ──────────────────────────────────────────────────────────────────────────────
function pachamala_create_taxonomy_terms() {
    $count = 0;

    $gallery_cats = [ 'Deity Photos', 'Festival Celebrations', 'Temple Architecture', 'Rituals & Poojas', 'Devotees' ];
    foreach ( $gallery_cats as $cat ) {
        $result = wp_insert_term( $cat, 'gallery_category' );
        if ( ! is_wp_error( $result ) ) $count++;
    }

    $event_cats = [ 'Major Festivals', 'Monthly Celebrations', 'Special Poojas', 'Cultural Events' ];
    foreach ( $event_cats as $cat ) {
        $result = wp_insert_term( $cat, 'event_category' );
        if ( ! is_wp_error( $result ) ) $count++;
    }

    return $count;
}

// ──────────────────────────────────────────────────────────────────────────────
// 8. CREATE SAMPLE EVENTS
// ──────────────────────────────────────────────────────────────────────────────
function pachamala_create_sample_events() {
    $events = [
        [
            'title'   => 'Maha Shivaratri',
            'excerpt' => 'The most sacred night of Lord Shiva. Night-long special poojas, Abhishekam, and devotional music.',
            'date'    => date( 'Y' ) + 1 . '-02-26',
            'time'    => '6:00 PM – 6:00 AM (overnight)',
            'tamil'   => 'மஹா சிவராத்திரி — சிவபெருமானின் மிகவும் புனிதமான இரவு.',
            'cat'     => 'Major Festivals',
        ],
        [
            'title'   => 'Thai Poosam',
            'excerpt' => 'Grand celebration on the auspicious star of Poosam in the Tamil month of Thai.',
            'date'    => date( 'Y' ) + 1 . '-02-11',
            'time'    => '6:00 AM – 9:00 PM',
            'tamil'   => 'தை பூசம் — தை மாதம் பூச நட்சத்திரத்தில் சிறப்பு வழிபாடு.',
            'cat'     => 'Major Festivals',
        ],
        [
            'title'   => 'Panguni Uthiram',
            'excerpt' => 'Auspicious festival celebrated in the Tamil month of Panguni on Uthiram star.',
            'date'    => date( 'Y' ) + 1 . '-04-11',
            'time'    => '6:00 AM – 8:00 PM',
            'tamil'   => 'பங்குனி உத்திரம் — திருமணக் கடவுளுக்கு உரிய விழா.',
            'cat'     => 'Major Festivals',
        ],
    ];

    $count = 0;
    foreach ( $events as $e ) {
        $existing = get_page_by_title( $e['title'], OBJECT, 'temple_event' );
        if ( $existing ) continue;

        $id = wp_insert_post( [
            'post_title'   => $e['title'],
            'post_excerpt' => $e['excerpt'],
            'post_status'  => 'publish',
            'post_type'    => 'temple_event',
        ] );

        if ( ! is_wp_error( $id ) ) {
            update_post_meta( $id, 'event_date',         $e['date'] );
            update_post_meta( $id, 'event_time',         $e['time'] );
            update_post_meta( $id, 'event_significance', $e['tamil'] );

            $term = get_term_by( 'name', $e['cat'], 'event_category' );
            if ( $term ) {
                wp_set_object_terms( $id, $term->term_id, 'event_category' );
            }
            $count++;
        }
    }
    return $count;
}

// ──────────────────────────────────────────────────────────────────────────────
// 9. AUTO-REDIRECT TO SETUP PAGE ON ACTIVATION
// ──────────────────────────────────────────────────────────────────────────────
register_activation_hook( __FILE__, function () {
    set_transient( 'pachamala_setup_redirect', true, 30 );
} );

add_action( 'admin_init', function () {
    if ( get_transient( 'pachamala_setup_redirect' ) ) {
        delete_transient( 'pachamala_setup_redirect' );
        if ( ! get_option( 'pachamala_setup_done' ) ) {
            wp_safe_redirect( admin_url( 'admin.php?page=pachamala-setup' ) );
            exit;
        }
    }
} );
