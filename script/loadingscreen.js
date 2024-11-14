// Show the loading screen when the page starts loading
document.getElementById('loading-screen').style.display = 'flex';

window.onload = function() {
    // Hide the loading screen once the page is fully loaded
    document.getElementById('loading-screen').style.display = 'none';

    // Show the main content
    document.getElementById('content').style.display = 'block';
};

// Optional: Display the loading screen again if the page is reloaded or navigated away
window.onbeforeunload = function() {
    // Show the loading screen when navigating away
    document.getElementById('loading-screen').style.display = 'flex';
};