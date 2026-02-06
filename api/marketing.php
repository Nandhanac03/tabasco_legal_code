<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Populate Select List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Customer List</h1>
    <label for="marketingelect">Select Customer:</label>
    <select id="marketingelect">
        <option value="">-- Select a Customer --</option>
    </select>

    <script>
        $(document).ready(function () {
            // URL of the JSON API
            const apiUrl = "https://tabasco.ae/legal_api_marketing.php";

            // Fetch data from the API
            $.ajax({
                url: apiUrl,
                method: "GET",
                dataType: "json",
                success: function (response) {
                    // Check if the API response is successful
                    if (response.status === "success") {
                        const marketing = response.data;
                        const marketingelect = $("#marketingelect");

                        // Populate the select dropdown
                        marketing.forEach(customer => {
                            marketingelect.append(
                                `<option value="${customer.user_Id}">${customer.user_name}</option>`
                            );
                        });
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("API Error:", error);
                    alert("Failed to load customer data. Please try again later.");
                }
            });
        });
    </script>
</body>
</html>
