<?php
class CaseRootAction extends dbcon
{
    function save_case_root($data = [], $id = '')
    {
        $params = [];
        if ($id) {
            $SqlCmd = "UPDATE legal_case_root_actions SET";
        } else {
            $SqlCmd = "INSERT INTO legal_case_root_actions SET";
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
        if (!empty($data['case_root_id'])) {
            $setParts[] = "case_root_id = :case_root_id";
            $params['case_root_id'] = $data['case_root_id'];
        }
        if (!empty($data['email'])) {
            $setParts[] = "email = :email";
            $params['email'] = $data['email'];
        }
        if (!empty($data['category_id'])) {
            $setParts[] = "category_id = :category_id";
            $params['category_id'] = $data['category_id'];
        }
        if (!empty($data['client_id'])) {
            $setParts[] = "client_id = :client_id";
            $params['client_id'] = $data['client_id'];
        }if (!empty($data['firm_id'])) {
            $setParts[] = "firm_id = :firm_id";
            $params['firm_id'] = $data['firm_id'];
        }if (!empty($data['parent_type'])) {
            $setParts[] = "parent_type = :parent_type";
            $params['parent_type'] = $data['parent_type'];
        }
        if (!empty($data['action_subcategory_id'])) {
            $setParts[] = "action_subcategory_id = :action_subcategory_id";
            $params['action_subcategory_id'] = $data['action_subcategory_id'];
        }
        if (!empty($data['date'])) {
            $setParts[] = "`date` = :date"; // backticks for reserved word
            $params['date'] = $data['date'];
        }
        if (!empty($data['description'])) {
            $setParts[] = "description = :description";
            $params['description'] = $data['description'];
        }
        if (!empty($data['document'])) {
            $setParts[] = "document = :document";
            $params['document'] = $data['document'];
        }
        if (!empty($data['uae_pass'])) {
            $setParts[] = "uae_pass = :uae_pass";
            $params['uae_pass'] = $data['uae_pass'];
        }
        if (!empty($data['status'])) {
            $setParts[] = "status = :status";
            $params['status'] = $data['status'];
        }
        if (!empty($data['created_from'])) {
            $setParts[] = "created_from = :created_from";
            $params['created_from'] = $data['created_from'];
        }
        if (!empty($data['case_type'])) {
            $setParts[] = "case_type = :case_type";
            $params['case_type'] = $data['case_type'];
        }
        if ($id == '') {
            $setParts[] = "created_by = :created_by";
            $params['created_by'] = $data['created_by'];
            // your table uses created_at, not created_on
            $setParts[] = "created_at = :created_at";
            $params['created_at'] = $data['created_at'] ?? date('Y-m-d H:i:s');
        }

        $setParts[] = "updated_by = :updated_by";
        $params['updated_by'] = $data['updated_by'];
        $setParts[] = "updated_on = :updated_on";
        $params['updated_on'] = $data['updated_on'];

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

        return $this->Query($SqlCmd, $params);
    }

    function get_case_root($id = '', $filters = [])
    {
        $params = [];
        $SqlCmd = "
        SELECT a.*, s.title AS subcategory_title, lc.title AS category_title, lcr.stage AS root_stage,lcr.root_cat_number AS root_cat_number,u.user_name AS case_root_action_user,

        CASE 
                WHEN a.parent_type = 'TP' THEN tp.name
                WHEN a.parent_type = 'DC' THEN dc.name
                WHEN a.parent_type = 'LF' THEN lf.name
                WHEN a.parent_type = 'LT' THEN lt.user_name
                ELSE ''
            END AS party_name,

            CASE 
                WHEN a.parent_type = 'TP' THEN CONCAT(tp.name, ' — Third Party')
                WHEN a.parent_type = 'DC' THEN CONCAT(dc.name, ' — Debt Collector')
                WHEN a.parent_type = 'LF' THEN CONCAT(lf.name, ' — Legal Firm')
                WHEN a.parent_type = 'LT' THEN CONCAT(lt.user_name, ' — Legal Team')
                ELSE ''
            END AS Present_Legal_Firm_Name


        FROM legal_case_root_actions a
        LEFT JOIN legal_third_party AS tp 
            ON a.firm_id = tp.id
        LEFT JOIN legal_debt_collector AS dc 
            ON a.firm_id = dc.id
        LEFT JOIN legal_firm AS lf 
            ON a.firm_id = lf.id
        LEFT JOIN users AS lt 
            ON a.firm_id = lt.user_Id
        LEFT JOIN legal_action_subcategory s 
            ON a.action_subcategory_id = s.id
        LEFT JOIN legal_category lc 
            ON a.category_id = lc.id
        LEFT JOIN legal_case_roots lcr 
            ON a.case_root_id = lcr.id
        LEFT JOIN users AS u 
            ON a.created_by = u.user_Id
        WHERE 1=1";

        // If an ID is given, fetch only that record
        if (!empty($id)) {
            $SqlCmd .= " AND a.id = ?";
            $params[] = $id;
        }

        // Apply optional filters 
        if (!empty($filters['case_id'])) {
            $SqlCmd .= " AND a.case_id = ?";
            $params[] = $filters['case_id'];
        }
        if (!empty($filters['category_id'])) {
            $SqlCmd .= " AND a.category_id = ?";
            $params[] = $filters['category_id'];
        }
        if (!empty($filters['case_type'])) {
            $SqlCmd .= " AND a.case_type = ?";
            $params[] = $filters['case_type'];
        }
        if (!empty($filters['action_subcategory_id'])) {
            $SqlCmd .= " AND a.action_subcategory_id = ?";
            $params[] = $filters['action_subcategory_id'];
        }

        if (!empty($filters['case_root_id'])) {
            $SqlCmd .= " AND a.case_root_id = ?";
            $params[] = $filters['case_root_id'];
        }
        if (!empty($filters['active_legal_id'])) {
            $SqlCmd .= " AND a.active_legal_id = ?";
            $params[] = $filters['active_legal_id'];
        }
        if (!empty($filters['status'])) {
            $SqlCmd .= " AND a.status = ?";
            $params[] = $filters['status'];
        }
        if (!empty($filters['created_from'])) {
            $SqlCmd .= " AND a.created_from = ?";
            $params[] = $filters['created_from'];
        }

        // Order by latest ID
        $SqlCmd .= " ORDER BY a.id DESC";

        $this->_result = $this->SELECT_MultiFetch($SqlCmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }

   
    function disable_case_root($data = [], $id = '')
    {
        $params = [];
        $Sqlcmd = "UPDATE legal_case_root_actions SET";
        if ($data['status']) {
            $Sqlcmd .= " status=:status";
            $params['status'] = $data['status'];
        }
        $Sqlcmd .= ", updated_by=:updated_by";
        $params['updated_by'] = $data['updated_by'];
        $Sqlcmd .= ", updated_on=:updated_on";
        $params['updated_on'] = $data['updated_on'];
        $Sqlcmd .= " WHERE id=$id";
        $this->_output_alert = 'Ok';
        $this->_last_query = $Sqlcmd;
        $this->_inserted_id = $this->mysqlInsertid();
        return $this->Query($Sqlcmd, $params);
    }
}
