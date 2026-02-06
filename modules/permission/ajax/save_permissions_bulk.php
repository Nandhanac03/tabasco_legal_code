<?php
ob_start();
session_start();
error_reporting(0);
include_once("../../../lib/config.php");

$conn = new mysqli(IP, USER, DBPWD, DB);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = isset($_POST['bulk']) ? json_decode($_POST['bulk'], true) : [];
if (empty($data) || !is_array($data)) {
    http_response_code(400);
    echo 'Invalid bulk input';
    exit;
}

$valid_permissions = ['A', 'V', 'E', 'D', 'P', 'M'];
foreach ($data as $row) {
    $menu_id = intval($row['menu_id']);
    $user_id = intval($row['user_id']);
    $permission = strtoupper($row['permission']);
    $value = intval($row['value']);

    if (!$menu_id || !$user_id || !in_array($permission, $valid_permissions)) {
        continue;
    }

    // Fetch existing record
    $query = "SELECT actions FROM legal_menu_permission WHERE menu_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $menu_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowData = $result->fetch_assoc();

    if ($rowData) {
        $actionsArray = array_filter(array_map('trim', explode(',', $rowData['actions'])));
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
    } else {
        $newActions = $value === 1 ? $permission : '';
        $insert = $conn->prepare("INSERT INTO legal_menu_permission (user_id, menu_id, actions, status, created_on, created_by) VALUES (?, ?, ?, 'A', NOW(), ?)");
        $insert->bind_param("iisi", $user_id, $menu_id, $newActions, $user_id);
        $insert->execute();
    }
}

echo "Bulk permissions updated";
?>
