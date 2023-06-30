
jQuery(document).ready(function($) {
    $('#wp-contact-manager-form').submit(function(e) {
        e.preventDefault();
        var form = $(this);

        // Perform form validation
        if (!form[0].checkValidity()) {
            // Handle form validation errors here
            return;
        }

        // Perform AJAX form submission
        $.ajax({
            url: wpContactManagerAjax.ajaxurl, // Use wpContactManagerAjax.ajaxurl instead of ajaxurl
            type: 'POST',
            data: {
                action: 'wp_contact_manager_submit_form',
                email: form.find('#email').val(),
                first_name: form.find('#first_name').val(),
                last_name: form.find('#last_name').val(),
                phone_number: form.find('#phone_number').val(),
                address: form.find('#address').val()
            },
            success: function(response) {
                if (response.success) {
                    // Handle form submission success here
                    console.log(response.data);
                } else {
                    // Handle form submission error here
                    console.log(response.data);
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX error here
                console.log(error);
            }
        });
    });
});

