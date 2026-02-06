<?php
class Clients extends dbcon
{
    // Manage Client Information (Insert/Update)
    function Manage_Client_information($data = [], $id = 0)
    {
        $params = [];
        $id = (int) $id;  // Ensure ID is an integer
        $isUpdate = $id > 0;
        $Sqlcmd = $isUpdate ? "UPDATE legal_client SET " : "INSERT INTO legal_client SET ";
        $fields = [
            "marketing",
            "type",
            "name",
            "behalf_of",
            "office_address",
            "contact_person",
            "designation",
            "email",
            "land_number",
            "mobile_number",
            "fax_number",
            "po_number",
            "website",
            "visiting_card",
            "total_outstanding",
            "outstanding_cheque",
            "outstanding_without_cheque",
            "create_by",
            "create_on",
            "refer_id",
            "client_from"
        ];
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $Sqlcmd .= "$field = :$field, ";
                $params[$field] = $data[$field];
            }
        }
        if ($isUpdate) {
            $Sqlcmd .= "update_by = :update_by, update_on = :update_on WHERE id = :id";
            $params['update_by'] = $data['update_by'] ?? null;
            $params['update_on'] = $data['update_on'] ?? null;
            $params['id'] = $id;
        } else {
            $Sqlcmd = rtrim($Sqlcmd, ", ");  // Remove trailing comma
        }
        $this->_output_alert = "Ok";
        $this->_last_query = $Sqlcmd;
        $result = $this->Query($Sqlcmd, $params);
        if (!$isUpdate) {
            $this->_inserted_id = $this->mysqlInsertid();
        }
        return $result;
    }
    // Fetch Client Information
    function Get_Client_Information($id = null, $name = null, $search = null, $status = null, $action_id = null, $offset = 0, $limit = 0, $marketing = null, $createFromdate = null, $createTodate = null, $validate_client_id = null)
    {
        $params = [];
        $Sqlcmd = "SELECT C.*, U.user_name AS marketing_person,usertype.usertype_title,UB.user_name AS behalf_of_person FROM legal_client C 
        LEFT JOIN users U ON U.user_Id = C.marketing 
        LEFT JOIN users UB ON UB.user_Id = C.behalf_of 
        LEFT JOIN usertype ON U.user_typeId = usertype.usertype_Id WHERE 1";
        if (!empty($id)) {
            $Sqlcmd .= " AND C.id = :id";
            $params['id'] = $id;
        }
        if (!empty($name)) {
            $Sqlcmd .= " AND C.name = :name";
            $params['name'] = $name;
        }
        // if (!empty($search)) {
        //     $Sqlcmd .= " AND (C.contact_person LIKE :search OR C.mobile_number LIKE :search1 OR C.email LIKE :search2)";
        //     $params['search'] = $params['search1'] = $params['search2'] = "%$search%";
        // }

        if (!empty($search)) {
            $Sqlcmd .= " AND (
                C.name LIKE :search_name
                OR C.contact_person LIKE :search
                OR C.mobile_number LIKE :search1
                OR C.email LIKE :search2
            )";

            $params['search_name'] =
                $params['search'] =
                $params['search1'] =
                $params['search2'] = "%$search%";
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
        if (!empty($validate_client_id)) {
            $Sqlcmd .= " AND C.refer_id = :refer_id";
            $params['refer_id'] = $validate_client_id;
        }
        $Sqlcmd .= " ORDER BY C.id DESC";
        if ($limit > 0) {
            $Sqlcmd .= " LIMIT " . (int)$offset . ", " . (int)$limit;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    // Get Total Client Count
    function Get_Client_TOTAL_COUNT($offset = '', $limit = '', $status = '', $clientId = '', $search = '', $marketing = '')
    {
        $params = [];
        $Sqlcmd = "SELECT COUNT(*) AS TOTAL_RECORDS FROM legal_client WHERE 1";
        if (!empty($status)) {
            $Sqlcmd .= " AND legal_client.status = :status";
            $params['status'] = $status;
        }
        if (!empty($clientId)) {
            $Sqlcmd .= " AND legal_client.id = :id";
            $params['id'] = $clientId;
        }
        // if (!empty($search)) {
        //     $Sqlcmd .= " AND (legal_client.contact_person LIKE :search OR legal_client.mobile_number LIKE :search1 OR legal_client.email LIKE :search2)";
        //     $params['search'] = $params['search1'] = $params['search2'] = "%$search%";
        // }
        if (!empty($search)) {
            $Sqlcmd .= " AND (
                legal_client.name LIKE :search_name
                OR legal_client.contact_person LIKE :search
                OR legal_client.mobile_number LIKE :search1
                OR legal_client.email LIKE :search2
            )";

            $params['search_name'] =
                $params['search'] =
                $params['search1'] =
                $params['search2'] = "%$search%";
        }

        if (!empty($marketing)) {
            $Sqlcmd .= " AND legal_client.marketing = :marketing";
            $params['marketing'] = $marketing;
        }
        $Sqlcmd .= " ORDER BY legal_client.id DESC";
        if ($limit > 0) {
            $Sqlcmd .= " LIMIT " . (int)$offset . ", " . (int)$limit;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    // Get Last Client ID (Formatted)
    function Get_Last_Client_ID()
    {
        $Sqlcmd = "SELECT MAX(id) AS last_id FROM legal_client";
        $result = $this->SQL_Fetch($Sqlcmd);
        $last_id = isset($result['last_id']) && $result['last_id'] !== null ? (int)$result['last_id'] : 0;
        $new_id = str_pad($last_id + 1, 4, '0', STR_PAD_LEFT);
        if (!defined('CLIENT_CODE')) {
            return 'ERROR: CLIENT_CODE is not defined';
        }
        return CLIENT_CODE . $new_id;
    }
    function Update_Client_Records_Status($id = '')
    {
        if ($id) {
            // Prepare parameters for the SQL queries
            $params = array();
            $params['id'] = $id;
            // SQL query for the first status update (soft delete: status='D')
            $Sqlcmd1 = "UPDATE legal_client SET legal_client.status='D'  WHERE id=:id";
            // Execute the first status update query (soft delete)
            $this->_last_query = $Sqlcmd1;
            $this->Query($Sqlcmd1, $params);
            // SQL query for the second status update (e.g., activate: status='D')
            $Sqlcmd2 = "UPDATE legal_document SET legal_document.status='D' WHERE parent_type='C' AND parent_id=:id";
            // Execute the second status update query (activate)
            $this->_last_query = $Sqlcmd2;
            $this->Query($Sqlcmd2, $params);
            // SQL query for the third status update (e.g., archive: status='D')
            $Sqlcmd3 = "UPDATE legal_contacts SET legal_contacts.status='D' WHERE parent_type='C' AND parent_id=:id";
            // Execute the third status update query (archive)
            $this->_last_query = $Sqlcmd3;
            return $this->Query($Sqlcmd3, $params);
        } else {
            return false; // Return false if no ID or status is provided
        }
    }

    function buildDebugSQL($sql, $params)
    {
        foreach ($params as $key => $value) {
            // If it's numeric, keep it raw; otherwise quote it
            $safeValue = is_numeric($value) ? $value : "'" . addslashes($value) . "'";
            $sql = str_replace(":$key", $safeValue, $sql);
        }
        return $sql;
    }

    function logSQLToFile($message)
    {
        $logFile = __DIR__ . "/sql_debug.log";  // log file in current directory
        $timestamp = date("Y-m-d H:i:s");
        file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
    }

    function Update_Cheque_OutStanding($id = '', $data = '')
    {
        $sql = "
        UPDATE legal_client
        SET
            total_outstanding = :total_outstanding,
            outstanding_cheque = :outstanding_cheque,
            outstanding_without_cheque = :outstanding_without_cheque
        WHERE id = :id
    ";

        $params = [
            'total_outstanding'          => $data['total_outstanding'],
            'outstanding_cheque'         => $data['outstanding_cheque'],
            'outstanding_without_cheque' => $data['outstanding_without_cheque'],
            'id'                         => $id
        ];

        // Build final SQL for logging
        //$finalSQL = $this->buildDebugSQL($sql, $params);

        // Log it to file
        //$this->logSQLToFile("Executing SQL: " . $finalSQL);

        return $this->Query($sql, $params);
    }
}
