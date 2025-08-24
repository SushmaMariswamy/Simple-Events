<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Define plugin paths
define( 'SEM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SEM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include core classes
require_once SEM_PLUGIN_DIR . 'includes/class-simple-events-manager-cpt.php';
require_once SEM_PLUGIN_DIR . 'includes/class-simple-events-manager-shortcode.php';
require_once SEM_PLUGIN_DIR . 'includes/class-simple-events-manager-settings.php';
require_once SEM_PLUGIN_DIR . 'includes/class-simple-events-manager-metabox.php';

// Register styles
function sem_enqueue_styles() {
    wp_enqueue_style( 'sem-events-style', SEM_PLUGIN_URL . 'assets/css/events.css' );
}
add_action( 'wp_enqueue_scripts', 'sem_enqueue_styles' );
?>
