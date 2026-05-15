<?php

class LegalActivityLog extends dbcon
{
    public function logActivity($action, $module, $user_id = null, $message = '', $ref_id = null) {
        $params = [
            ':log_datetime' => date('Y-m-d H:i:s'),
            ':log_date'     => date('Y-m-d'),
            ':log_user'     => $user_id ?? 0,
            ':log_utype'    => $this->getUserType($user_id),
            ':log_menu'     => $module, // Using module as menu/context
            ':log_action'   => $action,
            ':module'       => $module,
            ':log_message'  => $message . ($ref_id ? " (Ref ID: $ref_id)" : ""),
            ':log_url'      => $_SERVER['REQUEST_URI'] ?? '',
        ];
    
        $sql = "INSERT INTO legal_activity_log
                (log_datetime, log_date, log_user, log_utype, log_menu, log_action, module, log_message, log_url)
                VALUES (:log_datetime, :log_date, :log_user, :log_utype, :log_menu, :log_action, :module, :log_message, :log_url)";
        
        return $this->Query($sql, $params);
    }
    public function getUserType($user_id = null) {
        if (empty($user_id)) {
            return 'U'; // Default unknown user type
        }
    
        // Assuming $this->_db or Query() works with PDO
        $sql = "SELECT user_typeId FROM users WHERE user_Id = :user_id LIMIT 1";
        $params = [':user_id' => $user_id];
        $result = $this->SELECT_MultiFetch($sql, $params);
    
        if ($this->_num_rows > 0) {
            $row = (object)$result[0];
            // Map numeric type to letter or description if needed
            switch ($row->user_typeId) {
                case 1: return 'A'; // Admin
                case 2: return 'U'; // Regular User
                case 5: return 'S'; // Super Admin
                default: return 'U'; // Unknown
            }
        }
    
        return 'U';
    }
    
}
