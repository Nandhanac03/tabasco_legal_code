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
    $result = $this->Query($Sqlcmd, $params);

    // ✅ get inserted document id
    if ($result) {
        $docId = $this->mysqlInsertid();

        /* ===== ACTIVITY LOG ===== */
        include_once("class.legal_activity_log.php");
        $activity = new LegalActivityLog();

        $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;

        if ($loggedUserId) {
            $activity->logActivity(
                'UPLOAD',                         // action
                'legal_document',                 // module
                $loggedUserId,                    // user id
                "Uploaded document: {$data['name']} (ID: $docId)", 
                $docId                            // reference id
            );
        }
    }

    return $result;
}
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
function Delete_document($id = '', $data = [])
{
    if (empty($id) || $id <= 0) {
        return false;
    }

    $params = [];

    $Sqlcmd = "UPDATE legal_document SET
               status    = :status,
               update_by = :update_by,
               update_on = :update_on
               WHERE id  = :id";

    $params['status']    = $data['status'];   // usually 'D'
    $params['update_by'] = $data['update_by'];
    $params['update_on'] = $data['update_on'];
    $params['id']        = $id;

    $this->_last_query = $Sqlcmd;

    $result = $this->Query($Sqlcmd, $params);

    /* ===== ACTIVITY LOG ===== */
    if ($result) {

        include_once("class.legal_activity_log.php");
        $activity = new LegalActivityLog();

        $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;

        if ($loggedUserId) {
            $activity->logActivity(
                'DELETE',                              // action
                'legal_document',                      // module
                $loggedUserId,                         // user id
                "Deleted Document ID: $id",            // message
                $id                                    // reference id
            );
        }
    }

    return $result;
}

}//end class