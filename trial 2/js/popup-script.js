document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('openPopup').addEventListener('click', function() {
        // Show the popup
        document.getElementById('popup').style.display = 'block';
    });

    // Close the popup when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target == document.getElementById('popup')) {
            document.getElementById('popup').style.display = 'none';
        }
    });
});