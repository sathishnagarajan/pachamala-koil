<?php
/**
 * Custom Meta Boxes for CPTs
 *
 * @package PachamalaTemple
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// =============================================================
// POOJA TIMING META BOX
// =============================================================
add_action( 'add_meta_boxes', 'pkt_add_pooja_meta_box' );
function pkt_add_pooja_meta_box() {
    add_meta_box(
        'pkt-pooja-details',
        'Pooja Schedule Details',
        'pkt_pooja_meta_box_html',
        'pooja_timing',
        'normal',
        'high'
    );
}

function pkt_pooja_meta_box_html( $post ) {
    wp_nonce_field( 'pkt_save_pooja_meta', 'pkt_pooja_nonce' );

    $start_time = get_post_meta( $post->ID, 'pooja_start_time', true );
    $end_time   = get_post_meta( $post->ID, 'pooja_end_time',   true );
    $type       = get_post_meta( $post->ID, 'pooja_type',       true );
    $day_type   = get_post_meta( $post->ID, 'pooja_day_type',   true );
    ?>
    <table class="form-table pkt-meta-table">
        <tr>
            <th><label for="pooja_type">Pooja Type</label></th>
            <td>
                <select name="pooja_type" id="pooja_type">
                    <option value="">— Select —</option>
                    <?php foreach ( [ 'Morning Pooja', 'Noon Pooja', 'Evening Pooja', 'Night Pooja', 'Special Pooja' ] as $opt ) : ?>
                        <option value="<?php echo esc_attr( $opt ); ?>" <?php selected( $type, $opt ); ?>>
                            <?php echo esc_html( $opt ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="pooja_start_time">Start Time</label></th>
            <td>
                <input type="time" id="pooja_start_time" name="pooja_start_time"
                       value="<?php echo esc_attr( $start_time ); ?>" style="width:200px">
            </td>
        </tr>
        <tr>
            <th><label for="pooja_end_time">End Time</label></th>
            <td>
                <input type="time" id="pooja_end_time" name="pooja_end_time"
                       value="<?php echo esc_attr( $end_time ); ?>" style="width:200px">
            </td>
        </tr>
        <tr>
            <th><label for="pooja_day_type">Applicable Days</label></th>
            <td>
                <select name="pooja_day_type" id="pooja_day_type">
                    <option value="">— Select —</option>
                    <?php foreach ( [ 'Daily', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'Festival Days Only' ] as $day ) : ?>
                        <option value="<?php echo esc_attr( $day ); ?>" <?php selected( $day_type, $day ); ?>>
                            <?php echo esc_html( $day ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

add_action( 'save_post_pooja_timing', 'pkt_save_pooja_meta' );
function pkt_save_pooja_meta( $post_id ) {
    if ( ! isset( $_POST['pkt_pooja_nonce'] ) ) return;
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pkt_pooja_nonce'] ) ), 'pkt_save_pooja_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = [ 'pooja_start_time', 'pooja_end_time', 'pooja_type', 'pooja_day_type' ];
    foreach ( $fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
        }
    }
}


// =============================================================
// TEMPLE EVENT META BOX
// =============================================================
add_action( 'add_meta_boxes', 'pkt_add_event_meta_box' );
function pkt_add_event_meta_box() {
    add_meta_box(
        'pkt-event-details',
        'Event Details',
        'pkt_event_meta_box_html',
        'temple_event',
        'normal',
        'high'
    );
}

function pkt_event_meta_box_html( $post ) {
    wp_nonce_field( 'pkt_save_event_meta', 'pkt_event_nonce' );

    $event_date         = get_post_meta( $post->ID, 'event_date',         true );
    $event_end_date     = get_post_meta( $post->ID, 'event_end_date',     true );
    $event_time         = get_post_meta( $post->ID, 'event_time',         true );
    $event_significance = get_post_meta( $post->ID, 'event_significance', true );
    ?>
    <table class="form-table pkt-meta-table">
        <tr>
            <th><label for="event_date">Event Start Date</label></th>
            <td>
                <input type="date" id="event_date" name="event_date"
                       value="<?php echo esc_attr( $event_date ); ?>" style="width:200px">
            </td>
        </tr>
        <tr>
            <th><label for="event_end_date">Event End Date <small>(optional)</small></label></th>
            <td>
                <input type="date" id="event_end_date" name="event_end_date"
                       value="<?php echo esc_attr( $event_end_date ); ?>" style="width:200px">
            </td>
        </tr>
        <tr>
            <th><label for="event_time">Event Time</label></th>
            <td>
                <input type="text" id="event_time" name="event_time"
                       value="<?php echo esc_attr( $event_time ); ?>"
                       placeholder="e.g. 6:00 AM – 9:00 AM" style="width:300px">
            </td>
        </tr>
        <tr>
            <th><label for="event_significance">Significance <small>(Tamil)</small></label></th>
            <td>
                <textarea id="event_significance" name="event_significance"
                          rows="4" style="width:100%;font-family:'Noto Serif Tamil',serif;font-size:14px"
                          placeholder="நிகழ்வின் சிறப்பு..."><?php echo esc_textarea( $event_significance ); ?></textarea>
                <p class="description">Enter the significance of this event in Tamil.</p>
            </td>
        </tr>
    </table>
    <?php
}

add_action( 'save_post_temple_event', 'pkt_save_event_meta' );
function pkt_save_event_meta( $post_id ) {
    if ( ! isset( $_POST['pkt_event_nonce'] ) ) return;
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pkt_event_nonce'] ) ), 'pkt_save_event_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $text_fields = [ 'event_date', 'event_end_date', 'event_time' ];
    foreach ( $text_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
        }
    }

    // Textarea — sanitize keeping Tamil unicode
    if ( isset( $_POST['event_significance'] ) ) {
        update_post_meta( $post_id, 'event_significance', sanitize_textarea_field( wp_unslash( $_POST['event_significance'] ) ) );
    }
}
