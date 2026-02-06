<?php
ob_start();
session_start();
# including files here
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");

include_once "lib/class/class.validator.php";
$ObjValidator = new validator();

include_once "lib/class/class.common.php";
$Objcommon = new Common();

//CRSF Token class
include_once "lib/class/class.crsftoken.php";
$objCRSF = new csrftoken();
$validation_error = false;

unset($_SESSION['LOGIN_LEGAL_ID']);
unset($_SESSION['LOGIN_LEGAL_NAME']);
unset($_SESSION['LOGIN_LEGAL_TYPE_ID']);
unset($_SESSION['LOGIN_LEGAL_TYPE_NAME']);

include_once "lib/class/class.login.php";
# Object Creation
$Objlogin = new Login();


$go_Agencies_login = false;
if ($_POST && $validation_error == false) {

  $user_name = $ObjValidator->clean_string($_POST['legal_username']);
  $user_password = $ObjValidator->clean_string($_POST['legal_password']);

  unset($_SESSION['LOGIN_LEGAL_ID']);
  unset($_SESSION['LOGIN_LEGAL_NAME']);
  unset($_SESSION['LOGIN_LEGAL_TYPE_ID']);
  unset($_SESSION['LOGIN_LEGAL_TYPE_NAME']);
  unset($_SESSION['LOGIN_AGENCIES']);
  unset($_SESSION['LOGIN_SUPER_ADMIN']);


  if ($user_name != '' && $user_password != '') {
    // allowed with  user_legal_access='Y'
    if ($Objlogin->MainLoginAuthentication($user_name, $user_password, $user_types)) {
      if ($Objlogin->_login_authentication_msg == "success") {
        $_SESSION['LOGIN_LEGAL_ID']       = $Objlogin->_user_id;
        $_SESSION['LOGIN_LEGAL_NAME']     = $Objcommon->getFirstWords($Objlogin->_user_name);
        $_SESSION['LOGIN_LEGAL_TYPE_ID']  = $Objlogin->_user_type;
        $_SESSION['LOGIN_LEGAL_TYPE_NAME'] = $Objlogin->_user_type_name;
        $_SESSION['LOGIN_AGENCIES']       = '0'; // Not an agency user
        $_SESSION['LOGIN_SUPER_ADMIN']    = $Objlogin->_user_sa;
        header("location: " . ROOT_DIR . "dashboard/panel.html");
        exit;
      } else {
        $go_Agencies_login = true;
      }
    } else {
      $go_Agencies_login = true;
    }
  } else {
    $msgAlert = "Access denied. Your credentials are invalid or you do not have the required permissions.";
  }

  if ($go_Agencies_login == true) {

    $array_Agencies = $Objlogin->Agencies_Login_Authentication($user_name, $user_password);
    if ($Objlogin->_login_authentication_msg == "success") {
      // **Set sessions for agency login and redirect**
      $_SESSION['LOGIN_LEGAL_ID']       = $Objlogin->_user_id;
      $_SESSION['LOGIN_LEGAL_NAME']     = $Objcommon->getFirstWords($Objlogin->_user_name);
      $_SESSION['LOGIN_LEGAL_TYPE_ID']  = $Objlogin->_user_type;
      switch ($Objlogin->_user_type) {
        case 'TP':
          $_SESSION['LOGIN_LEGAL_TYPE_NAME'] = "Third Party";
          break;
        case 'LF':
          $_SESSION['LOGIN_LEGAL_TYPE_NAME'] = "Legal Firm";
          break;
        case 'DC':
          $_SESSION['LOGIN_LEGAL_TYPE_NAME'] = "Debt Collector";
          break;
      }
      $_SESSION['LOGIN_AGENCIES']       = '1'; // Agency user
      $_SESSION['LOGIN_SUPER_ADMIN']    = 'N'; // Not a super admin
      header("location: " . ROOT_DIR . "dashboard/agencies.html");
      exit;
    } else {
      $msgAlert = "Access denied. Your credentials are invalid or you do not have the required permissions.";
    }
  }
}

$signIn_label = 'Tabasco Legal System';
// switch($_GET['userIs']){
//   case 'tabascoTeam':
//   $signIn_label = 'Tabasco Team';
//   break;
//   case 'thirdParty':
//   $signIn_label = 'Third Party';
//   break;
//   case 'legalFirm':
//   $signIn_label = 'Legal Firm';
//   break;
//   case 'debtCollector':
//   $signIn_label = 'Debt Collector';
//   break;
//   default:
//   $signIn_label = 'Tabasco Team';
//   break;
// }

?>

<!doctype html>
<html lang="en" class="light-theme">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <meta name="csrf-token" content="<?php echo htmlspecialchars($csrf_token); ?>"> -->
  <!-- loader-->
  <link href="<?= ROOT_DIR ?>assets/css/pace.min.css" rel="stylesheet" />
  <script src="<?= ROOT_DIR ?>assets/js/pace.min.js"></script>
  <!--plugins-->
  <link href="<?= ROOT_DIR ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="<?= ROOT_DIR ?>assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= ROOT_DIR ?>assets/css/bootstrap-extended.css" rel="stylesheet">
  <link href="<?= ROOT_DIR ?>assets/css/style.css" rel="stylesheet">
  <link href="<?= ROOT_DIR ?>assets/css/icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <title><?= SITE_NAME ?></title>
  <style>
    .login-menu-2 .nav-link {
      color: #a38c29 !important;
      padding: 8px 16px;
      border: 2px solid transparent;
      border-radius: 25px;
      transition: all 0.3s ease-in-out;
      font-weight: 500;
      text-align: center;
    }

    .login-menu-2 .nav-link:hover {
      background-color: #a38c29;
      color: #fff !important;
      border-color: #a38c29;
    }

    .login-menu-2 .nav-link.active {
      background-color: #a38c29;
      color: #fff !important;
      border-color: #a38c29;
    }
  </style>
