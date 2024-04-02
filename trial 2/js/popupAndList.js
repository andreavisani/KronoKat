    /* MANAGE POPUPS */
    document.addEventListener('DOMContentLoaded', function() {
        /***************** NEW TASK POPUP *****************/
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
        /***************** END NEW TASK POPUP *****************/

        /***************** SEARCH POPUP *****************/
        // NB: DISPLAY IS MANAGED BY PHP
        var openSearch = document.getElementById('openSearchPopup');
        var searchPopup = document.getElementById('search-popup');

        document.addEventListener('click', function(event) {
            if (!searchPopup.contains(event.target) && event.target !== openSearch) {
                searchPopup.style.display = 'none';
            }
        });
        /***************** END SEARCH POPUP *****************/



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