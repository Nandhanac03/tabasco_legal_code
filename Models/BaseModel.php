<?php
require_once __DIR__ . 'core/AutoLoggingDB.php';

abstract class BaseModel {
    protected AutoLoggingDB $db;

    public function __construct() {
        $this->db = new AutoLoggingDB();
    }
}
