<?php
class LegalCollectionCommission extends dbcon
{

    function save_collection_commission($data = [], $id = '')
    {
        $params = [];
        if ($id) {
            $SqlCmd = "UPDATE legal_collection_commission SET";
        } else {
            $SqlCmd = "INSERT INTO legal_collection_commission SET";
        }

        $setParts = [];

        if (!empty($data['case_id'])) {
            $setParts[] = "case_id = :case_id";
            $params['case_id'] = $data['case_id'];
        }
        if (!empty($data['active_legal_id'])) {
            $setParts[] = "active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $data['active_legal_id'];
        }
        if (!empty($data['collection_id'])) {
            $setParts[] = "collection_id = :collection_id";
            $params['collection_id'] = $data['collection_id'];
        }
        if (!empty($data['parent_type'])) {
            $setParts[] = "parent_type = :parent_type";
            $params['parent_type'] = $data['parent_type'];
        }
        if (!empty($data['party_id'])) {
            $setParts[] = "party_id = :party_id";
            $params['party_id'] = $data['party_id'];
        }
        if (!empty($data['amount'])) {
            $setParts[] = "amount = :amount";
            $params['amount'] = $data['amount'];
        }
        if (!empty($data['date'])) {
            $setParts[] = "`date` = :date"; // backticks for reserved word
            $params['date'] = $data['date'];
        }

        if (!empty($data['status'])) {
            $setParts[] = "status = :status";
            $params['status'] = $data['status'];
        }
        if (!empty($data['commission_percentage'])) {
            $setParts[] = "commission_percentage = :commission_percentage";
            $params['commission_percentage'] = $data['commission_percentage'];
        }
        if (!empty($data['active_legal_commisionId'])) {
            $setParts[] = "active_legal_commisionId = :active_legal_commisionId";
            $params['active_legal_commisionId'] = $data['active_legal_commisionId'];
        }
        if (!empty($data['created_from'])) {
            $setParts[] = "created_from = :created_from";
            $params['created_from'] = $data['created_from'];
        }
        if (isset($data['zero_commission'])) {
            $setParts[] = "zero_commission = :zero_commission";
            $params['zero_commission'] = $data['zero_commission'];
        }
        if ($id == '') {
            $setParts[] = "created_by = :created_by";
            $params['created_by'] = $data['created_by'];
            // your table uses created_at, not created_on
            $setParts[] = "created_on = :created_on";
            $params['created_on'] = $data['created_on'] ?? date('Y-m-d H:i:s');
        }

        if (!empty($data['updated_by'])) {
            $setParts[] = "updated_by = :updated_by";
            $params['updated_by'] = $data['updated_by'];
        }
        if (!empty($data['updated_on'])) {
            $setParts[] = "updated_on = :updated_on";
            $params['updated_on'] = $data['updated_on'];
        }

        // join set parts with commas
        $SqlCmd .= " " . implode(", ", $setParts);

        if ($id) {
            $SqlCmd .= " WHERE idPrimary = :id";
            $params['id'] = $id;
        }

        $this->_output_alert = 'Ok';
        $this->_last_query = $SqlCmd;

        if (!$id) {
            $this->_inserted_id = $this->mysqlInsertid();
        }

        $result = $this->Query($SqlCmd, $params);

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
                        ? "Updated Collection Commission ID: $id"
                        : "Created Collection Commission ID: $id",
                    $id                                // reference id
                );
            }
        }
        
        return $result;
        
        }
        

    function get_collection_commission($filters = [])
    {
        $params = [];
        $SqlCmd = "SELECT * 
        FROM legal_collection_commission WHERE 1";

        if (!empty($filters['id'])) {
            $SqlCmd .= " AND idPrimary = :id";
            $params['id'] = $filters['id'];
        }

        if (!empty($filters['case_id'])) {
            $SqlCmd .= " AND case_id = :case_id";
            $params['case_id'] = $filters['case_id'];
        }

        if (!empty($filters['collection_id'])) {
            $SqlCmd .= " AND collection_id = :collection_id";
            $params['collection_id'] = $filters['collection_id'];
        }

        if (!empty($filters['party_id'])) {
            $SqlCmd .= " AND party_id = :party_id";
            $params['party_id'] = $filters['party_id'];
        }

        // Default status = 'A' unless explicitly passed
        $status = isset($filters['status']) ? $filters['status'] : 'A';
        $SqlCmd .= " AND status = :status";
        $params['status'] = $status;

        if (!empty($filters['parent_type'])) {
            $SqlCmd .= " AND parent_type = :parent_type";
            $params['parent_type'] = $filters['parent_type'];
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $SqlCmd .= " AND `date` BETWEEN :from_date AND :to_date";
            $params['from_date'] = $filters['from_date'];
            $params['to_date'] = $filters['to_date'];
        }

        $SqlCmd .= " ORDER BY idPrimary DESC";

        $this->_result = $this->SELECT_MultiFetch($SqlCmd, $params);

        if ($this->_num_rows > 0) {
            return $this->_result;
        } else {
            return false;
        }
    }



    function get_collection_commission_with_collection($filters = [])
    {
        $params = [];
        $SqlCmd = "
        SELECT 
            cc.*, 
            lc.amount AS collection_amount,
            lcl.name AS client_name,
            la.total_outstanding,
            ((cc.amount) * (cc.commission_percentage) / 100) AS received_amount,

            CASE 
                WHEN cc.parent_type = 'TP' THEN tp.name
                WHEN cc.parent_type = 'DC' THEN dc.name
                WHEN cc.parent_type = 'LF' THEN lf.name
                WHEN cc.parent_type = 'LT' THEN lt.user_name
                ELSE ''
            END AS party_name,

            CASE 
                WHEN cc.parent_type = 'TP' THEN CONCAT(tp.name, ' — Third Party')
                WHEN cc.parent_type = 'DC' THEN CONCAT(dc.name, ' — Debt Collector')
                WHEN cc.parent_type = 'LF' THEN CONCAT(lf.name, ' — Legal Firm')
                WHEN cc.parent_type = 'LT' THEN CONCAT(lt.user_name, ' — Legal Team')
                ELSE ''
            END AS Present_Legal_Firm_Name

        FROM legal_collection_commission AS cc
        JOIN legal_collections AS lc 
            ON cc.collection_id = lc.id
        LEFT JOIN legal_third_party AS tp 
            ON cc.party_id = tp.id
        LEFT JOIN legal_debt_collector AS dc 
            ON cc.party_id = dc.id
        LEFT JOIN legal_firm AS lf 
            ON cc.party_id = lf.id
        LEFT JOIN users AS lt 
            ON cc.party_id = lt.user_Id
        LEFT JOIN legal_activelegal AS la 
            ON cc.active_legal_id = la.id
        LEFT JOIN legal_client AS lcl       
            ON la.client = lcl.id
        WHERE 1 = 1
    ";

        // ✅ Apply filters dynamically
        if (!empty($filters['id'])) {
            $SqlCmd .= " AND cc.id = :id";
            $params['id'] = $filters['id'];
        }

        if (!empty($filters['active_legal_id'])) {
            $SqlCmd .= " AND cc.active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $filters['active_legal_id'];
        }

        if (!empty($filters['case_id'])) {
            $SqlCmd .= " AND cc.case_id = :case_id";
            $params['case_id'] = $filters['case_id'];
        }

        if (!empty($filters['collection_id'])) {
            $SqlCmd .= " AND cc.collection_id = :collection_id";
            $params['collection_id'] = $filters['collection_id'];
        }

        if (!empty($filters['parent_type'])) {
            $SqlCmd .= " AND cc.parent_type = :parent_type";
            $params['parent_type'] = $filters['parent_type'];
        }

        // Default to Active
        $status = $filters['status'] ?? 'A';
        $SqlCmd .= " AND cc.status = :status";
        $params['status'] = $status;

        $SqlCmd .= " ORDER BY cc.id DESC";

        $this->_result = $this->SELECT_MultiFetch($SqlCmd, $params);

        return $this->_num_rows > 0 ? $this->_result : false;
    }





    function get_collection_commission_aggregates($filters = [])
    {
        $params = [];
        $SqlCmd = "
        SELECT 
            cc.active_legal_id,
            lc.name AS client_name,
            la.total_outstanding AS total_outstanding,

            SUM(cc.amount) AS total_collection_amount,
            SUM(cc.commission_percentage) AS total_commission_percentage,
            (SUM(cc.amount) * SUM(cc.commission_percentage) / 100) AS received_amount,

            -- Optional: get dominant parent_type (if multiple, picks highest occurrence)
            MAX(cc.parent_type) AS parent_type,

            -- Derive name dynamically based on the dominant parent_type
            CASE 
                WHEN MAX(cc.parent_type) = 'TP' THEN MAX(tp.name)
                WHEN MAX(cc.parent_type) = 'DC' THEN MAX(dc.name)
                WHEN MAX(cc.parent_type) = 'LF' THEN MAX(lf.name)
                WHEN MAX(cc.parent_type) = 'LT' THEN MAX(lt.user_name)
            END AS party_name,

            CASE 
                WHEN MAX(cc.parent_type) = 'TP' THEN CONCAT(MAX(tp.name), ' — Third Party')
                WHEN MAX(cc.parent_type) = 'DC' THEN CONCAT(MAX(dc.name), ' — Debt Collector')
                WHEN MAX(cc.parent_type) = 'LF' THEN CONCAT(MAX(lf.name), ' — Legal Firm')
                WHEN MAX(cc.parent_type) = 'LT' THEN CONCAT(MAX(lt.user_name), ' — Legal Team')
            END AS Present_Legal_Firm_Name

        FROM legal_collection_commission AS cc
        LEFT JOIN legal_third_party AS tp 
            ON cc.party_id = tp.id
        LEFT JOIN legal_debt_collector AS dc 
            ON cc.party_id = dc.id
        LEFT JOIN legal_firm AS lf 
            ON cc.party_id = lf.id
        LEFT JOIN users AS lt 
            ON cc.party_id = lt.user_Id
        LEFT JOIN legal_activelegal AS la 
            ON cc.active_legal_id = la.id
        LEFT JOIN legal_client AS lc       
            ON la.client = lc.id
        WHERE 1
    ";
        if (!empty($filters['client'])) {
            $SqlCmd .= " AND la.client = :client";
            $params['client'] = $filters['client'];
        }
    

        // ✅ Optional filters
        if (!empty($filters['case_id'])) {
            $SqlCmd .= " AND cc.case_id = :case_id";
            $params['case_id'] = $filters['case_id'];
        }

        if (!empty($filters['active_legal_id'])) {
            $SqlCmd .= " AND cc.active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $filters['active_legal_id'];
        }

        if (!empty($filters['parent_type'])) {
            $SqlCmd .= " AND cc.parent_type = :parent_type";
            $params['parent_type'] = $filters['parent_type'];
        }

        // ✅ Default to active records
        $status = isset($filters['status']) ? $filters['status'] : 'A';
        $SqlCmd .= " AND cc.status = :status";
        $params['status'] = $status;

        // ✅ Grouping by only active_legal_id
        $SqlCmd .= "
        GROUP BY 
            cc.active_legal_id, 
            lc.name, 
            la.total_outstanding
        ORDER BY cc.active_legal_id DESC
    ";

        $this->_result = $this->SELECT_MultiFetch($SqlCmd, $params);

        if ($this->_num_rows > 0) {
            return $this->_result;
        } else {
            return false;
        }
    }
}
