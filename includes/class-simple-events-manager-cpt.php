<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Simple_Events_Manager_CPT {
    public function __construct() {
        add_action( 'init', array( $this, 'register_event_cpt' ) );
    }

    public function register_event_cpt() {
        $labels = array(
            'name' => 'Events',
            'singular_name' => 'Event',
            'add_new' => 'Add New Event',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'new_item' => 'New Event',
            'view_item' => 'View Event',
            'search_items' => 'Search Events',
            'not_found' => 'No events found',
            'not_found_in_trash' => 'No events found in Trash',
            'menu_name' => 'Events'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => array( 'title', 'editor', 'thumbnail' ),
        );

        register_post_type( 'event', $args );
    }
}
new Simple_Events_Manager_CPT();
?>
