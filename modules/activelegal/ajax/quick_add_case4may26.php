<!-- <?php
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_case.php");

session_start();

$objLegalCase = new LegalCase();
$user_id = $_SESSION['LOGIN_LEGAL_ID'];

if ($_POST) {
    $input_data = [];
    $input_data['active_legal_id']           = $_POST['active_legal_id'];
    $input_data['case_number']               = $_POST['case_number'];
    $input_data['category']                  = $_POST['category'];
 
    $input_data['created_id']                = $user_id;
    $input_data['created_on']                = date('Y-m-d H:i:s');
    $input_data['updated_id']                = $user_id;
    $input_data['updated_on']                = date('Y-m-d H:i:s');
    $input_data['status']                    = 'A';

    if ($objLegalCase->saveCase($input_data)) {
        $id = $objLegalCase->_inserted_id;
        
  
        $root_array = [];
        $root_array['case_id']        = $id;
        $root_array['active_legal_id'] = $_POST['active_legal_id'];
        $root_array['court']          = $_POST['court'];
        $root_array['stage']          = 1;
        $root_array['lawyer']         = $_POST['lawyer'];
        $root_array['register_date']  = $_POST['register_date'];
        $root_array['category']       = $_POST['category'];
        $root_array['created_on']     = date('Y-m-d H:i:s');
        $root_array['created_by']     = $user_id;
        $root_array['status']         = 'A';
        
        $objLegalCase->saveRoots($root_array);

        echo json_encode(['success' => true, 'message' => 'Case added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add case']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?> -->
