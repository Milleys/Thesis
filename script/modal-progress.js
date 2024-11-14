document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal");
    const openModalBtn = document.getElementById("open-modal-btn");
    const progressBar = document.getElementById("progress-bar");
    const loadingMessage = document.createElement("p");
    const completionSound = document.getElementById("completion-sound");

    let progress = 0;
    let progressInterval;
    let messageInterval;
    const messages = [
        "Fetching data for Station I...",
        "Fetching data for Station V...",
        "Fetching data for Station XV...",
        "Fetching data for Station XIX...",
        "Fetching data for Station XVI...",
        "Fetching data for Station XIII..."
    ];
    let messageIndex = 0;

    // Append loading message to modal content
    document.getElementById("modal-content").appendChild(loadingMessage);

    // Function to update progress bar width
    function updateProgress(percentage) {
        progressBar.style.width = percentage + "%";
    }

    // Function to update loading message
    function updateMessage() {
        loadingMessage.textContent = messages[messageIndex];
        messageIndex = (messageIndex + 1) % messages.length; // Loop through messages
    }

    // Function to start the slow progress and message rotation
    function startProgress() {
        progress = 0;
        messageIndex = 0;
        updateMessage(); // Display the first message

        // Start updating the progress bar slowly
        progressInterval = setInterval(() => {
            if (progress < 97) {
                progress += 0.57;
            } else if (progress < 99) {
                progress += 0.1;
            }
            updateProgress(progress);
        }, 100);

        // Rotate messages every 800ms (adjust as needed)
        messageInterval = setInterval(updateMessage, 3000);
      
    }

    // Event listener to show the modal and start progress tracking when button is clicked
    openModalBtn.addEventListener("click", () => {
        modal.style.display = "flex";
        startProgress();
    });

    // Complete the progress and close the modal when the page is fully loaded
    window.addEventListener("load", () => {
        clearInterval(progressInterval);
        clearInterval(messageInterval);
        progress = 100;
        updateProgress(progress);
        loadingMessage.textContent = "Loading complete!";
       

        setTimeout(() => {
            modal.style.display = "none";
        }, 500);
    });
});
