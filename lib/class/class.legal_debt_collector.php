<?php
class DebtCollector extends dbcon {
    /**
     * Insert or Update Debt Collector Information
     */
    public function manageDebtCollector($data, $id = null) {
        $params = [
            'name'         => $data['name'] ?? '',
            'address'      => $data['address'] ?? '',
            'contact_no'   => $data['contact_no'] ?? '',
            'email'        => $data['email'] ?? '',
            'post_box_no'  => $data['post_box_no'] ?? '',
            'notes'        => $data['notes'] ?? '',
            'visiting_card'=> $data['visiting_card'] ?? ''
        ];

        $isUpdate = $id ? true : false;

        if ($isUpdate) {
            $sql = "UPDATE legal_debt_collector SET
                        name = :name,
                        address = :address,
                        contact_no = :contact_no,
                        email = :email,
                        post_box_no = :post_box_no,
                        notes = :notes,
                        visiting_card = :visiting_card,
                        updated_by = :updated_by,
                        updated_by_type = :updated_by_type,
                        updated_on = NOW()
                    WHERE id = :id";
            $params['id'] = $id;
            $params['updated_by'] = $data['updated_by'] ?? null;
            $params['updated_by_type'] = $data['updated_by_type'] ?? null;
        } else {
            $sql = "INSERT INTO legal_debt_collector (
                        name, address, contact_no, email, post_box_no, notes, visiting_card, created_by, created_by_type, created_on
                    ) VALUES (
                        :name, :address, :contact_no, :email, :post_box_no, :notes, :visiting_card, :created_by, :created_by_type, NOW()
                    )";
            $params['created_by'] = $data['created_by'] ?? null;
            $params['created_by_type'] = $data['created_by_type'] ?? null;
        }

        $result = $this->Query($sql, $params);

        if (!$isUpdate && $result) {
            $id = $this->_inserted_id = $this->mysqlInsertid();
        }

        // ===== ACTIVITY LOG =====
        if ($result) {
            include_once __DIR__ . '/class.legal_activity_log.php';
            $activity = new LegalActivityLog();
            $loggedUserId = $data['created_by'] ?? $data['updated_by'] ?? ($_SESSION['LOGIN_LEGAL_ID'] ?? null);

            if ($isUpdate) {
                $activity->logActivity(
                    'UPDATE',                  // action type
                    'legal_debt_collector',    // module/table
                    $loggedUserId,             // log_user
                    "Updated Debt Collector record ID: $id", // message
                    $id                        // log_refr_id
                );
            } else {
                $activity->logActivity(
                    'CREATE',
                    'legal_debt_collector',
                    $loggedUserId,
                    "Created Debt Collector record ID: $id",
                    $id
                );
            }
        }

