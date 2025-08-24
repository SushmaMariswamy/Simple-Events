<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Simple_Events_Manager_Settings {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
    }

    public function add_settings_page() {
        add_options_page(
            'Events Manager Settings',
            'Events Manager',
            'manage_options',
            'sem-settings',
            array( $this, 'render_settings_page' )
        );
    }

    public function render_settings_page() {
        echo '<div class="wrap"><h1>Events Manager Settings</h1><p>Settings options will go here.</p></div>';
    }
}
new Simple_Events_Manager_Settings();
?>
