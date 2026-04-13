<?php
class LegalFirm extends dbcon {
    /**
     * Insert or Update Legal Firm Information
     */
    public function manageLegalFirmInformation($data, $id = null) {
        $params = [];
        $isUpdate = $id ? true : false;
    
        if ($isUpdate) {
            // Fetch old data before update for logging
            $oldData = $this->SELECT_MultiFetch("SELECT * FROM legal_firm WHERE id=:id", ['id' => $id])[0] ?? null;
    
            $sql = "UPDATE legal_firm SET
                        name = :name,
                        address = :address,
                        contact_no = :contact_no,
                        email = :email,
                        post_box_no = :post_box_no,
                        notes = :notes,
                        visiting_card = :visiting_card,
                        updated_by = :updated_by,
                        updated_on = NOW()
                    WHERE id = :id";
            $params['id'] = $id;
            $params['updated_by'] = $data['updated_by'] ?? null;
        } else {
            $sql = "INSERT INTO legal_firm (
                        name, address, contact_no, email, post_box_no, notes, visiting_card, created_by, created_on
                    ) VALUES (
                        :name, :address, :contact_no, :email, :post_box_no, :notes, :visiting_card, :created_by, NOW()
                    )";
            $params['created_by'] = $data['created_by'] ?? null;
        }
    
        // Bind common parameters
        $params['name'] = $data['name'] ?? '';
        $params['address'] = $data['address'] ?? '';
        $params['contact_no'] = $data['contact_no'] ?? '';
        $params['email'] = $data['email'] ?? '';
        $params['post_box_no'] = $data['post_box_no'] ?? '';
        $params['notes'] = $data['notes'] ?? '';
        $params['visiting_card'] = $data['visiting_card'] ?? '';
    
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
                    'legal_firm',    // module/table
                    $loggedUserId,             // log_user
                    "Updated Legal Firm record ID: $id", // message
                    $id                        // log_refr_id
                );
            } else {
                $activity->logActivity(
                    'CREATE',
                    'legal_firm',
                    $loggedUserId,
                    "Created Legal Firm record ID: $id",
                    $id
                );
            }
        }

        return $result;
    }
    
    /**
     * Get Legal Firm Information
     */
    public function getLegalFirmInformation($filters = []) {
        $params = [];
        $sql = "SELECT LF.*, U.user_name AS createdBy
                FROM legal_firm LF
                LEFT JOIN users U ON U.user_Id = LF.created_by
                WHERE 1";
        if (!empty($filters['id'])) {
            $sql .= " AND LF.id = :id";
            $params['id'] = $filters['id'];
        }
        if (!empty($filters['name'])) {
            $sql .= " AND LF.name = :name";
            $params['name'] = $filters['name'];
        }
        if (!empty($filters['search'])) {
            $sql .= " AND (LF.code LIKE :search OR LF.name LIKE :search1 OR LF.email LIKE :search2)";
            $params['search'] = '%' . $filters['search'] . '%';
            $params['search1'] = '%' . $filters['search'] . '%';
            $params['search2'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['status'])) {
            $sql .= " AND LF.status = :status";
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['action_id'])) {
            $sql .= " AND LF.id != :action_id";
            $params['action_id'] = $filters['action_id'];
        }
        // ✅ Ensure ordering is always applied
        $sql .= " ORDER BY LF.id DESC";
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
    function Get_Legal_Firm_TOTAL_COUNT($offset = '', $limit = '', $status = '', $search = '') {
        $params = [];
        $Sqlcmd = "SELECT COUNT(*) AS TOTAL_RECORDS FROM legal_firm WHERE 1";
        if (!empty($status)) {
            $Sqlcmd .= " AND legal_firm.status = :status";
            $params['status'] = $status;
        }
        if (!empty($search)) {
            $Sqlcmd .= " AND (legal_firm.name LIKE :search OR legal_firm.code LIKE :search1 OR legal_firm.email LIKE :search2)";
            $params['search'] = $params['search1'] = $params['search2'] = "%$search%";
        }
        $Sqlcmd .= " ORDER BY legal_firm.id DESC";
        if ($limit > 0) {
            $Sqlcmd .= " LIMIT " . (int)$offset . ", " . (int)$limit;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    /**
     * Get Last Legal Firm ID (for generating new ID)
     */
    public function getLastID() {
        $sql = "SELECT MAX(id) AS last_id FROM legal_firm";
        $result = $this->SQL_Fetch($sql);
        $last_id = isset($result['last_id']) ? (int) $result['last_id'] : 0;
        $new_id = str_pad($last_id + 1, 4, '0', STR_PAD_LEFT);
        return defined('LEGAL_FIRM_CODE') ? LEGAL_FIRM_CODE . $new_id : 'ERROR: LEGAL_FIRM_CODE not defined';
    }
    function Update_Firms_Records_Status($id = '') {
        if ($id) {
            // Prepare parameters for the SQL queries
            $params = array();
            $params['id'] = $id;
            // SQL query for the first status update (soft delete: status='D')
            $Sqlcmd1 = "UPDATE legal_firm SET legal_firm.status='D'  WHERE id=:id";
            // Execute the first status update query (soft delete)
            $this->_last_query = $Sqlcmd1;
            $this->Query($Sqlcmd1, $params);
            // SQL query for the second status update (e.g., activate: status='D')
            $Sqlcmd2 = "UPDATE legal_document SET legal_document.status='D' WHERE parent_type='LF' AND parent_id=:id";
            // Execute the second status update query (activate)
            $this->_last_query = $Sqlcmd2;
            $this->Query($Sqlcmd2, $params);
            // SQL query for the third status update (e.g., archive: status='D')
            $Sqlcmd3 = "UPDATE legal_contacts SET legal_contacts.status='D' WHERE parent_type='LF' AND parent_id=:id";
            // Execute the third status update query (archive)
            $this->_last_query = $Sqlcmd3;
            return $this->Query($Sqlcmd3, $params);
        } else {
            return false; // Return false if no ID or status is provided
        }
    }
}
?>
