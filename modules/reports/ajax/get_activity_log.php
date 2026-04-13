<?php
// ============================================================
// FILE: modules/reports/ajax/get_activity_log.php
// PURPOSE: AJAX — returns activity log rows as JSON for DataTable
// ============================================================
header('Content-Type: application/json');
ob_start();
session_start();

// Admin-only access guard
if (empty($_SESSION['LOGIN_LEGAL_ID']) && empty($_SESSION['LOGIN_SUPERADMIN_ID'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

include_once('../../../lib/config.php');
include_once('../../../lib/class/class.dbcon.php');

$pdo_dsn = "mysql:host=" . IP . ";dbname=" . DB . ";charset=utf8mb4";
try {
    $pdo = new PDO($pdo_dsn, USER, DBPWD, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}

// ── Filters ─────────────────────────────────────────────────
$date_from  = $_GET['date_from']  ?? '';
$date_to    = $_GET['date_to']    ?? '';
$utype      = $_GET['utype']      ?? '';
$action     = $_GET['action']     ?? '';
$module     = $_GET['module']     ?? '';
$search     = $_GET['search']     ?? '';

$where  = [];
$params = [];

if ($date_from) { $where[] = 'log_date >= :date_from'; $params['date_from'] = $date_from; }
if ($date_to)   { $where[] = 'log_date <= :date_to';   $params['date_to']   = $date_to; }
if ($utype)     { $where[] = 'log_utype = :utype';     $params['utype']     = $utype; }
if ($action)    { $where[] = 'log_action = :action';   $params['action']    = strtoupper($action); }
if ($module)    { $where[] = 'log_menu = :module';     $params['module']    = $module; }
if ($search)    {
    $where[]          = '(log_message LIKE :search OR log_menu LIKE :search2 OR log_action LIKE :search3)';
    $params['search']  = "%{$search}%";
    $params['search2'] = "%{$search}%";
    $params['search3'] = "%{$search}%";
}

$whereSQL = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

// Total count
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM legal_activity_log $whereSQL");
$countStmt->execute($params);
$total = (int) $countStmt->fetchColumn();

// Paged data
$limit  = max(1, (int) ($_GET['length'] ?? 25));
$offset = max(0, (int) ($_GET['start']  ?? 0));

$sql = "SELECT log_id, log_datetime, log_user, log_utype,
               log_menu, log_action, log_message, log_url,
               log_refr_id, log_parent_id, log_parent_type,
               log_before, log_after, log_ip
        FROM legal_activity_log
        $whereSQL
        ORDER BY log_id DESC
        LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) $stmt->bindValue($k, $v);
$stmt->bindValue('limit',  $limit,  PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

$utype_labels = ['A' => 'Admin', 'S' => 'Staff', 'C' => 'Client', 'U' => 'Unknown'];
$action_colors = [
    'LOGIN'  => 'primary',
    'CREATE' => 'success',
    'UPDATE' => 'warning',
    'DELETE' => 'danger',
    'VIEW'   => 'info',
];

$data = [];
foreach ($rows as $row) {
    $utLabel    = $utype_labels[$row['log_utype']] ?? $row['log_utype'];
    $actColor   = $action_colors[$row['log_action']] ?? 'secondary';
    $hasDiff    = ($row['log_before'] || $row['log_after']);

    $data[] = [
        'log_id'       => $row['log_id'],
        'log_datetime' => $row['log_datetime'],
        'log_user'     => $row['log_user'],
        'log_utype'    => "<span class=\"badge bg-{$actColor} bg-opacity-10 text-{$actColor} border border-{$actColor}\">{$utLabel}</span>",
        'log_menu'     => htmlspecialchars($row['log_menu']),
        'log_action'   => "<span class=\"badge bg-{$actColor}\">{$row['log_action']}</span>",
        'log_message'  => htmlspecialchars($row['log_message'] ?? ''),
        'log_ip'       => $row['log_ip'] ?? '—',
        'log_refr_id'  => $row['log_refr_id'] ?? '—',
        'diff_btn'     => $hasDiff
            ? "<button class='btn btn-xs btn-outline-secondary py-0 px-1 view-diff-btn'
                   data-id='{$row['log_id']}'
                   data-before='" . htmlspecialchars($row['log_before'] ?? '{}') . "'
                   data-after='"  . htmlspecialchars($row['log_after']  ?? '{}') . "'>
                   <i class='bx bx-code-alt'></i> Diff
               </button>"
            : '—',
    ];
}

echo json_encode([
    'recordsTotal'    => $total,
    'recordsFiltered' => $total,
    'data'            => $data,
]);
