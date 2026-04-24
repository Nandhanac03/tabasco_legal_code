
<?php
class LegalTask_reminders extends dbcon
{
    function save_taskReminders($data = [], $id = '')
    {
        $params = [];
    
        if ($id) {
            $SqlCmd = "UPDATE legal_task_reminders SET ";
        } else {
            $SqlCmd = "INSERT INTO legal_task_reminders SET ";
        }
    
        $first = true;
        if (!empty($data['user_legal_id'])) {
            $SqlCmd .= ($first ? "" : ", ") . "user_legal_id = :user_legal_id";
            $params['user_legal_id'] = $data['user_legal_id'];
            $first = false;
        }
    
        if (!empty($data['user_legal_type_id'])) {
            $SqlCmd .= ($first ? "" : ", ") . "user_legal_type_id = :user_legal_type_id";
            $params['user_legal_type_id'] = $data['user_legal_type_id'];
            $first = false;
        }
    
        if (!empty($data['user_legal_type'])) {
            $SqlCmd .= ($first ? "" : ", ") . "user_legal_type = :user_legal_type";
            $params['user_legal_type'] = $data['user_legal_type'];
            $first = false;
        }
    
        if (!empty($data['super_admin'])) {
            $SqlCmd .= ($first ? "" : ", ") . "super_admin = :super_admin";
            $params['super_admin'] = $data['super_admin'];
            $first = false;
        }
    
        if (!empty($data['task_name'])) {
            $SqlCmd .= ($first ? "" : ", ") . "task_name = :task_name";
            $params['task_name'] = $data['task_name'];
            $first = false;
        }
    
        if (!empty($data['task_info'])) {
            $SqlCmd .= ($first ? "" : ", ") . "task_info = :task_info";
            $params['task_info'] = $data['task_info'];
            $first = false;
        }
    
        if (!empty($data['task_date'])) {
            $SqlCmd .= ($first ? "" : ", ") . "task_date = :task_date";
            $params['task_date'] = $data['task_date'];
            $first = false;
        }
    
        if (!empty($data['reminder_date'])) {
            $SqlCmd .= ($first ? "" : ", ") . "reminder_date = :reminder_date";
            $params['reminder_date'] = $data['reminder_date'];
            $first = false;
        }
    
        if (!empty($data['status'])) {
            $SqlCmd .= ($first ? "" : ", ") . "status = :status";
            $params['status'] = $data['status'];
            $first = false;
        }
    
        if (!empty($data['is_view'])) {
            $SqlCmd .= ($first ? "" : ", ") . "is_view = :is_view";
            $params['is_view'] = $data['is_view'];
            $first = false;
        }
    
        if (!empty($data['active'])) {
            $SqlCmd .= ($first ? "" : ", ") . "active = :active";
            $params['active'] = $data['active'];
            $first = false;
        }

        if (!$id) {
            $SqlCmd .= ($first ? "" : ", ") . "created_by = :created_by";
            $params['created_by'] = $data['created_by'];
            $first = false;
    
            $SqlCmd .= ", created_at = :created_at";
            $params['created_at'] = $data['created_at'];
    
        }
       
        if ($id) {
            $SqlCmd .= ($first ? "" : ", ") . "updated_by = :updated_by";
            $params['updated_by'] = $data['updated_by'];
    
            $SqlCmd .= ", updated_at = :updated_at";
            $params['updated_at'] = $data['updated_at'];
        }
    
        if ($id) {
            $SqlCmd .= " WHERE id = :id";
            $params['id'] = $id;
        }
    
        $this->_output_alert = 'Ok';
        $this->_last_query = $SqlCmd;
    
        return $this->Query($SqlCmd, $params);
    }
    

    function get_taskReminders($filters = [])
    {
        $SqlCmd = "SELECT * FROM legal_task_reminders WHERE 1=1";
        $params = [];

        if (!empty($filters['id'])) {
            $SqlCmd .= " AND id = :id";
            $params['id'] = $filters['id'];
        }
        if (!empty($filters['user_legal_id'])) {
            $SqlCmd .= " AND user_legal_id = :user_legal_id";
            $params['user_legal_id'] = $filters['user_legal_id'];
        }
        if (!empty($filters['user_legal_type_id'])) {
            $SqlCmd .= " AND user_legal_type_id = :user_legal_type_id";
            $params['user_legal_type_id'] = $filters['user_legal_type_id'];
        }
        if (!empty($filters['user_legal_type'])) {
            $SqlCmd .= " AND user_legal_type = :user_legal_type";
            $params['user_legal_type'] = $filters['user_legal_type'];
        }
        if (!empty($filters['super_admin'])) {
            $SqlCmd .= " AND super_admin = :super_admin";
            $params['super_admin'] = $filters['super_admin'];
        }
        if (!empty($filters['is_view'])) {
            $SqlCmd .= " AND is_view = :is_view";
            $params['is_view'] = $filters['is_view'];
        }
        if (!empty($filters['task_name'])) {
            $SqlCmd .= " AND task_name LIKE :task_name";
            $params['task_name'] = '%' . $filters['task_name'] . '%';
        }

        $SqlCmd .= " AND reminder_date <= CURDATE()";
        $SqlCmd .= " AND task_date >= CURDATE()";

        if (!empty($filters['status'])) {
            $SqlCmd .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['active'])) {
            $SqlCmd .= " AND active = :active";
            $params['active'] = $filters['active'];
        }

        $SqlCmd .= " ORDER BY created_at DESC";

        $rows = $this->SELECT_MultiFetch($SqlCmd, $params);

        // Fast timestamp-based "X days ago"
        foreach ($rows as &$row) {
            if (!empty($row['created_at'])) {

                $createdTs = strtotime($row['created_at']);
                $nowTs = time();

                $days = floor(($nowTs - $createdTs) / 86400);

                if ($days > 0) {
                    $row['created_ago'] = $days . " day" . ($days > 1 ? "s" : "") . " ago";
                } else {
                    $row['created_ago'] = "Today";
                }
            } else {
                $row['created_ago'] = "Unknown";
            }
        }

        return ($this->_num_rows > 0) ? $rows : [];
    }
}
