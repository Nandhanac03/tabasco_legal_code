<?php
class UsersClass extends dbcon
{
    public function processUsers(array $data = []): bool
    {
        $params = [];
        $requiredFields = ['user_typeId', 'user_name'];
        $optionalFields = [
            'user_address',
            'user_emailId',
            'user_tel',
            'user_mob',
            'user_loginname',
            'user_password',
            'user_photo',
            'user_profile',
            'user_legal_access',
            'user_module'
        ];
        // Check if required fields exist
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new InvalidArgumentException("Missing required field: $field");
            }
            $params[$field] = $data[$field];
        }
        // Process optional fields if provided
        foreach ($optionalFields as $field) {
            if (isset($data[$field])) {
                $params[$field] = $data[$field];
            }
        }
        // Duplicate checks
        if (!empty($data['user_emailId'])) {
            $status = 'A'; // optional, use if needed
            $userId = !empty($data['user_Id']) ? $data['user_Id'] : '';
            if ($this->duplicate_Check($status, $userId, $data['user_emailId'], '')[0]['TOTAL_RECORDS'] > 0) {
                throw new RuntimeException("Duplicate email found: {$data['user_emailId']}");
            }
        }
        if (!empty($data['user_loginname'])) {
            $status = '';
            $userId = !empty($data['user_Id']) ? $data['user_Id'] : '';
            if ($this->duplicate_Check($status, $userId, '', $data['user_loginname'])[0]['TOTAL_RECORDS'] > 0) {
                throw new RuntimeException("Duplicate login name found: {$data['user_loginname']}");
            }
        }
        // Build SQL dynamically
        $sqlParts = [];
        foreach ($params as $field => $value) {
            $sqlParts[] = "$field = :$field";
        }
        if (empty($sqlParts)) {
            throw new RuntimeException("No data provided to insert or update.");
        }
        // Check if updating based on user_Id
        if (!empty($data['user_Id'])) {
            // UPDATE
            $params['user_Id'] = $data['user_Id']; // bind user_Id too
            $Sqlcmd = "UPDATE users SET " . implode(', ', $sqlParts) . " WHERE user_Id = :user_Id";
        } else {
            // INSERT
            $Sqlcmd = "INSERT INTO users SET " . implode(', ', $sqlParts);
        }
        $this->_output_alert = "Ok";
        $this->_last_query = $Sqlcmd;
        $result = $this->Query($Sqlcmd, $params);
        if (empty($data['user_Id'])) {
            $this->_inserted_id = $this->mysqlInsertid();
        }
        return (bool) $result;
    }
    public function get_all_Users(?int $user_Id = null, string $search = '',$user_typeId='', int $offset = 0, int $limit = 0)
    {
        $params = [];
        $Sqlcmd = "SELECT * FROM users WHERE user_module = 'TL' AND user_status = 'A' ";
        if (!is_null($user_Id)) {
            $Sqlcmd .= " AND user_Id = :user_Id";
            $params['user_Id'] = $user_Id;
        }
        if (!empty($search)) {
            $Sqlcmd .= " AND (user_name LIKE :search OR user_emailId LIKE :search1 OR user_mob LIKE :search2)";
            $searchParam = "%$search%";
            $params['search'] = $params['search1'] = $params['search2'] = $searchParam;
        }
        if (!empty($user_typeId)) {
            $Sqlcmd .= " AND user_typeId = :user_typeId";
            $params['user_typeId'] = $user_typeId;
        }
        $Sqlcmd .= " ORDER BY user_Id DESC";
        if ($limit > 0) {
            $offset = (int)$offset;
            $limit = (int)$limit;
            $Sqlcmd .= " LIMIT $offset, $limit";
        }
        // echo $Sqlcmd;exit;

        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }

    // public function get_all_Users(?int $user_Id = null, string $search = '', $user_typeId = '', int $offset = 0, int $limit = 0)
    // {
    //     $params = [];
    //     $Sqlcmd = "SELECT * FROM users WHERE user_module = 'TL' AND user_status = 'A'";

    //     if (!is_null($user_Id)) {
    //         $Sqlcmd .= " AND user_Id = :user_Id";
    //         $params['user_Id'] = $user_Id;
    //     }
    //     if (!empty($search)) {
    //         $Sqlcmd .= " AND (user_name LIKE :search OR user_emailId LIKE :search1 OR user_mob LIKE :search2)";
    //         $searchParam = "%$search%";
    //         $params['search'] = $params['search1'] = $params['search2'] = $searchParam;
    //     }
    //     if (!empty($user_typeId)) {
    //         $Sqlcmd .= " AND user_typeId = :user_typeId";
    //         $params['user_typeId'] = $user_typeId;
    //     }
    //     $Sqlcmd .= " ORDER BY user_Id DESC";
    //     if ($limit > 0) {
    //         $offset = (int)$offset;
    //         $limit = (int)$limit;
    //         $Sqlcmd .= " LIMIT $offset, $limit"; // Inline offset and limit
    //     }

    //     // Assuming SELECT_MultiFetch uses PDO
    //     $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    //     return ($this->_num_rows > 0) ? $this->_result : false;
    // }
    public function Get_Users_TOTAL_COUNT(string $status = '', string $search = '', $user_typeId = '')
    {
        $params = [];
        $Sqlcmd = "SELECT COUNT(*) AS TOTAL_RECORDS FROM users WHERE user_module = 'TL'";
        if (!empty($status)) {
            $Sqlcmd .= " AND user_status = :status";
            $params['status'] = $status;
        }
        if (!empty($user_typeId)) {
            $Sqlcmd .= " AND user_typeId = :user_typeId";
            $params['user_typeId'] = $user_typeId;
        }
        if (!empty($search)) {
            $Sqlcmd .= " AND (user_name LIKE :search OR user_emailId LIKE :search1 OR user_mob LIKE :search2)";
            $searchParam = "%$search%";
            $params['search'] = $params['search1'] = $params['search2'] = $searchParam;
        }
        // ❌ REMOVE: ORDER BY and LIMIT
        // $Sqlcmd .= " ORDER BY user_Id DESC";
        // if ($limit > 0) {
        //     $Sqlcmd .= " LIMIT :offset, :limit";
        //     $params['offset'] = (int)$offset;
        //     $params['limit'] = (int)$limit;
        // }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    public function duplicate_Check(string $status = '', $user_Id = '', string $emailId = '', string $userLoginname = '')
    {
        $params = [];
        $Sqlcmd = "SELECT COUNT(*) AS TOTAL_RECORDS FROM users WHERE 1";
        if (!empty($status)) {
            $Sqlcmd .= " AND user_status = :status";
            $params['status'] = $status;
        }
        if (!empty($user_Id)) {
            $Sqlcmd .= " AND user_Id != :user_Id";
            $params['user_Id'] = $user_Id;
        }
        if (!empty($emailId)) {
            $Sqlcmd .= " AND user_emailId = :user_emailId";
            $params['user_emailId'] = $emailId;
        }
        if (!empty($userLoginname)) {
            $Sqlcmd .= " AND user_loginname = :user_loginname";
            $params['user_loginname'] = $userLoginname;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        //echo $this->get_query($Sqlcmd, $params); exit;
        return ($this->_num_rows > 0) ? $this->_result : false;
    }

    
}
