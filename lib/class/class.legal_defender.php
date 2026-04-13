<?php
class Defender extends dbcon
{
    ################	MEMBER FUNCTIONS SECTION	##############
    function manage_defender($data = '', $id = '')
    {
        $params = array();
        $Sqlcmd = "INSERT INTO";
        $Sqlcmd = $Sqlcmd . " legal_defender SET ";
        $Sqlcmd = $Sqlcmd . " parent_id=:parent_id";
        $params['parent_id'] = $data['parent_id'];
        $Sqlcmd = $Sqlcmd . " ,parent_type=:parent_type";
        $params['parent_type'] = $data['parent_type'];
        $Sqlcmd = $Sqlcmd . " ,name=:name";
        $params['name'] = $data['name'];
        $Sqlcmd = $Sqlcmd . " ,contact_number=:contact_number";
        $params['contact_number'] = $data['contact_number'];
        $Sqlcmd = $Sqlcmd . " ,email=:email";
        $params['email'] = $data['email'];
      
        $Sqlcmd = $Sqlcmd . " ,create_by=:create_by";
        $params['create_by'] = $data['create_by'];
        $Sqlcmd = $Sqlcmd . " ,create_on=:create_on";
        $params['create_on'] = $data['create_on'];
        if ($id) {
            $Sqlcmd = $Sqlcmd . " ,update_by=:update_by";
            $params['update_by'] = $data['update_by'];
            $Sqlcmd = $Sqlcmd . " ,update_on=:update_on";
            $params['update_on'] = $data['update_on'];
        }
        //echo $this->get_query($Sqlcmd, $params);  exit;
        $this->_inserted_id = $this->mysqlInsertid();
        //return $this->Query($Sqlcmd, $params);

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
                    'legal_defender',                      // module/table
                    $loggedUserId,                     // user id
                    $isUpdate
                        ? "Updated Defender ID: $id"
                        : "Created Defender ID: $id",
                    $id                                // reference id
                );
            }
        }
        
        return $result;
        
    }


    
    function get_defender($id = '', $parent_id = '', $parent_type = '')
    {
        //echo $limit; echo $offset; exit;
        $params = array();
        $Sqlcmd = "SELECT * FROM legal_defender  WHERE 1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND legal_defender.id=:id";
            $params['id'] = $id;
        }
        if ($parent_id) {
            $Sqlcmd = $Sqlcmd . " AND legal_defender.parent_id=:parent_id";
            $params['parent_id'] = $parent_id;
        }
        if ($parent_type) {
            $Sqlcmd = $Sqlcmd . " AND legal_defender.parent_type=:parent_type";
            $params['parent_type'] = $parent_type;
        }
        $Sqlcmd = $Sqlcmd . " AND legal_defender.status=:statusIs";
        $params['statusIs'] = 'A';
        //echo $this->get_query($Sqlcmd, $params); exit;
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function Delete_Defender($id = '', $data = '')
    {
        $params = array();
        $Sqlcmd = "UPDATE";
        $Sqlcmd = $Sqlcmd . " legal_defender SET ";
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
        $this->_output_alert = "Ok";
        $this->_last_query = $Sqlcmd;
        //echo $this->get_query($Sqlcmd, $params);  exit;
        //$this->_inserted_id = $this->mysqlInsertid();
        $result = $this->Query($Sqlcmd, $params);

        if ($result) {
        
            include_once("class.legal_activity_log.php");
            $activity = new LegalActivityLog();
        
            // logged in user
            $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;
        
            if ($loggedUserId) {
                $activity->logActivity(
                    'DISABLE',                     // action
                    'legal_defender',                  // module/table
                    $loggedUserId,                 // user id
                    "Defendant disabled (ID: $id)",     // message
                    $id                            // reference id
                );
            }
        }
        
        return $result;
            }
    }//end function