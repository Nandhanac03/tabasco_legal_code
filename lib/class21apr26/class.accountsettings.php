<?php
class accountsettings extends dbcon {
    ################	MEMBER FUNCTIONS SECTION	##############
    function getsuperadmininfo($id = '', $email = '', $action_id = '') {
        $params = array();
        $Sqlcmd = "SELECT * FROM kr_admin_accountsettings WHERE 1";
        if ($id){
            $Sqlcmd = $Sqlcmd . " and acc_id=:acc_id";
            $params['acc_id'] = $id;
        }
        if ($email){
            $Sqlcmd = $Sqlcmd . " and user_email=:user_email";
            $params['user_email'] = $email;
        }
        if ($action_id){
            $Sqlcmd = $Sqlcmd . " and user_login_id!=:action_id";
            $params['action_id'] = $action_id;
        }
        $Sqlcmd = $Sqlcmd . " ORDER BY acc_id";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            $i = 0;
            foreach ($this->_result as $rec) {
                $row = (object) $rec;
                $records[$i]['acc_id'] = $row->acc_id;
                $records[$i]['user_email'] = $row->user_email;
                $records[$i]['user_contact'] = $row->user_contact;
                $records[$i]['user_mobile'] = $row->user_mobile;
                $records[$i]['user_login_id'] = $row->user_login_id;
                $records[$i]['threshold_notify_email'] = $row->threshold_notify_email;
                $records[$i]['threshold_warning_limit'] = $row->threshold_warning_limit;
                $i++;
            }
            return $records;
        } else
            return false;
    }
//END FUNCTION
    function UpdateSuperAdmininfo($user_email = '', $user_contact = '', $user_mobile = '', $threshold_notify_email = '', $threshold_warning_limit = '') {
        $params = array();
        $Sqlcmd = "UPDATE kr_admin_accountsettings SET  user_email=:user_email,user_contact=:user_contact,user_mobile=:user_mobile,threshold_notify_email=:threshold_notify_email,threshold_warning_limit=:threshold_warning_limit WHERE acc_id=1";
        $params['user_email'] = $user_email;
        $params['user_contact'] = $user_contact;
        $params['user_mobile'] = $user_mobile;
        $params['threshold_notify_email'] = $threshold_notify_email;
        $params['threshold_warning_limit'] = $threshold_warning_limit;
        $this->_last_query = $Sqlcmd;
        return $this->Query($Sqlcmd, $params);
    }
    function UpdateThresholdInfo($threshold_notify_email = '', $threshold_warning_limit = '') {
        $params = array();
        $Sqlcmd = "UPDATE kr_admin_accountsettings SET threshold_notify_email=:threshold_notify_email,threshold_warning_limit=:threshold_warning_limit WHERE acc_id=1";
        $params['threshold_notify_email'] = $threshold_notify_email;
        $params['threshold_warning_limit'] = $threshold_warning_limit;
        $this->_last_query = $Sqlcmd;
        return $this->Query($Sqlcmd, $params);
    }
}
//END CLASS