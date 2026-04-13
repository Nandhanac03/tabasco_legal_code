<?php

header('Content-Type: application/json');

error_reporting(0);

ini_set('display_errors', 1);

session_start();



include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_case.php");

include_once("../../../lib/class/class.legal_court.php");

include_once("../../../lib/class/class.legal_category.php");
include_once("../../../lib/class/class.legal_case_root_actions.php");


$objcaseRootAction = new CaseRootAction();
$objLegalCase = new LegalCase();


$objLegalCourt =  new Court();

$objLegalCategory =  new Category();



function generateRootsTemplate($data)

{

    if ($data) {

        $data = array_reverse($data);
    }

    $msg = '';

    if (empty($data)) {

        $msg = "<tr>

                    <td colspan='9' class='text-center'>No roots available.</td>

                </tr>";
    } else {

        foreach ($data as $key => $each_data) {

            $sl = $key + 1;

            // $json_data = json_encode(['id' => $each_data['id'], 'lawyer' => $each_data['lawyer'], 'court' => $each_data['court'], 'stage' => $each_data['stage'], 'category' => $each_data['category'], 'register_date' => $each_data['register_date']]);

            $json_data = json_encode([
                'id' => $each_data['id'],
                'lawyer' => $each_data['lawyer'],
                'court' => $each_data['court'],
                'stage' => $each_data['stage'],
                'plantiff' => $each_data['plantiff'],
                'defendant' => $each_data['defendant'],
                'category' => $each_data['category'],
                'register_date' => $each_data['register_date'],
                'root_cat_number' => $each_data['root_cat_number']
            ]);

            // print_r( $json_data);
            // exit();
            
            $root_cat_number = !empty($each_data['root_cat_number']) ? $each_data['root_cat_number'] : '.........';

           
            
            $msg .= "<tr>

                        <td>{$sl}</td>

                        <td>{$root_cat_number}</td>

                        <td>{$each_data['category_name']}</td>

                        <td>{$each_data['court_name']}</td>

                        <td>{$each_data['stage']}</td>

                        <td>{$each_data['plantiff']}</td>

                        <td>{$each_data['defendant']}</td>

                        <td>{$each_data['register_date']}</td>

                        <td style='max-width:280px; min-width:240px; white-space:normal; word-wrap:break-word; overflow-wrap:break-word; text-align: justify;'>{$each_data['last_action']}</td>

                        <td>{$each_data['last_action_date']}</td>

                        <td>

                            <button class='btn ' data-bs-toggle='modal' data-bs-target='#editRootsModal' data-jsonvalues='{$json_data}'><ion-icon name='pencil-outline'></ion-icon></button>

                        </td>

                    </tr>";
        }
    }

    return $msg;
}





