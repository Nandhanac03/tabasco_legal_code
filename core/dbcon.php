<?php
require_once __DIR__ . '/class/config.php';

class dbcon {
    protected static $instance = null;
    protected PDO $pdo;

    public function __construct() {
        if (!self::$instance) {
            self::$instance = new PDO(
                "mysql:host=".IP.";dbname=".DB.";charset=utf8mb4",
                USER,
                DBPWD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }
        $this->pdo = self::$instance;
    }

    public function Query(string $sql, array $params = []): PDOStatement {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function lastInsertId(): string {
        return $this->pdo->lastInsertId();
    }
}
