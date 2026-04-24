<?php
header('Content-Type: application/json');
error_reporting(0); // Prevents PHP notices/warnings from corrupting JSON
ob_clean(); // Clears output buffer
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");

include_once("../../../lib/class/class.legal_common_selection.php");
$objCommonSelection =   new CommonSelection();
include_once("../../../lib/class/class.legal_cheque.php");
$objCheque =   new Cheque();
include_once("../../../lib/class/class.legal_client.php");
$objClients =   new Clients();


$action =   trim($_REQUEST['action']);

switch ($action) {
    case 'client_list':
        /* Tabasco ERP Table data */
        $marketing_id       =   trim($_POST['marketingId']);
        $edit_id            = isset($_POST['edit_id']) ? (int)trim($_POST['edit_id']) : 0;
        $selectedClientId   = isset($_POST['selectedClientId']) ? (int)trim($_POST['selectedClientId']) : 0;


        // Fetch client data based on marketing ID and selected client ID

        $array_list         =   array();
        $result             =   array();

        if ($edit_id) {
            $array_list         =   $objCommonSelection->get_client($selectedClientId, $marketing_id);
        } else {
            $array_list         =   $objCommonSelection->get_client('', $marketing_id);
        }

        // Convert to desired format
        $result = array_map(function ($item) {
            return [
                'id' => (string)$item['customer_Id'],   // Convert to string if needed
                'name' => $item['customer_name'],
                'marketing' => $item['user_name']
            ];
        }, $array_list);

        echo json_encode($result, JSON_PRETTY_PRINT);
        break;
    case 'client_information':
        $clientId       =   trim($_POST['clientId']);
        $array_list     =   array();
        $result         =   array();
        $array_list     =   $objCommonSelection->get_client($clientId, '');
        // Convert to desired format
        //  $result = array_map(function($item) {
        //     return [
        //         'customer_mob' => (string)$item['customer_mob']

        //     ];
        // }, $array_list);


        echo json_encode([
            'mob' => (string)$array_list[0]['customer_mob'],
            'addr' => (string)$array_list[0]['customer_addr'],
            'contact_person' => (string)$array_list[0]['customer_contact_person'],
            'contact_desig' => (string)$array_list[0]['customer_contact_desig'],
            'contact_mob' => (string)$array_list[0]['customer_contact_mob'],
            'email' => (string)$array_list[0]['customer_email'],
            'tel' => (string)$array_list[0]['customer_tel'],
            'fax' => (string)$array_list[0]['customer_fax'],
            'website' => (string)$array_list[0]['customer_website'],
            'po_box' => (string)$array_list[0]['customer_po_box']

        ]);
        break;
    case 'client_legal_list':
        /* Tabasco legal client data */
        $marketing_id       =   trim($_POST['marketingId']);
        $array_list         =   array();
        $result             =   array();
        $array_list         =   $objClients->Get_Client_Information('', '', '', 'A', '', '', '', $marketing_id);


        // Convert to desired format
        $result = array_values(array_unique(array_map(function ($item) {
            return json_encode([
                'id' => (string) $item['id'], // Ensure `id` is a string for consistency
                'name' => $item['name'],
                'marketing' => $item['marketing'],
            ]);
        }, $array_list)));


        $result = array_map('json_decode', $result);

        if ($result) {
            foreach ($result as $key => $value) {
                $with_client = $objCheque->get_cheque_total($value->id, 'C');
                $wit_case    = $objCheque->get_cheque_total($value->id, 'CA');
        
                // Safely extract values from both queries
                $with_client_total1 = isset($with_client[0]['Total1']) ? (float)$with_client[0]['Total1'] : 0;
                $with_client_total2 = isset($with_client[0]['Total2']) ? (float)$with_client[0]['Total2'] : 0;
        
                $wit_case_total1 = isset($wit_case[0]['Total1']) ? (float)$wit_case[0]['Total1'] : 0;
                $wit_case_total2 = isset($wit_case[0]['Total2']) ? (float)$wit_case[0]['Total2'] : 0;
        
                // Combine totals
                $outstanding_cheque         = $with_client_total1 + $wit_case_total1;
                $outstanding_without_cheque = $with_client_total2 + $wit_case_total2;
                $total_outstanding          = $outstanding_cheque + $outstanding_without_cheque;
        
                // Add new fields to result object
                $value->outstanding_cheque         = $outstanding_cheque;
                $value->outstanding_without_cheque = $outstanding_without_cheque;
                $value->total_outstanding          = $total_outstanding;
        
                $result[$key] = $value;
            }
        }
        

        echo json_encode($result, JSON_PRETTY_PRINT);


        break;
}
