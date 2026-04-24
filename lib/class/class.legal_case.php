<?php
class LegalCase extends dbcon
{
    function saveCase($data = [], $id = '')
    {
        $params = [];

        $isUpdate =!empty($id);


        if ($id) {
            $sqlCmd = "UPDATE";
        } else {
            $sqlCmd = "INSERT INTO";
        }
        $sqlCmd .= " legal_case set";
        if ($data['active_legal_id']) {
            $sqlCmd .= " active_legal_id =:active_legal_id";
            $params['active_legal_id'] = $data['active_legal_id'];
        }
        if ($data['case_number']) {
            $sqlCmd .= ", case_number =:case_number";
            $params['case_number'] = $data['case_number'];
        }
        if ($data['category']) {
            $sqlCmd .= ", category =:category";
            $params['category'] = $data['category'];
        }
        if ($data['court']) {
            $sqlCmd .= ", court =:court";
            $params['court'] = $data['court'];
        }
        if ($data['plaintiff']) {
            $sqlCmd .= ", plaintiff =:plaintiff";
            $params['plaintiff'] = $data['plaintiff'];
        }
        if ($data['defendant']) {
            $sqlCmd .= ", defendant =:defendant";
            $params['defendant'] = $data['defendant'];
        }
        if ($data['register_date']) {
            $sqlCmd .= ", register_date =:register_date";
            $params['register_date'] = $data['register_date'];
        }
        if ($data['case_mode']) {
            $sqlCmd .= ", case_mode =:case_mode";
            $params['case_mode'] = $data['case_mode'];
        }
        if ($data['lawyer']) {
            $sqlCmd .= ", lawyer =:lawyer";
            $params['lawyer'] = $data['lawyer'];
        }
        if ($data['location']) {
            $sqlCmd .= ", location =:location";
            $params['location'] = $data['location'];
        }
        if ($data['case_date']) {
            $sqlCmd .= ", case_date =:case_date";
            $params['case_date'] = $data['case_date'];
        }
        if ($data['note']) {
            $sqlCmd .= ", note =:note";
            $params['note'] = $data['note'];
        }
        if ($id == '') {
            if ($data['created_id']) {
                $sqlCmd .= ", created_id =:created_id";
                $params['created_id'] = $data['created_id'];
            }
            if ($data['created_on']) {
                $sqlCmd .= ", created_on =:created_on";
                $params['created_on'] = $data['created_on'];
            }
        }
        if ($data['updated_id']) {
            $sqlCmd .= ", updated_id =:updated_id";
            $params['updated_id'] = $data['updated_id'];
        }
        if ($data['updated_on']) {
            $sqlCmd .= ", updated_on =:updated_on";
            $params['updated_on'] = $data['updated_on'];
        }
        if ($data['status']) {
            $sqlCmd .= ", status =:status";
            $params['status'] = $data['status'];
        }
        if ($data['total_outstanding']) {
            $sqlCmd .= ", total_outstanding =:total_outstanding";
            $params['total_outstanding'] = $data['total_outstanding'];
        }
        if ($data['outstanding_with_cheque']) {
            $sqlCmd .= ", outstanding_with_cheque =:outstanding_with_cheque";
            $params['outstanding_with_cheque'] = $data['outstanding_with_cheque'];
        }
        if ($data['outstanding_without_cheque']) {
            $sqlCmd .= ", outstanding_without_cheque =:outstanding_without_cheque";
            $params['outstanding_without_cheque'] = $data['outstanding_without_cheque'];
        }
        if ($id) {
            $sqlCmd .= " WHERE id=$id";
        }
        $this->_output_alert = 'Ok';
        $this->_last_query = $sqlCmd;
        $this->_inserted_id = $this->mysqlInsertid();
        $result = $this->Query($sqlCmd, $params);

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
                    'legal_case',                      // module/table
                    $loggedUserId,                     // user id
                    $isUpdate
                        ? "Updated Case record ID: $id"
                        : "Created Case record ID: $id",
                    $id                                // reference id
                );
            }
        }
        
        return $result;
        
    }

    function get_case($id = '', $active_legal_id = '', $case_number = '')
    {
        $params = [];
    
        $Sqlcmd = "
            SELECT 
                lc.*,
                lcm.title AS case_mode_title,
    
               
                lch.hearing_date,
                lch.hearing_feedback_date,
                lch.hearing_feedback,
    
                
                al.client AS client_id,
     cat.title AS category_name,
      law.user_name AS lawyer,
    
             
                lchs.id AS plantiff
    
            FROM legal_case AS lc
    
           LEFT JOIN legal_category cat ON lc.category = cat.id

            LEFT JOIN users law ON lc.lawyer = law.user_Id

           


            LEFT JOIN legal_case_hearing AS lch
                ON lch.id = (
                    SELECT lch2.id
                    FROM legal_case_hearing lch2
                    WHERE lch2.case_id = lc.id
                    ORDER BY lch2.hearing_date DESC, lch2.id DESC
                    LIMIT 1
                )
    
           
            LEFT JOIN legal_plantiff AS lchs
                ON lchs.id = (
                    SELECT lp.id
                    FROM legal_plantiff lp
                    JOIN legal_activelegal al2
                        ON al2.client = lp.parent_id
                    WHERE al2.id = lc.active_legal_id
                    ORDER BY lp.id DESC
                    LIMIT 1
                )
    
           
            JOIN legal_case_mode AS lcm
                ON lc.case_mode = lcm.id
    
          
            JOIN legal_activelegal AS al
                ON lc.active_legal_id = al.id
    
            WHERE lc.status = 'A'
        ";
    
        if (!empty($id)) {
            $Sqlcmd .= " AND lc.id = :id";
            $params['id'] = $id;
        }
    
        if (!empty($active_legal_id)) {
            $Sqlcmd .= " AND lc.active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $active_legal_id;
        }
    
        if (!empty($case_number)) {
            $Sqlcmd .= " AND lc.case_number LIKE :case_number";
            $params['case_number'] = "%{$case_number}%";
        }
    
        $Sqlcmd .= " ORDER BY lc.id DESC";
    
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    

// FUNCTION FOR FETCHING MULTIPLE HEARING DATE 
    // function get_case_info($id = '', $active_legal_id = '', $case_number = '')
    // {
    //     $params = [];
    //     $Sqlcmd = "
    //     SELECT 
    //         lc.*,
    //         lcm.title AS case_mode_title,
    //         lch.hearing_date,
    //         lch.hearing_feedback_date,
    //         lch.hearing_feedback,
    //         al.client AS client_id,
    //         CASE 
    //             WHEN lc.lawyer REGEXP '^[0-9]+$' THEN u.user_name
    //             ELSE lc.lawyer
    //         END AS lawyer_name
    //     FROM legal_case AS lc
    //     LEFT JOIN legal_case_hearing AS lch
    //         ON lc.id = lch.case_id
    //     LEFT JOIN users AS u
    //         ON lc.lawyer REGEXP '^[0-9]+$'
    //         AND u.user_Id = lc.lawyer
    //     JOIN legal_case_mode AS lcm
    //         ON lc.case_mode = lcm.id
    //     JOIN legal_activelegal AS al
    //         ON lc.active_legal_id = al.id
    //     WHERE 1=1
    // ";

    //     if (!empty($id)) {
    //         $Sqlcmd .= " AND lc.id = :id";
    //         $params['id'] = $id;
    //     }
    //     if (!empty($active_legal_id)) {
    //         $Sqlcmd .= " AND lc.active_legal_id = :active_legal_id";
    //         $params['active_legal_id'] = $active_legal_id;
    //     }
    //     if (!empty($case_number)) {
    //         $Sqlcmd .= " AND lc.case_number LIKE :case_number";
    //         $params['case_number'] = "%$case_number%";
    //     }

    //     $Sqlcmd .= " AND lc.status = 'A'";
    //     $Sqlcmd .= " ORDER BY lc.id DESC";

    //     $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    //     return ($this->_num_rows > 0) ? $this->_result : false;
    // }


// FUNCTION FOR AVOIDING MULTIPLE HEARING DATE IT ONLY GIVE LAST ENTEERED HEARING DATE
    function get_case_info($id = '', $active_legal_id = '', $case_number = '')
    {
        $params = [];

        $Sqlcmd = "
        SELECT 
            lc.*,
            lcm.title AS case_mode_title,
            lch.hearing_date,
            lch.hearing_feedback_date,
            lch.hearing_feedback,
            al.client AS client_id,
            cat.title AS category_name,

            CASE 
                WHEN lc.lawyer REGEXP '^[0-9]+$' THEN u.user_name
                ELSE lc.lawyer
            END AS lawyer_name
        FROM legal_case AS lc
        LEFT JOIN legal_category cat ON lc.category = cat.id

        /* Get ONLY the latest hearing */
        LEFT JOIN legal_case_hearing AS lch
            ON lch.id = (
                SELECT id 
                FROM legal_case_hearing 
                WHERE case_id = lc.id
                ORDER BY hearing_date DESC, id DESC
                LIMIT 1
            )

        LEFT JOIN users AS u
            ON lc.lawyer REGEXP '^[0-9]+$'
            AND u.user_Id = lc.lawyer

        JOIN legal_case_mode AS lcm
            ON lc.case_mode = lcm.id

        JOIN legal_activelegal AS al
            ON lc.active_legal_id = al.id

        WHERE 1 = 1
    ";

        if (!empty($id)) {
            $Sqlcmd .= " AND lc.id = :id";
            $params['id'] = $id;
        }

        if (!empty($active_legal_id)) {
            $Sqlcmd .= " AND lc.active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $active_legal_id;
        }

        if (!empty($case_number)) {
            $Sqlcmd .= " AND lc.case_number LIKE :case_number";
            $params['case_number'] = "%$case_number%";
        }

        $Sqlcmd .= " AND lc.status = 'A'";
        $Sqlcmd .= " ORDER BY lc.id DESC";

        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }




    function disable_case($data = [], $id)
    {
        $params = [];
        if ($id) {
            $sqlCmd = "UPDATE";
        }
        $sqlCmd .= " legal_case set";
        if ($data['updated_id']) {
            $sqlCmd .= " updated_id =:updated_id";
            $params['updated_id'] = $data['updated_id'];
        }
        if ($data['updated_on']) {
            $sqlCmd .= ", updated_on =:updated_on";
            $params['updated_on'] = $data['updated_on'];
        }
        if ($data['status']) {
            $sqlCmd .= ", status =:status";
            $params['status'] = 'D';
        }
        $sqlCmd .= " WHERE id=$id";
        $this->_output_alert = 'Ok';
        $this->_last_query = $sqlCmd;
        $this->_inserted_id = $this->mysqlInsertid();
        $result = $this->Query($sqlCmd, $params);

if ($result) {

    include_once("class.legal_activity_log.php");
    $activity = new LegalActivityLog();

    // logged in user
    $loggedUserId = $_SESSION['LOGIN_LEGAL_ID'] ?? null;

    if ($loggedUserId) {
        $activity->logActivity(
            'DISABLE',                     // action
            'legal_case',                  // module/table
            $loggedUserId,                 // user id
            "Case disabled (ID: $id)",     // message
            $id                            // reference id
        );
    }
}

return $result;
    }
    
    function saveRoots($data = [], $id = '')
    {
        $params = [];
        if ($id) {
            $sqlCmd = "UPDATE";
        } else {
            $sqlCmd = "INSERT INTO";
        }
        $sqlCmd .= " legal_case_roots set";
        if ($data['case_id']) {
            $sqlCmd .= " case_id =:case_id";
            $params['case_id'] = $data['case_id'];
        }
        if ($data['active_legal_id']) {
            $sqlCmd .= ", active_legal_id =:active_legal_id";
            $params['active_legal_id'] = $data['active_legal_id'];
        }
        if ($data['lawyer']) {
            $sqlCmd .= ", lawyer =:lawyer";
            $params['lawyer'] = $data['lawyer'];
        }
        if ($data['court']) {
            $sqlCmd .= ", court =:court";
            $params['court'] = $data['court'];
        }
        if ($data['stage']) {
            $sqlCmd .= ", stage =:stage";
            $params['stage'] = $data['stage'];
        }

        if ($data['plantiff']) {
            $sqlCmd .= ", plantiff =:plantiff";
            $params['plantiff'] = $data['plantiff'];
        }

        if ($data['defendant']) {
            $sqlCmd .= ", defendant =:defendant";
            $params['defendant'] = $data['defendant'];
        }
        if ($data['category']) {
            $sqlCmd .= ", category =:category";
            $params['category'] = $data['category'];
        }
        if ($data['register_date']) {
            $sqlCmd .= ", register_date =:register_date";
            $params['register_date'] = $data['register_date'];
        }
        if ($data['root_cat_number']) {
            $sqlCmd .= ", root_cat_number =:root_cat_number";
            $params['root_cat_number'] = $data['root_cat_number'];
        }
        if ($id == '') {
            if ($data['created_by']) {
                $sqlCmd .= ", created_by =:created_by";
                $params['created_by'] = $data['created_by'];
            }
            if ($data['created_on']) {
                $sqlCmd .= ", created_on =:created_on";
                $params['created_on'] = $data['created_on'];
            }
        }
        if ($data['updated_by']) {
            if ($data['updated_by']) {
                $sqlCmd .= ", updated_by =:updated_by";
                $params['updated_by'] = $data['updated_by'];
            }
        }
        if ($data['updated_on']) {
            if ($data['updated_on']) {
                $sqlCmd .= ", updated_on =:updated_on";
                $params['updated_on'] = $data['updated_on'];
            }
        }
        if ($data['status']) {
            $sqlCmd .= ", status =:status";
            $params['status'] = $data['status'];
        }
        if ($id) {
            $sqlCmd .= " WHERE id=$id";
        }
        $this->_output_alert = 'Ok';
        $this->_last_query = $sqlCmd;
        $this->_inserted_id = $this->mysqlInsertid();
        $result = $this->Query($sqlCmd, $params);

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
                    'legal_case_roots',                      // module/table
                    $loggedUserId,                     // user id
                    $isUpdate
                        ? "Updated Case Roots ID: $id"
                        : "Created Case Roots ID: $id",
                    $id                                // reference id
                );
            }
        }
        
        return $result;
        
    }

    function get_roots($id = '', $case_id = '', $active_legal_id = '', $stage = '', $category = '')
    {
        $params = [];
        $Sqlcmd = "SELECT * FROM legal_case_roots WHERE 1";
        if ($id) {
            $Sqlcmd .= " AND id=:id";
            $params['id'] = $id;
        }
        if ($case_id) {
            $Sqlcmd .= " AND case_id=:case_id";
            $params['case_id'] = $case_id;
        }
        if ($active_legal_id) {
            $Sqlcmd .= " AND active_legal_id=:active_legal_id";
            $params['active_legal_id'] = $active_legal_id;
        }
        if ($stage) {
            $Sqlcmd .= " AND stage=:stage";
            $params['stage'] = $stage;
        }
        if ($category) {
            $Sqlcmd .= " AND category=:category";
            $params['category'] = $category;
        }
        $Sqlcmd .= " AND status ='A'";
        $Sqlcmd .= " ORDER BY id DESC";
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }



