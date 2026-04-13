<?php

require_once __DIR__ . '/class.dbcon.php';


class LegalCommissionVoucher {
    private $db;

    public function __construct()
    {
        $this->db = new Dbcon();   // ✅ create DB connection
    }
 

    public function createVoucher($data)
    {
        $sql = "INSERT INTO legal_commission_voucher
                (voucher_no, voucher_date, total_amount, status, printed_at, created_by, created_at, commission_pdf)
                VALUES (:voucher_no, :voucher_date, :total_amount, 'Printed', NOW(), :created_by, NOW(), :commission_pdf)";
    
        $result = $this->db->Query($sql, $data);
    
        if ($result) {
    
            $insertId = $this->db->mysqlInsertid();
    
            /* ===== ACTIVITY LOG ===== */
            include_once("class.legal_activity_log.php");
            $activity = new LegalActivityLog();
    
            $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;
    
            if ($loggedUserId) {
    
                $activity->logActivity(
                    'INSERT',                         // action
                    'legal_commission_voucher',       // module/table
                    $loggedUserId,                    // user id
                    "Created Commission Voucher ID: $insertId",
                    $insertId                         // reference id
                );
    
            }
    
            return $insertId;
        }
    
        return false;
    }
    

    public function getLastVoucherId() {
        $result = $this->db->Query("SELECT LAST_INSERT_ID() as id");
        return $result[0]['id'] ?? 0;
    }

    public function get_all_commission_vouchers()
    {
        $sql = "
            SELECT *
            FROM legal_commission_voucher
            ORDER BY id DESC
        ";

        return $this->db->SELECT_MultiFetch($sql);
    }
   public function get_all_vouchers()
{
    $sql = "
        SELECT *
        FROM legal_commission_voucher
        WHERE status IN ('Printed','Paid')
        AND total_amount > 0.00
        ORDER BY id DESC
    ";

    return $this->db->SELECT_MultiFetch($sql);
}



public function get_vouchers()
{
    $sql = "
        SELECT *
        FROM legal_commission_voucher
        WHERE status != 'paid'
         AND total_amount > 0.00
        ORDER BY id DESC
    ";

    return $this->db->SELECT_MultiFetch($sql);
}



    
}
?>
