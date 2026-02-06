<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 1);
session_start();
// Include necessary files
include_once("../lib/config.php");
include_once("../lib/class/class.dbcon.php");

include_once("../lib/class/class.legal_document.php");
$objprocessDocument = new processDocument();

// CSRF token validation
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);
    exit;
}

$file           = $_FILES['filename'];
$parent_id      = isset($_POST['parent_id']) ? $_POST['parent_id'] : null;
$parent_type    = isset($_POST['parent_type']) ? $_POST['parent_type'] : null;
$ddl_type       = isset($_POST['ddl_type']) ? $_POST['ddl_type'] : null;

if ($ddl_type=='' && $parent_id=='' && !isset($_FILES['filename']))  {
    echo json_encode(['status' => 'error', 'message' => VALIDATION_MSG]);
    exit;
}

if ($file['error'] !== UPLOAD_ERR_OK && $ddl_type=='') {
    $response['message'] = VALIDATION_MSG;
    $response['status'] ='error';
    echo json_encode($response);
    exit;
}
// Check if file is uploaded
if (!isset($_FILES['filename'])) {
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded.']);
    exit;
}


// Allowed MIME types and extensions
$allowedMimeTypes = [
    'application/pdf' => 'pdf',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
    'image/png' => 'png',
    'image/jpeg' => 'jpg'
];

$maxSize = 1 * 1024 * 1024; // ✅ Updated to 1MB limit

// Validate file error
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'File upload error.']);
    exit;
}

// Validate file size
if ($file['size'] > $maxSize) {
    echo json_encode(['status' => 'error', 'message' => 'File exceeds the 1MB limit.']);
    exit;
}

// Validate MIME type from file content
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);

if (!array_key_exists($mime, $allowedMimeTypes)) {
    echo json_encode(['status' => 'error', 'message' => 'Unsupported file type.']);
    exit;
}

// Generate a secure, unique file name
$extension = $allowedMimeTypes[$mime];
$newName = uniqid('file_'.$parent_id.'_', true) . '.' . $extension;
$uploadDir = '../uploads/documents' . DIRECTORY_SEPARATOR;
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$destination = $uploadDir . $newName;

// Move the uploaded file
if (move_uploaded_file($file['tmp_name'], $destination)) {

    $input_data =   array();

    $input_data['type_id']      =   trim($ddl_type);
    $input_data['name']         =  $newName;
    $input_data['parent_id']    =  $parent_id;
    $input_data['parent_type']  =  $parent_type;
    $input_data['create_by']    =  $_SESSION['LOGIN_LEGAL_ID'];
    $input_data['create_on']    =  date('Y-m-d H:i:s');
    if($objprocessDocument->upload_document($input_data)){
        echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully.']);
    }else{
        // ❌ Failed to save document data, so unlink (delete) the uploaded file
        if (file_exists($destination)) {
            unlink($destination); // Safely remove the uploaded file
        }
        echo json_encode(['status' => 'error', 'message' => 'Failed to save the uploaded file.']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save the uploaded file.']);
}