//     function all_get_roots($case_id, $id = '', $active_legal_id = '')
// {
//     // ❗ Force case_id
//     if (empty($case_id)) {
//         return false; // or throw error
//     }

//     $params = [
//         'case_id' => $case_id
//     ];

//     $Sqlcmd = "
//         SELECT 
//             r.*, 
//             c.title AS court_name, 
//             cat.title AS category_name
//         FROM legal_case_roots r
//         LEFT JOIN legal_court c ON r.court = c.id
//         LEFT JOIN legal_category cat ON r.category = cat.id
//         WHERE r.status = 'A'
//         AND r.case_id = :case_id
//     ";

//     // Optional filters
//     if (!empty($id)) {
//         $Sqlcmd .= " AND r.id = :id";
//         $params['id'] = $id;
//     }

//     if (!empty($active_legal_id)) {
//         $Sqlcmd .= " AND r.active_legal_id = :active_legal_id";
//         $params['active_legal_id'] = $active_legal_id;
//     }

//     $Sqlcmd .= " ORDER BY r.id DESC";

//     $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);

//     return ($this->_num_rows > 0) ? $this->_result : false;
// }


    // function all_get_roots($id = '', $case_id = '', $active_legal_id = '')
    // {
    //     $params = [];
    
    //     $Sqlcmd = "
    //         SELECT 
    //             r.*, 
    //             c.title AS court_name, 
    //             cat.title AS category_name
    //         FROM legal_case_roots r
    //         LEFT JOIN legal_court c ON r.court = c.id
    //         LEFT JOIN legal_category cat ON r.category = cat.id
    //         WHERE r.status = 'A'
    //     ";
    
    //     if ($id) {
    //         $Sqlcmd .= " AND r.id = :id";
    //         $params['id'] = $id;
    //     }
    
    //     if ($case_id) {
    //         $Sqlcmd .= " AND r.case_id = :case_id";
    //         $params['case_id'] = $case_id;
    //     }
    
    //     if ($active_legal_id) {
    //         $Sqlcmd .= " AND r.active_legal_id = :active_legal_id";
    //         $params['active_legal_id'] = $active_legal_id;
    //     }
    
    //     $Sqlcmd .= " ORDER BY r.id DESC";
    
    //     $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    
    //     return ($this->_num_rows > 0) ? $this->_result : false;
    // }
    



    function all_get_roots($id = '', $case_id = '', $active_legal_id = '')
    {
        $params = [];
    
        $Sqlcmd = "
            SELECT 
                r.*, 
                c.title AS court_name, 
                cat.title AS category_name,
    
                a.id AS action_id,
                a.date AS action_date,
                a.description AS action_description,
                a.document,
                a.uae_pass
    
            FROM legal_case_roots r
    
            LEFT JOIN legal_court c 
                ON r.court = c.id
    
            LEFT JOIN legal_category cat 
                ON r.category = cat.id
    
            LEFT JOIN legal_case_root_actions a 
                ON a.case_root_id = r.id 
                AND a.status = 'A'
    
            WHERE r.status = 'A'
        ";
    
        if ($id) {
            $Sqlcmd .= " AND r.id = :id";
            $params['id'] = $id;
        }
    
        if ($case_id) {
            $Sqlcmd .= " AND r.case_id = :case_id";
            $params['case_id'] = $case_id;
        }
    
        if ($active_legal_id) {
            $Sqlcmd .= " AND r.active_legal_id = :active_legal_id";
            $params['active_legal_id'] = $active_legal_id;
        }
    
        $Sqlcmd .= " ORDER BY r.id DESC, a.date DESC";
    
        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    



    function get_case_root_clients($case_id) {
        $params = ['case_id' => $case_id];
    
        $sql = "
            SELECT
                c.id  AS case_id,
                al.id AS active_legal_id,
                lc.id AS client_id,
                lp.id AS plantiff_id,
                lp.name AS plantiff
            FROM legal_case c
            INNER JOIN legal_activelegal al 
                ON c.active_legal_id = al.id
            INNER JOIN legal_client lc 
                ON al.client = lc.id
            INNER JOIN legal_plantiff lp 
                ON lp.parent_id = lc.id
               AND lp.parent_type = 'C'
            WHERE c.id = :case_id
              AND al.status = 'A'
              AND lp.status = 'A'
            ORDER BY lp.id DESC
        ";
    

 // 🔍 DEBUG
//  echo "<pre>";
//  echo "SQL:\n$sql\n\n";
//  echo "Params:\n";
//  print_r($params);
//  echo "</pre>";
//  exit;


        $this->_result = $this->SELECT_MultiFetch($sql, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    





    function get_case_root_clients_defender($case_id) {
        $params = ['case_id' => $case_id];
    
        $sql = "
            SELECT
                c.id  AS case_id,
                al.id AS active_legal_id,
                lc.id AS client_id,
                lp.id AS defendant_id,
                lp.name AS defendant
            FROM legal_case c
            INNER JOIN legal_activelegal al 
                ON c.active_legal_id = al.id
            INNER JOIN legal_client lc 
                ON al.client = lc.id
            INNER JOIN legal_defender lp 
                ON lp.parent_id = lc.id
               AND lp.parent_type = 'C'
            WHERE c.id = :case_id
              AND al.status = 'A'
              AND lp.status = 'A'
            ORDER BY lp.id DESC
        ";
    
        $this->_result = $this->SELECT_MultiFetch($sql, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }
    

    // function get_case_root_clients_defender(
    //     $client_id = null,
    //     $id = null,
    //     $case_id = null,
    //     $active_legal_id = null
    // ) {
    //     $params = [];
    
    //     $Sqlcmd = "
    //         SELECT DISTINCT
    //             lp.id   AS defender_id,
    //             lp.name AS defender_name,
    //             lc.id   AS client_id,
    //             lc.name AS client_name
    //         FROM legal_defender lp
    //         INNER JOIN legal_client lc 
    //             ON lc.id = lp.parent_id
    //         WHERE 1 = 1
    //     ";
  
    //     if ($client_id !== null) {
    //         $Sqlcmd .= " AND lp.parent_id = :client_id";
    //         $params['client_id'] = $client_id;
    //     }
    
    //     if ($id !== null) {
    //         $Sqlcmd .= " AND lp.id = :id";
    //         $params['id'] = $id;
    //     }
    
    //     if ($case_id !== null) {
    //         $Sqlcmd .= " AND lp.case_id = :case_id";
    //         $params['case_id'] = $case_id;
    //     }
    
    //     if ($active_legal_id !== null) {
    //         $Sqlcmd .= " AND lp.active_legal_id = :active_legal_id";
    //         $params['active_legal_id'] = $active_legal_id;
    //     }
    
    //     $Sqlcmd .= " ORDER BY lp.id DESC";
    
    //     $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
    
    //     return ($this->_num_rows > 0) ? $this->_result : false;
    // }
    



    // public function get_case_root_clients($parent_id)
    // {
    //     $this->CI->db->select('DISTINCT lc.id, lc.name');
    //     $this->CI->db->from('legal_case_roots_actions lcra');
    //     $this->CI->db->join('legal_client lc', 'lc.id = lcra.client_id', 'inner');
    //     $this->CI->db->where('lcra.parent_id', $parent_id);

    //     return $this->CI->db->get()->result();
    // }





    function get_plantiffs_by_client($client_id)
{
    $sql = "
        SELECT id, name
        FROM legal_plantiff
        WHERE parent_id = :client_id
          AND parent_type = 'C'
          AND status = 'A'
        ORDER BY name ASC
    ";

    $params = ['client_id' => $client_id];

    $this->_result = $this->SELECT_MultiFetch($sql, $params);
    return ($this->_num_rows > 0) ? $this->_result : [];
}

function get_defendant_by_client($client_id)
{
    $sql = "
        SELECT id, name
        FROM legal_defender
        WHERE parent_id = :client_id
          AND parent_type = 'C'
          AND status = 'A'
        ORDER BY name ASC
    ";

    $params = ['client_id' => $client_id];

    $this->_result = $this->SELECT_MultiFetch($sql, $params);
    return ($this->_num_rows > 0) ? $this->_result : [];
}





public function get_legal_case($active_legal_id = '')
{
    $params = [];
    $sql = "SELECT LC.*, AL.client FROM legal_case LC JOIN legal_activelegal AL ON LC.active_legal_id = AL.id WHERE LC.status = 'A'";

    if (!empty($active_legal_id)) {
        $sql .= " AND LC.active_legal_id = :active_legal_id";
        $params['active_legal_id'] = $active_legal_id;
    }

    $sql .= " ORDER BY LC.id DESC";

    $this->_result = $this->SELECT_MultiFetch($sql, $params);

    return ($this->_num_rows > 0) ? $this->_result : [];
}



}
