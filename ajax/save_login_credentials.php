<?php
header('Content-Type: application/json');
session_start();
error_reporting(0);
ini_set('display_errors', 1);

// Include dependencies
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");

// DB connection
$dsn = "mysql:host=" . IP . ";dbname=" . DB . ";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, USER, DBPWD, $options);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Collect input
$mode       = $_POST['mode'] ?? '';
$username   = trim($_POST['login_username'] ?? '');
$password   = trim($_POST['login_password'] ?? '');
$user_type  = $_POST['user_type'] ?? '';
$user_id    = $_POST['user_id'] ?? '';
$created_by = $_SESSION['LOGIN_LEGAL_ID'] ?? null;



// ===== Encryption and Decryption Functions for Password =====
function encryptPassword($data, $key) {
    // Generate a random initialization vector (IV)
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    // Encrypt the password using AES-256-CBC algorithm
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

    // Return the encrypted password along with the IV (necessary for decryption)
    return base64_encode($encryptedData . '::' . $iv);
}




// ===== REGISTER OR UPDATE =====
if ($mode === 'register') {

    // Check for required fields
    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username and password are required.']);
        exit;
    }

    if (empty($user_type) || empty($user_id)) {
        echo json_encode(['success' => false, 'message' => 'Invalid user type or ID.']);
        exit;
    }

    // Validate username length
    if (strlen($username) < 4 || strlen($username) > 100) {
        echo json_encode(['success' => false, 'message' => 'Username must be between 4 and 100 characters.']);
        exit;
    }

    // Validate password length
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters.']);
        exit;
    }

    // Check for duplicate username, excluding current user_id if updating
    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM legal_agencies_login WHERE user_name = ? AND user_id != ?
    ");
    $stmt->execute([$username, $user_id]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false,'message' => 'Username <u>'.htmlspecialchars($username).'</u> already exists.']);
        exit;
    }

    // Check if the combination of user_id and user_type already exists (for update scenario)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM legal_agencies_login WHERE user_id = ? AND user_type = ?");
    $stmt->execute([$user_id, $user_type]);
    $exists = $stmt->fetchColumn() > 0;

    // Encrypt the password
    $encryptedPassword = encryptPassword($password, secretKey);

    try {
        if ($exists) {
            // Update existing record
            $stmt = $pdo->prepare("
                UPDATE legal_agencies_login
                SET user_name = ?, password = ?, updated_on = NOW(), updated_by = ?
                WHERE user_id = ? AND user_type = ?
            ");
            $success = $stmt->execute([$username, $encryptedPassword, $created_by, $user_id, $user_type]);
            $message = $success ? 'Login credentials updated successfully.' : 'Update failed.';
        } else {
            // Insert new record
            $stmt = $pdo->prepare("
                INSERT INTO legal_agencies_login (
                    user_id, user_type, user_name, password, created_on, created_by
                ) VALUES (?, ?, ?, ?, NOW(), ?)
            ");
            $success = $stmt->execute([$user_id, $user_type, $username, $encryptedPassword, $created_by]);
            $message = $success ? 'Login credentials registered successfully.' : 'Registration failed.';
        }

        $_SESSION['PAGE_SUCCESS'] = $message;
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;

    } catch (PDOException $e) {
        // Improved error handling with more detail
        if (strpos($e->getMessage(), 'Integrity constraint violation') !== false) {
            echo json_encode(['success' => false, 'message' => 'Username already exists or violated unique constraints.']);
        } else {
            // Log the error to server logs for debugging purposes (optional)
            error_log('Database Error: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
        exit;
    }
}



// ===== LOGIN =====
elseif ($mode === 'login') {

    $stmt = $pdo->prepare("SELECT * FROM legal_agencies_login WHERE user_name = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
        exit;
    }

    // Decrypt password from the database
    $decryptedPassword = decryptPassword($user['password'], secretKey);

    if ($decryptedPassword !== $password) {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
        exit;
    }

    // Create session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user_name'] = $user['user_name'];
    $_SESSION['user_type'] = $user['user_type'];

    echo json_encode(['success' => true, 'message' => 'Login successful.']);
    exit;

}


// ===== SHOW =====
elseif ($mode === 'show') {

    if (empty($user_id) || empty($user_type)) {
        echo json_encode(['success' => false, 'message' => 'User ID and User Type are required.']);
        exit;
    }

    // Fetch the user details from the database, including the encrypted password
    $stmt = $pdo->prepare("SELECT user_name, legal_agencies_login.password FROM legal_agencies_login WHERE user_id = ? AND user_type = ?");
    $stmt->execute([$user_id, $user_type]);
    $user = $stmt->fetch();

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
        exit;
    }

    // Decrypt the password
    $decryptedPassword = decryptPassword($user['password'], secretKey);

    // Return the user details, including decrypted password
    echo json_encode([
        'success' => true,
        'message' => 'User details retrieved successfully.',
        'user_data' => [
            'user_name' => $user['user_name'],
            'password' => $decryptedPassword // Showing the decrypted password
        ]
    ]);
    exit;

}


// ===== INVALID MODE =====
else {
    echo json_encode(['success' => false, 'message' => 'Invalid request mode.']);
    exit;
}
