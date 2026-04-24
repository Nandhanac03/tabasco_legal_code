<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.filemanagement.php");
$objFile = new Filemanagement;

if ($_POST) {
    echo "<pre>";
    print_r($_POST);
    echo "<pre>";
    print_r($_FILES);
    if (!empty($_FILES)) {
        $uploaded_doc['uploaded_file'] = $_FILES['document'];

        $data = $objFile->uploadFile($uploaded_doc);
        echo "<pre>";
        print_r($data);
        exit;
    }
}




$body = "document.tpl";