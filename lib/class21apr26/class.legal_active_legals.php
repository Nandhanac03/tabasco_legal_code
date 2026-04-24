<?php
class ActiveLegal extends dbcon
{
    // Insert or update Active Legal record
    function Manage_ActiveLegal($data = [], $id = 0)
    {
        $params = [];
        $id = (int) $id;
        $isUpdate = $id > 0;
        $Sqlcmd = $isUpdate
            ? "UPDATE legal_activelegal SET "
            : "INSERT INTO legal_activelegal SET ";
        $fields = [
            "dateon",
            "code",
            "user_id",
            "client",
            "category",
            "agencies_id",
            "notes",
            "total_outstanding",
            "outstanding_with_cheque",
            "outstanding_without_cheque",
            "claim_amount",
            "collected_amount",
            "balance_claim",
            "expense_amount",
            "status",
            "legal_status",
            "legal_status_reason"

            //'created_id', 'created_on', 'updated_id', 'updated_on' handled below
        ];
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $Sqlcmd .= "$field = :$field, ";
                $params[$field] = $data[$field];
            }
        }
        $loginId = $_SESSION['LOGIN_LEGAL_ID'] ?? 0;
        $currentDatetime = date('Y-m-d H:i:s');
        if ($isUpdate) {
            // For updates
            $Sqlcmd .= "updated_id = :updated_id, updated_on = :updated_on ";
            $params['updated_id'] = $loginId;
            $params['updated_on'] = $currentDatetime;
            $Sqlcmd .= "WHERE id = :id";
            $params['id'] = $id;
        } else {
            // For inserts
            $Sqlcmd .= "created_id = :created_id, created_on = :created_on ";
            $params['created_id'] = $loginId;
            $params['created_on'] = $currentDatetime;
        }
        $this->_output_alert = "Ok";
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
                    'legal_activelegal',                      // module/table
                    $loggedUserId,                     // user id
                    $isUpdate
                        ? "Updated Active Legal ID: $id"
                        : "Created Active Legal ID: $id",
                    $id                                // reference id
                );
            }
        }
        
        return $result;
        
    }
    function Get_Last_ActiveLegal_ID()
    {
        $Sqlcmd = "SELECT MAX(id) AS last_id FROM legal_activelegal";
        $result = $this->SQL_Fetch($Sqlcmd);
        $last_id = isset($result['last_id']) && $result['last_id'] !== null ? (int)$result['last_id'] : 0;
        $new_id = str_pad($last_id + 1, 4, '0', STR_PAD_LEFT);
        if (!defined('ACTIVE_LEGAL_CODE')) {
            return 'ERROR: ACTIVE_LEGAL_CODE is not defined';
        }
        return ACTIVE_LEGAL_CODE . $new_id;
    }
    public function Get_ActiveLegal_Information($filters = [])
    {
        $params = [];
        $sql = "SELECT
    AL.*,
    U1.user_name AS createdBy,
    U2.user_name AS User_Client,
    UT.usertype_title AS Usertype_Client,
    LC.name AS ClientName,
    LC.type AS ClientType,
    LC.mobile_number AS Clientmobile_number,
    LDC.contact_no AS Deptmobile_number,
    LF.contact_no AS legalfirmmobile_number,
    LTP.contact_no AS thirdmobile_number,
    U3.user_mob AS legalteammobile_number,

    CONCAT(
        COALESCE(
            CONCAT(LTP.name, ' — Third Party'),
            CONCAT(LF.name, ' — Legal Firm'),
            CONCAT(LDC.name, ' — Debt Collector'),
            CONCAT(U3.user_name, ' — Legal Team')
        )
    ) AS Present_Legal_Firm_Name,
    CASE
        WHEN AL.category = 1 THEN 'TP'
        WHEN AL.category = 2 THEN 'LF'
        WHEN AL.category = 3 THEN 'DC'
        WHEN AL.category = 4 THEN 'LT'
        ELSE 'unknown'
    END AS legal_firm_type,
    CASE
        WHEN AL.category = 1 THEN 'third_party'
        WHEN AL.category = 2 THEN 'legal_firm'
        WHEN AL.category = 3 THEN 'debt_collector'
        WHEN AL.category = 4 THEN 'legal_team'
        ELSE 'unknown'
    END AS legal_firm_type_name
FROM legal_activelegal AL
LEFT JOIN users U1 ON U1.user_Id = AL.created_id
LEFT JOIN users U2 ON U2.user_Id = AL.user_id
LEFT JOIN usertype UT ON UT.usertype_Id = U2.user_typeId
LEFT JOIN legal_client LC ON LC.id = AL.client
LEFT JOIN legal_third_party LTP ON LTP.id = AL.agencies_id AND AL.category = 1
LEFT JOIN legal_firm LF ON LF.id = AL.agencies_id AND AL.category = 2
LEFT JOIN legal_debt_collector LDC ON LDC.id = AL.agencies_id AND AL.category = 3
LEFT JOIN users U3 ON U3.user_Id = AL.agencies_id AND AL.category = 4
WHERE 1";
        if (!empty($filters['id'])) {
            $sql .= " AND AL.id = :id";
            $params['id'] = $filters['id'];
        }
        if (!empty($filters['code'])) {
            $sql .= " AND AL.code = :code";
            $params['code'] = $filters['code'];
        }
        if (!empty($filters['dateon'])) {
            $sql .= " AND DATE(AL.dateon) = :dateon";
            $params['dateon'] = $filters['dateon'];
        }
        if (!empty($filters['user_id'])) {
            $sql .= " AND AL.user_id = :user_id";
            $params['user_id'] = $filters['user_id'];
        }
        if (!empty($filters['client'])) {
            $sql .= " AND AL.client = :client";
            $params['client'] = $filters['client'];
        }
        if (!empty($filters['case_id'])) {
            $sql .= " AND EXISTS (SELECT 1 FROM legal_case WHERE active_legal_id = AL.id AND id = :case_id AND status = 'A')";
            $params['case_id'] = $filters['case_id'];
        }
        if (!empty($filters['search'])) {
            $sql .= " AND (AL.code LIKE :search 
                      OR AL.notes LIKE :search1 
                      OR U1.user_name LIKE :search2 
                      OR LC.name LIKE :search3 
                      OR EXISTS (SELECT 1 FROM legal_case WHERE active_legal_id = AL.id AND case_number LIKE :search4 AND status = 'A'))";
            $params['search'] = '%' . $filters['search'] . '%';
            $params['search1'] = '%' . $filters['search'] . '%';
            $params['search2'] = '%' . $filters['search'] . '%';
            $params['search3'] = '%' . $filters['search'] . '%';
            $params['search4'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['status'])) {
            $sql .= " AND AL.status = :status";
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['legal_status'])) {
            $sql .= " AND AL.legal_status = :legal_status";
            $params['legal_status'] = $filters['legal_status'];
        }
        if (!empty($filters['action_id'])) {
            $sql .= " AND AL.id != :action_id";
            $params['action_id'] = $filters['action_id'];
        }
        
        $sql .= " ORDER BY AL.id DESC";

        if (!empty($filters['limit'])) {
            $limit = (int)$filters['limit']; 
            $offset = !empty($filters['offset']) ? (int)$filters['offset'] : 0; 
            $sql .= " LIMIT $offset, $limit";
        }
      
        // echo $this->get_query($sql, $params); exit;
        return $this->SELECT_MultiFetch($sql, $params);


        $activity->log(
            'legal_activelegal',
            $id,
            'UPDATE',
            'Updated Active Legal record',
            $oldData,
            $data
        );
        
    }
    function Get_LEGAL_TOTAL_COUNT($offset = '', $limit = '', $status = '', $legal_status = '', $filters = [])
    {
        $params = [];
        $Sqlcmd = "SELECT COUNT(*) AS TOTAL_RECORDS FROM legal_activelegal WHERE 1";
        if (!empty($status)) {
            $Sqlcmd .= " AND legal_activelegal.status = :status";
            $params['status'] = $status;
        }
        if (!empty($legal_status)) {
            $Sqlcmd .= " AND legal_activelegal.legal_status = :legal_status";
            $params['legal_status'] = $legal_status;
        }
        if (!empty($filters['dateon'])) {
            $Sqlcmd .= " AND DATE(legal_activelegal.dateon) = :dateon";
            $params['dateon'] = $filters['dateon'];
        }
        if (!empty($filters['user_id'])) {
            $Sqlcmd .= " AND legal_activelegal.user_id = :user_id";
            $params['user_id'] = $filters['user_id'];
        }
        if (!empty($filters['client'])) {
            $Sqlcmd .= " AND legal_activelegal.client = :client";
            $params['client'] = $filters['client'];
        }
        if (!empty($filters['case_id'])) {
            $Sqlcmd .= " AND EXISTS (SELECT 1 FROM legal_case WHERE active_legal_id = legal_activelegal.id AND id = :case_id AND status = 'A')";
            $params['case_id'] = $filters['case_id'];
        }
        if (!empty($filters['search'])) {
            $Sqlcmd .= " AND (legal_activelegal.code LIKE :search 
                          OR legal_activelegal.notes LIKE :search1 
                          OR legal_client.name LIKE :search2 
                          OR EXISTS (SELECT 1 FROM legal_case WHERE active_legal_id = legal_activelegal.id AND case_number LIKE :search3 AND status = 'A'))";
            $params['search'] = '%' . $filters['search'] . '%';
            $params['search1'] = '%' . $filters['search'] . '%';
            $params['search2'] = '%' . $filters['search'] . '%';
            $params['search3'] = '%' . $filters['search'] . '%';
        }
        $Sqlcmd .= " ORDER BY legal_activelegal.id DESC";
        if ($limit > 0) {
            $Sqlcmd .= " LIMIT " . (int)$offset . ", " . (int)$limit;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    // function shift_active_legal($data = [], $id = '')
    // {
    //     $params = [];
    //     if ($id) {
    //         $Sqlcmd = "UPDATE";
    //     } else {
    //         $Sqlcmd = "INSERT INTO";
    //     }
    //     $Sqlcmd .= " legal_shift_active_legal SET";
    //     if ($data['active_legal_id']) {
    //         $Sqlcmd .= " active_legal_id=:active_legal_id";
    //         $params['active_legal_id'] = $data['active_legal_id'];
    //     }
    //     if ($data['legal_type']) {
    //         $Sqlcmd .= ", legal_type=:legal_type";
    //         $params['legal_type'] = $data['legal_type'];
    //     }
    //     if ($data['party_name']) {
    //         $Sqlcmd .= ", party_name=:party_name";
    //         $params['party_name'] = $data['party_name'];
    //     }
    //     if ($data['start_date']) {
    //         $Sqlcmd .= ", start_date=:start_date";
    //         $params['start_date'] = $data['start_date'];
    //     }
    //     if ($data['shifted_date']) {
    //         $Sqlcmd .= ", shifted_date=:shifted_date";
    //         $params['shifted_date'] = $data['shifted_date'];
    //     }
    //     if ($id == '') {
    //         $Sqlcmd .= ", created_by=:created_by";
    //         $params['created_by'] = $data['created_by'];
    //         $Sqlcmd .= ", created_at=:created_at";
    //         $params['created_at'] = $data['created_at'];
    //     }
    //     $Sqlcmd .= ", updated_by=:updated_by";
    //     $params['updated_by'] = $data['updated_by'];
    //     $Sqlcmd .= ", updated_at=:updated_at";
    //     $params['updated_at'] = $data['updated_at'];
    //     if ($data['status']) {
    //         $Sqlcmd .= ", status=:status";
    //         $params['status'] = $data['status'];
    //     }
    //     if ($id) {
    //         $Sqlcmd .= " WHERE id=$id";
    //     }
    //     $this->_output_alert = 'Ok';
    //     $this->_last_query = $Sqlcmd;
    //     $this->_inserted_id = $this->mysqlInsertid();
    //     return $this->Query($Sqlcmd, $params);
    // }
    function shift_active_legal($data = [], $id = '')
    {
        $params = [];
        $fields = [];

        if ($id) {
            $Sqlcmd = "UPDATE legal_shift_active_legal SET ";
        } else {
            $Sqlcmd = "INSERT INTO legal_shift_active_legal SET ";
        }

       
        if (!empty($data['active_legal_id'])) {
            $fields[] = "active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $data['active_legal_id'];
        }
        if (!empty($data['legal_type'])) {
            $fields[] = "legal_type = :legal_type";
            $params['legal_type'] = $data['legal_type'];
        }
        if (!empty($data['party_name'])) {
            $fields[] = "party_name = :party_name";
            $params['party_name'] = $data['party_name'];
        }
        if (!empty($data['start_date'])) {
            $fields[] = "start_date = :start_date";
            $params['start_date'] = $data['start_date'];
        }
        if (!empty($data['shifted_date'])) {
            $fields[] = "shifted_date = :shifted_date";
            $params['shifted_date'] = $data['shifted_date'];
        }

        if (empty($id)) {
            $fields[] = "created_by = :created_by";
            $params['created_by'] = $data['created_by'];

            $fields[] = "created_at = :created_at";
            $params['created_at'] = $data['created_at'];
        }

        $fields[] = "updated_by = :updated_by";
        $params['updated_by'] = $data['updated_by'];

        $fields[] = "updated_at = :updated_at";
        $params['updated_at'] = $data['updated_at'];

        if (!empty($data['status'])) {
            $fields[] = "status = :status";
            $params['status'] = $data['status'];
        }

     
        $Sqlcmd .= implode(', ', $fields);

        
        if (!empty($id)) {
            $Sqlcmd .= " WHERE id = :id";
            $params['id'] = $id;
        }

        $this->_output_alert = 'Ok';
        $this->_last_query = $Sqlcmd;
        $this->_inserted_id = $this->mysqlInsertid();

        return $this->Query($Sqlcmd, $params);
    }

    function get_shifting($id = '', $active_legal_id = '', $not_id = '', $sort_asc = false)
    {
        $params = [];
        $Sqlcmd = "SELECT * FROM legal_shift_active_legal WHERE 1";
        if ($id) {
            $Sqlcmd .= " AND id=:id";
            $params['id'] = $id;
        }
        if ($active_legal_id) {
            $Sqlcmd .= " AND active_legal_id=:active_legal_id";
            $params['active_legal_id'] = $active_legal_id;
        }
        if ($not_id) {
            $Sqlcmd .= " AND id !=:not_id";
            $params['not_id'] = $not_id;
        }
        $Sqlcmd .= " AND status ='A'";
        if ($sort_asc) {
            $Sqlcmd .= " ORDER BY id ASC";
        } else {
            $Sqlcmd .= " ORDER BY id DESC";
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }


    function get_shifting_withLegal($id = '', $active_legal_id = '', $not_id = '', $sort_asc = false)
    {
        $params = array();

        $Sqlcmd = "SELECT legal_shift_active_legal.*, 
                      legal_activelegal.total_outstanding, 
                      legal_activelegal.outstanding_with_cheque,
                      legal_activelegal.outstanding_without_cheque,
                      legal_activelegal.claim_amount,
                      legal_activelegal.collected_amount,
                      legal_activelegal.balance_claim,
                      legal_activelegal.expense_amount


               FROM legal_shift_active_legal 
               JOIN legal_activelegal 
               ON legal_shift_active_legal.active_legal_id = legal_activelegal.id 
               WHERE 1";

        if ($id) {
            $Sqlcmd .= " AND legal_shift_active_legal.id = :id";
            $params['id'] = $id;
        }

        if ($active_legal_id) {
            $Sqlcmd .= " AND legal_shift_active_legal.active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $active_legal_id;
        }

        if ($not_id) {
            $Sqlcmd .= " AND legal_shift_active_legal.id != :not_id";
            $params['not_id'] = $not_id;
        }

        $Sqlcmd .= " AND legal_shift_active_legal.status = 'A'";

        $Sqlcmd .= $sort_asc ? " ORDER BY legal_shift_active_legal.id ASC" : " ORDER BY legal_shift_active_legal.id DESC";

        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }



    function disable_active_legal($data = [], $id = '')
    {
        $params = [];
    
        $Sqlcmd = "UPDATE legal_activelegal SET
                   updated_id=:updated_id,
                   updated_on=:updated_on,
                   status=:status
                   WHERE id=:id";
    
        $params['updated_id'] = $data['updated_id'];
        $params['updated_on'] = $data['updated_on'];
        $params['status']     = $data['status'];
        $params['id']         = $id;
    
        $result = $this->Query($Sqlcmd, $params);

        if ($result) {
        
            include_once("class.legal_activity_log.php");
            $activity = new LegalActivityLog();
        
            // logged in user
            $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;
        
            if ($loggedUserId) {
                $activity->logActivity(
                    'DISABLE',                     // action
                    'legal_activelegal',                  // module/table
                    $loggedUserId,                 // user id
                    "Activelegal disabled (ID: $id)",     // message
                    $id                            // reference id
                );
            }
        }
        
        return $result;
            }    function save_commission($data = [], $id = '')
    {
        $params = [];
        $setParts = [];

        if ($data['active_legal_id']) {
            $setParts[] = "active_legal_id=:active_legal_id";
            $params['active_legal_id'] = $data['active_legal_id'];
        }
        if ($data['parent_type']) {
            $setParts[] = "parent_type=:parent_type";
            $params['parent_type'] = $data['parent_type'];
        }
        if ($data['party_id']) {
            $setParts[] = "party_id=:party_id";
            $params['party_id'] = $data['party_id'];
        }
        if (isset($data['commission'])) {
            $setParts[] = "commission=:commission";
            $params['commission'] = $data['commission'];
        }
        if ($data['notes']) {
            $setParts[] = "notes=:notes";
            $params['notes'] = $data['notes'];
        }
        if ($id == '') {
            $setParts[] = "created_by=:created_by";
            $params['created_by'] = $data['created_by'];
            $setParts[] = "created_at=:created_at";
            $params['created_at'] = $data['created_at'];
        }
        $setParts[] = "updated_by=:updated_by";
        $params['updated_by'] = $data['updated_by'];
        $setParts[] = "updated_at=:updated_at";
        $params['updated_at'] = $data['updated_at'];
        if ($data['active']) {
            $setParts[] = "active=:active";
            $params['active'] = $data['active'];
        }
        if (isset($data['zero_commission'])) {
            $setParts[] = "zero_commission=:zero_commission";
            $params['zero_commission'] = $data['zero_commission'];
        }

        if (empty($setParts)) {
            return false;
        }

        if ($id) {
            $Sqlcmd = "UPDATE legal_activelegal_commission SET " . implode(", ", $setParts) . " WHERE id=:id";
            $params['id'] = $id;
        } else {
            $Sqlcmd = "INSERT INTO legal_activelegal_commission SET " . implode(", ", $setParts);
        }

        $this->_output_alert = 'Ok';
        $this->_last_query = $Sqlcmd;
        
        $result = $this->Query($Sqlcmd, $params);
        if ($result && !$id) {
            $this->_inserted_id = $this->mysqlInsertid();
        }
        return $result;
    }
    function get_commission($id = '', $active_legal_id = '', $parent_type = '', $party_id = '')
    {
        $params = array();
        $Sqlcmd = "SELECT legal_activelegal_commission.*,legal_activelegal.code FROM legal_activelegal_commission join legal_activelegal";
        $Sqlcmd .= " ON legal_activelegal_commission.active_legal_id=legal_activelegal.id";
        $Sqlcmd .= " WHERE 1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND legal_activelegal_commission.id=:id";
            $params['id'] = $id;
        }
        if ($active_legal_id) {
            $Sqlcmd .= " AND legal_activelegal_commission.active_legal_id=:active_legal_id";
            $params['active_legal_id'] = $active_legal_id;
        }
        if ($parent_type) {
            $Sqlcmd .= " AND legal_activelegal_commission.parent_type=:parent_type";
            $params['parent_type'] = $parent_type;
        }
        if ($party_id) {
            $Sqlcmd .= " AND legal_activelegal_commission.party_id=:party_id";
            $params['party_id'] = $party_id;
        }
        $Sqlcmd = $Sqlcmd . " AND legal_activelegal_commission.active=:activeIs";
        $params['activeIs'] = 'A';
        $Sqlcmd = $Sqlcmd . " ORDER BY legal_activelegal_commission.id DESC";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
}
        } else
            return false;
    }
}
