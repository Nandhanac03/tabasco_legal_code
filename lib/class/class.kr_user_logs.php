<?php
class Kr_User_Logs extends dbcon {
    ################	MEMBER FUNCTIONS SECTION	##############
    function SaveuserLogs($data) {
        $params = array();
        $Sqlcmd = "INSERT INTO ";
        $Sqlcmd = $Sqlcmd . " kr_user_logs SET";
        if ($_SESSION['LOGIN_SUPERADMIN_ID']){
            $Sqlcmd = $Sqlcmd . " ulog_user_id=:ulog_user_id";
            $params['ulog_user_id'] = $_SESSION['LOGIN_SUPERADMIN_ID'];
        }
        if ($_SESSION['LOGIN_CLIENT_ID']){
            $Sqlcmd = $Sqlcmd . " ulog_user_id=:ulog_user_id";
            $params['ulog_user_id'] = $_SESSION['LOGIN_CLIENT_ID'];
        }
        if ($_SESSION['LOGIN_SUPERADMIN_NAME']){
            $Sqlcmd = $Sqlcmd . ",ulog_user_name=:ulog_user_name";
            $params['ulog_user_name'] = $_SESSION['LOGIN_SUPERADMIN_NAME'];
        }
        if ($_SESSION['LOGIN_CLIENT_AUTHENTICATION']){
            $Sqlcmd = $Sqlcmd . ",ulog_user_name=:ulog_user_name";
            $params['ulog_user_name'] = $_SESSION['LOGIN_CLIENT_AUTHENTICATION'];
        }
        if ($data['ulog_uaction_id']){
            $Sqlcmd = $Sqlcmd . ",ulog_uaction_id=:ulog_uaction_id";
            $params['ulog_uaction_id'] = $data['ulog_uaction_id'];
        }
        if ($data['ulog_uaction_name']){
            $Sqlcmd = $Sqlcmd . ",ulog_uaction_name=:ulog_uaction_name";
            $params['ulog_uaction_name'] = $data['ulog_uaction_name'];
        }
        $Sqlcmd = $Sqlcmd . ",ulog_date_n_time	='" . date('Y-m-d H-i-s') . "'";
        $Sqlcmd = $Sqlcmd . ",ulog_system_ip=:ulog_system_ip";
        $params['ulog_system_ip'] = $_SERVER['REMOTE_ADDR'];
        if ($data['ulog_system_location']){
            $Sqlcmd = $Sqlcmd . ",ulog_system_location=:ulog_system_location";
            $params['ulog_system_location'] = $_SESSION['LOGIN_LOCATION'];
        }
        if ($data['ulog_system_os']){
            $Sqlcmd = $Sqlcmd . ",ulog_system_os=:ulog_system_os";
            $params['ulog_system_os'] = $data['ulog_system_os'];
        }
        $Sqlcmd = $Sqlcmd . ",ulog_system_browser=:ulog_system_browser";
        $params['ulog_system_browser'] = $_SERVER['HTTP_USER_AGENT'];
        if ($data['ulog_sql_satmnt']){
            $Sqlcmd = $Sqlcmd . ",ulog_sql_satmnt=:ulog_sql_satmnt";
            $params['ulog_sql_satmnt'] = $data['ulog_sql_satmnt'];
        }
        $this->_last_query = $Sqlcmd;
        return $this->Query($Sqlcmd,$params);
    }
//END FUNCTION
    function getExcelINFO($file_name = '') {
        if ($file_name) {
            $params = array();
            $Sqlcmd = "SELECT * FROM kr_user_logs WHERE 1";
            if ($_SESSION['LOGIN_SUPERADMIN_NAME']){
                $Sqlcmd = $Sqlcmd . " and ulog_user_name=:ulog_user_name";
                $params['ulog_user_name'] = $_SESSION['LOGIN_SUPERADMIN_NAME'];
            }
            if ($_SESSION['LOGIN_CLIENT_AUTHENTICATION']){
                $Sqlcmd = $Sqlcmd . " and ulog_user_name=:ulog_user_name";
                $params['ulog_user_name'] = $_SESSION['LOGIN_CLIENT_AUTHENTICATION'];
            }
            if ($_SESSION['LOGIN_CLIENT_ID']){
                $Sqlcmd = $Sqlcmd . " and ulog_user_id=:ulog_user_id";
                $params['ulog_user_id'] = $_SESSION['LOGIN_CLIENT_ID'];
            }
            if ($file_name){
                $Sqlcmd = $Sqlcmd . " and ulog_uaction_name=:ulog_uaction_name";
                $params['ulog_uaction_name'] = $file_name;
            }
            $Sqlcmd = $Sqlcmd . " ORDER BY ulog_date_n_time DESC";
            $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
            if ($this->_num_rows > 0) {
                /*$i = 0;
                while ($row = mysqli_fetch_object($this->_result)) {
                    $records[$i]['ulog_id'] = $row->ulog_id;
                    $records[$i]['ulog_user_id'] = $row->ulog_user_id;
                    $records[$i]['ulog_user_name'] = $row->ulog_user_name;
                    $records[$i]['ulog_uaction_id'] = $row->ulog_uaction_id;
                    $records[$i]['ulog_uaction_name'] = stripslashes($row->ulog_uaction_name);
                    $records[$i]['ulog_date_n_time'] = $row->ulog_date_n_time;
                    $records[$i]['ulog_system_ip'] = $row->ulog_system_ip;
                    $records[$i]['ulog_system_location'] = $row->ulog_system_location;
                    $records[$i]['ulog_system_os'] = $row->ulog_system_os;
                    $records[$i]['ulog_system_browser'] = $row->ulog_system_browser;
                    $records[$i]['ulog_sql_satmnt'] = $row->ulog_sql_satmnt;
                    $i++;
                }*/
                return $this->_result;
            } else
                return false;
        }
    }
//END FUNCTION
    /*function GetStaffForBenchmark($not_id = '') {
        $params = array();
        $Sqlcmd = "SELECT * FROM kr_staffs WHERE 1";
        if ($not_id)
            $Sqlcmd = $Sqlcmd . " and staff_id NOT IN (" . $not_id . ")";
        //if($client_id)
        $Sqlcmd = $Sqlcmd . " and staff_client_id='58'";
        $Sqlcmd = $Sqlcmd . " and staff_status='active' ORDER BY staff_id";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
        $this->_last_query = $Sqlcmd;
        //echo $Sqlcmd; exit;
        if ($this->_num_rows > 0) {
            $i = 0;
            while ($row = mysqli_fetch_object($this->_result)) {
                $records[$i]['staff_id'] = $row->staff_id;
                //$records[$i]['staff_self_signup']					        =	$row->staff_self_signup;
                $records[$i]['staff_client_id'] = $row->staff_client_id;
                $records[$i]['staff_full_name'] = html_entity_decode($row->staff_full_name);
                //$records[$i]['staff_job_role_id']				  =	$row->staff_job_role_id;
                //$records[$i]['staff_team_id']					    =	$row->staff_team_id;
                //$records[$i]['staff_territory_id']				=	$row->staff_territory_id;
                $records[$i]['staff_email'] = $row->staff_email;
                $records[$i]['staff_question_type_id'] = $row->staff_question_type_id;
                $records[$i]['staff_status'] = $row->staff_status;
                //$records[$i]['staff_sub_job_role_id']			=	$row->staff_sub_job_role_id;
                //[$i]['staff_exam_time']				    =	$row->staff_exam_time;
                //$records[$i]['staff_exam_minutes']				=	$row->staff_exam_minutes;
                //$records[$i]['staff_spend_time']				  =	$row->staff_spend_time;
                //$records[$i]['staff_participant_id']			=	html_entity_decode($row->staff_participant_id);
                //$records[$i]['staff_random_questions']		=	$row->staff_random_questions;
                //$records[$i]['staff_randomize_number']		=	$row->staff_randomize_number;
                //$records[$i]['staff_multiple_exam']		    =	$row->staff_multiple_exam;
                //$records[$i]['staff_previos_result']		  =	$row->staff_previos_result;
                //generic sections
                $records[$i]['staff_generic_jobrole'] = $row->staff_generic_jobrole;
                $records[$i]['staff_generic_sector'] = $row->staff_generic_sector;
                $records[$i]['staff_generic_country'] = $row->staff_generic_country;
                $i++;
            }
            return $records;
        } else
            return false;
    }*/
//END FUNCTION
    /*function GetAnswerSheetDetailsForBenchmark($staff_id = '') {
        $params = array();
        $Sqlcmd = "SELECT * FROM kr_answer_sheet A INNER JOIN kr_questions Q ON A.benchmark_question_id=Q.question_id WHERE 1";
        if ($staff_id)
            $Sqlcmd = $Sqlcmd . " and A.asheet_staff_id=" . $staff_id;
        if ($sub_question_id)
            $Sqlcmd = $Sqlcmd . " and A.asheet_qsub_id=" . $sub_question_id;
        if ($competency_id)
            $Sqlcmd = $Sqlcmd . " and A.asheet_competency_id=" . $competency_id;
        if ($main_question_id)
            $Sqlcmd = $Sqlcmd . " and A.asheet_main_question_id=" . $main_question_id;
        if ($exam_number)
            $Sqlcmd = $Sqlcmd . " and A.asheet_exam_number=" . $exam_number;
        $Sqlcmd = $Sqlcmd . " ORDER BY A.asheet_id";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
        $this->_last_query = $Sqlcmd;
        if ($this->_num_rows > 0) {
            $i = 0;
            while ($row = mysqli_fetch_object($this->_result)) {
                $records[$i]['asheet_id'] = $row->asheet_id;
                $records[$i]['generic_competency'] = $row->question_generic_competency_id;
                $records[$i]['asheet_staff_id'] = $row->asheet_staff_id;
                $records[$i]['asheet_qsub_id'] = $row->asheet_qsub_id;
                $records[$i]['asheet_response'] = $row->asheet_response;
                $records[$i]['ashett_confidence'] = $row->ashett_confidence;
                $records[$i]['asheet_attended_time'] = $row->asheet_attended_time;
                $records[$i]['asheet_updated_time'] = $row->asheet_updated_time;
                $records[$i]['asheet_competency_id'] = $row->asheet_competency_id;
                $i++;
            }
            return $records;
        } else
            return false;
    }//END FUNCTION*/
}