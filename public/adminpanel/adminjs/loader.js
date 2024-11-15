function showLoader() {
    // Show loader
    document.getElementById('loader').style.display = 'inline-block';
    
    // Disable the button to prevent multiple clicks
    document.querySelector('.login-btn').setAttribute('disabled', 'true');
    
}

  function disableLink(event, link) {
        // event.preventDefault(); // Prevent the default action (i.e., following the link)

        if (link.classList.contains('disabled')) {
            return; // If the link is already disabled, do nothing
        }

        // Disable all links
        var allLinks = document.querySelectorAll('a.btn');
        allLinks.forEach(function(element) {
            element.classList.add('disabled');
            element.setAttribute('aria-disabled', 'true');
        });

        // Enable the clicked link
        link.classList.remove('disabled');
        link.removeAttribute('aria-disabled');

        // Optionally, you can perform additional actions here, such as displaying a loading spinner
    }