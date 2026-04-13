<?php
/**
 * FILE: debug_activity_log.php  (ROOT of project)
 * PURPOSE: Diagnose why legal_activity_log is not storing data.
 * USAGE: Open http://localhost/tabasco_legal_code/debug_activity_log.php
 * DELETE this file after debugging is complete.
 */

session_start();
include_once('lib/config.php');
include_once('lib/class/class.dbcon.php');
include_once('lib/class/class.legal_activity_log.php');

echo '<style>body{font-family:monospace;padding:20px;} .ok{color:green;} .fail{color:red;} .info{color:#555;}</style>';
echo '<h2>🔍 Activity Log Debugger</h2>';

// ── Step 1: DB Connection ────────────────────────────────────
echo '<h3>Step 1: DB Connection</h3>';
try {
    $pdo = new PDO(
        "mysql:host=" . IP . ";dbname=" . DB . ";charset=utf8mb4",
        USER, DBPWD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo '<p class="ok">✅ Connected to <b>' . DB . '</b> on <b>' . IP . '</b></p>';
} catch (PDOException $e) {
    echo '<p class="fail">❌ DB Connection FAILED: ' . $e->getMessage() . '</p>';
    exit;
}

// ── Step 2: Table Exists? ────────────────────────────────────
echo '<h3>Step 2: Table Check</h3>';
$tableExists = $pdo->query("SHOW TABLES LIKE 'legal_activity_log'")->rowCount() > 0;
if ($tableExists) {
    echo '<p class="ok">✅ Table <b>legal_activity_log</b> EXISTS</p>';
    // Show columns
    $cols = $pdo->query("DESCRIBE legal_activity_log")->fetchAll(PDO::FETCH_ASSOC);
    echo '<table border="1" cellpadding="4" style="border-collapse:collapse;font-size:12px;">';
    echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Default</th></tr>';
    foreach ($cols as $col) {
        echo "<tr><td>{$col['Field']}</td><td>{$col['Type']}</td><td>{$col['Null']}</td><td>{$col['Default']}</td></tr>";
    }
    echo '</table>';
} else {
    echo '<p class="fail">❌ Table <b>legal_activity_log</b> does NOT exist.</p>';
    echo '<p class="info">👉 Run <b>database/schema_activity_log.sql</b> in phpMyAdmin first.</p>';

    // Auto-create it
    echo '<p class="info">⚙️ Attempting to auto-create table…</p>';
    $createSQL = "CREATE TABLE IF NOT EXISTS `legal_activity_log` (
        `log_id`          BIGINT(20)   NOT NULL AUTO_INCREMENT,
        `log_datetime`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `log_date`        DATE         NOT NULL,
        `log_user`        BIGINT(20)   NOT NULL DEFAULT 0,
        `log_utype`       VARCHAR(5)   NOT NULL DEFAULT 'U',
        `log_menu`        VARCHAR(100) NOT NULL,
        `log_action`      VARCHAR(50)  NOT NULL,
        `log_message`     TEXT         DEFAULT NULL,
        `log_url`         TEXT         DEFAULT NULL,
        `log_refr_id`     BIGINT(20)   DEFAULT NULL,
        `log_parent_id`   BIGINT(20)   NOT NULL DEFAULT 0,
        `log_parent_type` VARCHAR(50)  NOT NULL DEFAULT 'N/A',
        `log_before`      LONGTEXT     DEFAULT NULL,
        `log_after`       LONGTEXT     DEFAULT NULL,
        `log_ip`          VARCHAR(45)  DEFAULT NULL,
        `log_agent`       TEXT         DEFAULT NULL,
        PRIMARY KEY (`log_id`),
        KEY `idx_log_date`   (`log_date`),
        KEY `idx_log_user`   (`log_user`),
        KEY `idx_log_action` (`log_action`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    try {
        $pdo->exec($createSQL);
        echo '<p class="ok">✅ Table created successfully!</p>';
        $tableExists = true;
    } catch (PDOException $e) {
        echo '<p class="fail">❌ Auto-create failed: ' . $e->getMessage() . '</p>';
    }
}

// ── Step 3: Test Insert via LegalActivityLog ─────────────────
if ($tableExists) {
    echo '<h3>Step 3: Test Insert via LegalActivityLog</h3>';

    // Fake a session to simulate a logged-in admin
    $_SESSION['LOGIN_LEGAL_ID']   = 1;
    $_SESSION['LOGIN_SUPER_ADMIN'] = 'Y';

    try {
        $logger = new LegalActivityLog();
        $ok = $logger->logActivity(
            'VIEW',
            'Debug Test',
            999,
            'Test log entry from debug_activity_log.php',
            ['old_field' => 'old_value'],
            ['new_field' => 'new_value']
        );
        if ($ok) {
            echo '<p class="ok">✅ LegalActivityLog::logActivity() returned TRUE — row inserted!</p>';
        } else {
            echo '<p class="fail">❌ logActivity() returned FALSE — insert failed silently. Check PHP error_log.</p>';
        }
    } catch (Throwable $e) {
        echo '<p class="fail">❌ Exception: ' . $e->getMessage() . '</p>';
        echo '<pre class="fail">' . $e->getTraceAsString() . '</pre>';
    }

    // ── Step 4: Verify row in DB ─────────────────────────────
    echo '<h3>Step 4: Verify Latest Log Rows</h3>';
    $rows = $pdo->query("SELECT log_id, log_datetime, log_user, log_utype, log_menu, log_action, log_message, log_ip FROM legal_activity_log ORDER BY log_id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        echo '<table border="1" cellpadding="4" style="border-collapse:collapse;font-size:12px;color:green;">';
        echo '<tr><th>log_id</th><th>log_datetime</th><th>log_user</th><th>log_utype</th><th>log_menu</th><th>log_action</th><th>log_message</th><th>log_ip</th></tr>';
        foreach ($rows as $row) {
            echo '<tr>';
            foreach ($row as $v) echo '<td>' . htmlspecialchars($v ?? '—') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p class="fail">❌ No rows found in legal_activity_log — insert did not work.</p>';
    }
}

echo '<hr><p class="info">⚠️ Delete <b>debug_activity_log.php</b> after debugging.</p>';
