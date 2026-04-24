<?php
class Item extends dbcon {
    ################	MEMBER FUNCTIONS SECTION	##############
    function Add_Item_Details($data='',$item_id='') {
        $params = array();
        if($item_id>0){
            $Sqlcmd = "UPDATE";
        }else{
            $Sqlcmd = "INSERT INTO";
        }
        $Sqlcmd = $Sqlcmd . " distributor_pl SET ";
        $Sqlcmd = $Sqlcmd . " ITEM_NUMBER=:ITEM_NUMBER";
        $params['ITEM_NUMBER'] = $data['ITEM_NUMBER'];
        $Sqlcmd = $Sqlcmd . " ,DESCRIPTION=:DESCRIPTION";
        $params['DESCRIPTION'] = $data['DESCRIPTION'];
        $Sqlcmd = $Sqlcmd . " ,ITEM_STATUS=:ITEM_STATUS";
        $params['ITEM_STATUS'] = $data['ITEM_STATUS'];
        $Sqlcmd = $Sqlcmd . " ,MEA_SOURCE_ORG=:MEA_SOURCE_ORG";
        $params['MEA_SOURCE_ORG'] = $data['MEA_SOURCE_ORG'];
        $Sqlcmd = $Sqlcmd . " ,LIST_PRICE_USD=:LIST_PRICE_USD";
        $params['LIST_PRICE_USD'] = $data['LIST_PRICE_USD'];
        $Sqlcmd = $Sqlcmd . " ,START_DATE_ACTIVE=:START_DATE_ACTIVE";
        $params['START_DATE_ACTIVE'] = $data['START_DATE_ACTIVE'];
        $Sqlcmd = $Sqlcmd . " ,END_DATE_ACTIVE=:END_DATE_ACTIVE";
        $params['END_DATE_ACTIVE'] = $data['END_DATE_ACTIVE'];
        $Sqlcmd = $Sqlcmd . " ,LAST_UPDATE_DATE=:LAST_UPDATE_DATE";
        $params['LAST_UPDATE_DATE'] = $data['LAST_UPDATE_DATE'];
        $Sqlcmd = $Sqlcmd . " ,CREATION_DATE=:CREATION_DATE";
        $params['CREATION_DATE'] = $data['CREATION_DATE'];
        if($item_id>0){
            $Sqlcmd = $Sqlcmd . " WHERE  item_id=:item_id";
            $params['item_id'] = $item_id;
        }
        $this->_output_alert = "Ok";
        $this->_last_query = $Sqlcmd;
        //echo $this->get_query($Sqlcmd, $params);  exit;
        //$this->_inserted_id = $this->mysqlInsertid();
        return $this->Query($Sqlcmd, $params);
    }//end function
    function Save_Excel_Item_Info($data='',$item_number='') {
        $params = array();
        if($item_number!=""){
            $Sqlcmd = "UPDATE";
        }else{
            $Sqlcmd = "INSERT INTO";
        }
        $Sqlcmd = $Sqlcmd . " distributor_pl SET ";
        $Sqlcmd = $Sqlcmd . " DESCRIPTION=:DESCRIPTION";
        $params['DESCRIPTION'] = $data['DESCRIPTION'];
        $Sqlcmd = $Sqlcmd . " ,ITEM_STATUS=:ITEM_STATUS";
        $params['ITEM_STATUS'] = $data['ITEM_STATUS'];
        $Sqlcmd = $Sqlcmd . " ,LIST_PRICE_USD=:LIST_PRICE_USD";
        $params['LIST_PRICE_USD'] = $data['LIST_PRICE_USD'];
        $Sqlcmd = $Sqlcmd . " ,START_DATE_ACTIVE=:START_DATE_ACTIVE";
        $params['START_DATE_ACTIVE'] = $data['START_DATE_ACTIVE'];
        $Sqlcmd = $Sqlcmd . " ,LAST_UPDATE_DATE=:LAST_UPDATE_DATE";
        $params['LAST_UPDATE_DATE'] = $data['LAST_UPDATE_DATE'];
        $Sqlcmd = $Sqlcmd . " ,CREATION_DATE=:CREATION_DATE";
        $params['CREATION_DATE'] = $data['CREATION_DATE'];
        $Sqlcmd = $Sqlcmd . " ,MEA_SOURCE_ORG=:MEA_SOURCE_ORG";
        $params['MEA_SOURCE_ORG'] = $data['MEA_SOURCE_ORG'];
        if($item_number!=""){
            $Sqlcmd = $Sqlcmd . " WHERE  ITEM_NUMBER=:ITEM_NUMBER";
            $params['ITEM_NUMBER'] = $item_number;
        }else{
            $Sqlcmd = $Sqlcmd . ",ITEM_NUMBER=:ITEM_NUMBER";
            $params['ITEM_NUMBER'] = $data['ITEM_NUMBER'];
        }
        $this->_output_alert = "Ok";
        $this->_last_query = $Sqlcmd;
        //echo $this->get_query($Sqlcmd, $params);  exit;
        //$this->_inserted_id = $this->mysqlInsertid();
        return $this->Query($Sqlcmd, $params);
    }//end function
    function Get_Item_Details($name = '', $search = '', $status = '',$action_id="",$offset='',$limit='') {
        //echo $limit; echo $offset; exit;
        $params = array();
        $Sqlcmd = "SELECT * FROM distributor_pl C WHERE 1";
        if ($name) {
            $Sqlcmd = $Sqlcmd . " AND C.ITEM_NUMBER=:ITEM_NUMBER";
            $params['ITEM_NUMBER'] = $name;
        }
        if ($search) {
            $Sqlcmd = $Sqlcmd . " AND ( C.ITEM_NUMBER LIKE :search OR C.DESCRIPTION LIKE :search1 )";
            $params['search'] = '%' . $search . '%';
            $params['search1'] = '%' . $search . '%';
        }
        if ($status) {
            $Sqlcmd = $Sqlcmd . " AND C.ITEM_STATUS=:status";
            $params['status'] = $status;
        }
        if ($action_id) {
            $Sqlcmd = $Sqlcmd . " AND C.item_id!=:action_id";
            $params['action_id'] = $action_id;
        }
        if($limit>0){
            $Sqlcmd = $Sqlcmd . " ORDER BY C.ITEM_NUMBER ASC limit $offset,$limit";
        }else{
            $Sqlcmd = $Sqlcmd . " ORDER BY C.ITEM_NUMBER ASC";
        }
        //echo $this->get_query($Sqlcmd, $params); exit;
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function Get_Item_Details_TOTAL_COUNT($name = '', $search = '', $status = '',$action_id="",$offset='',$limit='') {
        //echo $limit; echo $offset; exit;
        $params = array();
        $Sqlcmd = "SELECT COUNT(*) AS TOTAL_RECORDS FROM distributor_pl C WHERE 1";
        if ($name) {
            $Sqlcmd = $Sqlcmd . " AND C.ITEM_NUMBER=:ITEM_NUMBER";
            $params['ITEM_NUMBER'] = $name;
        }
        if ($search) {
            $Sqlcmd = $Sqlcmd . " AND ( C.ITEM_NUMBER LIKE :search OR C.DESCRIPTION LIKE :search1 )";
            $params['search'] = '%' . $search . '%';
            $params['search1'] = '%' . $search . '%';
        }
        if ($status) {
            $Sqlcmd = $Sqlcmd . " AND C.ITEM_STATUS=:status";
            $params['status'] = $status;
        }
        if ($action_id) {
            $Sqlcmd = $Sqlcmd . " AND C.item_id!=:action_id";
            $params['action_id'] = $action_id;
        }
        if($limit>0){
            $Sqlcmd = $Sqlcmd . " ORDER BY C.ITEM_NUMBER ASC limit $offset,$limit";
        }else{
            $Sqlcmd = $Sqlcmd . " ORDER BY C.ITEM_NUMBER ASC";
        }
        //echo $this->get_query($Sqlcmd, $params); exit;
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function Get_Item_Edit($item_id='') {
        $params = array();
        $Sqlcmd = "SELECT * FROM distributor_pl C WHERE 1";
        if ($item_id) {
            $Sqlcmd = $Sqlcmd . " AND C.item_id=:item_id";
            $params['item_id'] = $item_id;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
    function Get_Total_Items_Count() {
        $params = array();
        $Sqlcmd = "SELECT COUNT(*) AS TOTAL_ITEMS_COUNT FROM distributor_pl C WHERE 1";
        if ($status) {
            $Sqlcmd = $Sqlcmd . " AND C.status=:status";
            $params['status'] = $status;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }
//END FUNCTION
    function get_distributor_basic_info($id = '', $name = '', $search = '', $action_id = '') {
        $params = array();
        $Sqlcmd = "SELECT distributor_id,dist_lastname,dist_email,distributor_name FROM distributors WHERE 1";
        if ($id) {
            $Sqlcmd = $Sqlcmd . " AND distributor_id=:distributor_id";
            $params['distributor_id'] = $id;
        }
        $Sqlcmd = $Sqlcmd . " AND status='A'";
        $Sqlcmd = $Sqlcmd . " ORDER BY distributor_name ASC";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }//END FUNCTION
    function Add_Item_Cart($cart_item_number,$cart_distributor_id) {
        if($cart_distributor_id>0 && $cart_item_number!=""){
            $params = array();
            $Sqlcmd = "INSERT INTO";
            $Sqlcmd = $Sqlcmd . " cart SET ";
            $Sqlcmd = $Sqlcmd . " status=:status";
            $params['status'] = 'A';
            $Sqlcmd = $Sqlcmd . " ,created=:created";
            $params['created'] = date('Y-m-d H:i:s');
            if ($cart_distributor_id>0) {
                $Sqlcmd = $Sqlcmd . " ,cart_distributor_id=:cart_distributor_id";
                $params['cart_distributor_id'] = $cart_distributor_id;
            }
            if ($cart_item_number) {
                $Sqlcmd = $Sqlcmd . " ,cart_item_number=:cart_item_number";
                $params['cart_item_number'] = $cart_item_number;
            }
            $this->_output_alert = "Ok";
            $this->_last_query = $Sqlcmd;
            //$this->_inserted_id = $this->mysqlInsertid();
            return $this->Query($Sqlcmd, $params);
        }else{
            return false;
        }
    }//end function
    function get_cart_basic_info($distributor_id = '') {
        if($distributor_id>0){
            $params = array();
            $Sqlcmd = "SELECT ITEM_NUMBER,DESCRIPTION,ITEM_STATUS,MEA_SOURCE_ORG,LIST_PRICE_USD,cart_distributor_id,cart_id FROM distributor_pl D INNER JOIN cart C ON D.ITEM_NUMBER=C.cart_item_number WHERE 1";
            if ($distributor_id) {
                $Sqlcmd = $Sqlcmd . " AND cart_distributor_id=:distributor_id";
                $params['distributor_id'] = $distributor_id;
            }
            $Sqlcmd = $Sqlcmd . " ORDER BY cart_id DESC";
            $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
            if ($this->_num_rows > 0) {
                return $this->_result;
            } else
                return false;
        }else{
            return false;
        }
    }//END FUNCTION
    function check_item_exists_in_cart($cart_item_number='',$distributor_id = '') {
        if($distributor_id>0 && $cart_item_number!=""){
            $params = array();
            $Sqlcmd = "SELECT cart_item_number,cart_id,cart_distributor_id FROM cart WHERE 1";
            if ($distributor_id) {
                $Sqlcmd = $Sqlcmd . " AND cart_distributor_id=:distributor_id";
                $params['distributor_id'] = $distributor_id;
            }
            if ($cart_item_number) {
                $Sqlcmd = $Sqlcmd . " AND cart_item_number=:cart_item_number";
                $params['cart_item_number'] = $cart_item_number;
            }
            //echo $this->get_query($Sqlcmd, $params);
            $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
            if ($this->_num_rows > 0) {
                return false;
            } else
                return true;
        }else{
            return false;
        }
    }//END FUNCTION
    function Save_Excel_Download_History($filename,$distributor_id,$type=1) {
        if($distributor_id>0 && $filename!=""){
            $params = array();
            $Sqlcmd = "INSERT INTO";
            $Sqlcmd = $Sqlcmd . " download_history SET ";
            $Sqlcmd = $Sqlcmd . " status=:status";
            $params['status'] = 'A';
            $Sqlcmd = $Sqlcmd . " ,download_on=:created";
            $params['created'] = date('Y-m-d H:i:s');
            if ($distributor_id>0) {
                $Sqlcmd = $Sqlcmd . " ,distributor_id=:distributor_id";
                $params['distributor_id'] = $distributor_id;
            }
            if ($filename) {
                $Sqlcmd = $Sqlcmd . " ,filename=:filename";
                $params['filename'] = $filename;
            }
            if($type>0){
                $Sqlcmd = $Sqlcmd . " ,type=:type";
                $params['type'] = $type;
            }
            $this->_output_alert = "Ok";
            $this->_last_query = $Sqlcmd;
            //$this->_inserted_id = $this->mysqlInsertid();
            return $this->Query($Sqlcmd, $params);
        }else{
            return false;
        }
    }//end function
    function Get_Download_History($distributor_id = '') {
        $params = array();
        $Sqlcmd = "SELECT * FROM download_history WHERE 1";
        if ($distributor_id) {
            $Sqlcmd = $Sqlcmd . " AND distributor_id=:distributor_id";
            $params['distributor_id'] = $distributor_id;
        }
        $Sqlcmd = $Sqlcmd . " ORDER BY download_id DESC";
        //echo $this->get_query($Sqlcmd, $params);
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return true;
    }//END FUNCTION
    function Delete_Cart_Details($distributor_id = '') {
        if ($distributor_id > 0) {
            $params = array();
            $Sqlcmd = "DELETE from cart WHERE cart_distributor_id=:distributor_id";
            $params['distributor_id'] = $distributor_id;
            $this->_last_query = $Sqlcmd;
            return $this->Query($Sqlcmd, $params);
        } else {
            return false;
        }
    }
    function Delete_Cart_Item_Details($distributor_id = '',$cart_item_number='') {
        if ($distributor_id > 0 && $cart_item_number!="") {
            $params = array();
            $Sqlcmd = "DELETE from cart WHERE cart_distributor_id=:distributor_id and cart_item_number=:cart_item_number";
            $params['distributor_id'] = $distributor_id;
            $params['cart_item_number'] = $cart_item_number;

            //echo $this->get_query($Sqlcmd, $params); exit;
            return $this->Query($Sqlcmd, $params);
        } else {
            return false;
        }
    }
    function get_items_number_array() {
        $params = array();
        $Sqlcmd = "SELECT ITEM_NUMBER FROM distributor_pl order by ITEM_NUMBER ASC";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            if($this->_result){
                $result_array   =   [];
                foreach($this->_result as $record){
                    $result_array[$record['ITEM_NUMBER']]    =   $record['ITEM_NUMBER'];
                }
                return $result_array;
            }
        } else
            return false;
    }//END FUNCTION
    function Delete_Item_Details($item_id = '') {
        if ($item_id > 0) {
            $params = array();
            $Sqlcmd = "DELETE from distributor_pl WHERE item_id=:item_id";
            $params['item_id'] = $item_id;
            $this->_last_query = $Sqlcmd;
            return $this->Query($Sqlcmd, $params);
        } else {
            return false;
        }
    }
    function Delete_Item_NUMBER($item_number = '') {
        if ($item_number) {
            $params = array();
            $Sqlcmd = "DELETE from distributor_pl WHERE ITEM_NUMBER=:ITEM_NUMBER";
            $params['ITEM_NUMBER'] = $item_number;
            $this->_last_query = $Sqlcmd;
            return $this->Query($Sqlcmd, $params);
        } else {
            return false;
        }
    }
    function Get_last_item_updated() {
        $params = array();
        $Sqlcmd = "SELECT LAST_UPDATE_DATE FROM distributor_pl order by LAST_UPDATE_DATE DESC LIMIT 1";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else{
            return true;
        }
    }//END FUNCTION
    function get_status() {
        $params = array();
        $Sqlcmd = "SELECT * FROM trane_status order by status_id ASC";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            $result_array   =   [];
            foreach($this->_result as $record){
                $result_array[$record['status_text']]['status_text']   =   $record['status_text'];
                $result_array[$record['status_text']]['color']   =   $record['color'];
            }
            return $result_array;
        } else{
            return true;
        }
    }//END FUNCTION
}//end class