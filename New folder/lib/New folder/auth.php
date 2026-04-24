<?php

// ========================================================
// Check if LEGAL_PAGES_AUTH is defined, if not, define it
// ========================================================
if (!defined('LEGAL_PAGES_AUTH')) {
    define('LEGAL_PAGES_AUTH', false);
}

// ========================================================
// ✅ Declare global permission array (by reference)
// ========================================================
$GLOBALS['LEGAL_AUTH_FLAGS'] = [
    'LEGAL_AUTH_VIEW'   => false,
    'LEGAL_AUTH_ADD'    => false,
    'LEGAL_AUTH_EDIT'   => false,
    'LEGAL_AUTH_DELETE' => false,
    'LEGAL_AUTH_PRINT'  => false,
    'LEGAL_AUTH_MAIL'   => false
];

// ========================================================
// 🚫 If agency = 1 → force all FALSE (deny everything)
// ========================================================
if (isset($_SESSION['LOGIN_AGENCIES']) && $_SESSION['LOGIN_AGENCIES'] == 1) {
    if (!defined('LEGAL_AUTH_VIEW'))   define('LEGAL_AUTH_VIEW', false);
    if (!defined('LEGAL_AUTH_ADD'))    define('LEGAL_AUTH_ADD', false);
    if (!defined('LEGAL_AUTH_EDIT'))   define('LEGAL_AUTH_EDIT', false);
    if (!defined('LEGAL_AUTH_DELETE')) define('LEGAL_AUTH_DELETE', false);
    if (!defined('LEGAL_AUTH_PRINT'))  define('LEGAL_AUTH_PRINT', false);
    if (!defined('LEGAL_AUTH_MAIL'))   define('LEGAL_AUTH_MAIL', false);

    // stop here, no DB or super admin checks
    return;
}

// ========================================================
// Normal users (load from DB when agencies=0 and not super admin)
// ========================================================
if (LEGAL_PAGES_AUTH === true && $_SESSION['LOGIN_AGENCIES'] == 0 && $_SESSION['LOGIN_SUPER_ADMIN'] == 'N') {

    include_once("lib/class/class.legal_permission.php");
    $ObjvalidatePermission = new userPermission();

    // ========================================================
    // Load permissions from DB (auto-detect page/module)
    // ========================================================
    function load_legal_permissions($page, $ObjvalidatePermission, $module = '')
    {
        $LEGAL_AUTH_FLAGS = &$GLOBALS['LEGAL_AUTH_FLAGS'];

        if (LEGAL_PAGES_AUTH !== true) {
            return;
        }

        // Page/module → menu ID mapping
        $pageMenuMap = [
            'area'         => 1,
            'bank'         => 2,
            'category'     => 3,
            'location'     => 4,
            'court'        => 5,
            'case_mode'    => 6,
            'dtype'        => 7,
            'client'       => 8,
            'thirdparty'   => 9,
            'legalfirm'    => 10,
            'debtcollector' => 11,
            'activelegal'  => 12,
            'actionreport' => 13,
            'addcase'      => 14,
            'bad_debts'    => 15,
            'total_legal_report' => 16,
            'action_report_with_clain_ex' => 17,
            'client_base_statement' => 18,
            'expence_report' => 19,
            'action_report'  => 20,
            'subcategory'    => 21,
            'closedlegal'    => 22,
            'baddebts'       => 23,
            'totallegal'     => 24,
            'lawyer'         => 25
        ];

        // Auto-detect: prefer page if exists in map, otherwise module
        if (!empty($page) && isset($pageMenuMap[strtolower($page)])) {
            $checkKey = strtolower($page);
        } elseif (!empty($module) && isset($pageMenuMap[strtolower($module)])) {
            $checkKey = strtolower($module);
        } else {
            $checkKey = ''; // no valid key found
        }

        // Fetch allowed permissions from DB
        $array_allowed_permissions = [];
        if (!empty($_SESSION['LOGIN_LEGAL_ID'])) {
            $array_allowed_permissions = $ObjvalidatePermission->get_user_allowed_permissions($_SESSION['LOGIN_LEGAL_ID']);
        }

        // Code → name mapping
        $authMap = [
            'V' => 'LEGAL_AUTH_VIEW',
            'A' => 'LEGAL_AUTH_ADD',
            'E' => 'LEGAL_AUTH_EDIT',
            'D' => 'LEGAL_AUTH_DELETE',
            'P' => 'LEGAL_AUTH_PRINT',
            'M' => 'LEGAL_AUTH_MAIL'
        ];

        // Default all permissions to false
        foreach ($authMap as $constName) {
            $LEGAL_AUTH_FLAGS[$constName] = false;
        }

        // Assign true values from DB
        if (!empty($array_allowed_permissions) && !empty($checkKey) && isset($pageMenuMap[$checkKey])) {
            $menuId = $pageMenuMap[$checkKey];
            if (!empty($array_allowed_permissions[$menuId])) {
                $authArray = explode(',', $array_allowed_permissions[$menuId]);
                foreach ($authArray as $code) {
                    $code = trim($code);
                    if (isset($authMap[$code])) {
                        $LEGAL_AUTH_FLAGS[$authMap[$code]] = true;
                    }
                }
            }
        }

        // Define constants only after final values
        foreach ($LEGAL_AUTH_FLAGS as $constName => $value) {
            if (!defined($constName)) {
                define($constName, $value);
            }
        }
    }

    // ========================================================
    // Auto-run if $ObjvalidatePermission exists
    // ========================================================
    if (isset($ObjvalidatePermission)) {
        $module = $_REQUEST['module'] ?? '';
        $page   = $_REQUEST['page'] ?? '';
        load_legal_permissions($page, $ObjvalidatePermission, $module);

        // Redirect if view permission is denied
        // if (defined('LEGAL_AUTH_VIEW') && LEGAL_AUTH_VIEW === false) {
        //     header("Location: ".ROOT_DIR."permission_denied.php");
        //     exit();
        // }
    }

    // ========================================================
    // Debug helper
    // ========================================================
    function debug_legal_permissions($usedKey = '')
    {
        echo '<pre>';
        if (!empty($usedKey)) {
            echo "Permissions checked for: {$usedKey}" . PHP_EOL . PHP_EOL;
        }
        foreach ($GLOBALS['LEGAL_AUTH_FLAGS'] as $name => $value) {
            echo $name . ': ' . ($value ? 'true' : 'false') . PHP_EOL;
        }
        echo '</pre>';
    }
} else {

    // ========================================================
    // Super Admin → Define all as TRUE
    // ========================================================
    if ($_SESSION['LOGIN_SUPER_ADMIN'] == 'Y') {
        if (!defined('LEGAL_AUTH_VIEW'))   define('LEGAL_AUTH_VIEW', true);
        if (!defined('LEGAL_AUTH_ADD'))    define('LEGAL_AUTH_ADD', true);
        if (!defined('LEGAL_AUTH_EDIT'))   define('LEGAL_AUTH_EDIT', true);
        if (!defined('LEGAL_AUTH_DELETE')) define('LEGAL_AUTH_DELETE', true);
        if (!defined('LEGAL_AUTH_PRINT'))  define('LEGAL_AUTH_PRINT', true);
        if (!defined('LEGAL_AUTH_MAIL'))   define('LEGAL_AUTH_MAIL', true);
    }
}
