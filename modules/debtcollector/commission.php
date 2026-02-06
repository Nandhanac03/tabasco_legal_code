<?php

include_once("lib/class/class.legal_active_legals.php");
$objActiveLegal = new ActiveLegal();


# Securely fetch and sanitize GET parameters
$edit_id = filter_input(INPUT_GET, 'param1', FILTER_SANITIZE_NUMBER_INT);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

# Redirect if edit_id is missing or invalid
if (!$edit_id || !is_numeric($edit_id)) {
    header("Location: " . ROOT_DIR . "permission_denied.php");
    exit;
}

$commissions = $objActiveLegal->get_commission('', '', 'DC', $edit_id);


# Generate CSRF Token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$actve_sub_menu = 'dashboard';
$body = "commission.tpl";
?>

<!-- CSRF Token Hidden Field (for Forms) -->
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">