</head>

<body>
  <div class="au-sign-in-basic"></div>
  <!-- <div class="login-bg-overlay au-sign-up-basic"></div> -->
  <!--start wrapper-->
  <div class="wrapper">
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-transparent p-3">
        <div class="container-fluid">
          <!-- <a href="javascript:;" style="color:#a38c29 !important;"><h5>TABASCO</h5></a> -->
          <!-- <a href="<?= ROOT_DIR ?>login.php?userIs=tabascoTeam&authID=<?= generateRandomString(10) ?>">
            <img src="<?= ROOT_DIR ?>assets/images/logo-small.png" alt="" />
          </a> -->
          <button class="navbar-toggler btn-warning" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-2 login-menu-2 d-none">
              <li class="nav-item">
                <a class="nav-link <?= ($_GET['userIs'] == 'tabascoTeam' || !isset($_GET['userIs'])) ? 'active' : '' ?>"
                  href="<?= ROOT_DIR ?>login.php?userIs=tabascoTeam&authID=<?= generateRandomString(10) ?>">
                  Tabasco Team
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= ($_GET['userIs'] == 'thirdParty') ? 'active' : '' ?>"
                  href="<?= ROOT_DIR ?>login.php?userIs=thirdParty&authID=<?= generateRandomString(10) ?>">
                  Third Party
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= ($_GET['userIs'] == 'legalFirm') ? 'active' : '' ?>"
                  href="<?= ROOT_DIR ?>login.php?userIs=legalFirm&authID=<?= generateRandomString(10) ?>">
                  Legal Firm
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= ($_GET['userIs'] == 'debtCollector') ? 'active' : '' ?>"
                  href="<?= ROOT_DIR ?>login.php?userIs=debtCollector&authID=<?= generateRandomString(10) ?>">
                  Debt Collector
                </a>
              </li>
            </ul>


          </div>
        </div>
      </nav>
    </header>
    <div class="container">
      <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-xl-4 col-lg-5 col-md-7">



          <div class="card radius-10 shadow">
            <div class="card-body p-4">
              <div class="text-center mb-4">
                <a href="<?= ROOT_DIR ?>login.php?userIs=tabascoTeam&authID=<?= generateRandomString(10) ?>">
                  <img src="<?= ROOT_DIR ?>assets/images/logo-small.png" alt="Logo" />
                </a>
              </div>
              <div class="text-center mb-4">
                <h4 class="mb-2"><?= $signIn_label ?></h4>
                <p class="mb-2">Sign In</p>
              </div>
              <form class="form-body row g-3" method="post" id="form_login" name="form_login"
                enctype="multipart/form-data" autocomplete="off">
                <div class="col-12">
                  <label for="legal_username" class="form-label">User Name</label>
                  <input type="text" class="form-control py-2" id="legal_username" name="legal_username"
                    autocomplete="new-username" required />
                </div>
                <div class="col-12">
                  <label for="legal_password" class="form-label">Password</label>
                  <input type="password" class="form-control py-2" id="legal_password" name="legal_password"
                    autocomplete="new-password" required />
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary py-2">Sign In</button>
                  </div>
                  <div class="text-danger text-center mt-2">
                    <?= $msgAlert ?>
                  </div>
                </div>
                <div class="col-12 text-center mt-3"
                  style="color:#d9534f; font-size:14px; line-height:1.6; font-weight:600;">

                  <div style="margin-bottom:4px;">
                    Press Ctrl + Shift + R before login
                  </div>
                  <div>
                    Don't try to open same menu on different tab on the same browser
                  </div>

                </div>


                <div class="col-12 text-center mt-3">
                  <small class="text-muted">
                    Copyrigh &#169; <?= date('Y') ?> <a href="https://tabascouae.com/" target="_blank"
                      style="text-decoration: none;">TABASCO TECH CONT LLC</a> Powered by
                    <a href="https://arabinfotechllc.com/" target="_blank"
                      style="text-decoration: none;">ARABINFOTEC</a>
                  </small>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
    <footer class="my-5">
      <div class="container d-none">
        <div class="d-flex align-items-center gap-4 fs-5 justify-content-center social-login-footer">
          <a href="javascript:;">
            <ion-icon name="logo-twitter"></ion-icon>
          </a>
          <a href="javascript:;">
            <ion-icon name="logo-linkedin"></ion-icon>
          </a>
          <a href="javascript:;">
            <ion-icon name="logo-github"></ion-icon>
          </a>
          <a href="javascript:;">
            <ion-icon name="logo-facebook"></ion-icon>
          </a>
          <a href="javascript:;">
            <ion-icon name="logo-pinterest"></ion-icon>
          </a>
        </div>
        <div class="text-center d-none">
          <p class="my-4">Copyright © 2025 Tabasco Human Capital</p>
        </div>
      </div>
    </footer>
  </div>
  <!--end wrapper-->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#submitBtn").click(function() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.post("ajax/user_login.php", {
          name: $("#legal_username").val(),
          password: $("#legal_password").val(),
          csrf_token: csrfToken
        }, function(response) {

        }, "json").fail(function(jqXHR, textStatus, errorThrown) {

        });
      });
    });
  </script>

</body>



</html>