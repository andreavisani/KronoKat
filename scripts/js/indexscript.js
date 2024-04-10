window.addEventListener('scroll', function() {
    var scrollPosition = window.scrollY;
    var featuresContainer = document.querySelector('.features_container');
    var stopPosition = 300; // Adjust this value to set the point where the container stops moving
    // Check if scroll position is less than the stop position
    if (scrollPosition < stopPosition) {
      // Adjust translateY value as needed for the desired parallax effect
    featuresContainer.style.transform = 'translateY(' + (scrollPosition / 2) + 'px)';
    }
});