<?php
class bankDetails extends dbcon
{
    ################	MEMBER FUNCTIONS SECTION	##############
    function manage_bank_account($data = '', $ac_id = '')
    {
        $params = array();
        $Sqlcmd = $ac_id ? "UPDATE legal_bank_accounts SET" : "INSERT INTO legal_bank_accounts SET";
        $Sqlcmd .= " ac_type = :ac_type";
        $params['ac_type'] = $data['ac_type'];
        $Sqlcmd .= " ,ac_name = :ac_name";
        $params['ac_name'] = $data['ac_name'];
        // ✅ Fix: Ensure bank_id is NULL if empty
        $Sqlcmd .= " ,bank_id = :bank_id";
        $params['bank_id'] = isset($data['bank_id']) && $data['bank_id'] !== '' ? (int)$data['bank_id'] : null;
        $Sqlcmd .= " ,iban_no = :iban_no";
        $params['iban_no'] = $data['iban_no'];
        $Sqlcmd .= " ,ac_number = :ac_number";
        $params['ac_number'] = $data['ac_number'];
        // ✅ Fix: Ensure bank_county_id is NULL if empty
        $Sqlcmd .= " ,bank_county_id = :bank_county_id";
        $params['bank_county_id'] = isset($data['bank_county_id']) && $data['bank_county_id'] !== '' ? (int)$data['bank_county_id'] : null;
        $Sqlcmd .= " ,swift_code = :swift_code";
        $params['swift_code'] = $data['swift_code'];
        $Sqlcmd .= " ,parent_id = :parent_id";
        $params['parent_id'] = $data['parent_id'];
        $Sqlcmd .= " ,parent_type = :parent_type";
        $params['parent_type'] = $data['parent_type'];
        $Sqlcmd .= " ,created_by = :created_by";
        $params['created_by'] = $data['created_by'];
        $Sqlcmd .= " ,created_on = :created_on";
        $params['created_on'] = $data['created_on'];
        if ($ac_id) {
            $Sqlcmd .= " ,updated_by = :updated_by";
            $params['updated_by'] = $data['updated_by'];
            $Sqlcmd .= " ,updated_on = :updated_on";
            $params['updated_on'] = $data['updated_on'];
            $Sqlcmd .= " WHERE ac_id = :ac_id";
            $params['ac_id'] = $ac_id;
        }
        // echo $this->get_query($Sqlcmd, $params); exit;
        $this->_inserted_id = $this->mysqlInsertid();
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
                    'legal_bank',                      // module/table
                    $loggedUserId,                     // user id
                    $isUpdate
                        ? "Updated Bank ID: $id"
                        : "Created Bank ID: $id",
                    $id                                // reference id
                );
            }
        }
        
        return $result;
        
    }
    function save_bank($data = '', $id = '')
    {
        $params = [];
        if ($id) {
            $Sqlcmd = "UPDATE";
        } else {
            $Sqlcmd = "INSERT INTO";
        }
        $Sqlcmd .= " legal_bank SET";
        if ($data['name']) {
            $Sqlcmd .= " name=:name";
            $params['name'] = $data['name'];
        }
        if ($data['status']) {
            $Sqlcmd .= ", status=:status";
            $params['status'] = $data['status'];
        }
        if ($id == '') {
            $Sqlcmd .= ", created_by=:created_by";
            $params['created_by'] = $data['created_by'];
            $Sqlcmd .= ", created_on=:created_on";
            $params['created_on'] = $data['created_on'];
        }
        $Sqlcmd .= ", updated_by=:updated_by";
        $params['updated_by'] = $data['updated_by'];
        $Sqlcmd .= ", updated_on=:updated_on";
        $params['updated_on'] = $data['updated_on'];
        if ($id) {
            $Sqlcmd .= " WHERE id=$id";
        }
        $this->_output_alert = 'Ok';
        $this->_last_query = $Sqlcmd;
        $this->_inserted_id = $this->mysqlInsertid();
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
                    'legal_bank',                      // module/table
                    $loggedUserId,                     // user id
                    $isUpdate
                        ? "Updated Bank ID: $id"
                        : "Created Bank ID: $id",
                    $id                                // reference id
                );
            }
        }
        
        return $result;
        
    }
    function get_bank_account_details($id = '', $parent_id = '', $parent_type = '')
    {
        //echo $limit; echo $offset; exit;
        $params = array();
        $Sqlcmd = "SELECT
        legal_bank_accounts.*,legal_bank_ac_type.name as ac_type_name,
        legal_bank_country.name as bank_country_name,
        legal_bank.name as bank_name
    FROM
        legal_bank_accounts
        LEFT JOIN legal_bank_ac_type ON legal_bank_ac_type.id=legal_bank_accounts.ac_type
        LEFT JOIN legal_bank_country ON legal_bank_country.id=legal_bank_accounts.bank_county_id
        LEFT JOIN legal_bank ON legal_bank.id=legal_bank_accounts.bank_id
    WHERE
        1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND legal_bank_accounts.ac_id=:id";
            $params['id'] = $id;
        }
        if ($parent_id) {
            $Sqlcmd = $Sqlcmd . " AND legal_bank_accounts.parent_id=:parent_id";
            $params['parent_id'] = $parent_id;
        }
        if ($parent_type) {
            $Sqlcmd = $Sqlcmd . " AND legal_bank_accounts.parent_type=:parent_type";
            $params['parent_type'] = $parent_type;
        }
        $Sqlcmd = $Sqlcmd . " AND legal_bank_accounts.status=:statusIs";
        $params['statusIs'] = 'A';
        //echo $this->get_query($Sqlcmd, $params); exit;
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function get_bank_names($id = '', $name = '', $not_id = '', $search = '', $limit = '', $offset = '')
    {
        $params = array();
        $Sqlcmd = "SELECT * FROM legal_bank WHERE 1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND legal_bank.id=:id";
            $params['id'] = $id;
        }
        if ($name) {
            $Sqlcmd .= " AND legal_bank.name=:name";
            $params['name'] = $name;
        }
        if ($not_id) {
            $Sqlcmd .= " AND legal_bank.id !=:not_id";
            $params['not_id'] = $not_id;
        }
        if ($search) {
            $Sqlcmd .= " AND legal_bank.name LIKE :search";
            $params['search'] = "%$search%";
        }
        $Sqlcmd = $Sqlcmd . " AND legal_bank.status=:statusIs";
        $params['statusIs'] = 'A';
        $Sqlcmd = $Sqlcmd . " ORDER BY legal_bank.id DESC";
        if ($limit) {
            $Sqlcmd .= " LIMIT $limit OFFSET $offset";
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function get_bank_ac_types($id = '')
    {
        $params = array();
        $Sqlcmd = "SELECT * FROM legal_bank_ac_type WHERE 1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND legal_bank_ac_type.id=:id";
            $params['id'] = $id;
        }
        $Sqlcmd = $Sqlcmd . " AND legal_bank_ac_type.status=:statusIs";
        $params['statusIs'] = 'A';
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function get_bank_country($id = '')
    {
        $params = array();
        $Sqlcmd = "SELECT * FROM legal_bank_country WHERE 1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND legal_bank_country.id=:id";
            $params['id'] = $id;
        }
        $Sqlcmd = $Sqlcmd . " AND legal_bank_country.status=:statusIs";
        $params['statusIs'] = 'A';
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function disable_bank($data = [], $id = '')
    {
        $params = [];
        $Sqlcmd = "UPDATE legal_bank SET";
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
        $result = $this->Query($Sqlcmd, $params);

        if ($result) {
        
            include_once("class.legal_activity_log.php");
            $activity = new LegalActivityLog();
        
            // logged in user
            $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;
        
            if ($loggedUserId) {
                $activity->logActivity(
                    'DISABLE',                     // action
                    'legal_bank',                  // module/table
                    $loggedUserId,                 // user id
                    "Bank disabled (ID: $id)",     // message
                    $id                            // reference id
                );
            }
        }
        
        return $result;
            }
        }
