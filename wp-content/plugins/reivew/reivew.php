<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.linkedin.com/in/ajay-ghaghretiya/
 * @since             1.0.0
 * @package           Reivew
 *
 * @wordpress-plugin
 * Plugin Name:       Review
 * Plugin URI:        store.multidots.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ajay
 * Author URI:        https://www.linkedin.com/in/ajay-ghaghretiya/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       reivew
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-reivew-activator.php
 */
function activate_reivew() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-reivew-activator.php';
    Reivew_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-reivew-deactivator.php
 */
function deactivate_reivew() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-reivew-deactivator.php';
    Reivew_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_reivew');
register_deactivation_hook(__FILE__, 'deactivate_reivew');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-reivew.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_reivew() {

    $plugin = new Reivew();
    $plugin->run();
}

run_reivew();

function elegance_referal_init() {
    if (is_page('review')) {
        $dir = plugin_dir_path(__FILE__);
        include($dir . "public/partials/reivew-public-display.php");
        //die();
    }
}

add_action('wp', 'elegance_referal_init');

add_action('admin_menu', 'my_menu_pages');

function my_menu_pages() {
add_menu_page('Reviews', 'Reviews Page', 'manage_options', 'my-top-level-slug', 'admin_review_page',plugins_url() . '/reivew/star.png', 45);
add_submenu_page( 'my-top-level-slug', 'Pending Reviews', 'Pending Reviews', 'manage_options', 'my-top-level-slug');
add_submenu_page( 'my-top-level-slug', 'Reviews Shortcode', 'Reviews Shortcode', 'manage_options', 'my-secondary-slug', 'admin_shortcode_page');
}

function admin_review_page() {
    echo "<h2>hello</h2>";
}
function admin_shortcode_page(){
    echo "<h2>hiii </h2>";
}
add_action('admin_footer', 'mycss');

function mycss() {
    echo '<style>' . '
    #adminmenu .wp-menu-image img {
    padding: 9px 0 0;
    opacity: .6;
    height: 23px;
    width: 27px;
    filter: alpha(opacity=60)' . '</style>';
}
