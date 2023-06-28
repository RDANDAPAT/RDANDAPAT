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
register_activation_hook(__FILE__, 'wp_contact_manager_create_table'); //for activation of plugins


// Enqueue scripts and styles ()
// function wp_contact_manager_enqueue_scripts() {
//     wp_enqueue_script('jquery');
//     wp_enqueue_script('wp-contact-manager-scripts', plugins_url('js/scripts.js', __FILE__), array('jquery'), '1.0', true);
// }
// add_action('wp_enqueue_scripts', 'wp_contact_manager_enqueue_scripts');

// Enqueue scripts and styles
function wp_contact_manager_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('wp-contact-manager-scripts', plugins_url('js/scripts.js', __FILE__), array('jquery'), '1.0', true);

    // Localize the script and pass the ajaxurl value
    wp_localize_script('wp-contact-manager-scripts', 'wpContactManagerAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'wp_contact_manager_enqueue_scripts');


// Display the contact form
function wp_contact_manager_form_markup() {
    ob_start();
    ?>
    <form id="wp-contact-manager-form" method="post">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
        </div>
        <div>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
        </div>
        <div>
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required>
        </div>
        <div>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address">
        </div>
        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('wp_contact_manager_form', 'wp_contact_manager_form_markup');

// Handle form submission
function wp_contact_manager_submit_form() {
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
add_action('wp_ajax_wp_contact_manager_submit_form', 'wp_contact_manager_submit_form');
add_action('wp_ajax_nopriv_wp_contact_manager_submit_form', 'wp_contact_manager_submit_form');

// Create an admin page to view contact details
function wp_contact_manager_admin_page() {
    add_menu_page(
        'Contact Manager',
        'Contact Manager',
        'manage_options',
        'wp-contact-manager',
        'wp_contact_manager_admin_page_markup',
        'dashicons-book-alt',
        30
    );
}
add_action('admin_menu', 'wp_contact_manager_admin_page');

// Display the contact details on the admin page
function wp_contact_manager_admin_page_markup() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contacts';
    $contacts = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<div class="wrap">';
    echo '<h1>Contact Manager</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>Address</th></tr></thead>';
    echo '<tbody>';

    foreach ($contacts as $contact) {
        echo '<tr>';
        echo '<td>' . $contact->id . '</td>';
        echo '<td>' . $contact->email . '</td>';
        echo '<td>' . $contact->first_name . '</td>';
        echo '<td>' . $contact->last_name . '</td>';
        echo '<td>' . $contact->phone_number . '</td>';
        echo '<td>' . $contact->address . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
