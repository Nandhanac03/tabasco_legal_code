<?php
// API URL
$url = "https://tabasco.ae/legal_api_customers.php";

// Fetch JSON data from the URL
$jsonData = file_get_contents($url);

// Check if the request was successful
if ($jsonData === FALSE) {
    die("Error: Unable to fetch data from the API.");
}

// Decode the JSON response into a PHP array
$data = json_decode($jsonData, true); // Use `true` to decode into an associative array

// Check if decoding was successful
if ($data === NULL) {
    die("Error: Failed to decode JSON.");
}

// Print the array (for debugging)
print_r($data);

// Access specific parts of the array (example)
if ($data['status'] === 'success') {
    foreach ($data['data'] as $customer) {
        echo "ID: " . $customer['customer_Id'] . ", Name: " . $customer['customer_name'] . "\n";
    }
}



exit;
?>


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
    <label for="customerSelect">Select Customer:</label>
    <select id="customerSelect">
        <option value="">-- Select a Customer --</option>
    </select>

    <script>
        $(document).ready(function () {
            // URL of the JSON API
            const apiUrl = "https://tabasco.ae/legal_api_customers.php";

            // Fetch data from the API
            $.ajax({
                url: apiUrl,
                method: "GET",
                dataType: "json",
                success: function (response) {
                    // Check if the API response is successful
                    if (response.status === "success") {
                        const customers = response.data;
                        const customerSelect = $("#customerSelect");

                        // Populate the select dropdown
                        customers.forEach(customer => {
                            customerSelect.append(
                                `<option value="${customer.customer_Id}">${customer.customer_name}</option>`
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
