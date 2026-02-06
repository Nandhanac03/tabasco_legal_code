<?php
header('Content-Type: application/json');
include_once("../../../lib/config.php");

// ✅ Database credentials (from config.php)
$host     = IP;
$username = USER;
$password = DBPWD;
$database = DB;

// ✅ Connect to MySQL
$conn = new mysqli($host, $username, $password, $database);

// ✅ Check connection
if ($conn->connect_error) {
    echo json_encode([
        'exists' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit;
}

// ✅ Process request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'client_exist') {

    $client_id = isset($_POST['client_id']) ? trim($_POST['client_id']) : '';

    if (!empty($client_id)) {
        // ✅ Prepared statement to get `id`
        $stmt = $conn->prepare("SELECT id FROM legal_client WHERE status='A' AND refer_id = ?");
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($client_db_id);
            $stmt->fetch();

            echo json_encode([
                'exists' => true,
                'id' => $client_db_id   // ✅ Return actual client `id`
            ]);
        } else {
            echo json_encode([
                'exists' => false,
                'message' => 'Client not found'
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            'exists' => false,
            'message' => 'Client ID is empty'
        ]);
    }

} else {
    echo json_encode([
        'exists' => false,
        'message' => 'Invalid request'
    ]);
}

$conn->close();
?>
