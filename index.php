<?php
ob_start();
header("Content-Type: text/html; charset=utf-8");
ini_set("default_charset", 'utf-8');
ini_set('memory_limit', '-1');
error_reporting(0);
session_start();
# Collect Module, Page, and Action parameters
$module = false;
$page = false;
$action = false;
$param1 = false;
$param2 = false;



$module = $_REQUEST['module'] ?? '';
$page = $_REQUEST['page'] ?? '';
$action = $_REQUEST['action'] ?? '';

if (isset($_REQUEST['param1']))
  $param1 = $_REQUEST['param1'];
if (isset($_REQUEST['param2']))
  $param2 = $_REQUEST['param2'];

# Configure application settings
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/auth.php");
include_once("lib/functions/navigations.php");
include_once("lib/functions/select_options.php");

if ($_SESSION['LOGIN_LEGAL_ID'] == "") {
  header("location:" . ROOT_DIR . "login.php");
  exit;
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

# Global Variables Declaration
$tpl_path = "./templates/frontend";
$Array_Months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

# Dynamic inclusion of requested module and page
if (!empty($module) && !empty($page)) {
  $module_page_path = "modules/$module/$page.php";
  if (file_exists($module_page_path)) {
    include_once($module_page_path);
  } else {
   // echo "Requested page not found.";
  }
}

include_once("$tpl_path/master_page.php");
// Check if PAGE_SUCCESS session is set
if (isset($_SESSION['PAGE_SUCCESS'])):
  $notification_Msg = $_SESSION['PAGE_SUCCESS'];
  unset($_SESSION['PAGE_SUCCESS']);

  ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      round_success_noti('<?= $notification_Msg ?>'); // 🚀 Trigger the function on page load
    });
  </script>
  <?php
  // Optionally, clear the session to avoid retriggering on refresh
  unset($_SESSION['PAGE_SUCCESS']);
endif;
?>

<script>
  function goBack() {
    window.history.back();
  }

  function popupwindow(url, title, w, h) {
    const left = (screen.width - w) / 2;
    const top = (screen.height - h) / 2;
    window.open(url, title, `toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=${w},height=${h},top=${top},left=${left}`);
  }
</script>