<?php

class LegalActivityLogAmount extends dbcon
{
    public function logAmountActivity($action, $module, $user_id = null, $message = '', $ref_id = null) {
        $this->ensureAmountTableExists();

        $params = [
            ':log_datetime' => date('Y-m-d H:i:s'),
            ':log_user'     => $user_id ?? 0,
            ':log_utype'    => $this->getUserType($user_id),
            ':log_menu'     => $module,
            ':log_action'   => $action,
            ':log_message'  => $message . ($ref_id ? " (Ref ID: $ref_id)" : ""),
            ':log_url'      => $_SERVER['REQUEST_URI'] ?? '',
        ];

        $sql = "INSERT INTO legal_activitylog_amount
                (log_datetime, log_user, log_utype, log_menu, log_action, log_message, log_url)
                VALUES (:log_datetime, :log_user, :log_utype, :log_menu, :log_action, :log_message, :log_url)";
        
        try {
            if ($this->_pdo) {
                $stmt = $this->_pdo->prepare($sql);
                return $stmt->execute($params);
            }
        } catch (Exception $e) {
            // Gracefully log database issue but do not halt the script,
            // ensuring main client/activelegal saves always succeed.
            error_log("Failed to log amount activity: " . $e->getMessage());
        }
        return false;
    }

    private function ensureAmountTableExists() {
        $sql = "CREATE TABLE IF NOT EXISTS `legal_activitylog_amount` (
            `id`              BIGINT(20)   NOT NULL AUTO_INCREMENT,
            `log_datetime`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `log_user`        BIGINT(20)   NOT NULL DEFAULT 0,
            `log_utype`       VARCHAR(5)   NOT NULL DEFAULT 'U',
            `log_menu`        VARCHAR(100) NOT NULL,
            `log_action`      VARCHAR(50)  NOT NULL,
            `log_message`     TEXT         DEFAULT NULL,
            `log_url`         TEXT         DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_log_user`   (`log_user`),
            KEY `idx_log_action` (`log_action`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        
        try {
            if ($this->_pdo) {
                $this->_pdo->exec($sql);
            }
        } catch (Exception $e) {
            // Gracefully catch privilege/connection issues.
            error_log("Table legal_activitylog_amount could not be auto-created: " . $e->getMessage());
        }
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
