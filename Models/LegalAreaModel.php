<?php
namespace App\Models;

use core\AutoLoggingDB;

class LegalAreaModel extends BaseModel {

    public function saveArea(array $data, ?int $id = null): \PDOStatement {
        $isUpdate = $id !== null;
        $params = [];

        $sql = $isUpdate ? "UPDATE legal_area SET " : "INSERT INTO legal_area SET ";
        $fields = ['title', 'description', 'status'];
        foreach ($fields as $f) {
            if (isset($data[$f])) {
                $sql .= "{$f}=:{$f}, ";
                $params[$f] = $data[$f];
            }
        }

        if (!$isUpdate) {
            $sql .= "created_by=:created_by, created_on=NOW(), ";
            $params['created_by'] = $data['created_by'] ?? ($_SESSION['user_id'] ?? 0);
        }

        $sql .= "updated_by=:updated_by, updated_on=NOW() ";
        $params['updated_by'] = $data['updated_by'] ?? ($_SESSION['user_id'] ?? 0);

        if ($isUpdate) {
            $sql .= " WHERE id=:id";
            $params['id'] = $id;
        }

        return $this->db->query($sql, $params);
    }
}
