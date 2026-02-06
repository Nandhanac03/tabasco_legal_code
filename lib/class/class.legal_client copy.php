<?php



class Clients extends dbcon {



################	MEMBER FUNCTIONS SECTION	##############





function Manage_Client_information($data='',$id='') {



    $params = array();

    if($id>0){

        $Sqlcmd = "UPDATE";

    }else{

        $Sqlcmd = "INSERT INTO";

    }

    $Sqlcmd = $Sqlcmd . " legal_client SET ";



    $Sqlcmd = $Sqlcmd . " marketing=:marketing";

    $params['marketing'] = $data['marketing'];



    // $Sqlcmd = $Sqlcmd . " ,code=:code";

    // $params['code'] = $data['code'];



    $Sqlcmd = $Sqlcmd . " ,name=:name";

    $params['name'] = $data['name'];

    $Sqlcmd = $Sqlcmd . " ,client_from=:client_from";

    $params['client_from'] = $data['client_from'];



    $Sqlcmd = $Sqlcmd . " ,office_address=:office_address";

    $params['office_address'] = $data['office_address'];



    $Sqlcmd = $Sqlcmd . " ,contact_person=:contact_person";

    $params['contact_person'] = $data['contact_person'];



    $Sqlcmd = $Sqlcmd . " ,designation=:designation";

    $params['designation'] = $data['designation'];



    $Sqlcmd = $Sqlcmd . " ,email=:email";

    $params['email'] = $data['email'];



    $Sqlcmd = $Sqlcmd . " ,land_number=:land_number";

    $params['land_number'] = $data['land_number'];



    $Sqlcmd = $Sqlcmd . " ,mobile_number=:mobile_number";

    $params['mobile_number'] = $data['mobile_number'];



    $Sqlcmd = $Sqlcmd . " ,fax_number=:fax_number";

    $params['fax_number'] = $data['fax_number'];



    $Sqlcmd = $Sqlcmd . " ,po_number=:po_number";

    $params['po_number'] = $data['po_number'];



    $Sqlcmd = $Sqlcmd . " ,website=:website";

    $params['website'] = $data['website'];





    $Sqlcmd = $Sqlcmd . " ,visiting_card=:visiting_card";

    $params['visiting_card'] = $data['visiting_card'];





    $Sqlcmd = $Sqlcmd . " ,total_outstanding=:total_outstanding";

    $params['total_outstanding'] = $data['total_outstanding'];



    $Sqlcmd = $Sqlcmd . " ,outstanding_cheque=:outstanding_cheque";

    $params['outstanding_cheque'] = $data['outstanding_cheque'];



    $Sqlcmd = $Sqlcmd . " ,outstanding_without_cheque=:outstanding_without_cheque";

    $params['outstanding_without_cheque'] = $data['outstanding_without_cheque'];



    $Sqlcmd = $Sqlcmd . " ,create_by=:create_by";

    $params['create_by'] = $data['create_by'];



    $Sqlcmd = $Sqlcmd . " ,create_on=:create_on";

    $params['create_on'] = $data['create_on'];





    $Sqlcmd = $Sqlcmd . " ,refer_id=:refer_id";

    $params['refer_id'] = $data['refer_id'];





    if($id>0){

        $Sqlcmd = $Sqlcmd . " ,update_by=:update_by";

        $params['update_by'] = $data['update_by'];



        $Sqlcmd = $Sqlcmd . " ,update_on=:update_on";

        $params['update_on'] = $data['update_on'];



        $Sqlcmd = $Sqlcmd . " WHERE  legal_client.id=:id";

        $params['id'] = $id;

    }



    $this->_output_alert = "Ok";

    $this->_last_query = $Sqlcmd;

    //echo $this->get_query($Sqlcmd, $params);  exit;

    $this->_inserted_id = $this->mysqlInsertid();

    return $this->Query($Sqlcmd, $params);

}//end function









function Get_Client_Information(

    $id = null,

    $name = null,

    $search = null,

    $status = null,

    $action_id = null,

    $offset = 0,

    $limit = 0,

    $marketing = null,

    $createFromdate = null,

    $createTodate = null

) {

    $params = array();

    $Sqlcmd = "

        SELECT C.*, U.user_name AS marketing_person

        FROM legal_client C

        LEFT JOIN users U ON U.user_Id = C.marketing

        WHERE 1";



    if (!empty($id)) {

        $Sqlcmd .= " AND C.id = :id";

        $params['id'] = $id;

    }



    if (!empty($name)) {

        $Sqlcmd .= " AND C.name = :name";

        $params['name'] = $name;

    }



    if (!empty($search)) {

        $Sqlcmd .= " AND (C.contact_person LIKE :search OR C.mobile_number LIKE :search1 OR C.email LIKE :search2)";

        $params['search'] = '%' . $search . '%';

        $params['search1'] = '%' . $search . '%';

        $params['search2'] = '%' . $search . '%';

    }



    if (!empty($status)) {

        $Sqlcmd .= " AND C.status = :status";

        $params['status'] = $status;

    }



    if (!empty($action_id)) {

        $Sqlcmd .= " AND C.id != :action_id";

        $params['action_id'] = $action_id;

    }



    if (!empty($marketing)) {

        $Sqlcmd .= " AND C.marketing = :marketing";

        $params['marketing'] = $marketing;

    }











    // ORDER BY Clause

    $Sqlcmd .= " ORDER BY C.id ASC";



    // ✅ Fixed LIMIT & OFFSET (Directly included as Integers)

    if ($limit > 0) {

        $Sqlcmd .= " LIMIT " . (int)$offset . ", " . (int)$limit;

    }



    // Execute Query

    $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);



