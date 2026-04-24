<?php
class CaseReport extends dbcon
{


    // function getTempCase($id = '', $filters = [])
    // {
    //     $params = [];
    //     $sqlCmd = "SELECT * FROM legal_temp_case WHERE 1=1";

    //     // Get by ID
    //     if ($id) {
    //         $sqlCmd .= " AND id = :id";
    //         $params['id'] = $id;
    //     }

    //     // Optional filters passed as array (not $_GET)
    //     if (!empty($filters['client_id'])) {
    //         $sqlCmd .= " AND client_id = :client_id";
    //         $params['client_id'] = $filters['client_id'];
    //     }

    //     if (!empty($filters['status'])) {
    //         $sqlCmd .= " AND status = :status";
    //         $params['status'] = $filters['status'];
    //     }

    //     if (!empty($filters['category'])) {
    //         $sqlCmd .= " AND category = :category";
    //         $params['category'] = $filters['category'];
    //     }

    //     if (!empty($filters['agencies_id'])) {
    //         $sqlCmd .= " AND agencies_id = :agencies_id";
    //         $params['agencies_id'] = $filters['agencies_id'];
    //     }

    //     $sqlCmd .= " AND status = 'A'";
    //     $sqlCmd .= " ORDER BY id DESC";

    //     $this->_result = $this->SELECT_MultiFetch($sqlCmd, $params);
    //     return ($this->_num_rows > 0) ? $this->_result : false;
    // }

    // public function getCaseRootActions($filters = [])
    // {
    //     $SqlCmd = "SELECT * FROM legal_case_root_actions 
        
    //                WHERE uae_pass = 'yes' ";
    
    //     $rows = $this->SELECT_MultiFetch($SqlCmd, []);
    //     return $rows;
    // }
    public function getCaseRootActions($filters = [])
    {
        $SqlCmd = "
            SELECT 
                ra.*, 
                cl.id AS client_primary_id, 
                cl.name AS ClientName, 
                ca.case_number 
            FROM legal_case_root_actions ra
            INNER JOIN legal_activelegal al 
                ON ra.active_legal_id = al.id
            LEFT JOIN legal_client cl 
                ON ra.client_id = cl.id
            LEFT JOIN legal_case ca 
                ON ra.case_id = ca.id
            WHERE ra.uae_pass = 'YES'
        ";
    
        // $params = [];
        // print_r($params = []);
        // exit();
    
        if (!empty($filters['active_legal_id'])) {
            $SqlCmd .= " AND al.id = ?";
            $params[] = $filters['active_legal_id'];
        }
    
        return $this->SELECT_MultiFetch($SqlCmd, $params);
    }
    
    
    

}
