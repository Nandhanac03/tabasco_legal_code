<?php
class Collection extends dbcon
{
    ################	MEMBER FUNCTIONS SECTION	##############
    function save_collection($data = '', $id = '')
    {
        $params = array();
        $fields = array();

        if (!empty($data['marketing_id'])) {
            $fields[] = "marketing_id=:marketing_id";
            $params['marketing_id'] = $data['marketing_id'];
        }
        if (!empty($data['active_legal_id'])) {
            $fields[] = "active_legal_id=:active_legal_id";
            $params['active_legal_id'] = $data['active_legal_id'];
        }
        if (!empty($data['category_type'])) {
            $fields[] = "category_type=:category_type";
            $params['category_type'] = $data['category_type'];
        }
        if (!empty($data['case_id'])) {
            $fields[] = "case_id=:case_id";
            $params['case_id'] = $data['case_id'];
        }
        if (!empty($data['client_id'])) {
            $fields[] = "client_id=:client_id";
            $params['client_id'] = $data['client_id'];
        }
        if (!empty($data['category_id'])) {
            $fields[] = "category_id=:category_id";
            $params['category_id'] = $data['category_id'];
        }
        if (!empty($data['firm_id'])) {
            $fields[] = "firm_id=:firm_id";
            $params['firm_id'] = $data['firm_id'];
        }
        if (!empty($data['fees_type'])) {
            $fields[] = "fees_type=:fees_type";
            $params['fees_type'] = $data['fees_type'];
        }
        if (!empty($data['date'])) {
            $fields[] = "`date`=:date"; // date is reserved, escape with backticks
            $params['date'] = $data['date'];
        }
        if (!empty($data['amount'])) {
            $fields[] = "amount=:amount";
            $params['amount'] = $data['amount'];
        }
        if (!empty($data['description'])) {
            $fields[] = "description=:description";
            $params['description'] = $data['description'];
        }
        if (!empty($data['remark'])) {
            $fields[] = "remark=:remark";
            $params['remark'] = $data['remark'];
        }
        if (!empty($data['created_on'])) {
            $fields[] = "created_on=:created_on";
            $params['created_on'] = $data['created_on'];
        }
        if (!empty($data['created_by'])) {
            $fields[] = "created_by=:created_by";
            $params['created_by'] = $data['created_by'];
        }
        if ($id) {
            if (!empty($data['updated_on'])) {
                $fields[] = "updated_on=:updated_on";
                $params['updated_on'] = $data['updated_on'];
            }
            if (!empty($data['updated_by'])) {
                $fields[] = "updated_by=:updated_by";
                $params['updated_by'] = $data['updated_by'];
            }
        }
        if (!empty($data['status'])) {
            $fields[] = "status=:status";
            $params['status'] = $data['status'];
        }
        if (!empty($data['document'])) {
            $fields[] = "document=:document";
            $params['document'] = $data['document'];
        }

        // Build query
        $Sqlcmd = "INSERT INTO legal_collections SET " . implode(", ", $fields);

 if ($id) {
    $Sqlcmd = "UPDATE legal_collections SET " . implode(", ", $fields) . " WHERE id=:id";
    $params['id'] = $id;
    $action = 'UPDATE';
} else {
    $Sqlcmd = "INSERT INTO legal_collections SET " . implode(", ", $fields);
    $action = 'CREATE';
}

$this->_last_query = $Sqlcmd;

$result = $this->Query($Sqlcmd, $params);

/* ===== GET INSERTED ID ===== */
$isUpdate = !empty($id);

if ($result && !$isUpdate) {
    $id = $this->mysqlInsertid();
}

/* ===== ACTIVITY LOG ===== */
if ($result) {

    include_once("class.legal_activity_log.php");
    $activity = new LegalActivityLog();

    // Logged-in user ID
    $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;

    if ($loggedUserId) {
        $activity->logActivity(
            $isUpdate ? 'UPDATE' : 'INSERT',   // action
            'legal_collections',                      // module/table
            $loggedUserId,                     // user id
            $isUpdate
                ? "Updated Collection ID: $id"
                : "Created Collection ID: $id",
            $id                                // reference id
        );
    }
}

return $result;

}


