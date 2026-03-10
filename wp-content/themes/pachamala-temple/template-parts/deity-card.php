<?php
/**
 * Deity Cards — Template Part
 * Shows Athireeswarar and Anushiyambal
 *
 * @package PachamalaTemple
 */

$deities = [
    [
        'name_tamil' => 'ஆதிரீஸ்வரர்',
        'name_en'    => __( 'Lord Athireeswarar', 'pachamala-temple' ),
        'role'       => __( 'Presiding Deity (Lord Shiva)', 'pachamala-temple' ),
        'desc'       => __( 'Pachaimalai Athireeswarar is the presiding deity of this temple, a form of Lord Shiva who bestows wisdom, prosperity, and liberation upon his devotees. The green hills (Pachaimalai) are his divine abode.', 'pachamala-temple' ),
        'icon'       => '🕉',
        'page_url'   => home_url( '/deities/athireeswarar' ),
    ],
    [
        'name_tamil' => 'அனுசியாம்பாள்',
        'name_en'    => __( 'Goddess Anushiyambal', 'pachamala-temple' ),
        'role'       => __( 'Consort Goddess (Goddess Parvati)', 'pachamala-temple' ),
        'desc'       => __( 'Goddess Anushiyambal, the divine consort of Lord Athireeswarar, is worshipped here as Shakti. She grants blessings of health, wealth, and marital bliss to all devotees who seek her grace.', 'pachamala-temple' ),
        'icon'       => '🪷',
        'page_url'   => home_url( '/deities/anushiyambal' ),
    ],
];
?>
<div class="deities-grid">
    <?php foreach ( $deities as $deity ) : ?>
    <div class="deity-card">
        <div class="deity-card-image">
            <span style="font-size:5rem"><?php echo esc_html( $deity['icon'] ); ?></span>
        </div>
        <div class="deity-card-body">
            <h3 class="deity-name-tamil" lang="ta"><?php echo esc_html( $deity['name_tamil'] ); ?></h3>
            <p class="deity-name-en"><?php echo esc_html( $deity['name_en'] ); ?></p>
            <p style="font-size:.8rem;color:var(--color-secondary);margin-bottom:.75rem;font-style:italic">
                <?php echo esc_html( $deity['role'] ); ?>
            </p>
            <p class="deity-desc"><?php echo esc_html( $deity['desc'] ); ?></p>
            <a href="<?php echo esc_url( $deity['page_url'] ); ?>" class="btn btn-outline-gold" style="margin-top:1.5rem">
                <?php esc_html_e( 'Learn More', 'pachamala-temple' ); ?>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
