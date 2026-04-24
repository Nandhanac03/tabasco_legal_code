<?php

class Casenotification extends dbcon
{
    function save_notification($data = [], $id = '')
    {
        $params = [];
        $Sqlcmd = $id ? "UPDATE" : "INSERT INTO";
        $Sqlcmd .= " legal_case_notification SET";
        $setParts = [];

        if (!empty($data['active_legal_id'])) {
            $setParts[] = "active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $data['active_legal_id'];
        }
        if (!empty($data['case_id'])) {
            $setParts[] = "case_id = :case_id";
            $params['case_id'] = $data['case_id'];
        }
        if (!empty($data['client_id'])) {
            $setParts[] = "client_id = :client_id";
            $params['client_id'] = $data['client_id'];
        }
        if (!empty($data['marketing_id'])) {
            $setParts[] = "marketing_id = :marketing_id";
            $params['marketing_id'] = $data['marketing_id'];
        }
        if (!empty($data['case_root_id'])) {
            $setParts[] = "case_root_id = :case_root_id";
            $params['case_root_id'] = $data['case_root_id'];
        }
        if (!empty($data['hearing_date'])) {
            $setParts[] = "hearing_date = :hearing_date";
            $params['hearing_date'] = $data['hearing_date'];
        }
        if (!empty($data['remind_date'])) {
            $setParts[] = "remind_date = :remind_date";
            $params['remind_date'] = $data['remind_date'];
        }
        if (!empty($data['case_status'])) {
            $setParts[] = "case_status = :case_status";
            $params['case_status'] = $data['case_status'];
        }

        if ($id === '') {
            $setParts[] = "created_by = :created_by";
            $params['created_by'] = $data['created_by'];

            $setParts[] = "created_at = :created_at";
            $params['created_at'] = $data['created_at'];
        }

        $setParts[] = "updated_by = :updated_by";
        $params['updated_by'] = $data['updated_by'];

        // FIX: match column name from your DB (updated_on)
        $setParts[] = "updated_on = :updated_on";
        $params['updated_on'] = $data['updated_on'];

        if (!empty($data['status'])) {
            $setParts[] = "status = :status";
            $params['status'] = $data['status'];
        }

        $Sqlcmd .= " " . implode(", ", $setParts);

        if ($id) {
            $Sqlcmd .= " WHERE idPrimary = :id";
            $params['id'] = $id;
        }

        $this->_output_alert = 'Ok';
        $this->_last_query = $Sqlcmd;

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
                    'legal_case_notification',                      // module/table
                    $loggedUserId,                     // user id
                    $isUpdate
                        ? "Updated Case Notification ID: $id"
                        : "Created Case Notification ID: $id",
                    $id                                // reference id
                );
            }
        }
return $result;

    }

    function get_notifications($id = null, $from_date = null, $to_date = null)
    {
        $params = [];
        $sql = "
            SELECT 
                n.*,
                u.user_name,
                c.case_number,
                lc.name AS client_name
            FROM legal_case_notification n
            LEFT JOIN users u ON u.user_id = n.marketing_id
            LEFT JOIN legal_case c ON c.id = n.case_id
            LEFT JOIN legal_client lc ON lc.id = n.client_id
            WHERE CURDATE() >= n.remind_date
            AND CURDATE() <= n.hearing_date
            ";

        if (!empty($id)) {
            $sql .= " WHERE n.idPrimary = :id";
            $params['id'] = $id;
        }

      
        if (!empty($from_date)) {
            $sql .= " AND n.hearing_date >= :from_date";
            $params['from_date'] = $from_date;
        }


        if (!empty($to_date)) {
            $sql .= " AND n.hearing_date <= :to_date";
            $params['to_date'] = $to_date;
        }

        $sql .= " ORDER BY n.created_at DESC";

        $this->_result = $this->SELECT_MultiFetch($sql, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
}
