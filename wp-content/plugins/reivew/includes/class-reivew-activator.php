<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.linkedin.com/in/ajay-ghaghretiya/
 * @since      1.0.0
 *
 * @package    Reivew
 * @subpackage Reivew/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Reivew
 * @subpackage Reivew/includes
 * @author     Ajay <ajayghaghretiya.multidots@gmail.com>
 */
class Reivew_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'Custom Menu Title', 'textdomain' ),
        'custom menu',
        'manage_options',
        'myplugin/myplugin-admin.php',
        '',
        plugins_url( 'myplugin/images/icon.png' ),
        6
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );	
	}

}
