<?php
class ContactFormUser {
    public function __construct() {
        // Add shortcode for contact form
        add_shortcode('contact_form', array($this, 'wp_contact_manager_form_markup'));

        // Enqueue scripts and styles
        // add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_plugin_scripts'));

        // AJAX form submission handler
        add_action('wp_ajax_wp_contact_manager_submit_form', array($this, 'wp_contact_manager_submit_form'));
        add_action('wp_ajax_nopriv_wp_contact_manager_submit_form', array($this, 'wp_contact_manager_submit_form'));
    }

        // Enqueue scripts and styles
    public function enqueue_plugin_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('wp-contact-manager-scripts', plugins_url('js/scripts.js', __FILE__), array('jquery'), '1.0', true);

        // Localize the script and pass the ajaxurl value
        wp_localize_script('wp-contact-manager-scripts', 'contactManagerAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
    }


    // Shortcode callback for displaying the contact form
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
            wp_send_json_error(array(
                'message' => 'All fields are mandatory.'
            ));
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

        wp_send_json_success(array(
            'message' => 'Contact submitted successfully.'
        ));
    }
}
