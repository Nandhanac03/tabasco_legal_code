
<?php
class ActionSubcategory extends dbcon
{
    function save_subcategory($data = [], $id = '')
    {
        $params = [];
        if ($id) {
            $SqlCmd = "UPDATE";
        } else {
            $SqlCmd = "INSERT INTO";
        }
        $SqlCmd .= " legal_action_subcategory set";
        if ($data['title']) {
            $SqlCmd .= " title =:title";
            $params['title'] = $data['title'];
        }
        if ($data['description']) {
            $SqlCmd .= ", description =:description";
            $params['description'] = $data['description'];
        }
        if ($data['status']) {
            $SqlCmd .= ", status =:status";
            $params['status'] = $data['status'];
        }
        if ($id == '') {
            $SqlCmd .= ", created_by =:created_by";
            $params['created_by'] = $data['created_by'];
            $SqlCmd .= ", created_on =:created_on";
            $params['created_on'] = $data['created_on'];
        }
        $SqlCmd .= ", updated_by =:updated_by";
        $params['updated_by'] = $data['updated_by'];
        $SqlCmd .= ", updated_on =:updated_on";
        $params['updated_on'] = $data['updated_on'];
        if ($id) {
            $SqlCmd .= " WHERE id=$id";
        }
        $this->_output_alert = 'Ok';
        $this->_last_query = $SqlCmd;
        $this->_inserted_id = $this->mysqlInsertid();
        return $this->Query($SqlCmd, $params);
    }
    function get_subcategory($id = '', $title = '', $not_id = '', $search = '', $limit = '', $offset = '')
    {
        $params = [];
        $Sqlcmd = "SELECT * FROM legal_action_subcategory WHERE 1";
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
    function disable_subcategory($data = [], $id = '')
    {
        $params = [];
        $Sqlcmd = "UPDATE legal_action_subcategory SET";
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
