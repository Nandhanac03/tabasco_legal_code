<?php
class LegalTempCase extends dbcon
{
    function saveTempCase($data = [], $id = '')
    {
        $params = [];
        if ($id) {
            $sqlCmd = "UPDATE";
        } else {
            $sqlCmd = "INSERT INTO";
        }
        $sqlCmd .= " legal_temp_case set";
        if ($data['active_legal_id']) {
            $sqlCmd .= " active_legal_id =:active_legal_id";
            $params['active_legal_id'] = $data['active_legal_id'];
        }
        if ($data['temp_case_number']) {
            $sqlCmd .= ", temp_case_number =:temp_case_number";
            $params['temp_case_number'] = $data['temp_case_number'];
        }




        if ($data['register_date']) {
            $sqlCmd .= ", register_date =:register_date";
            $params['register_date'] = $data['register_date'];
        }
        if ($data['client_id']) {
            $sqlCmd .= ", client_id =:client_id";
            $params['client_id'] = $data['client_id'];
        }
        if ($data['user_id']) {
            $sqlCmd .= ", user_id =:user_id";
            $params['user_id'] = $data['user_id'];
        }
        if ($data['agencies_id']) {
            $sqlCmd .= ", agencies_id =:agencies_id";
            $params['agencies_id'] = $data['agencies_id'];
        }
        if ($data['category']) {
            $sqlCmd .= ", category =:category";
            $params['category'] = $data['category'];
        }

        if ($id == '') {
            if ($data['created_id']) {
                $sqlCmd .= ", created_id =:created_id";
                $params['created_id'] = $data['created_id'];
            }
            if ($data['created_on']) {
                $sqlCmd .= ", created_on =:created_on";
                $params['created_on'] = $data['created_on'];
            }
        }
        if ($data['updated_id']) {
            $sqlCmd .= ", updated_id =:updated_id";
            $params['updated_id'] = $data['updated_id'];
        }
        if ($data['updated_on']) {
            $sqlCmd .= ", updated_on =:updated_on";
            $params['updated_on'] = $data['updated_on'];
        }
        if ($data['status']) {
            $sqlCmd .= ", status =:status";
            $params['status'] = $data['status'];
        }
        if ($data['total_outstanding']) {
            $sqlCmd .= ", total_outstanding =:total_outstanding";
            $params['total_outstanding'] = $data['total_outstanding'];
        }
        if ($data['outstanding_with_cheque']) {
            $sqlCmd .= ", outstanding_with_cheque =:outstanding_with_cheque";
            $params['outstanding_with_cheque'] = $data['outstanding_with_cheque'];
        }
        if ($data['outstanding_without_cheque']) {
            $sqlCmd .= ", outstanding_without_cheque =:outstanding_without_cheque";
            $params['outstanding_without_cheque'] = $data['outstanding_without_cheque'];
        }
        if ($id) {
            $sqlCmd .= " WHERE id=$id";
        }
        $this->_output_alert = 'Ok';
        $this->_last_query = $sqlCmd;
        $this->_inserted_id = $this->mysqlInsertid();
        return $this->Query($sqlCmd, $params);
    }

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

    
    function getTempCase($filters = [])
    {
        $SqlCmd = "SELECT * FROM legal_temp_case WHERE 1=1";
        $params = [];

        if (!empty($filters['id'])) {
            $SqlCmd .= " AND id = :id";
            $params['id'] = $filters['id'];
        }
        if (!empty($filters['temp_case_number'])) {
            $SqlCmd .= " AND temp_case_number = :temp_case_number";
            $params['temp_case_number'] = $filters['temp_case_number'];
        }
        if (!empty($filters['active_legal_id'])) {
            $SqlCmd .= " AND active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $filters['active_legal_id'];
        }

        if (!empty($filters['client_id'])) {
            $SqlCmd .= " AND client_id = :client_id";
            $params['client_id'] = $filters['client_id'];
        }

        if (!empty($filters['status'])) {
            $SqlCmd .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['category'])) {
            $SqlCmd .= " AND category = :category";
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['agencies_id'])) {
            $SqlCmd .= " AND agencies_id = :agencies_id";
            $params['agencies_id'] = $filters['agencies_id'];
        }
        $SqlCmd .= " ORDER BY created_on DESC";
        $rows = $this->SELECT_MultiFetch($SqlCmd, $params);
        return ($this->_num_rows > 0) ? $rows : [];
    }
}
