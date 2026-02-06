<div>
        <button id="back-button" class="btn btn-secondary">
            <ion-icon name="arrow-back-outline"></ion-icon> Back
        </button>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Back Button Click - Go to Previous Page
        let backButton = document.getElementById("back-button");
        if (backButton) {
            backButton.addEventListener("click", function () {
                window.history.back(); // Navigate back
            });
        }
    });
</script>