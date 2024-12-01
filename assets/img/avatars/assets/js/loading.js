$(document).ready(function() {
    function showLoading() {
        $('#loadingOverlay').fadeIn(300);
    }

    function hideLoading() {
        $('#loadingOverlay').fadeOut(300);
    }

    // Show loading on initial page load
    showLoading();
    $('body').css('visibility', 'hidden');

    // Hide loading when page is fully loaded
    $(window).on('load', function() {
        hideLoading();
        $('body').css('visibility', 'visible');
    });

    // Show loading on AJAX requests
    $(document).on({
        ajaxStart: function() {
            showLoading();
        },
        ajaxStop: function() {
            hideLoading();
        }
    });

    // Expose functions globally
    window.showLoading = showLoading;
    window.hideLoading = hideLoading;
});