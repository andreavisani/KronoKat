    /* SHOW THE POPUP */
    document.addEventListener('DOMContentLoaded', function() {
        var openPopupButton = document.getElementById('openPopup');
        var popup = document.getElementById('popup');
        
        // Show the popup when the openPopup button is clicked
        openPopupButton.addEventListener('click', function() {
            popup.style.display = 'block';
        });

        document.addEventListener('click', function(event) {
            if (!popup.contains(event.target) && event.target !== openPopupButton) {
                popup.style.display = 'none';
            }
        });
    });

    
    // Add a "checked" symbol when clicking on a list item
    var list = document.querySelector('ul');
    list.addEventListener('click', function(ev) {
        // Check if the clicked target is either the <li> or one of its children
        var clickedElement = ev.target;
        while (clickedElement && clickedElement !== list) {
            if (clickedElement.tagName === 'LI') {
                clickedElement.classList.toggle('checked');
                break;
            }
            clickedElement = clickedElement.parentNode;
        }
    }, false);