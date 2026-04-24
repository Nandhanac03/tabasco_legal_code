<?php
namespace App\Models;

use core\AutoLoggingDB; // ✅ Match class name exactly

abstract class BaseModel {
    protected AutoLoggingDB $db; // ✅ Match type hint casing

    public function __construct() {
        $this->db = new AutoLoggingDB();
    }
}
