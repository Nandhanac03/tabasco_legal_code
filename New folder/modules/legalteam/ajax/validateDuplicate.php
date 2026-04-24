<?php
ob_start();
session_start();
error_reporting(0);
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_users.php");

$ObjUsersClass = new UsersClass();

$action     = $_POST['action'] ?? null;
$edit_ID    = $_POST['edit_ID'] ?? null;
$response='';


switch ($action) {
    case 'validateEmail':
        $email      = $_POST['email'] ?? null;
        if($email){
            $array_validate = $ObjUsersClass->duplicate_Check('A', $edit_ID, $email,'');

            if ($array_validate[0]['TOTAL_RECORDS'] > 0) {
                $response = '<span class="text-danger">'.$email.' Email ID already exists.</span>';
            } else {
                //$response = '<span class="text-success">Email ID is available.</span>';
            }
            echo $response;
        }

    break;

    case 'validateLoginName':
        $loginName      = $_POST['loginName'] ?? null;
        if($loginName){
            $array_validate = $ObjUsersClass->duplicate_Check('A', $edit_ID, '',$loginName);

            if ($array_validate[0]['TOTAL_RECORDS'] > 0) {
                $response = '<span class="text-danger">'.$loginName.' Username already exists.</span>';
            } else {
                //$response = '<span class="text-success">Email ID is available.</span>';
            }
            echo $response;
        }


    break;



}

