<?php
include_once("lib/class/class.legal_active_legals.php");
$objActiveLegal = new ActiveLegal();

$edit_id        =   trim($_GET['param1']);
$action         =   trim($_GET['action']);

if (!$edit_id) {
    header("location: " . ROOT_DIR . "permission_denied.php");
    exit;
}

$commissions = $objActiveLegal->get_commission('', '', 'TP', $edit_id);
// echo"<pre>";print_r($commissions);exit;
$actve_sub_menu = 'dashboard';
$body = "commission.tpl";
?>

<!-- CSRF Token Hidden Field (for Forms) -->
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">