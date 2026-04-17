<?php
class CommonSelection extends dbcon {
################	MEMBER FUNCTIONS SECTION	##############
function get_marketing() {
    $params = array();
    $Sqlcmd = "SELECT user_Id, user_name, usertype_title FROM users LEFT JOIN usertype ON users.user_typeId = usertype.usertype_Id WHERE usertype.usertype_Id=1 AND users.user_status='A' ORDER BY user_name ASC";
    $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    if ($this->_num_rows > 0) {
        return $this->_result;
    } else
        return true;
}//END FUNCTION
function get_all_users($with_out_admin='',$userTypeId='') {
    $params = array();
    $Sqlcmd = "SELECT user_Id, user_name, usertype_title FROM users LEFT JOIN usertype ON users.user_typeId = usertype.usertype_Id WHERE 1";
    if($with_out_admin=='yes'){
        $Sqlcmd = $Sqlcmd." AND users.user_typeId != 0";
    }
    if($userTypeId){
        $Sqlcmd = $Sqlcmd." AND users.user_typeId IN (".$userTypeId.")";
    }
    $Sqlcmd = $Sqlcmd." AND users.user_status='A' ORDER BY users.user_name ASC";
    $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    if ($this->_num_rows > 0) {
        return $this->_result;
    } else
        return true;
}//END FUNCTION
// This function return marketing list from legal client
function get_marketing_legal_client() {
//usertype.usertype_Id = 1 AND
    $params = array();
$Sqlcmd = "SELECT
user_Id,
user_name,
usertype_title
FROM
users
JOIN usertype ON users.user_typeId = usertype.usertype_Id
JOIN legal_client ON legal_client.marketing=users.user_Id
WHERE
 users.user_status = 'A'
GROUP BY legal_client.marketing ORDER BY user_name ASC";
    $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    if ($this->_num_rows > 0) {
        return $this->_result;
    } else
        return true;
}//END FUNCTION
function get_client($customer_Id='',$marketing_Id='') {
    $params = array();
    $Sqlcmd = "SELECT
    customer.customer_Id,
    customer.customer_name,
    customer.customer_mob,
    users.user_name,
    usertype.usertype_title,
customer.customer_addr,
customer.customer_contact_person,customer_contact_desig,customer_contact_mob,customer_website,customer_email,customer_tel,customer_fax,customer_po_box
FROM
    customer
LEFT JOIN users ON users.user_Id = customer.create_Id
LEFT JOIN usertype ON usertype.usertype_Id = users.user_typeId
WHERE
    customer.customer_status = 'A' AND users.user_status = 'A' AND usertype.usertype_status = 'A' ";
    if($customer_Id>0){
        $Sqlcmd                             =   $Sqlcmd." AND  customer.customer_Id=:customer_Id";
        $params['customer_Id']              =   $customer_Id;
    }
    if($marketing_Id>0){
      $Sqlcmd                               =   $Sqlcmd." AND users.user_Id=:marketing_Id";
      $params['marketing_Id']               =   $marketing_Id;
    }
    $Sqlcmd =   $Sqlcmd." ORDER BY users.user_name ASC";
    $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    if ($this->_num_rows > 0) {
        return $this->_result;
    } else
        return true;
}//END FUNCTION









function get_case_client() {
    //usertype.usertype_Id = 1 AND
        $params = array();
    $Sqlcmd = "SELECT
    user_Id,
    user_name,
    usertype_title
    FROM
    users
    JOIN usertype ON users.user_typeId = usertype.usertype_Id
    JOIN legal_client ON legal_client.marketing=users.user_Id
    WHERE
     users.user_status = 'A'
    GROUP BY legal_client.marketing ORDER BY user_name ASC";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return true;
    }





    function get_case_no() {
        //usertype.usertype_Id = 1 AND
            $params = array();
        $Sqlcmd = "SELECT
        user_Id,
        user_name,
        usertype_title
        FROM
        users
        JOIN usertype ON users.user_typeId = usertype.usertype_Id

        WHERE
         users.user_status = 'A'
        GROUP BY legal_client.marketing ORDER BY user_name ASC";
            $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
            if ($this->_num_rows > 0) {
                return $this->_result;
            } else
                return true;
        }
    
















}//end class