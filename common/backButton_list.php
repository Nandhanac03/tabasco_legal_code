<div>
        <button id="back-button-client" class="btn btn-secondary">
            <ion-icon name="arrow-back-outline"></ion-icon> Back
        </button>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Back Button Click - Go to Previous Page
        let backButtonclient = document.getElementById("back-button-client");
        if (backButtonclient) {
            backButtonclient.addEventListener("click", function () {
                window.location.href = "<?= ROOT_DIR ?><?=$module?>/list.html"; // Update the path if needed

            });
        }
    });
</script>