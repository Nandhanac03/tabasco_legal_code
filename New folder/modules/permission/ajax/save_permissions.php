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
$permission = isset($_POST['permission']) ? strtoupper(trim($_POST['permission'])) : '';
$value = isset($_POST['value']) ? intval($_POST['value']) : 0;

$valid_permissions = ['A','V','E','D','P','M'];

if (!$menu_id || !$user_id || !in_array($permission, $valid_permissions)) {
    http_response_code(400);
    echo 'Invalid input';
    exit;
}

/* FETCH EXISTING RECORD */
$stmt = $conn->prepare("SELECT actions FROM legal_menu_permission WHERE menu_id=? AND user_id=?");
$stmt->bind_param("ii",$menu_id,$user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$actionsArray = [];

if($row){

    $actionsArray = array_filter(array_map('trim', explode(',',$row['actions'])));

    /* ADD PERMISSION */
    if($value==1 && !in_array($permission,$actionsArray)){
        $actionsArray[] = $permission;
    }

    /* REMOVE PERMISSION */
    if($value==0){
        $actionsArray = array_diff($actionsArray,[$permission]);
    }

    $actionsArray = array_unique($actionsArray);
    $newActions = implode(',',$actionsArray);

    /* DELETE RECORD IF NO ACTION LEFT */
    if(empty($newActions)){
        $delete = $conn->prepare("DELETE FROM legal_menu_permission WHERE menu_id=? AND user_id=?");
        $delete->bind_param("ii",$menu_id,$user_id);
        $delete->execute();

        echo "Permission removed";
        exit;
    }

    /* UPDATE RECORD */
    $update = $conn->prepare("UPDATE legal_menu_permission 
        SET actions=?,updated_on=NOW(),updated_by=? 
        WHERE menu_id=? AND user_id=?");

    $update->bind_param("siii",$newActions,$user_id,$menu_id,$user_id);
    $update->execute();

    echo "Permission updated";

}else{

    /* INSERT NEW RECORD */

    if($value==1){

        $insert = $conn->prepare("INSERT INTO legal_menu_permission
        (user_id,menu_id,actions,status,created_on,created_by)
        VALUES (?,?,?,'A',NOW(),?)");

        $insert->bind_param("iisi",$user_id,$menu_id,$permission,$user_id);
        $insert->execute();

        echo "Permission inserted";
    }

}
?>
