<?php
// Allow CORS for development purposes
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Database configuration
// $host = 'localhost';
// $user = 'tabasco_ait';
// $password = '863n4CJET!uq';
// $database = 'tabasco_live';

$host = 'ded6951.inmotionhosting.com';
$user = 'tabasco_legal';
$password = 'gME6i0ljZLu6';
$database = 'tabasco_live';


try {
    // Connect to the database
    $mysqli = new mysqli($host, $user, $password, $database);

    // Check for connection errors
    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }

    // Query to get the list of customers
    $query = "SELECT * FROM customer";
    $result = $mysqli->query($query);

    // Check if the query returned results
    if (!$result) {
        throw new Exception("Query failed: " . $mysqli->error);
    }

    // Fetch customers into an array
    $customers = [];
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }

    // Free the result set
    $result->free();

    // Close the database connection
    $mysqli->close();

    // Send JSON response
    echo json_encode([
        "status" => "success",
        "data" => $customers
    ]);
} catch (Exception $e) {
    // Handle errors and send JSON error response
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>
