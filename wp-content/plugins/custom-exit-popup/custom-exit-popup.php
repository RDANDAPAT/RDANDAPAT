<?php
/**
 * Plugin Name: Custom Exit Popup
 * Description: Display a custom exit-intent popup with images, buttons, and links.
 * Version: 1.0
 * Author: Rahul Dandapat
 */


// Enqueue scripts and styles
function custom_exit_popup_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-exit-popup', plugin_dir_url(__FILE__) . 'js/custom-exit-popup.js', array('jquery'), '1.0', true);
    wp_enqueue_style('custom-exit-popup-style', plugin_dir_url(__FILE__) . 'css/custom-exit-popup.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'custom_exit_popup_enqueue_scripts');

function custom_exit_popup_content() {
    // Customize the popup content here
    $popup_content = '<div class="custom-exit-popup">
        <img src="' . plugin_dir_url(__FILE__) . 'images/image1.jpg" alt="Image 1">
        <p>This is your exit-intent popup content.</p>
        <a href="#">Click Me</a>
    </div>';

    return $popup_content;
}

function display_custom_exit_popup() {
    echo custom_exit_popup_content();
}
add_action('wp_footer', 'display_custom_exit_popup');

?>