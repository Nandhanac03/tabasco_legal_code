<?php
class userPermission extends dbcon {

    public function get_legal_users(?int $user_Id = null, string $search = '', $user_typeId = '', $user_legal_access = '', $user_module = '', int $offset = 0, int $limit = 0)
    {
        $params = [];
        $Sqlcmd = "SELECT *
                   FROM users
                   LEFT JOIN usertype ON usertype.usertype_Id = users.user_typeId
                   WHERE user_status = 'A' AND user_sa='N'";

        if (!is_null($user_Id) && $user_Id > 0) {
            $Sqlcmd .= " AND user_Id = :user_Id";
            $params['user_Id'] = $user_Id;
        }

        if ($search !== '') {
            $Sqlcmd .= " AND (user_name LIKE :search OR user_emailId LIKE :search1 OR user_mob LIKE :search2)";
            $searchParam = "%{$search}%";
            $params['search'] = $params['search1'] = $params['search2'] = $searchParam;
        }

        if ($user_typeId !== '') {
            $Sqlcmd .= " AND user_typeId = :user_typeId";
            $params['user_typeId'] = $user_typeId;
        }

        if ($user_legal_access !== '') {
            $Sqlcmd .= " AND user_legal_access = :user_legal_access";
            $params['user_legal_access'] = $user_legal_access;
        }

        if ($user_module !== '') {
            $Sqlcmd .= " AND user_module = :user_module";
            $params['user_module'] = $user_module;
        }

        $Sqlcmd .= " ORDER BY user_Id DESC";

        if ($limit > 0) {
            $offset = max(0, (int)$offset);
            $limit = (int)$limit;
            $Sqlcmd .= " LIMIT {$offset}, {$limit}";
        }

        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }

    public function get_legal_menu(?int $id = null)
    {
        $params = [];
        $Sqlcmd = "SELECT *
                   FROM legal_menu
                   WHERE legal_menu.status = 'A'";

        if (!is_null($id) && $id > 0) {
            $Sqlcmd .= " AND id = :id";
            $params['id'] = $id;
        }

        $Sqlcmd .= " ORDER BY order_no";

        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }

    public function get_allowed_permission(?int $user_id = null, ?int $menu_id = null)
    {
        $params = [];
        $Sqlcmd = "SELECT *
                   FROM legal_menu_permission
                   WHERE legal_menu_permission.status = 'A'";

        if (!is_null($user_id) && $user_id > 0) {
            $Sqlcmd .= " AND user_id = :user_id";
            $params['user_id'] = $user_id;
        }

        if (!is_null($menu_id) && $menu_id > 0) {
            $Sqlcmd .= " AND menu_id = :menu_id";
            $params['menu_id'] = $menu_id;
        }

        $Sqlcmd .= " ORDER BY menu_id";

        $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);
        return ($this->_num_rows > 0) ? $this->_result : false;
    }

   public function get_user_allowed_permissions(?int $user_id = null)
{
    $params = [];
    $Sqlcmd = "SELECT user_id, menu_id, actions
               FROM legal_menu_permission
               WHERE legal_menu_permission.status = 'A'";

    if (!is_null($user_id) && $user_id > 0) {
        $Sqlcmd .= " AND user_id = :user_id";
        $params['user_id'] = $user_id;
    }

    $Sqlcmd .= " ORDER BY menu_id ASC";

    $this->_result = $this->SELECT_MultiFetch($Sqlcmd, $params);

    if ($this->_num_rows > 0) {
        $permissions = [];
        foreach ($this->_result as $row) {
            $permissions[$row['user_id']][$row['menu_id']] = $row['actions'];
        }

        // If specific user requested, return only their permissions
        if (!is_null($user_id) && isset($permissions[$user_id])) {
            return $permissions[$user_id];
        }

        return $permissions;
    }
    return false;
}

}
?>
