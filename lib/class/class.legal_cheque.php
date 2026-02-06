<?php
class Cheque extends dbcon
{
    ################	MEMBER FUNCTIONS SECTION	##############
    function upload_cheque($data = '')
    {
        $params = array();
        $Sqlcmd = "INSERT INTO";
        $Sqlcmd = $Sqlcmd . " legal_cheque_upload SET ";
        $Sqlcmd = $Sqlcmd . " add_type=:add_type";
        $params['add_type'] = $data['add_type'];
        $Sqlcmd = $Sqlcmd . ", upload_date=:upload_date";
        $params['upload_date'] = $data['upload_date'];
        $Sqlcmd = $Sqlcmd . " ,amount=:amount";
        $params['amount'] = $data['amount'];
        $Sqlcmd = $Sqlcmd . " ,cheque_name=:cheque_name";
        $params['cheque_name'] = $data['cheque_name'];
        $Sqlcmd = $Sqlcmd . " ,notes=:notes";
        $params['notes'] = $data['notes'];
        $Sqlcmd = $Sqlcmd . " ,parent_id=:parent_id";
        $params['parent_id'] = $data['parent_id'];
        $Sqlcmd = $Sqlcmd . " ,type=:type";
        $params['type'] = $data['type'];

        $Sqlcmd = $Sqlcmd . " ,cheque_number=:cheque_number";
        $params['cheque_number'] = $data['cheque_number'];
        $Sqlcmd = $Sqlcmd . " ,cheque_bank=:cheque_bank";
        $params['cheque_bank'] = $data['cheque_bank'];
        $Sqlcmd = $Sqlcmd . " ,cheque_bounced_date=:cheque_bounced_date";
        $params['cheque_bounced_date'] = $data['cheque_bounced_date'];

        $Sqlcmd = $Sqlcmd . " ,create_by=:create_by";
        $params['create_by'] = $data['create_by'];
        $Sqlcmd = $Sqlcmd . " ,create_on=:create_on";
        $params['create_on'] = $data['create_on'];
        $this->_output_alert = "Ok";
        $this->_last_query = $Sqlcmd;
        // echo $this->get_query($Sqlcmd, $params);  exit;
        $this->_inserted_id = $this->mysqlInsertid();
        return $this->Query($Sqlcmd, $params);
    } //end function
    function get_cheque($id = '', $parent_id = '', $type = '', $add_type = '')
    {
        //echo $limit; echo $offset; exit;
        $params = array();
        $Sqlcmd = "SELECT * FROM legal_cheque_upload C WHERE 1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND C.id=:id";
            $params['id'] = $id;
        }
        if ($parent_id) {
            $Sqlcmd = $Sqlcmd . " AND C.parent_id=:parent_id";
            $params['parent_id'] = $parent_id;
        }
        if ($type) {
            $Sqlcmd = $Sqlcmd . " AND C.type=:type";
            $params['type'] = $type;
        }
        if ($add_type) {
            $Sqlcmd = $Sqlcmd . " AND C.add_type=:add_type";
            $params['add_type'] = $add_type;
        }
        $Sqlcmd = $Sqlcmd . " AND C.status=:status";
        $params['status'] = 'A';
        //echo $this->get_query($Sqlcmd, $params); exit;
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function get_cheque_total($parent_id, $type)
    {
        //echo $limit; echo $offset; exit;
        $params = array();
        $Sqlcmd = "SELECT SUM(CASE WHEN add_type = 1 THEN amount ELSE 0 END) AS Total1,
    SUM(CASE WHEN add_type = 2 THEN amount ELSE 0 END) AS Total2
FROM
    legal_cheque_upload
WHERE
    legal_cheque_upload.status = 'A'";
        if ($parent_id) {
            $Sqlcmd = $Sqlcmd . " AND legal_cheque_upload.parent_id=:parent_id";
            $params['parent_id'] = $parent_id;
        }
        if ($type) {
            $Sqlcmd = $Sqlcmd . " AND legal_cheque_upload.type=:type";
            $params['type'] = $type;
        }
        //echo $this->get_query($Sqlcmd, $params); exit;
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function Delete_Cheque($id = '', $data = '')
    {
        $params = array();
        $Sqlcmd = "UPDATE";
        $Sqlcmd = $Sqlcmd . " legal_cheque_upload SET ";
        $Sqlcmd = $Sqlcmd . " status=:status";
        $params['status'] = $data['status'];
        $Sqlcmd = $Sqlcmd . " ,update_by=:update_by";
        $params['update_by'] = $data['update_by'];
        $Sqlcmd = $Sqlcmd . " ,update_on=:update_on";
        $params['update_on'] = $data['update_on'];
        if ($id > 0) {
            $Sqlcmd = $Sqlcmd . " WHERE  id=:id";
            $params['id'] = $id;
        }
        return $this->Query($Sqlcmd, $params);
    } //end function


}//end class