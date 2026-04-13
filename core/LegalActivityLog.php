<?php
require_once __DIR__ . 'core/dbcon.php';
class LegalActivityLog extends dbcon {
   // exit;

   public function logActivity(
    $action,
    $module,
    $log_user,        // user who performed the action
    $message,
    $log_refr_id = null,
    $before = null,
    $after = null
): void {
    // Use the parameters passed in, fallback to session only if not provided
    $user_id = $log_user ?? ($_SESSION['user_id'] ?? null);
    $role    = $_SESSION['role'] ?? null;
    $ip      = $_SERVER['REMOTE_ADDR'] ?? null;
    $url     = $_SERVER['REQUEST_URI'] ?? null;

    $this->Query(
        "INSERT INTO legal_activity_logs
        (log_user, log_utype, log_action, log_menu, log_message, log_url, log_refr_id, beforei, afteri, ip, log_datetime, log_date)
        VALUES
        (:log_user, :log_utype, :log_action, :log_menu, :log_message, :log_url, :log_refr_id, :beforei, :afteri, :ip, NOW(), CURDATE())",
        [
            'log_user'    => $user_id,
            'log_utype'   => $role,
            'log_action'  => $action,
            'log_menu'    => $module,
            'log_message' => $message,
            'log_url'     => $url,
            'log_refr_id' => $log_refr_id,
            'beforei'     => $before ? json_encode($before) : null,
            'afteri'      => $after ? json_encode($after) : null,
            'ip'          => $ip
        ]
    );
}


}






    

