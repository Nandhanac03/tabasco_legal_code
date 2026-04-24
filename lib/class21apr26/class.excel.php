<?php
class ExcelClass extends dbcon {
    ################	MEMBER FUNCTIONS SECTION	##############
    function GetStaff_forExcel($Client_Id = '', $jobroles_id = '', $subjroles_sorting = '', $Questiontype_Id = '', $team_id = '', $teritory_id = '', $Staff_Id = '', $keyword = '') {
        $params = array();
        $Sqlcmd = "SELECT S.staff_id, S.staff_client_id, S.staff_participant_id, S.staff_full_name,S.staff_previos_result, T.team_name, J.jrole_name AS 'department', SJ.jrole_name AS 'jobrole', TE.territory_name, Q.qtype_name, U.user_name, U.user_password, S.staff_email, S.staff_exam_minutes/60 AS 'time_limit', GJR.generic_name AS generic_job_role, GCY.generic_name AS generic_country, GS.generic_name AS generic_sector FROM kr_staffs S LEFT JOIN kr_users U ON S.staff_id=U.user_login_id LEFT JOIN kr_team T ON T.team_id=S.staff_team_id AND T.team_status='active' LEFT JOIN kr_job_roles J ON J.jrole_id=S.staff_job_role_id AND J.jrole_status='active' LEFT JOIN kr_job_roles SJ ON SJ.jrole_id=S.staff_sub_job_role_id AND SJ.jrole_status='active' LEFT JOIN kr_territory TE ON TE.territory_id=S.staff_territory_id AND TE.territory_status='active' LEFT JOIN kr_question_type Q ON Q.qtype_id=S.staff_question_type_id AND Q.qtype_status='active' LEFT JOIN kr_generic GJR ON S.staff_generic_jobrole=GJR.generic_id LEFT JOIN kr_generic GS ON S.staff_generic_sector=GS.generic_id LEFT JOIN kr_generic GCY ON S.staff_generic_country=GCY.generic_id WHERE 1 AND S.staff_status='active' ";
        if ($Client_Id > 0){
            $Sqlcmd .= "AND S.staff_client_id=:staff_client_id";
            $params['staff_client_id'] = $Client_Id;
        }
        if ($jobroles_id > 0){
            $Sqlcmd .= " AND S.staff_job_role_id=:staff_job_role_id AND J.jrole_parent_id='0' ";
            $params['staff_job_role_id'] = $jobroles_id;
        }
        if ($subjroles_sorting > 0){
            $Sqlcmd .= " AND S.staff_sub_job_role_id=:staff_sub_job_role_id AND SJ.jrole_parent_id='CD' ";
            $params['staff_sub_job_role_id'] = $subjroles_sorting;
        }
        if ($Questiontype_Id > 0){
            $Sqlcmd .= " AND S.staff_question_type_id=:staff_question_type_id";
            $params['staff_question_type_id'] = $Questiontype_Id;
        }
        if ($team_id > 0){
            $Sqlcmd .= " AND S.staff_team_id=:staff_team_id";
            $params['staff_team_id'] = $team_id;
        }
        if ($teritory_id > 0){
            $Sqlcmd .= " AND S.staff_territory_id=:staff_territory_id";
            $params['staff_territory_id'] = $teritory_id;
        }
        if ($Staff_Id > 0){
            $Sqlcmd .= " AND S.staff_id=:staff_id";
            $params['staff_id'] = $Staff_Id;
        }
        if ($keyword){
            $Sqlcmd .= " AND ( S.staff_full_name like :search )";
            $params['search'] = '%'.$keyword.'%';
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
        $this->_last_query = $Sqlcmd;
        if ($this->_num_rows > 0) {
            $i = 1;
            foreach ($this->_result as $rec) {
                $row = (object) $rec;
                $records[$i]['staff_id'] = $row->staff_id;
                $records[$i]['staff_client_id'] = $row->staff_client_id;
                $records[$i]['staff_participant_id'] = stripslashes($row->staff_participant_id);
                $records[$i]['staff_full_name'] = stripslashes($row->staff_full_name);
                $records[$i]['team_name'] = stripslashes($row->team_name);
                $records[$i]['department'] = stripslashes($row->department);
                $records[$i]['jobrole'] = stripslashes(stripslashes($row->jobrole));
                $records[$i]['territory_name'] = stripslashes($row->territory_name);
                $records[$i]['qtype_name'] = stripslashes($row->qtype_name);
                $records[$i]['staff_email'] = $row->staff_email;
                $records[$i]['time_limit'] = $row->time_limit;
                $records[$i]['staff_previos_result'] = stripslashes($row->staff_previos_result);
                //generic sections
                $records[$i]['generic_job_role'] = stripslashes($row->generic_job_role);
                $records[$i]['generic_country'] = stripslashes($row->generic_country);
                $records[$i]['generic_sector'] = stripslashes($row->generic_sector);
                $i++;
            }
            return $records;
        } else
            return false;
    }//END FUNCTION
    function getAllQuestionSets($client_id = '') {
        $params = array();
        $Sqlcmd = "SELECT qtype_id,qtype_name FROM kr_question_type WHERE 1";
        if ($client_id) {
            $Sqlcmd = $Sqlcmd . " and qtype_client_id=:qtype_client_id";
            $params['qtype_client_id'] = $client_id;
        }
        $Sqlcmd = $Sqlcmd . " ORDER BY qtype_id ASC";
        //echo $Sqlcmd;exit;
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        if ($this->_num_rows > 0) {
            $i = 0;
            foreach ($this->_result as $rec) {
                $row = (object) $rec;
                $records[$row->qtype_id] = $row->qtype_name;
                $i++;
            }
            return $records;
        } else
            return false;
    }
    /*function GetStaff_forExcel( $client_id = '', $jobroles = '', $subjobroles = '', $question_type = '', $team_id = '', $teritory_id = '', $id = '', $search = '') {
        $params = array();
        if ($exam_status == "C") {
            $exam_status_sql = "AND multiple_exam_attended_status='Completed'";
        } else if ($exam_status == "P") {
            $exam_status_sql = "AND multiple_exam_attended_status='Pending'";
        } else {
            $exam_status_sql = "";
        }
        if ($from_date > 0 && $to_date > 0) {
            if ($exam_status_sql == "") {
                $exam_status_sql = "AND multiple_exam_attended_status='Completed'";
                $exam_status = "C";
            }
            $Sqlcmd = "SELECT staff_id,staff_client_id,staff_participant_id,staff_full_name,staff_job_role_id,staff_sub_job_role_id, FROM kr_staffs S LEFT JOIN (SELECT max(multiple_exam_id) AS multiple_exam_id,max(multiple_exam_attended_status) AS multiple_exam_attended_status,multiple_exam_staff_id,examtime_endtime FROM kr_multiple_exam INNER JOIN kr_examtime ON kr_multiple_exam.multiple_exam_id=kr_examtime.examtime_exam_number WHERE 1 AND examtime_endtime>=:from_date AND examtime_endtime<=:to_date " . $exam_status_sql . " AND multiple_exam_status='active' GROUP BY multiple_exam_staff_id) ME ON S.staff_id=ME.multiple_exam_staff_id WHERE 1 AND S.staff_status='active'";
            $params['from_date'] = date("Y-m-d 00:00:00", strtotime($from_date));
            $params['to_date'] = date("Y-m-d 23:59:59", strtotime($to_date));
        } else {
            //$Sqlcmd	=	"SELECT * FROM kr_staffs S LEFT JOIN kr_users U ON S.staff_id=U.user_login_id and U.user_type='Staff' LEFT JOIN (SELECT max(multiple_exam_id) AS multiple_exam_id,max(multiple_exam_attended_status) AS multiple_exam_attended_status,multiple_exam_staff_id FROM kr_multiple_exam WHERE 1 ".$exam_status_sql." AND multiple_exam_status='active' GROUP BY multiple_exam_staff_id) ME ON S.staff_id=ME.multiple_exam_staff_id WHERE 1 AND S.staff_status='active'";
            $Sqlcmd = "SELECT * FROM kr_staffs S LEFT JOIN (SELECT max(multiple_exam_id) AS multiple_exam_id,max(multiple_exam_attended_status) AS multiple_exam_attended_status,multiple_exam_staff_id FROM kr_multiple_exam WHERE 1 " . $exam_status_sql . " AND multiple_exam_status='active' GROUP BY multiple_exam_staff_id) ME ON S.staff_id=ME.multiple_exam_staff_id WHERE 1 AND S.staff_status='active'";
        }
        if ($id) {
            $Sqlcmd = $Sqlcmd . " and S.staff_id=:staff_id";
            $params['staff_id'] = $id;
        }
        if ($name) {
            $Sqlcmd = $Sqlcmd . " and S.staff_full_name=:staff_full_name";
            $params['staff_full_name'] = $name;
        }
        if ($search) {
            $Sqlcmd = $Sqlcmd . " and ( S.staff_full_name like :search1 )";
            $params['search1'] = $search;
        }
        if ($jobroles) {
            $Sqlcmd = $Sqlcmd . " and S.staff_job_role_id=:staff_job_role_id";
            $params['staff_job_role_id'] = $jobroles;
        }
        if ($team_id) {
            $Sqlcmd = $Sqlcmd . " and S.staff_team_id=:staff_team_id";
            $params['staff_team_id'] = $team_id;
        }
        if ($teritory_id) {
            $Sqlcmd = $Sqlcmd . " and S.staff_territory_id=:staff_territory_id";
            $params['staff_territory_id'] = $teritory_id;
        }
        if ($client_id) {
            $Sqlcmd = $Sqlcmd . " and S.staff_client_id=:staff_client_id";
            $params['staff_client_id'] = $client_id;
        }
        if ($question_type) {
            $Sqlcmd = $Sqlcmd . " and S.staff_question_type_id=:staff_question_type_id";
            $params['staff_question_type_id'] = $question_type;
        }
        if ($subjobroles) {
            $Sqlcmd = $Sqlcmd . " and S.staff_sub_job_role_id=:staff_sub_job_role_id";
            $params['staff_sub_job_role_id'] = $subjobroles;
        }
        if ($user_email) {
            $Sqlcmd = $Sqlcmd . " and S.staff_email=:staff_email";
            $params['staff_email'] = $user_email;
        }
        if ($status) {
            $Sqlcmd = $Sqlcmd . " and S.staff_status=:staff_status";
            $params['staff_status'] = $status;
        }
        if ($exam_status == "P")
            $Sqlcmd = $Sqlcmd . " and ME.multiple_exam_attended_status='Pending'";
        if ($exam_status == "C")
            $Sqlcmd = $Sqlcmd . " and ME.multiple_exam_attended_status='Completed'";
        if ($start >= 0 && $end > 0) {
            $Sqlcmd = $Sqlcmd . " GROUP BY S.staff_id,S.staff_full_name ORDER BY S.staff_full_name ASC LIMIT $start,$end ";
            //$params['limit_start'] = $start;
            // $params['limit_end'] = $end;
        } else {
            $Sqlcmd = $Sqlcmd . " GROUP BY S.staff_id,S.staff_full_name ORDER BY S.staff_full_name ASC";
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        $this->_last_query = $Sqlcmd;
        if ($this->_num_rows > 0) {
            return $this->_result;
        } else
            return false;
    }*/
    /*     * **********************************Excell Download Answer sheet********************************************** */
    /*function Excellanswersheet($jobroles_id = '', $subjroles_sorting = '', $Questiontype_Id = '', $team_id = '', $teritory_id = '', $Staff_Ids = '', $keyword = '', $subquestionId = '', $from_date = '', $to_date = '') {
        $Sqlcmd = "SELECT COMP.competency_name,QTS.question_description,S.staff_full_name,J.jrole_name AS 'department',SJ.jrole_name AS 'jobrole',T.team_name,TE.territory_name,ANS.ashett_confidence,ANS.asheet_main_question_id,ANS.asheet_qsub_id,ANS.asheet_response,ANS.asheet_id,ANS.asheet_staff_id
          FROM kr_answer_sheet ANS
          LEFT JOIN kr_staffs S ON ANS.asheet_staff_id=S.staff_id
          LEFT JOIN kr_examtime EXTM ON ANS.asheet_staff_id=EXTM.examtime_staffid
          LEFT JOIN kr_competency COMP ON ANS.asheet_competency_id=COMP.competency_id
          LEFT JOIN kr_questions_sub SUBQST ON ANS.asheet_qsub_id=SUBQST.qsub_id
          LEFT JOIN kr_team T ON T.team_id=S.staff_team_id AND T.team_status='active'
          LEFT JOIN kr_job_roles J ON J.jrole_id=S.staff_job_role_id AND J.jrole_status='active'
          LEFT JOIN kr_job_roles SJ ON SJ.jrole_id=S.staff_sub_job_role_id AND SJ.jrole_status='active'
          LEFT JOIN kr_territory TE ON TE.territory_id=S.staff_territory_id AND TE.territory_status='active'
          LEFT JOIN kr_question_type Q ON Q.qtype_id=S.staff_question_type_id AND Q.qtype_status='active'
          LEFT JOIN kr_questions QTS ON ANS.asheet_main_question_id=QTS.question_id where 1";
        if ($jobroles_id > 0)
            $Sqlcmd .= " AND S.staff_job_role_id='" . $jobroles_id . "' AND J.jrole_parent_id='0' ";
        if ($subjroles_sorting > 0)
            $Sqlcmd .= " AND S.staff_sub_job_role_id='" . $subjroles_sorting . "' AND SJ.jrole_parent_id='CD' ";
        if ($Questiontype_Id > 0)
            $Sqlcmd .= " AND S.staff_question_type_id='" . $Questiontype_Id . "' ";
        if ($team_id > 0)
            $Sqlcmd .= " AND S.staff_team_id='" . $team_id . "' ";
        if ($teritory_id > 0)
            $Sqlcmd .= " AND S.staff_territory_id='" . $teritory_id . "' ";
        if ($subquestionId > 0)
            $Sqlcmd .= " AND SUBQST.qsub_id='" . $subquestionId . "' ";
        if ($Staff_Ids)
            $Sqlcmd .= " AND S.staff_id IN (" . $Staff_Ids . ")";
        if ($keyword)
            $Sqlcmd .= " AND ( S.staff_full_name like '%$keyword%' OR U.user_name like '%$keyword%' )";
        if ($from_date)
            $Sqlcmd .= " AND EXTM.examtime_begintime<='" . date("Y-m-d", strtotime($from_date)) . "'";
        if ($to_date)
            $Sqlcmd .= " AND EXTM.examtime_endtime>='" . date("Y-m-d", strtotime($to_date)) . "'";
        //echo $Sqlcmd."<br>-----<br>";exit;
        $this->Query($Sqlcmd);
        $this->_last_query = $Sqlcmd;
        if ($this->_num_rows > 0) {
            $i = 1;
            while ($row = mysqli_fetch_object($this->_result)) {
                $records[$i]['asheet_id'] = stripslashes($row->asheet_id);
                $records[$i]['asheet_staff_id'] = stripslashes($row->asheet_staff_id);
                $records[$i]['competency_name'] = stripslashes(stripslashes($row->competency_name));
                $records[$i]['question_description'] = stripslashes(stripslashes($row->question_description));
                $records[$i]['staff_full_name'] = stripslashes(stripslashes($row->staff_full_name));
                $records[$i]['team_name'] = stripslashes(stripslashes($row->team_name));
                $records[$i]['department'] = stripslashes(stripslashes($row->department));
                $records[$i]['jobrole'] = stripslashes(stripslashes($row->jobrole));
                $records[$i]['territory_name'] = stripslashes(stripslashes($row->territory_name));
                $records[$i]['asheet_main_question_id'] = stripslashes($row->asheet_main_question_id);
                $records[$i]['asheet_qsub_id'] = stripslashes($row->asheet_qsub_id);
                $records[$i]['ashett_confidence'] = stripslashes($row->ashett_confidence);
                $records[$i]['asheet_response'] = stripslashes($row->asheet_response);
                $i++;
            }
            return $records;
        } else
            return false;
    }*/
//end function
    /*function answersheetnew($mainquestion_id = '', $staff_id = '', $exam_number = '') {
        $Sqlcmd = "SELECT * FROM kr_answer_sheet WHERE 1";
        if ($mainquestion_id)
            $Sqlcmd = $Sqlcmd . " and asheet_main_question_id=" . $mainquestion_id;
        if ($staff_id)
            $Sqlcmd = $Sqlcmd . " and asheet_staff_id=" . $staff_id;
        if ($exam_number)
            $Sqlcmd = $Sqlcmd . " and asheet_exam_number=" . $exam_number;
        $Sqlcmd = $Sqlcmd . " order by asheet_qsub_id";
        //echo $Sqlcmd;exit;
        $this->Query($Sqlcmd);
        if ($this->_num_rows > 0) {
            $i = 0;
            while ($row = mysqli_fetch_object($this->_result)) {
                $records[$i]['asheet_id'] = $row->asheet_id;
                $records[$i]['asheet_qsub_id'] = $row->asheet_qsub_id;
                $records[$i]['asheet_main_question_id'] = $row->asheet_main_question_id;
                $records[$i]['asheet_staff_id'] = $row->asheet_staff_id;
                $records[$i]['asheet_exam_number'] = $row->asheet_exam_number;
                $records[$i]['asheet_competency_id'] = $row->asheet_competency_id;
                $records[$i]['asheet_response'] = $row->asheet_response;
                $records[$i]['ashett_confidence'] = $row->ashett_confidence;
                $i++;
            }
            return $records;
        } else
            return false;
    }*/
//end function
    //NEW OPTIMIZED CODE FOR RAW DATA DOWNLOAD
    function answersheetnew_Optimized($client_id = '', $staff_id = '') {
        $params = array();
        $Sqlcmd = "SELECT asheet_id,asheet_qsub_id,asheet_main_question_id,asheet_staff_id,asheet_exam_number,asheet_competency_id,asheet_response,ashett_confidence FROM `kr_answer_sheet` A INNER JOIN kr_multiple_exam M ON A.`asheet_exam_number` = M.multiple_exam_id INNER JOIN kr_clients C ON M.multiple_exam_client_id = C.client_id WHERE 1 AND asheet_staff_id>0 AND asheet_exam_number>0";
        if ($client_id > 0){
            $Sqlcmd = $Sqlcmd . " and C.client_id=:client_id";
            $params['client_id'] = $client_id;
        }
        /*if ($staff_id){
            $Sqlcmd = $Sqlcmd . " and A.asheet_staff_id IN (" . $staff_id . ")";
            $params['generic_main_id'] = $id;
        }*/
        $Sqlcmd = $Sqlcmd . " order by asheet_staff_id,asheet_exam_number,asheet_qsub_id";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
        if ($this->_num_rows > 0) {
            $i = 0;
            $temp_staff_id = 0;
            $processed = 0;
            foreach ($this->_result as $rec) {
                $row = (object) $rec;
                if ($processed > 0) {
                    if ($temp_staff_id != $row->asheet_staff_id) {
                        $final_res[$temp_staff_id] = $records;
                        $i = 0;
                        $records = array();
                    }
                }
                $records[$i]['asheet_id'] = $row->asheet_id;
                $records[$i]['asheet_qsub_id'] = $row->asheet_qsub_id;
                $records[$i]['asheet_main_question_id'] = $row->asheet_main_question_id;
                $records[$i]['asheet_staff_id'] = $row->asheet_staff_id;
                $records[$i]['asheet_exam_number'] = $row->asheet_exam_number;
                $records[$i]['asheet_competency_id'] = $row->asheet_competency_id;
                $records[$i]['asheet_response'] = $row->asheet_response;
                $records[$i]['ashett_confidence'] = $row->ashett_confidence;
                $temp_staff_id = $row->asheet_staff_id;
                $i++;
                $processed++;
                if ($this->_num_rows == $processed) {
                    $final_res[$temp_staff_id] = $records;
                }
            }
            return $final_res;
        } else
            return false;
    }
//end function
    function getMultipleExamInfo_Optimized($id = '', $staff_id = '', $client_id = '', $attended_status = '', $details = '') {
        $params = array();
        $Sqlcmd = "SELECT * FROM kr_multiple_exam WHERE 1";
        if ($id){
            $Sqlcmd = $Sqlcmd . " and multiple_exam_id=:multiple_exam_id";
            $params['multiple_exam_id'] = $id;
        }
        if ($staff_id){
            $Sqlcmd = $Sqlcmd . " and multiple_exam_staff_id=:multiple_exam_staff_id";
            $params['multiple_exam_staff_id'] = $staff_id;
        }
        if ($client_id){
            $Sqlcmd = $Sqlcmd . " and multiple_exam_client_id=:multiple_exam_client_id";
            $params['multiple_exam_client_id'] = $client_id;
        }
        if ($attended_status){
            $Sqlcmd = $Sqlcmd . " and multiple_exam_attended_status=:multiple_exam_attended_status";
            $params['multiple_exam_attended_status'] = $attended_status;
        }
        /* if($details)
          $Sqlcmd	=	$Sqlcmd." and multiple_exam_status='active' ORDER BY multiple_exam_id ASC";
          else
          $Sqlcmd	=	$Sqlcmd." and multiple_exam_status='active' ORDER BY multiple_exam_id DESC"; */
        $Sqlcmd = $Sqlcmd . " and multiple_exam_status='active' ORDER BY multiple_exam_staff_id,multiple_exam_id ASC";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
        if ($this->_num_rows > 0) {
            $i = 0;
            $temp_staff_id = 0;
            $processed = 0;
            foreach ($this->_result as $rec) {
                $row = (object) $rec;
                if ($temp_staff_id == $row->multiple_exam_staff_id) {
                    $records[$i]['multiple_exam_id'] = $row->multiple_exam_id;
                    $records[$i]['multiple_exam_staff_id'] = $row->multiple_exam_staff_id;
                } else {
                    if ($processed > 0) {
                        $final_arr[$temp_staff_id] = $records;
                        $i = 0;
                        $records = array();
                    }
                    $records[$i]['multiple_exam_id'] = $row->multiple_exam_id;
                    $records[$i]['multiple_exam_staff_id'] = $row->multiple_exam_staff_id;
                }
                $temp_staff_id = $row->multiple_exam_staff_id;
                $i++;
                $processed++;
                if ($this->_num_rows == $processed) {
                    $final_arr[$temp_staff_id] = $records;
                }
            }
            return $final_arr;
        } else
            return false;
    }
//END FUNCTION
    function getExamTimeDetails_Optimized() {
        $params = array();
        $Sqlcmd = "SELECT examtime_exam_number,examtime_endtime FROM kr_examtime WHERE 1";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
        $this->_last_query = $Sqlcmd;
        if ($this->_num_rows > 0) {
            $i = 0;
            foreach ($this->_result as $rec) {
                $row = (object) $rec;
                $records[$row->examtime_exam_number] = $row->examtime_endtime;
                $i++;
            }
            return $records;
        } else
            return false;
    }
//END FUNCTION
    function getCompetencyInfo_Optimized($id = '', $client_id = '', $language = '') {
        //$Sqlcmd	=	"SELECT * FROM kr_competency C LEFT JOIN kr_competency_lang KL ON C.competency_id=KL.comp_lang_main_id WHERE 1 AND KL.comp_lang_status='active' ";
        $params = array();
        $Sqlcmd = "SELECT competency_id,competency_name FROM kr_competency C WHERE 1 AND C.competency_status='active'";
        if ($language > 0) {
            $Sqlcmd .= "AND KL.comp_lang_language=:comp_lang_language";
            $params['comp_lang_language'] = $language;
        }
        if ($id){
            $Sqlcmd = $Sqlcmd . " and C.competency_id=:competency_id";
            $params['competency_id'] = $id;
        }
        if ($client_id){
            $Sqlcmd = $Sqlcmd . " and C.competency_client_id=:competency_client_id";
            $params['competency_client_id'] = $client_id;
        }
        $Sqlcmd = $Sqlcmd . " ORDER BY C.competency_name";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
        if ($this->_num_rows > 0) {
            $i = 0;
            foreach ($this->_result as $rec) {
                $row = (object) $rec;
                $records[$row->competency_id] = stripslashes($row->competency_name);
                $i++;
            }
            return $records;
        } else
            return false;
    }
//END FUNCTION
    function getQuestion_Optimized($client_id = '') {
        $params = array();
        $Sqlcmd = "SELECT question_id,question_description,question_generic_competency_id FROM kr_questions WHERE 1";
        if ($client_id){
            $Sqlcmd = $Sqlcmd . " and question_client_id=:question_client_id";
            $params['question_client_id'] = $client_id;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
        if ($this->_num_rows > 0) {
            $i = 0;
            foreach ($this->_result as $rec) {
                $row = (object) $rec;
                $records[$row->question_id]['question_description'] = stripslashes($row->question_description);
                $records[$row->question_id]['question_generic_competency_id'] = stripslashes($row->question_generic_competency_id);
                $i++;
            }
            return $records;
        } else
            return false;
    }
//END FUNCTION
    function getGenericInfo_Optimized($id = '', $name = '', $search = '', $action_id = '', $status = '', $client_id = '', $type = '') {
        $params = array();
        $Sqlcmd = "SELECT generic_id,generic_name FROM kr_generic WHERE 1 ";
        if ($status){
            $Sqlcmd = $Sqlcmd . " and generic_status=:generic_status";
            $params['generic_status'] = $status;
        }
        if ($type){
            $Sqlcmd = $Sqlcmd . " and generic_type=:generic_type";
            $params['generic_type'] = $type;
        }
        $Sqlcmd = $Sqlcmd . " ORDER BY generic_id";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
        if ($this->_num_rows > 0) {
            $i = 0;
            foreach ($this->_result as $rec) {
                $row = (object) $rec;
                $records[$row->generic_id] = stripslashes($row->generic_name);
                $i++;
            }
            return $records;
        } else
            return false;
    }
//END FUNCTION
    function getSubQuestion_Optimized($client_id = '') {
        $params = array();
        $Sqlcmd = "SELECT qsub_id,qsub_description,qsub_answer FROM kr_questions_sub WHERE 1";
        if ($client_id > 0){
            $Sqlcmd = $Sqlcmd . " and qsub_client_id=:qsub_client_id";
            $params['qsub_client_id'] = $client_id;
        }
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd,$params);
        $this->_last_query = $Sqlcmd;
        if ($this->_num_rows > 0) {
            $i = 0;
            foreach ($this->_result as $rec) {
                $row = (object) $rec;
                $records[$row->qsub_id]['qsub_answer'] = $row->qsub_answer;
                $records[$row->qsub_id]['qsub_description'] = stripslashes($row->qsub_description);
                $i++;
            }
            return $records;
        } else
            return false;
    }
//END FUNCTION
}
//end class