<?php
class Masterdata extends dbcon {
################	MEMBER FUNCTIONS SECTION	##############
function storeDocumentType ($data='') {
    $params = array();
    $Sqlcmd = "INSERT INTO";
    $Sqlcmd = $Sqlcmd . " legal_document_type SET ";
    $Sqlcmd = $Sqlcmd . " title=:title";
    $params['title'] = $data['title'];
    $Sqlcmd = $Sqlcmd . " ,create_by=:create_by";
    $params['create_by'] = $data['create_by'];
    $Sqlcmd = $Sqlcmd . " ,create_on=:create_on";
    $params['create_on'] = $data['create_on'];
    $this->_output_alert = "Ok";
    $this->_last_query = $Sqlcmd;
    //echo $this->get_query($Sqlcmd, $params);  exit;
    $this->_inserted_id = $this->mysqlInsertid();
    return $this->Query($Sqlcmd, $params);
}//end function
function get_DocumentType($id='') {
    //echo $limit; echo $offset; exit;
    $params = array();
    $Sqlcmd = "SELECT * FROM legal_document_type WHERE 1";
    if ($id) {
        $Sqlcmd = $Sqlcmd . " AND id=:id";
        $params['id'] = $id;
    }
    $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    if ($this->_num_rows > 0) {
        return $this->_result;
    } else
        return false;
}
}//end class