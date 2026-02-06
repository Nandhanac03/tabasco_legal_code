<?php
# Name: class.login.php
# File Description: login class
class Login extends dbcon {
    var $_user_id;
    var $_user_name;
    var $_user_type;
    var $_user_type_name;
    var $_user_password;
    var $_user_permitted_action;
    var $_user_last_login;
    var $_login_authentication_msg;

    var $_user_sa;
    ################	MEMBER FUNCTIONS SECTION	##############
    /**
     * Summary of MainLoginAuthentication
     * Used for login of user Type with 5,7,8,9
     */
    function MainLoginAuthentication($user_name = '', $user_password = '', $user_type_ids = []) {
        // || empty($user_type_ids)
        if (empty($user_name) || empty($user_password)) {
            return false; // Early return for invalid inputs
        }
        // Generate named placeholders: :type_0, :type_1, etc.
        $placeholders = [];
        $params = [
            ':user_status'    => 'A',
            ':user_loginname' => $user_name,
            ':user_password' =>$user_password,
        ];

            //     foreach ($user_type_ids as $index => $type_id) {
            // $placeholder = ":type_$index";
            // $placeholders[] = $placeholder;
            // $params[$placeholder] = $type_id;
            //  }


        $Sqlcmd = "
            SELECT users.*,usertype_title
            FROM users
            JOIN usertype ON usertype.usertype_Id=users.user_typeId AND user_legal_access='Y'
            WHERE user_status = :user_status
              AND user_loginname = :user_loginname
              AND user_password =:user_password
            LIMIT 1";
        //AND user_typeId IN (" . implode(',', $placeholders) . ")
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        $this->_last_query = $Sqlcmd;
        if ($this->_num_rows > 0) {
            $row = (object)$this->_result[0];
           // if (password_verify($user_password, $row->user_password)) {
                $this->_login_authentication_msg    = "success";
                $this->_user_id                     = $row->user_Id;
                $this->_user_name                   = stripslashes($row->user_name);
                $this->_user_type                   = $row->user_typeId;
                $this->_user_type_name              = $row->usertype_title;
                $this->_user_sa                     = $row->user_sa;
                return $this->_result;
          //  }
        }
        $this->_login_authentication_msg = "Invalid credentials";
        return false;
    }
        function Agencies_Login_Authentication($user_name = '', $user_password = '') {
    if (empty($user_name) || empty($user_password)) {
        $this->_login_authentication_msg = "Missing username or password";
        return false;
    }
    // Prepare parameters
    $params = [
        ':status'    => 'A',
        ':user_name' => $user_name
    ];
    $Sqlcmd = "
        SELECT * FROM legal_agencies_login
        WHERE status = :status
        AND user_name = :user_name
        LIMIT 1
    ";
    $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    $this->_last_query = $Sqlcmd;
    if ($this->_num_rows > 0) {
        $row = (object)$this->_result[0];
        // Decrypt stored password and compare
        $decryptedPassword = decryptPassword($row->password, secretKey); // Decrypt DB password, not input
        if ($user_password === $decryptedPassword) {
            $this->_login_authentication_msg = "success";
            $this->_user_id                  = $row->user_id;
            $this->_user_name                = stripslashes($row->user_name);
            $this->_user_type                = $row->user_type;
            return $this->_result;
        }
    }
    $this->_login_authentication_msg = "Invalid credentials";
    return false;
}
}
//END CLASS