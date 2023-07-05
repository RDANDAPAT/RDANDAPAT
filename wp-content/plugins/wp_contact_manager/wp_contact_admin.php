<?php
class ContactManagerAdmin {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'contacts';

        // Plugin activation hook
        register_activation_hook(__FILE__, 'wp_contact_manager_create_table');

        // Admin menu and page for contact list
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'create_contact_list_page')); 
    }


    // Create an admin page to view contact details
    public function add_admin_menu() {
        add_menu_page(
            'Contact Manager',
            'Contact Manager',
            'manage_options',
            'wp-contact-manager',
            array($this, 'display_contact_list'),
            'dashicons-book-alt',
            30
        );
    }

    // Create admin page for contact list
    public function create_contact_list_page() {
        add_submenu_page(
            'Contact Manager',
            'Contact Manager',
            'Contact Manager',
            'manage_options',
            'wp-contact-manager',
            array($this, 'display_contact_list')
        );
    }

    public function display_contact_list() {
        global $wpdb;
        $contacts = $wpdb->get_results("SELECT * FROM $this->table_name");

        include_once(plugin_dir_path(__FILE__) . '/templates/contact-list.php');
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
    }