if ($_POST['action']) {

    $action = $_POST['action'];



    switch ($action) {

        case 'save':

            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {

                echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);

                exit;
            }

            $id = isset($_POST['id']) ? $_POST['id'] : '';

            $case_id = $_POST['case_id'];

            $active_legal_id = $_POST['active_legal_id'];

            $lawyer = $_POST['lawyer'];

            $court = $_POST['court'];


            $category = $_POST['category'];

            $register_date = $_POST['register_date'];

            $root_cat_number = $_POST['root_cat_number'];


            $stage = $_POST['stage'];

            $plantiff = $_POST['plantiff'];

            $defendant = $_POST['defendant'];
           

            $previous_stage = $_POST['previous_stage'];


            if ($case_id == '') {

                echo json_encode(['success' => false, 'message' => 'Case ID required.']);

                exit;
            }

            if ($active_legal_id == '') {

                echo json_encode(['success' => false, 'message' => 'Active Legal ID required.']);

                exit;
            }

            if ($lawyer == '') {

                echo json_encode(['success' => false, 'message' => 'Lawyer name required.']);

                exit;
            }

            if ($court == '') {

                echo json_encode(['success' => false, 'message' => 'Court is required.']);

                exit;
            }

            if ($stage == '') {

                echo json_encode(['success' => false, 'message' => 'Stage is required.']);

                exit;
            }


           




            if ($category == '') {

                echo json_encode(['success' => false, 'message' => 'Category is required.']);

                exit;
            }

            if ($register_date == '') {

                echo json_encode(['success' => false, 'message' => 'Register Date required.']);

                exit;
            }

            $input_data = [];

            $input_data['case_id'] = $case_id;

            $input_data['active_legal_id'] = $active_legal_id;

            $input_data['lawyer'] = $lawyer;

            $input_data['court'] = $court;

            $input_data['stage'] = $stage;

            $input_data['plantiff'] = $plantiff;


            $input_data['defendant'] = $defendant;


            $input_data['category'] = $category;

            $input_data['register_date'] = $register_date;

            $input_data['root_cat_number'] = $root_cat_number;
            // echo '<pre>';
            // print_r($input_data);
            // echo '</pre>';
            // exit;
            

            if ($id == '') {

                $input_data['created_on'] = date('Y-m-d H:i:s');

                $input_data['created_by'] = $_SESSION['LOGIN_LEGAL_ID'];
            }

            $input_data['status'] = 'A';

            $input_data['updated_on'] = date('Y-m-d H:i:s');

            $input_data['updated_by'] = $_SESSION['LOGIN_LEGAL_ID'];

            $exist_root = $objLegalCase->get_roots('', $case_id, $active_legal_id, $stage);

            $is_true = ($stage == $previous_stage) ? true : false;

            if ($exist_root && ! $is_true) {
                echo json_encode(['success' => false, 'message' => 'Select a new stage (do not reuse an existing one)']);
                exit;
                
            }





            $before_data = null;
            if ($id) {
                $current_roots = $objLegalCase->get_roots($id);
                $before_data = !empty($current_roots) ? $current_roots[0] : null;
            }

            if ($objLegalCase->saveRoots($input_data, $id)) {
                $action_type = $id ? 'UPDATE' : 'CREATE';
                $record_id = $id ? $id : $objLegalCase->mysqlInsertid();
                
                $message = $id ? "Updated case root for case ID: {$case_id}" : "Created new case root for case ID: {$case_id}";
                
                //$objlogger->logActivity($action_type, 'Case Roots', $record_id, $message, $before_data, $input_data);

                if ($id) {
                    echo json_encode(['success' => true, 'message' => 'Roots updated successfully']);
                } else {
                    echo json_encode(['success' => true, 'message' => 'Roots saved successfully']);
                }
                exit;
            } else {

                echo json_encode(['success' => false, 'message' => 'Error occured while saving.']);

                exit;
            }

        case 'get_data':

            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {

                echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);

                exit;
            }

            $case_id = $_POST['case_id'];

            $active_legal_id = $_POST['active_legal_id'];

            $case_roots_data = $objLegalCase->get_roots('', $case_id, $active_legal_id);

           

            if (!empty($case_roots_data)) {

                $case_data = $objLegalCase->get_case_info($case_id);

                $courts = $objLegalCourt->get_court();

                $categories = $objLegalCategory->get_category();

                $case_number = isset($case_data) && !empty($case_data) ? $case_data[0]['case_number'] : '';

                foreach ($case_roots_data as $key => $roots) {

                    $case_roots_data[$key]['case_number'] = $case_number;

                    $root_cat_number = $roots['root_cat_number'];
                    $case_filter = array();
                    $case_filter['created_from'] = 'CA';
                    $case_filter['case_root_id'] = $roots['id'];
                    $case_filter['active_legal_id'] = $roots['active_legal_id'];

                    $case_roots = $objcaseRootAction->get_case_root('',  $case_filter);
                    $case_roots_data[$key]['last_action'] = $case_roots_data[$key]['last_action_date'] = '****';
                    if ($case_roots) {
                        $last_case_root = $case_roots[0];
                        $case_roots_data[$key]['last_action'] = $last_case_root['description'];
                        $case_roots_data[$key]['last_action_date'] = $last_case_root['date'];
                    }


                    if (!empty($courts)) {

                        foreach ($courts as $court) {

                            if ($roots['court'] == $court['id']) {

                                $case_roots_data[$key]['court_name'] = $court['title'];
                            }
                        }
                    }

                    if (!empty($categories)) {

                        foreach ($categories as $category) {

                            if ($roots['category'] == $category['id']) {

                                $case_roots_data[$key]['category_name'] = $category['title'];
                            }
                        }
                    }
                }
            }

            echo json_encode(['success' => true, 'message' => generateRootsTemplate($case_roots_data)]);

            exit;
    }
} else {

    echo json_encode(['success' => false, 'message' => 'Invalid request']);

    exit;
}






