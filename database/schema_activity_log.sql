-- ============================================================
-- TABLE: legal_activity_log
-- PURPOSE: Tracks every CREATE / UPDATE / DELETE / VIEW / LOGIN
--          action performed by any admin, staff, or client user.
--
-- Column naming convention: log_* (must match autologgindb.php)
-- ============================================================

CREATE TABLE IF NOT EXISTS `legal_activity_log` (
  `log_id`          BIGINT(20)   NOT NULL AUTO_INCREMENT,
  `log_datetime`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Exact timestamp of action',
  `log_date`        DATE         NOT NULL                           COMMENT 'Date only — for fast date filtering',
  `log_user`        BIGINT(20)   NOT NULL DEFAULT 0                 COMMENT 'User ID from session',
  `log_utype`       VARCHAR(5)   NOT NULL DEFAULT 'U'               COMMENT 'A=Admin  S=Staff  C=Client  U=Unknown',
  `log_menu`        VARCHAR(100) NOT NULL                           COMMENT 'Module/section name, e.g. Cases',
  `log_action`      VARCHAR(50)  NOT NULL                           COMMENT 'LOGIN | CREATE | UPDATE | DELETE | VIEW',
  `log_message`     TEXT         DEFAULT NULL                       COMMENT 'Human-readable description',
  `log_url`         TEXT         DEFAULT NULL                       COMMENT 'Full URL of the page that triggered the log',
  `log_refr_id`     BIGINT(20)   DEFAULT NULL                       COMMENT 'Primary key of the affected record',
  `log_parent_id`   BIGINT(20)   NOT NULL DEFAULT 0                 COMMENT 'Parent record PK (e.g. Case ID)',
  `log_parent_type` VARCHAR(50)  NOT NULL DEFAULT 'N/A'             COMMENT 'Parent record type label',
  `log_before`      LONGTEXT     DEFAULT NULL                       COMMENT 'JSON snapshot of row BEFORE change',
  `log_after`       LONGTEXT     DEFAULT NULL                       COMMENT 'JSON snapshot of row AFTER change',
  `log_ip`          VARCHAR(45)  DEFAULT NULL                       COMMENT 'Client IP address',
  `log_agent`       TEXT         DEFAULT NULL                       COMMENT 'Browser user-agent string',
  PRIMARY KEY (`log_id`),
  KEY `idx_log_date`   (`log_date`),
  KEY `idx_log_user`   (`log_user`),
  KEY `idx_log_action` (`log_action`),
  KEY `idx_log_menu`   (`log_menu`(50))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
  COMMENT='Audit trail for all admin/user actions in Tabasco Legal';
