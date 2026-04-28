





<!-- view -->


<?php

ob_start();

session_start();

# including files here

include_once("lib/config.php");

include_once("lib/class/class.dbcon.php");

include_once("lib/class/class.legal_case.php");

include_once("lib/class/class.legal_category.php");

include_once("lib/class/class.legal_court.php");

include_once("lib/class/class.legal_users.php");
include_once("lib/class/class.legal_active_legals.php");

$objActiveLegal = new ActiveLegal();



$action = $_GET['action'];

$id = $_GET['param1'];

$objLegalCase =   new LegalCase();

$objCategory =   new Category();

$objCourt =   new Court();
$ObjUsersClass = new UsersClass();


$categories = $objCategory->get_category();



// if (!$action || !$id) {

//     header("location: " . ROOT_DIR . "activelegal/list.html");

//     exit;
// }



$current_case = $objLegalCase->get_case_info($id);

$current_case_root = $objLegalCase->get_roots('', $id);

$case_id = $id;        
$case_plantiffs = $objLegalCase->get_case_root_clients($case_id);




// echo '<pre>';
// print_r($current_case_root[0]['plantiff_name']); 
// exit;



// $active_legal_id = $id; // The ID of the current case

// $case_plantiffs = $objLegalCaseClient->get_case_plantiffs($active_legal_id);
//$case_defender  = $objLegalCaseClient->get_case_defenders($active_legal_id);

$case_ids = $id;        
$case_defender = $objLegalCase->get_case_root_clients_defender($case_ids);







$courts = $objCourt->get_court();

$list1 = $ObjUsersClass->get_all_Users(null, '', 23) ?: [];
$list2 = $ObjUsersClass->get_all_Users(null, '', 24) ?: [];

$lawyerusersList = array_merge($list1, $list2);

if (!empty($current_case)) {

    foreach ($categories as $category) {

        if ($category['id'] = $current_case[0]['category']) {

            $current_case[0]['category_name'] = $category['title'];
        }
    }
}

$active_legal_id = $current_case[0]['active_legal_id'];
$active_legal = $objActiveLegal->Get_ActiveLegal_Information(['id' => $active_legal_id]);




$body   =   "view.tpl";
