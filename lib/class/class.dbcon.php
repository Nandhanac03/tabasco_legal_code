<?php
/*
  PDO SQL Routines by Elmar Hanlhofer 03/09/2018 https://www.plop.at
  Free to use. Comes without warranty.
  ------------------------------------------------------------
  function SQL_Connect    ($user, $pass, $db, $host = "localhost", $charset = "utf8mb4");
  function SQL_Exec       ($pdo, $query, $values = false);
  function SQL_Fetch      ($pdo, $query, $values = false);
  function SELECT_MultiFetch ($pdo, $query, $values = false);
  function SQL_LastID     ($pdo);
  function SQL_Error      ($e, $query);
  ------------------------------------------------------------
  Define PDO_DEBUG for detailed error messages.
  PDO_DEBUG values:
  1: Print the error message.
  2: Print also the SQL Statement.
  3: Print SQL Statement and traceback with detailed information where the error occurs.
  Example: define ("PDO_DEBUG", "2");
 */
class Dbcon {
    var $_host;
    var $_password;
    var $_user;
    var $_database;
    var $_link;
    var $_query;
    var $_result;
    var $_num_rows;
    var $_db_process_status;
    var $_pdo;
    var $_inserted_id;
    var $_rand_var;
    /* function Dbcon(){
      $this->_host 		= IP;
      $this->_user		= USER;
      $this->_password	= DBPWD;
      $this->_database 	= DB;
      } *///END FUNCTION
    //function OpenLink()
    function __construct() {
        $this->_host = IP;
        $this->_user = USER;
        $this->_password = DBPWD;
        $this->_database = DB;
        $charset = "utf8";
        try {
            $this->_pdo = new PDO("mysql:host=$this->_host;dbname=$this->_database;charset=$charset", $this->_user, $this->_password, array(PDO::ATTR_PERSISTENT => true));
        } catch (PDOException $e) {
            $this->SQL_Error($e);
        }
        $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$this->_pdo->setAttribute (PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        // Returned values are only indexed by column name.
        // Set it to PDO::FETCH_BOTH if you also want to have the 0-indexed column number in your result.
        // $pdo->setAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        //return $pdo;
    }
    function __destruct() {
        $this->_pdo = null;
    }
    function Begin() {
        //$this->OpenLink();
        if(!$this->_pdo->inTransaction())
            $this->_pdo->beginTransaction();
    }
    function Query($query, $values = false) {
        //$this->OpenLink();
        try {
            if (!$values) {
                $this->_pdo->exec($query);
                $this->_inserted_id =   $this->_pdo->lastInsertId();
                return true;
            } else {
                $stmt = $this->_pdo->prepare($query);
                $stmt->execute($values);
                $this->_affectedRows = $stmt->rowCount();
                $this->_inserted_id =   $this->_pdo->lastInsertId();
                $stmt = null;
                return true;
            }
        } catch (PDOException $e) {
            $this->SQL_Error($e, $query);
        }
    }
    function SQL_Fetch($query, $values = false) {
        //$this->OpenLink();
        try {
            if (!$values) {
                return $this->_pdo->query($query)->fetch();
            } else {
                $stmt = $this->_pdo->prepare($query);
                $stmt->execute($values);
                $arr = $stmt->fetch();
                $stmt = null;
                return $arr;
            }
        } catch (PDOException $e) {
            $this->SQL_Error($e, $query);
        }
    }
    function SELECT_MultiFetch($query, $values = false) {
        //$this->OpenLink();
        try {
            $stmt = $this->_pdo->prepare($query);
            if (!$values) {
                $stmt->execute();
            } else {
                $stmt->execute($values);
            }
            $arr = $stmt->fetchAll();
            $this->_num_rows = count($arr);
            $stmt = null;
            return $arr;
        } catch (PDOException $e) {
            $this->SQL_Error($e, $query);
        }
    }
    function mysqlInsertid() {
        return $this->_inserted_id;
    }
    function SQL_Error($e, $query) {
        if (defined("PDO_DEBUG")) {
            if (PDO_DEBUG == "1") {
                echo "<div style='float:left; width:100%;font-size:20px; height:50px; text-align: center; color:#ff0000;'><b>SQL Error: Please contact your Administrator Urgently.</b></div>";
            }
            if (PDO_DEBUG == "2") {
                echo "SQL Error: " . $e->getMessage() . "\n\n";
                echo "$query\n\n";
            }
            if (PDO_DEBUG == "3") {
                echo "<div style='float:left; width:100%;font-size:12px; height:auto; text-align: left; color:#ff0000;'><pre>";
                echo "SQL Error: " . $e->getMessage() . "\n\n";
                // Print details like script name and line.
                print_r($e);
                echo "</pre></div>";
            }
        } else {
            echo "SQL Error! Please contact the administrator.";
        }
        // Stop on error.
        exit;
    }
//end function
    function Commit() {
        $this->_pdo->commit();
    }
    function Rollback() {
        $this->_pdo->rollBack();
    }
    function mysqlerror() {
        //return mysqli_error($this->_link);
    }
    function stripslash($str) {
        return stripslashes($str);
    }
//end function
        function return_IN_array($input_array=null){
		if(count(array_filter($input_array))>0){
			$input_array = array_combine(
				array_map(function($i){ return ':id'.$this->_rand_var.'_'.$i; }, array_keys($input_array)),
				$input_array
			);
			return $input_array;
		}else{
			return false;
		}
	}//end function
	function return_IN_comma($input_array=null,$flag=''){
		if(count(array_filter($input_array))>0){
		$input_array = array_combine(
			array_map(function($i){ return ':id'.$this->_rand_var.'_'.$i; }, array_keys($input_array)),
			$input_array
		);
		$in_placeholders = implode(',', array_keys($input_array));
		return $in_placeholders;
		}else{
			return false;
		}
	}//end function
        function get_query($string,$data) {
            $indexed=$data==array_values($data);
            foreach($data as $k=>$v) {
                if(is_string($v)) $v="'$v'";
                if($indexed) $string=preg_replace('/\?/',$v,$string,1);
                else $string=str_replace(":$k",$v,$string);
            }
            return $string;
        }
//end function
}
//end class