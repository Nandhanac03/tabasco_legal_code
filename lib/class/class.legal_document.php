<?php
class processDocument extends dbcon {
################	MEMBER FUNCTIONS SECTION	##############
function upload_document($data='') {
    $params = array();
    $Sqlcmd = "INSERT INTO";
    $Sqlcmd = $Sqlcmd . " legal_document SET ";
    $Sqlcmd = $Sqlcmd . " type_id=:type_id";
    $params['type_id'] = $data['type_id'];
    $Sqlcmd = $Sqlcmd . " ,name=:name";
    $params['name'] = $data['name'];
    $Sqlcmd = $Sqlcmd . " ,description=:description";
    $params['description'] = $data['description'];
    $Sqlcmd = $Sqlcmd . " ,parent_id=:parent_id";
    $params['parent_id'] = $data['parent_id'];
    $Sqlcmd = $Sqlcmd . " ,parent_type=:parent_type";
    $params['parent_type'] = $data['parent_type'];
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
function get_document($id='',$parent_id = '',$parent_type='') {
    //echo $limit; echo $offset; exit;
    $params = array();
    $Sqlcmd = "SELECT legal_document.*,legal_document_type.title as document_type_name FROM legal_document LEFT JOIN legal_document_type ON legal_document_type.id=legal_document.type_id WHERE 1";
    if ($id) {
        $Sqlcmd = $Sqlcmd . " AND legal_document.id=:id";
        $params['id'] = $id;
    }
    if ($parent_id) {
        $Sqlcmd = $Sqlcmd . " AND legal_document.parent_id=:parent_id";
        $params['parent_id'] = $parent_id;
    }
    if ($parent_type) {
        $Sqlcmd = $Sqlcmd . " AND legal_document.parent_type=:parent_type";
        $params['parent_type'] = $parent_type;
    }
    $Sqlcmd = $Sqlcmd . " AND legal_document.status=:status";
    $params['status'] = 'A';
    //echo $this->get_query($Sqlcmd, $params); exit;
    $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    if ($this->_num_rows > 0) {
        return $this->_result;
    } else
        return false;
}
function Delete_document($id='',$data='') {
    $params = array();
    $Sqlcmd = "UPDATE";
    $Sqlcmd = $Sqlcmd . " legal_document SET ";
    $Sqlcmd = $Sqlcmd . " status=:status";
    $params['status'] = $data['status'];
    $Sqlcmd = $Sqlcmd . " ,update_by=:update_by";
    $params['update_by'] = $data['update_by'];
    $Sqlcmd = $Sqlcmd . " ,update_on=:update_on";
    $params['update_on'] = $data['update_on'];
    if($id>0){
        $Sqlcmd = $Sqlcmd . " WHERE  id=:id";
        $params['id'] = $id;
    }
    return $this->Query($Sqlcmd, $params);
}//end function
}//end class