<?php
class CaseHearing extends dbcon
{
    ################	MEMBER FUNCTIONS SECTION	##############
    function save_hearing($data = [], $id = '')
    {
        $params = [];
        $set = [];

        if (!empty($data['case_id'])) {
            $set[] = "case_id = :case_id";
            $params['case_id'] = $data['case_id'];
        }

        if (!empty($data['file'])) {
            $set[] = "file = :file";
            $params['file'] = $data['file'];
        }

        if (!empty($data['hearing_date'])) {
            $set[] = "hearing_date = :hearing_date";
            $params['hearing_date'] = $data['hearing_date'];
        }

        if (!empty($data['hearing_feedback_date'])) {
            $set[] = "hearing_feedback_date = :hearing_feedback_date";
            $params['hearing_feedback_date'] = $data['hearing_feedback_date'];
        }

        if (!empty($data['hearing_feedback'])) {
            $set[] = "hearing_feedback = :hearing_feedback";
            $params['hearing_feedback'] = $data['hearing_feedback'];
        }

        if (!$id) {
            // INSERT fields
            $set[] = "created_on = :created_on";
            $set[] = "created_id = :created_id";
            $set[] = "status = :status";

            $params['created_on'] = $data['created_on'];
            $params['created_id'] = $data['created_id'];
            $params['status'] = $data['status'];

            $sql = "INSERT INTO legal_case_hearing SET " . implode(', ', $set);
        } else {
            // UPDATE fields
            $set[] = "updated_on = :updated_on";
            $set[] = "updated_id = :updated_id";

            $params['updated_on'] = $data['updated_on'];
            $params['updated_id'] = $data['updated_id'];

            $sql = "UPDATE legal_case_hearing SET " . implode(', ', $set) . " WHERE id = :id";
            $params['id'] = $id;
        }

        $this->_last_query = $sql;
        return $this->Query($sql, $params);
    }

    function get_hearing($id = '', $case_id = '', $type = '')
    {
        $params = array();
        $Sqlcmd = "SELECT * FROM legal_case_hearing WHERE 1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND id=:id";
            $params['id'] = $id;
        }
        if ($case_id) {
            $Sqlcmd = $Sqlcmd . " AND case_id=:case_id";
            $params['case_id'] = $case_id;
        }
        $Sqlcmd = $Sqlcmd . " AND status=:status";
        $params['status'] = 'A';
        $Sqlcmd = $Sqlcmd . " ORDER BY id DESC";
        //echo $this->get_query($Sqlcmd, $params); exit;
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function delete_hearing($data = '', $id = '')
    {
        $params = array();
        $Sqlcmd = "UPDATE";
        $Sqlcmd = $Sqlcmd . " legal_case_hearing SET ";
        $Sqlcmd = $Sqlcmd . " status=:status";
        $params['status'] = $data['status'];
        $Sqlcmd = $Sqlcmd . " ,updated_id=:updated_id";
        $params['updated_id'] = $data['updated_id'];
        $Sqlcmd = $Sqlcmd . " ,updated_on=:updated_on";
        $params['updated_on'] = $data['updated_on'];
        if ($id > 0) {
            $Sqlcmd = $Sqlcmd . " WHERE  id=:id";
            $params['id'] = $id;
        }
        return $this->Query($Sqlcmd, $params);
    } //end function
}//end class