<?php
ob_start();
session_start();
error_reporting(0);
include_once("../../../lib/config.php");

$conn = new mysqli(IP, USER, DBPWD, DB);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$menu_id = isset($_POST['menu_id']) ? intval($_POST['menu_id']) : 0;
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$permission = isset($_POST['permission']) ? strtoupper($_POST['permission']) : '';
$value = isset($_POST['value']) ? intval($_POST['value']) : 0;

$valid_permissions = ['A', 'V', 'E', 'D', 'P', 'M'];
if (!$menu_id || !$user_id || !in_array($permission, $valid_permissions)) {
    http_response_code(400);
    echo 'Invalid input';
    exit;
}

// Fetch existing record
$query = "SELECT actions FROM legal_menu_permission WHERE menu_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $menu_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$currentActions = '';
if ($row) {
    $currentActions = $row['actions'];
    $actionsArray = array_filter(array_map('trim', explode(',', $currentActions)));

    if ($value === 1 && !in_array($permission, $actionsArray)) {
        $actionsArray[] = $permission;
    } elseif ($value === 0) {
        $actionsArray = array_filter($actionsArray, function($act) use ($permission) {
            return $act !== $permission;
        });
    }

    $newActions = implode(',', $actionsArray);

    $update = $conn->prepare("UPDATE legal_menu_permission SET actions = ?, updated_on = NOW(), updated_by = ? WHERE menu_id = ? AND user_id = ?");
    $update->bind_param("siii", $newActions, $user_id, $menu_id, $user_id);
    $update->execute();

    echo 'Permission updated';
} else {
    // Insert new record
    $newActions = $value === 1 ? $permission : '';
    $insert = $conn->prepare("INSERT INTO legal_menu_permission (user_id, menu_id, actions, status, created_on, created_by) VALUES (?, ?, ?, 'A', NOW(), ?)");
    $insert->bind_param("iisi", $user_id, $menu_id, $newActions, $user_id);
    $insert->execute();

    echo 'Permission inserted';
}
?>
