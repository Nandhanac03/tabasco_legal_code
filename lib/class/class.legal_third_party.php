<?php
class thirdParty extends dbcon
{
    ################	MEMBER FUNCTIONS SECTION	##############
    function Manage_thirdParty_information($data = '', $id = '')
    {
        $params = array();
        if ($id > 0) {
            $Sqlcmd = "UPDATE";
        } else {
            $Sqlcmd = "INSERT INTO";
        }
        $Sqlcmd = $Sqlcmd . " legal_third_party SET ";
        $Sqlcmd = $Sqlcmd . " code=:code";
        $params['code'] = $data['code'];
        $Sqlcmd = $Sqlcmd . " ,name=:name";
        $params['name'] = $data['name'];
        $Sqlcmd = $Sqlcmd . " ,address=:address";
        $params['address'] = $data['address'];
        $Sqlcmd = $Sqlcmd . " ,contact_no=:contact_no";
        $params['contact_no'] = $data['contact_no'];
        $Sqlcmd = $Sqlcmd . " ,email=:email";
        $params['email'] = $data['email'];
        $Sqlcmd = $Sqlcmd . " ,notes=:notes";
        $params['notes'] = $data['notes'];
        $Sqlcmd = $Sqlcmd . " ,visiting_card=:visiting_card";
        $params['visiting_card'] = $data['visiting_card'];
        if ($id > 0) {
            $Sqlcmd = $Sqlcmd . " ,updated_by=:updated_by";
            $params['updated_by'] = $data['updated_by'];
            $Sqlcmd = $Sqlcmd . " ,updated_by_type=:updated_by_type";
            $params['updated_by_type'] = $data['updated_by_type'];
            $Sqlcmd = $Sqlcmd . " ,updated_on=:updated_on";
            $params['updated_on'] = $data['updated_on'];
            $Sqlcmd = $Sqlcmd . " WHERE  legal_third_party.id=:id";
            $params['id'] = $id;
        } else {
            $Sqlcmd = $Sqlcmd . " ,created_by=:created_by";
            $params['created_by'] = $data['created_by'];
            $Sqlcmd = $Sqlcmd . " ,created_by_type=:created_by_type";
            $params['created_by_type'] = $data['created_by_type'];
            $Sqlcmd = $Sqlcmd . " ,created_on=:created_on";
            $params['created_on'] = $data['created_on'];
        }
        //echo $this->get_query($Sqlcmd, $params);  exit;
        $this->_inserted_id = $this->mysqlInsertid();
        return $this->Query($Sqlcmd, $params);
    } //end function
    function Get_Last_ThirdParty_ID()
    {
        // SQL query to get the maximum 'id' from the 'legal_client' table
        $Sqlcmd = "SELECT MAX(id) AS last_id FROM legal_third_party";
        // Fetch the result of the query (Assuming SQL_Fetch() returns an associative array)
        $result = $this->SQL_Fetch($Sqlcmd);
        // Check if 'last_id' is present in the result, otherwise set it to 0
        $last_id = isset($result['last_id']) && $result['last_id'] !== null ? (int)$result['last_id'] : 0;
        // Increment the last ID to generate the new client ID
        $new_id = $last_id + 1;
        // Return the formatted new client ID (Ensure CLIENT_CODE is defined)
        return THIRD_PARTY_CODE . $new_id;
    }
    function Get_Third_Party_TOTAL_COUNT($offset = '', $limit = '', $status = '', $search = '')
    {
        $params = [];
        $Sqlcmd = "SELECT COUNT(*) AS TOTAL_RECORDS FROM legal_third_party WHERE 1";
        if (!empty($status)) {
            $Sqlcmd .= " AND legal_third_party.status = :status";
            $params['status'] = $status;
        }
        if (!empty($search)) {
            $Sqlcmd .= " AND (legal_third_party.name LIKE :search OR legal_third_party.code LIKE :search1 OR legal_third_party.email LIKE :search2)";
            $params['search'] = $params['search1'] = $params['search2'] = "%$search%";
        }
        $Sqlcmd .= " ORDER BY legal_third_party.id DESC";
        if ($limit > 0) {
            $Sqlcmd .= " LIMIT " . (int)$offset . ", " . (int)$limit;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    function get_legal_third_Information($id = '', $name = '', $search = '', $status = '', $action_id = "", $offset = '', $limit = '')
    {
        //echo $limit; echo $offset; exit;
        $params = array();
        $Sqlcmd = "SELECT
    DC.*,
    U.user_name AS createdBy
FROM
    legal_third_party DC
LEFT JOIN users U ON
    U.user_Id = DC.created_by
WHERE
    1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND DC.id=:id";
            $params['id'] = $id;
        }
        if ($name) {
            $Sqlcmd = $Sqlcmd . " AND DC.name=:name";
            $params['name'] = $name;
        }
        if ($search) {
            $Sqlcmd = $Sqlcmd . " AND ( DC.code LIKE :search OR DC.name LIKE :search1 OR DC.email LIKE :search2)";
            $params['search'] = '%' . $search . '%';
            $params['search1'] = '%' . $search . '%';
            $params['search2'] = '%' . $search . '%';
        }
        if ($status) {
            $Sqlcmd = $Sqlcmd . " AND DC.status=:status";
            $params['status'] = $status;
        }
        if ($action_id) {
            $Sqlcmd = $Sqlcmd . " AND DC.id!=:action_id";
            $params['action_id'] = $action_id;
        }
        if ($limit > 0) {
            $Sqlcmd = $Sqlcmd . " ORDER BY DC.id DESC limit $offset,$limit";
        } else {
            $Sqlcmd = $Sqlcmd . " ORDER BY DC.id DESC";
        }
        //echo $this->get_query($Sqlcmd, $params); exit;
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function get_Last_ID()
    {
        // SQL query to get the maximum 'id' from the 'legal_third_party' table
        $Sqlcmd = "SELECT MAX(id) AS last_id FROM legal_third_party";
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
        return THIRD_PARTY_CODE . $new_id; // Return formatted new ID
    }
    function Update_Third_Party_Records_Status($id = '')
    {
        if ($id) {
            // Prepare parameters for the SQL queries
            $params = array();
            $params['id'] = $id;
            // SQL query for the first status update (soft delete: status='D')
            $Sqlcmd1 = "UPDATE legal_third_party SET legal_third_party.status='D'  WHERE id=:id";
            // Execute the first status update query (soft delete)
            $this->_last_query = $Sqlcmd1;
            $this->Query($Sqlcmd1, $params);
            // SQL query for the second status update (e.g., activate: status='D')
            $Sqlcmd2 = "UPDATE legal_document SET legal_document.status='D' WHERE parent_type='TP' AND parent_id=:id";
            // Execute the second status update query (activate)
            $this->_last_query = $Sqlcmd2;
            $this->Query($Sqlcmd2, $params);
            // SQL query for the third status update (e.g., archive: status='D')
            $Sqlcmd3 = "UPDATE legal_contacts SET legal_contacts.status='D' WHERE parent_type='TP' AND parent_id=:id";
            // Execute the third status update query (archive)
            $this->_last_query = $Sqlcmd3;
            return $this->Query($Sqlcmd3, $params);
        } else {
            return false; // Return false if no ID or status is provided
        }
    }
}//end class