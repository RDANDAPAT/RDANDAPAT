<?php
/*
Plugin Name: WP Contact Manager
Plugin URI: https://your-plugin-uri.com
Description: Simple contact management plugin for WordPress.
Version: 1.0
Author: Rahul Dandapat
Author URI: https://your-website.com
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: wp-contact-manager
Domain Path: /languages
*/

defined('ABSPATH') || exit; // Prevent direct access to the plugin file

class Contact_manager {

    private $table_name;
    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'contacts';
        // Plugin activation hook
        register_activation_hook(__FILE__, array($this, 'plugin_activation'));
        // Enqueue scripts and styles
        // add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_plugin_scripts'));

        // Add shortcode for contact form
        add_shortcode('contact_form', array($this, 'wp_contact_manager_form_markup'));

        // AJAX form submission handler
        add_action('wp_ajax_submit_contact_form', array($this, 'wp_contact_manager_submit_form'));
        add_action('wp_ajax_nopriv_submit_contact_form', array($this, 'wp_contact_manager_submit_form'));

        // Admin menu and page for contact list
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'create_contact_list_page')); 
    }
    // Create the database table on plugin activation
    public function wp_contact_manager_create_table() {
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
    // Enqueue scripts and styles
    public function enqueue_plugin_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('wp-contact-manager-scripts', plugins_url('js/scripts.js', __FILE__), array('jquery'), '1.0', true);

        // Localize the script and pass the ajaxurl value
        wp_localize_script('wp-contact-manager-scripts', 'wpContactManagerAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));
    }
    // Shortcode callback for display the contact form
    public function wp_contact_manager_form_markup() {
        ob_start();
        include_once(plugin_dir_path(__FILE__) . '/templates/contact-form.php');
        return ob_get_clean();
    }
    // Handle form submission
    public function wp_contact_manager_submit_form() {
        // Perform form data validation
        $email = sanitize_email($_POST['email']);
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $phone_number = sanitize_text_field($_POST['phone_number']);
        $address = sanitize_text_field($_POST['address']);

        if (empty($email) || empty($first_name) || empty($last_name) || empty($phone_number)) {
            wp_send_json_error('All fields are mandatory.');
        }

        // Insert the contact into the database
        global $wpdb;
        $table_name = $wpdb->prefix . 'contacts';

        $wpdb->insert($table_name, array(
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone_number' => $phone_number,
            'address' => $address,
        ));

        wp_send_json_success('Contact submitted successfully.');
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
    public function create_contact_list_page()
    {
        add_submenu_page(
            'Contact Manager',
            'Contact Manager',
            'Contact Manager',
            'manage_options',
            'wp-contact-manager',
            array($this, 'display_contact_list')
        );
    }
    public function display_contact_list()
    {
        global $wpdb;
        $contacts = $wpdb->get_results("SELECT * FROM $this->table_name");

        include_once(plugin_dir_path(__FILE__) . '/templates/contact-list.php');
    }
}

// Initialize the plugin
new Contact_manager();

?>


