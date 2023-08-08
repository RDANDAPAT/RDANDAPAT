jQuery(document).ready(function($) {
    var exitPopupShown = false;

    $(document).mouseleave(function() {
        if (!exitPopupShown) {
            // Code to show the exit-intent popup
            exitPopupShown = true;
        }
    });
});