    return ($this->_num_rows > 0) ? $this->_result : false;

}





// Pagination Count

function Get_Client_TOTAL_COUNT($offset = '', $limit = '', $status = '',$clientId='',$search='',$marketing)

{



    $params = array();

    $Sqlcmd = "SELECT COUNT(*) AS TOTAL_RECORDS FROM legal_client  WHERE 1";

    if ($status) {

        $Sqlcmd = $Sqlcmd . " AND legal_client.status=:status";

        $params['status'] = $status;

    }



    if (!empty($clientId)) {

        $Sqlcmd .= " AND legal_client.id = :id";

        $params['id'] = $clientId;

    }







    if (!empty($search)) {

        $Sqlcmd .= " AND (legal_client.contact_person LIKE :search OR legal_client.mobile_number LIKE :search1 OR legal_client.email LIKE :search2)";

        $params['search'] = '%' . $search . '%';

        $params['search1'] = '%' . $search . '%';

        $params['search2'] = '%' . $search . '%';

    }











    if (!empty($marketing)) {

        $Sqlcmd .= " AND legal_client.marketing = :marketing";

        $params['marketing'] = $marketing;

    }



    if ($limit > 0) {

        $Sqlcmd = $Sqlcmd . " ORDER BY legal_client.id DESC limit $offset,$limit";

    } else {

        $Sqlcmd = $Sqlcmd . " ORDER BY legal_client.id DESC";



    }



    $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);

    //echo $this->get_query($Sqlcmd, $params);

    if ($this->_num_rows > 0) {

        return $this->_result;

    } else

        return false;

}



function Get_Last_Client_ID() {

// SQL query to get the maximum 'id' from the 'legal_client' table

$Sqlcmd = "SELECT MAX(id) AS last_id FROM legal_client";



// Fetch the result (Handle possible errors)

$result = $this->SQL_Fetch($Sqlcmd);



// Ensure the query executed successfully and handle NULL values

$last_id = isset($result['last_id']) && $result['last_id'] !== null ? (int)$result['last_id'] : 0;



// Generate the new client ID and ensure it is always 4 digits

$new_id = str_pad($last_id + 1, 4, '0', STR_PAD_LEFT);



// Ensure CLIENT_CODE is defined before using it

if (!defined('CLIENT_CODE')) {

    return 'ERROR: CLIENT_CODE is not defined';

}



    // Return the formatted new client ID (Ensure CLIENT_CODE is defined)

    return CLIENT_CODE . $new_id;

}









}//end class