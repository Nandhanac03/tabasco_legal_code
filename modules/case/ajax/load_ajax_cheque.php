<?php

ob_start();

session_start();

error_reporting(0);



include_once("../../../lib/config.php");

include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_cheque.php");
include_once("../../../lib/class/class.legal_active_legals.php");

include_once("../../../lib/class/class.legal_case.php");
$objLegalCase =   new LegalCase();
$objActiveLegal =   new ActiveLegal();

$objCheque = new Cheque();


if ($_POST) {






    // CSRF token validation

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {

        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);

        exit;
    }

    $postID = isset($_POST['hid_parentID']) ? htmlspecialchars($_POST['hid_parentID']) : null;

    $post_module = isset($_POST['hid_module']) ? htmlspecialchars($_POST['hid_module']) : null;

    $post_page = isset($_POST['hid_page']) ? htmlspecialchars($_POST['hid_page']) : null;

    $active_legal = isset($_POST['active_legal']) ? htmlspecialchars($_POST['active_legal']) : null;
    $selected_client_id = isset($_POST['selected_client_id']) ? htmlspecialchars($_POST['selected_client_id']) : null;

    $parentID = '';

    if (!empty($postID)) {
        $case = $objLegalCase->get_case($postID);
        $parentID = $case[0]['client_id'] ?? '';
    } elseif (!empty($active_legal) && empty($selected_client_id)) {
        $active_legal_array = $objActiveLegal->Get_ActiveLegal_Information(['id' => $active_legal]);
        $parentID = $active_legal_array[0]['client'] ?? '';
    } elseif (!empty($selected_client_id)) {
        $parentID = $selected_client_id;
    }



    if (!$parentID || !$post_module || !$post_page) {

        $response['message'] = 'Error occured while fetching';

        $response['success'] = false;

        echo json_encode($response);

        exit;
    }

    try {



        $available_cheque = $objCheque->get_cheque('', $parentID);



        $html = "";

        if (!empty($available_cheque)) {

            foreach ($available_cheque as $key => $cheque) {

                $no = $key + 1;
                if (!empty($cheque['cheque_name'])) {
                    $fileIcon = "<a href='" . ROOT_DIR . "/uploads/all_cheque/{$cheque['cheque_name']}' target='_blank' 
                                    title='View cheque file'>
                                    <ion-icon name='file-tray-full' size='small'></ion-icon> View
                                 </a>";
                } else {
                    $fileIcon = "<span style='color:#999;'>
                                    <ion-icon name='file-tray-full' size='small'></ion-icon> No File
                                 </span>";
                }


                $html .= "<tr>
    <td>{$no}</td>
    <td>{$cheque['upload_date']}</td>
    <td>{$cheque['amount']}</td>
    <td>{$fileIcon}</td>
    
</tr>";
            }
        } else {

            $html = "<tr>

                    <td class='text-center' colspan='4'>No Cheques uploaded !</td>

                    </tr>";
        }

        $response['message'] = $html;

        $response['success'] = true;

        echo json_encode($response);

        exit;
    } catch (Exception $e) {

        $response['message'] = $e->getMessage();

        $response['success'] = false;

        echo json_encode($response);

        exit;
    }
} else {

    $response['message'] = 'Invalid Request';

    $response['success'] = false;

    echo json_encode($response);

    exit;
}
