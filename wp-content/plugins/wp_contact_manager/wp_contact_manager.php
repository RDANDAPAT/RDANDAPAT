<?php
/*
Plugin Name: WP Contact Manager
Plugin URI: https://your-plugin-uri.com
Description: Simple contact management plugin for WordPress.
Version: 1.3
Author: Rahul Dandapat
Author URI: https://your-website.com
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: wp-contact-manager
Domain Path: /languages
*/

defined('ABSPATH') || exit; // Prevent direct access to the plugin file

/*class ContactManager {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'contacts';

        // Plugin activation hook
        register_activation_hook(__FILE__, 'wp_contact_manager_create_table');
    }
}

// Create the database table on plugin activation
function wp_contact_manager_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contacts';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT(16) NOT NULL AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        phone_number VARCHAR(50) NOT NULL,
        address VARCHAR(500),
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}*/


require_once(plugin_dir_path(__FILE__) . '/wp_contact_admin.php');
require_once(plugin_dir_path(__FILE__) . '/wp_contact_user.php');

// Initialize the user-end class
new ContactFormUser();

// Initialize the admin-end class
new ContactManagerAdmin();
