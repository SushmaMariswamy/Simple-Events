<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Simple_Events_Manager_Metabox {
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_meta_box' ) );
    }

    public function add_meta_box() {
        add_meta_box(
            'sem_event_details',
            'Event Details',
            array( $this, 'render_meta_box' ),
            'event',
            'normal',
            'high'
        );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'sem_save_event_details', 'sem_event_nonce' );

        $date = get_post_meta( $post->ID, '_sem_event_date', true );
        $location = get_post_meta( $post->ID, '_sem_event_location', true );
        $organizer = get_post_meta( $post->ID, '_sem_event_organizer', true );

        echo '<p><label for="sem_event_date"><strong>Date (required):</strong></label><br>';
        echo '<input type="date" id="sem_event_date" name="sem_event_date" value="' . esc_attr( $date ) . '" required></p>';

        echo '<p><label for="sem_event_location"><strong>Location:</strong></label><br>';
        echo '<input type="text" id="sem_event_location" name="sem_event_location" value="' . esc_attr( $location ) . '" style="width:100%;"></p>';

        echo '<p><label for="sem_event_organizer"><strong>Organizer:</strong></label><br>';
        echo '<input type="text" id="sem_event_organizer" name="sem_event_organizer" value="' . esc_attr( $organizer ) . '" style="width:100%;"></p>';
    }

    public function save_meta_box( $post_id ) {
        if ( ! isset( $_POST['sem_event_nonce'] ) || ! wp_verify_nonce( $_POST['sem_event_nonce'], 'sem_save_event_details' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;

        if ( isset( $_POST['sem_event_date'] ) ) {
            update_post_meta( $post_id, '_sem_event_date', sanitize_text_field( $_POST['sem_event_date'] ) );
        }

        if ( isset( $_POST['sem_event_location'] ) ) {
            update_post_meta( $post_id, '_sem_event_location', sanitize_text_field( $_POST['sem_event_location'] ) );
        }

        if ( isset( $_POST['sem_event_organizer'] ) ) {
            update_post_meta( $post_id, '_sem_event_organizer', sanitize_text_field( $_POST['sem_event_organizer'] ) );
        }
    }
}
new Simple_Events_Manager_Metabox();
?>