    function getting_collection($id = '', $case_id = '', $type = '')
    {
        $params = array();
        $Sqlcmd = "SELECT * FROM legal_collections WHERE 1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND id=:id";
            $params['id'] = $id;
        }
        if ($case_id) {
            $Sqlcmd = $Sqlcmd . " AND case_id=:case_id";
            $params['case_id'] = $case_id;
        }
        $Sqlcmd = $Sqlcmd . " AND status=:status";
        $params['status'] = 'A';
        $Sqlcmd = $Sqlcmd . " ORDER BY id DESC";
        //echo $this->get_query($Sqlcmd, $params); exit;
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }

    function get_last_collection($case_id = '', $type = '')
    {
        $params = array();
        $Sqlcmd = "SELECT * FROM legal_collections WHERE status = :status";
        $params['status'] = 'A';

        if ($case_id) {
            $Sqlcmd .= " AND case_id = :case_id";
            $params['case_id'] = $case_id;
        }

        $Sqlcmd .= " ORDER BY id DESC LIMIT 1";

        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);

        if ($this->_num_rows > 0) {
            return $this->_result[0]; // return only the latest record
        } else {
            return false;
        }
    }


    function get_collection($id = '', $filters = [])
    {
        $params = [];

        $Sqlcmd = "
        SELECT 
            lco.*,
            lc.name AS client_name, 
            lc.id AS legal_client_id,       
            al.code AS active_legal_code,
            U.user_name AS marketing_person,
            FT.title AS fees_type_title,
            usertype.usertype_title,
            COALESCE(
                CONCAT(LTP.name, ' — Third Party'),
                CONCAT(LF.name, ' — Legal Firm'),
                CONCAT(LDC.name, ' — Debt Collector'),
                CONCAT(U3.user_name, ' — Legal Team')
            ) AS Present_Legal_Firm_Name
        FROM legal_collections lco
        LEFT JOIN legal_client lc ON lco.client_id = lc.id
        LEFT JOIN legal_activelegal al ON lco.active_legal_id = al.id
        LEFT JOIN users U ON U.user_Id = lco.marketing_id
        LEFT JOIN legal_fees_type FT ON FT.id = lco.fees_type
        LEFT JOIN usertype ON U.user_typeId = usertype.usertype_Id
        LEFT JOIN legal_third_party LTP ON LTP.id = al.agencies_id AND al.category = 1
        LEFT JOIN legal_firm LF ON LF.id = al.agencies_id AND al.category = 2
        LEFT JOIN legal_debt_collector LDC ON LDC.id = al.agencies_id AND al.category = 3
        LEFT JOIN users U3 ON U3.user_Id = al.agencies_id AND al.category = 4
        WHERE 1=1
    ";

        // If specific ID requested
        if (!empty($id)) {
            $Sqlcmd .= " AND lco.id = :id";
            $params['id'] = $id;
        }

        // Extra filters (optional)
        if (!empty($filters['client_id'])) {
            $Sqlcmd .= " AND lco.client_id = :client_id";
            $params['client_id'] = $filters['client_id'];
        }
        if (!empty($filters['active_legal_id'])) {
            $Sqlcmd .= " AND lco.active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $filters['active_legal_id'];
        }
        if (!empty($filters['marketing_id'])) {
            $Sqlcmd .= " AND lco.marketing_id = :marketing_id";
            $params['marketing_id'] = $filters['marketing_id'];
        }
        if (!empty($filters['case_id'])) {
            $Sqlcmd .= " AND lco.case_id = :case_id";
            $params['case_id'] = $filters['case_id'];
        }
        if (!empty($filters['status'])) {
            $Sqlcmd .= " AND lco.status = :status";
            $params['status'] = $filters['status'];
        } else {
            // default: only active
            $Sqlcmd .= " AND lco.status = :status";
            $params['status'] = 'A';
        }
        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $Sqlcmd .= " AND lco.date BETWEEN :date_from AND :date_to";
            $params['date_from'] = $filters['date_from'];
            $params['date_to']   = $filters['date_to'];
        }

        $Sqlcmd .= " ORDER BY lco.id DESC";

        $this->_last_query = $Sqlcmd;

        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);

        if ($this->_num_rows > 0) {
            return $this->_result;  // array of rows
        } else {
            return false;
        }
    }

    function total_collection($active_legal_id = '', $case_id = '')
    {
        $params = [];
        $Sqlcmd = "SELECT SUM(amount) AS total_amount FROM legal_collections WHERE status = :status";
        $params['status'] = 'A'; // Only active collections

        if (!empty($active_legal_id)) {
            $Sqlcmd .= " AND active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $active_legal_id;
        }

        if (!empty($case_id)) {
            $Sqlcmd .= " AND case_id = :case_id";
            $params['case_id'] = $case_id;
        }

        // Fetch result (expecting one row)
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);

        if ($this->_num_rows > 0 && isset($this->_result[0]['total_amount'])) {
            return (float)$this->_result[0]['total_amount'];
        } else {
            return 0;
        }
    }


    function delete_hearing($data = '', $id = '')
    {
        $params = array();
        $Sqlcmd = "UPDATE";
        $Sqlcmd = $Sqlcmd . " legal_collections SET ";
        $Sqlcmd = $Sqlcmd . " status=:status";
        $params['status'] = $data['status'];
        $Sqlcmd = $Sqlcmd . " ,updated_by=:updated_by";
        $params['updated_by'] = $data['updated_by'];
        $Sqlcmd = $Sqlcmd . " ,updated_on=:updated_on";
        $params['updated_on'] = $data['updated_on'];
        if ($id > 0) {
            $Sqlcmd = $Sqlcmd . " WHERE  id=:id";
            $params['id'] = $id;
        }
        return $this->Query($Sqlcmd, $params);


        
    } //end function
}//end class