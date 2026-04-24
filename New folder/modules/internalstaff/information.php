<?php
ob_start();
include_once("lib/class/auth.php");
session_start();
if (LEGAL_AUTH_VIEW==false){
    header("Location: ".ROOT_DIR."permission_denied.php");
    exit();
}

include_once("lib/class/class.legal_users.php");
$ObjUsersClass = new UsersClass();

$edit_id        =   trim($_GET['param1']);
$action         =   trim($_GET['action']);

if ($_POST) {


    if (isset($_POST['user_name'])) {
        if($action=='edit')
        $data['user_Id']      =  trim($_POST['edit_ID']);
        else
        $data['user_Id']      =  '';
        $data['user_typeId']  = 22; // Assuming 21 is the user type ID for internal staff
        $data['user_name']    = $_POST['user_name'];
        $data['user_emailId'] = $_POST['user_emailId'];
        $data['user_tel']     = $_POST['user_tel'];
        $data['user_mob']     = $_POST['user_mob'];
        $data['user_address'] = $_POST['user_address'];
        $data['user_module']  = 'TL';

// Handle the uploaded image
if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profilePhoto']['tmp_name'];
    $fileName = $_FILES['profilePhoto']['name'];
    $fileSize = $_FILES['profilePhoto']['size'];
    $fileType = $_FILES['profilePhoto']['type'];

    // Optional: Validate file type/size here on the server side
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Get the file extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileType, $allowedMimeTypes) && in_array($fileExtension, $allowedExtensions)) {

        // Define the upload directory
        $uploadFileDir = 'uploads/users_photo/';

        // Create the upload directory if it doesn't exist
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        // Generate a unique random file name and append the original file extension
        $newFileName = uniqid() . '.' . $fileExtension; // Unique name with the original file extension
        $dest_path = $uploadFileDir . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // File uploaded successfully, save the file name in the database
            $data['user_photo'] = $newFileName;
        } else {
            // Error moving the file
            $msg = "Error moving uploaded file.";
        }
    } else {
        // Invalid file type or file extension
        $msg = "Invalid file type or file extension uploaded.";
    }
} else {
    // No image uploaded, you can either skip it or assign a default image
    $data['user_profile'] = 'default.png'; // Default profile image
}





        // Now save the user data in the database
        if ($ObjUsersClass->processUsers($data)) {
            $msg = "User information updated successfully.";
            $_SESSION['PAGE_SUCCESS'] = 'You have successfully ' . ($edit_id ? 'updated' : 'added') . ' the Internal Staff';
            header("location: " . ROOT_DIR . "internalstaff/list.html");
            exit;
        } else {
            $msg = "Failed to update user information.";
        }
    }
}else{
    switch($action){
        case 'edit':
            $array_user_data  =   array();
            if ($edit_id > 0)
            $data               =   $ObjUsersClass->get_all_Users($edit_id,'',22)[0];
            $data['user_photo'] = $data['user_photo'] ? $data['user_photo'] : ''; // Default
            if(!isset($data['user_Id'])){
                header("location: " . ROOT_DIR . "internalstaff/information.html");
                exit;
            }
        break;

    }
}

$actve_sub_menu = 'dashboard';
$body = "information.tpl";
