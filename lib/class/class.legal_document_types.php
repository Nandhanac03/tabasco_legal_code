<?php
class Document_types extends dbcon
{
    function save_document_type($data = [], $id = '')
    {
        $params = [];
        $isUpdate = !empty($id);
        if ($id) {
            $Sqlcmd = "UPDATE";
        } else {
            $Sqlcmd = "INSERT INTO";
        }
        $Sqlcmd .= " legal_document_type SET";
        if ($data['title']) {
            $Sqlcmd .= " title=:title";
            $params['title'] = $data['title'];
        }
        if ($data['status']) {
            $Sqlcmd .= ", status=:status";
            $params['status'] = $data['status'];
        }
        if ($id == '') {
            $Sqlcmd .= ", create_by=:create_by";
            $params['create_by'] = $data['create_by'];
            $Sqlcmd .= ", create_on=:create_on";
            $params['create_on'] = $data['create_on'];
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

    /* ===== GET INSERT ID IF INSERT ===== */
    if ($result && !$isUpdate) {
        $id = $this->mysqlInsertid();
    }

    /* ===== ACTIVITY LOG ===== */
    if ($result) {

        include_once("class.legal_activity_log.php");
        $activity = new LegalActivityLog();

        $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;

        if ($loggedUserId) {
            $activity->logActivity(
                $isUpdate ? 'UPDATE' : 'INSERT',          // action
                'legal_document_type',                    // module/table
                $loggedUserId,                            // user id
                $isUpdate 
                    ? "Updated Document Type ID: $id"
                    : "Created Document Type ID: $id",
                $id                                       // reference id
            );
        }
    }

    return $result;
}
    
    function get_document_type($id = '', $title = '', $not_id = '', $search = '', $limit = '', $offset = '')
    {
        $params = [];
        $Sqlcmd = "SELECT * FROM legal_document_type WHERE 1";
        if ($id) {
            $Sqlcmd .= " AND id=:id";
            $params['id'] = $id;
        }
        if ($title) {
            $Sqlcmd .= " AND title=:title";
            $params['title'] = $title;
        }
        if ($not_id) {
            $Sqlcmd .= " AND id !=:not_id";
            $params['not_id'] = $not_id;
        }
        if ($search) {
            $Sqlcmd .= " AND title LIKE :search";
            $params['search'] = "%$search%";
        }
        $Sqlcmd .= " AND status ='A'";
        $Sqlcmd .= " ORDER BY id DESC";
        if ($limit) {
            $Sqlcmd .= " LIMIT $limit OFFSET $offset";
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    function disable_doc_type($data = [], $id = '')
    {
        $params = [];
        $Sqlcmd = "UPDATE legal_document_type SET";
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

    /* ===== ACTIVITY LOG ===== */
    if ($result) {

        include_once("class.legal_activity_log.php");
        $activity = new LegalActivityLog();

        $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;

        if ($loggedUserId) {
            $activity->logActivity(
                'DISABLE',                         // action
                'legal_document_type',             // module
                $loggedUserId,                     // user
                "Disabled Document Type ID: $id",  // message
                $id                                // reference id
            );
        }
    }

    return $result;
}
    }
