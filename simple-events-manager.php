<?php
/* Requires PHP: 7.4
* Author: Your Name
* Author URI: https://example.com
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: simple-events-manager
*/


if ( ! defined( 'ABSPATH' ) ) { exit; }


// Define constants
define( 'SEM_VERSION', '1.0.0' );
define( 'SEM_PLUGIN_FILE', __FILE__ );
define( 'SEM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SEM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


// Includes
require_once SEM_PLUGIN_DIR . 'includes/class-sem-cpt.php';
require_once SEM_PLUGIN_DIR . 'includes/class-sem-metaboxes.php';
require_once SEM_PLUGIN_DIR . 'includes/class-sem-settings.php';
require_once SEM_PLUGIN_DIR . 'includes/class-sem-shortcodes.php';


// Activation/Deactivation hooks
function sem_activate() {
SEM_CPT::register_cpt();
flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'sem_activate' );


function sem_deactivate() {
flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'sem_deactivate' );


// Bootstrap plugin
add_action( 'plugins_loaded', function() {
// Register CPT + taxonomies
add_action( 'init', [ 'SEM_CPT', 'register_cpt' ] );


// Metaboxes
add_action( 'add_meta_boxes', [ 'SEM_Metaboxes', 'add_boxes' ] );
add_action( 'save_post_event', [ 'SEM_Metaboxes', 'save' ] );


// Settings page
add_action( 'admin_menu', [ 'SEM_Settings', 'add_menu' ] );
add_action( 'admin_init', [ 'SEM_Settings', 'register_settings' ] );


// Shortcodes
add_action( 'init', [ 'SEM_Shortcodes', 'register' ] );


// Frontend assets
add_action( 'wp_enqueue_scripts', function() {
wp_enqueue_style( 'sem-events', SEM_PLUGIN_URL . 'assets/css/events.css', [], SEM_VERSION );
} );
} );
