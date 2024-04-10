
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

      /***************** SEARCH POPUP, CLOSE *****************/
        // Function to clear the URL from any previous GET parameters
        function clearURL() {
            window.history.replaceState(null, '', window.location.pathname);
            // credits to https://stackoverflow.com/questions/22753052/remove-url-parameters-without-refreshing-page
        }

        // NB: DISPLAY IS MANAGED BY PHP
        var openSearch = document.getElementById('openSearchPopup');
        var searchPopup = document.getElementById('search-popup');

        document.addEventListener('click', function(event) {
            if (!searchPopup.contains(event.target) && event.target !== openSearch) {
                searchPopup.style.display = 'none';
                clearURL();
            }
        });
        /***************** END SEARCH POPUP *****************/


    });

    
    // Add a "checked" symbol when clicking on a list item
    var list = document.getElementById('task-list');
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

    