        return $result;
    }

    
    /**
     * Get Debt Collector Information
     */public function getDebtCollectorInfo($filters = []) {
    $params = [];
    $sql = "SELECT DC.*, U.user_name AS createdBy
            FROM legal_debt_collector DC
            LEFT JOIN users U ON U.user_Id = DC.created_by
            WHERE 1";
    if (!empty($filters['id'])) {
        $sql .= " AND DC.id = :id";
        $params['id'] = $filters['id'];
    }
    if (!empty($filters['name'])) {
        $sql .= " AND DC.name = :name";
        $params['name'] = $filters['name'];
    }
    if (!empty($filters['search'])) {
        $sql .= " AND (DC.code LIKE :search OR DC.name LIKE :search1 OR DC.email LIKE :search2)";
        $params['search'] = '%' . $filters['search'] . '%';
        $params['search1'] = '%' . $filters['search'] . '%';
        $params['search2'] = '%' . $filters['search'] . '%';
    }
    if (!empty($filters['status'])) {
        $sql .= " AND DC.status = :status";
        $params['status'] = $filters['status'];
    }
    if (!empty($filters['action_id'])) {
        $sql .= " AND DC.id != :action_id";
        $params['action_id'] = $filters['action_id'];
    }
    // ✅ Ensure ordering is always applied
    $sql .= " ORDER BY DC.id DESC";
    // ✅ FIX: Proper LIMIT and OFFSET Handling
    if (!empty($filters['limit'])) {
        $limit = (int)$filters['limit']; // Ensure limit is an integer
        $offset = !empty($filters['offset']) ? (int)$filters['offset'] : 0; // Default to 0 if not set
        $sql .= " LIMIT $offset, $limit";
    }
    // Debugging - Uncomment if needed
    // echo $this->get_query($sql, $params); exit;
    return $this->SELECT_MultiFetch($sql, $params);
}
    /**
     * Get Last Debt Collector ID (for generating new ID)
     */
    public function getLastID() {
        $sql = "SELECT MAX(id) AS last_id FROM legal_debt_collector";
        $result = $this->SQL_Fetch($sql);
        $last_id = isset($result['last_id']) ? (int) $result['last_id'] : 0;
        $new_id = str_pad($last_id + 1, 4, '0', STR_PAD_LEFT);
        return defined('DEBT_COLLECTOR_CODE') ? DEBT_COLLECTOR_CODE . $new_id : 'ERROR: DEBT_COLLECTOR_CODE not defined';
    }
    function Get_Debt_Collector_TOTAL_COUNT($offset = '', $limit = '', $status = '', $search = '') {
        $params = [];
        $Sqlcmd = "SELECT COUNT(*) AS TOTAL_RECORDS FROM legal_debt_collector WHERE 1";
        if (!empty($status)) {
            $Sqlcmd .= " AND legal_debt_collector.status = :status";
            $params['status'] = $status;
        }
        if (!empty($search)) {
            $Sqlcmd .= " AND (legal_debt_collector.name LIKE :search OR legal_debt_collector.code LIKE :search1 OR legal_debt_collector.email LIKE :search2)";
            $params['search'] = $params['search1'] = $params['search2'] = "%$search%";
        }
        $Sqlcmd .= " ORDER BY legal_debt_collector.id DESC";
        if ($limit > 0) {
            $Sqlcmd .= " LIMIT " . (int)$offset . ", " . (int)$limit;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }

    public function Update_Debt_Collector_Records_Status($id = '') {
        if (!$id) return false;

        $params = ['id' => $id];

        // Update debt collector
        $Sqlcmd1 = "UPDATE legal_debt_collector SET status='D' WHERE id=:id";
        $this->Query($Sqlcmd1, $params);

        // Update related documents
        $Sqlcmd2 = "UPDATE legal_document SET status='D' WHERE parent_type='DC' AND parent_id=:id";
        $this->Query($Sqlcmd2, $params);

        // Update related contacts
        $Sqlcmd3 = "UPDATE legal_contacts SET status='D' WHERE parent_type='DC' AND parent_id=:id";
        $result = $this->Query($Sqlcmd3, $params);

        // ===== ACTIVITY LOG =====
        if ($result) {
            include_once __DIR__ . '/class.legal_activity_log.php';
            $activity = new LegalActivityLog();
            $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;

            $activity->logActivity(
                'DELETE',
                'legal_debt_collector',
                $loggedUserId,
                "Soft deleted Debt Collector record ID: $id",
                $id
            );
        }

        return $result;
    }
    // function Update_Debt_Collector_Records_Status($id = '') {
    //     if ($id) {
    //         // Prepare parameters for the SQL queries
    //         $params = array();
    //         $params['id'] = $id;
    //         // SQL query for the first status update (soft delete: status='D')
    //         $Sqlcmd1 = "UPDATE legal_debt_collector SET legal_debt_collector.status='D'  WHERE id=:id";
    //         // Execute the first status update query (soft delete)
    //         $this->_last_query = $Sqlcmd1;
    //         $this->Query($Sqlcmd1, $params);
    //         // SQL query for the second status update (e.g., activate: status='D')
    //         $Sqlcmd2 = "UPDATE legal_document SET legal_document.status='D' WHERE parent_type='DC' AND parent_id=:id";
    //         // Execute the second status update query (activate)
    //         $this->_last_query = $Sqlcmd2;
    //         $this->Query($Sqlcmd2, $params);
    //         // SQL query for the third status update (e.g., archive: status='D')
    //         $Sqlcmd3 = "UPDATE legal_contacts SET legal_contacts.status='D' WHERE parent_type='DC' AND parent_id=:id";
    //         // Execute the third status update query (archive)
    //         $this->_last_query = $Sqlcmd3;
    //         return $this->Query($Sqlcmd3, $params);
    //     } else {
    //         return false; // Return false if no ID or status is provided
    //     }
    // }
}
?>
