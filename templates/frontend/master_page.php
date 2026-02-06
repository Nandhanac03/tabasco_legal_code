<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>

  <!-- Required meta tags -->

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">



  <!-- loader-->

  <link href="<?= ROOT_DIR ?>assets/css/pace.min.css" rel="stylesheet" />

  <noscript>
    <div style="color: red; text-align: center; font-weight: bold;">
      ⚠️ JavaScript is disabled in your browser. Please enable it for the best experience.
    </div>
  </noscript>


  <script src="<?= ROOT_DIR ?>assets/js/pace.min.js"></script>



  <!--plugins-->

  <link href="<?= ROOT_DIR ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />

  <link href="<?= ROOT_DIR ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />

  <link href="<?= ROOT_DIR ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <link href="<?= ROOT_DIR ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link href="<?= ROOT_DIR ?>assets/plugins/bs-stepper/css/bs-stepper.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= ROOT_DIR ?>assets/plugins/notifications/css/lobibox.min.css" />


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

  <!-- CSS Files -->

  <link href="<?= ROOT_DIR ?>assets/css/bootstrap.min.css" rel="stylesheet">

  <link href="<?= ROOT_DIR ?>assets/css/bootstrap-extended.css" rel="stylesheet">

  <link href="<?= ROOT_DIR ?>assets/css/style.css" rel="stylesheet">

  <link href="<?= ROOT_DIR ?>assets/css/icons.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">



  <!--Theme Styles-->

  <link href="<?= ROOT_DIR ?>assets/css/dark-theme.css" rel="stylesheet" />

  <link href="<?= ROOT_DIR ?>assets/css/semi-dark.css" rel="stylesheet" />

  <link href="<?= ROOT_DIR ?>assets/css/header-colors.css" rel="stylesheet" />



  <title><?= SITE_NAME ?></title>


  <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</head>



<!--start wrapper-->

<div class="wrapper">
  <!--start sidebar -->
  <aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div onclick="window.location.href='<?= ROOT_DIR ?>dashboard/panel.html';">
        <img src="<?= ROOT_DIR ?>assets/images/non_transparent_logo.png" class="logo-icon" alt="logo icon">
      </div>
      <!-- <div>
          <h4 class="logo-text">TABASCO</h4>
        </div> -->
    </div>

    <!--navigation-->
    <ul class="metismenu" id="menu">
      <li <?= ($actve_sub_menu == 'dashboard') ? 'class="mm-active"' : '' ?>>
        <a href="<?= ROOT_DIR ?>dashboard/panel.html">
          <div class="parent-icon">
            <ion-icon name="speedometer-outline"></ion-icon>
          </div>
          <div class="menu-title">Dashboard</div>
        </a>
      </li>
      <?php
      /* Third Pary , Legal Firm , Debt Collector Menu  */
      if($_SESSION['LOGIN_AGENCIES']==1){?>

      <?php }?>
    <?php
    /* Admin , HR , Legal Staff Menu  */
    if($_SESSION['LOGIN_AGENCIES']==0){?>
      <li>
        <a href="javascript:;" class="has-arrow">
          <div class="parent-icon">
            <ion-icon name="grid-outline"></ion-icon>
          </div>
          <div class="menu-title ">Master</div>
        </a>
        <ul>
          <li <?= ($actve_sub_menu == 'area') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>master/area.html">
              <ion-icon name="ellipse-outline"></ion-icon>Area
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'bank') ? 'class="mm-active"' : '' ?>> <a
              href="<?= ROOT_DIR ?>master/bank.html">
              <ion-icon name="ellipse-outline"></ion-icon>Bank
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'category') ? 'class="mm-active"' : '' ?>> <a
              href="<?= ROOT_DIR ?>master/category.html">
              <ion-icon name="ellipse-outline"></ion-icon>Category
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'subcategory') ? 'class="mm-active"' : '' ?>> <a
              href="<?= ROOT_DIR ?>master/subcategory.html">
              <ion-icon name="ellipse-outline"></ion-icon>Sub Category
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'lawyer') ? 'class="mm-active"' : '' ?>> <a
              href="<?= ROOT_DIR ?>master/lawyer.html">
              <ion-icon name="ellipse-outline"></ion-icon>Lawyer
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'documenttype') ? 'class="mm-active"' : '' ?>> <a
              href="<?= ROOT_DIR ?>master/dtype.html">
              <ion-icon name="ellipse-outline"></ion-icon>Document Types
            </a>
          </li>
           <li <?= ($actve_sub_menu == 'fees_type') ? 'class="mm-active"' : '' ?>> <a
              href="<?= ROOT_DIR ?>master/fees_type.html">
              <ion-icon name="ellipse-outline"></ion-icon>Fees Types
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'location') ? 'class="mm-active"' : '' ?>> <a
              href="<?= ROOT_DIR ?>master/location.html">
              <ion-icon name="ellipse-outline"></ion-icon>Location
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'court') ? 'class="mm-active"' : '' ?>> <a
              href="<?= ROOT_DIR ?>master/court.html">
              <ion-icon name="ellipse-outline"></ion-icon>Court
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'case_mode') ? 'class="mm-active"' : '' ?>> <a
              href="<?= ROOT_DIR ?>master/case_mode.html">
              <ion-icon name="ellipse-outline"></ion-icon>Case Mode
            </a>
          </li>
        </ul>
      </li>

      <li <?= ($main_menu == 'reports') ? 'class="mm-active"' : '' ?>>
        <a href="<?= ROOT_DIR ?>reports/list.html" class="has-arrow">
          <div class="parent-icon">
            <ion-icon name="bar-chart-outline"></ion-icon>
          </div>
          <div class="menu-title ">Report</div>
        </a>
        <ul>
          <li <?= ($actve_sub_menu == 'bad_debts') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>reports/bad_debts.html">
              <ion-icon name="ellipse-outline"></ion-icon>Bad Debts Report
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'closed_legal_report') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>reports/closed_legal_report.html">
              <ion-icon name="ellipse-outline"></ion-icon>Closed Legal Report
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'total_legal_report') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>reports/total_legal_report.html">
              <ion-icon name="ellipse-outline"></ion-icon>Total Legal Statement
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'client_base_action') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>reports/client_base_action_report_list.html">
              <ion-icon name="ellipse-outline"></ion-icon>Client Base Action Report
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'client_base_statement') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>reports/statementbase_report_list.html">
              <ion-icon name="ellipse-outline"></ion-icon>Statement Base Report
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'expence_report') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>reports/expense_report_list.html">
              <ion-icon name="ellipse-outline"></ion-icon>Expense Report
            </a>
          </li>
          <li <?= ($actve_sub_menu == 'action_report') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>reports/action_report_list.html">
              <ion-icon name="ellipse-outline"></ion-icon>Action Report
            </a>
          </li>

          <li <?= ($actve_sub_menu == 'case_report') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>reports/case_report_list.html">
              <ion-icon name="ellipse-outline"></ion-icon>UAE Pass Report
            </a>
          </li>


        </ul>
      </li>
      <li <?= ($main_menu == 'settings') ? 'class="mm-active"' : '' ?>>
        <a href="javascript:;" class="has-arrow">
          <div class="parent-icon">
            <ion-icon name="construct-outline"></ion-icon>
          </div>
          <div class="menu-title ">Settings</div>
        </a>
        <ul>
          <li <?= ($actve_sub_menu == 'permission') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>permission/userlist.html">
              <ion-icon name="ellipse-outline"></ion-icon>Set Permissions
            </a>
          </li>
          <!-- <li <?= ($actve_sub_menu == 'profile') ? 'class="mm-active"' : '' ?>> <a href="<?= ROOT_DIR ?>settings/profile.html">
              <ion-icon name="ellipse-outline"></ion-icon>Edit Profile
            </a>
          </li> -->
          <li> <a href="<?= ROOT_DIR ?>login.php">
              <ion-icon name="ellipse-outline"></ion-icon>Logout
            </a>
          </li>
        </ul>
      </li>
<?php }?>
    </ul>
    <!--end navigation-->

  </aside>

  <!--end sidebar -->



  <!--start top header-->

  <header class="top-header">

    <nav class="navbar navbar-expand gap-3">

      <div class="toggle-icon">

        <ion-icon name="menu-outline"></ion-icon>

      </div>





      <div class="top-navbar-right ms-auto">



        <ul class="navbar-nav align-items-center">



          <li class="nav-item">

            <a class="nav-link dark-mode-icon" href="javascript:;">

              <div class="mode-icon">

                <ion-icon name="moon-outline"></ion-icon>

              </div>

            </a>

          </li>

          <li class="nav-item dropdown dropdown-large dropdown-apps">

            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">

              <div class="">

                <ion-icon name="apps-outline"></ion-icon>

              </div>

            </a>

            <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark">

              <div class="row row-cols-3 g-3 p-3">


<!-- onclick="window.location.href='<?= ROOT_DIR ?>dashboard/panel.html';" -->
<div class="col text-center" >
<a href="<?= ROOT_DIR ?>dashboard/panel.html">
  <div class="app-box mx-auto bg-gradient-success text-white">
    <ion-icon name="speedometer-outline"></ion-icon>
  </div>
  <div class="app-title">Dashboard</div>
</a>
</div>



                <div class="col text-center">
                  <div class="app-box mx-auto bg-gradient-warning text-white">
                    <ion-icon name="megaphone-outline"></ion-icon>
                  </div>
                  <div class="app-title">Notification</div>
                </div>
                <!-- onclick="window.location.href='<?= ROOT_DIR ?>task/list.html';" -->
                <div class="col text-center" >
                  <a href="<?= ROOT_DIR ?>task/list.html">
                  <div class="app-box mx-auto bg-gradient-danger text-white">
                    <ion-icon name="alarm-outline"></ion-icon>
                  </div>
                  <div class="app-title">Task </div>
                  </a>
                </div>



              </div>

            </div>

          </li>

          <li class="nav-item dropdown dropdown-large d-none">

            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">

              <div class="position-relative">

                <span class="notify-badge">8</span>

                <ion-icon name="notifications-outline"></ion-icon>

              </div>

            </a>

            <div class="dropdown-menu dropdown-menu-end">

              <a href="javascript:;">

                <div class="msg-header">

                  <p class="msg-header-title">Notifications</p>

                  <p class="msg-header-clear ms-auto">Marks all as read</p>

                </div>

              </a>

              <div class="header-notifications-list">

                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex align-items-center">

                    <div class="notify text-primary">

                      <ion-icon name="cart-outline"></ion-icon>

                    </div>

                    <div class="flex-grow-1">

                      <h6 class="msg-name">New Orders <span class="msg-time float-end">2 min

                          ago</span></h6>

                      <p class="msg-info">You have recived new orders</p>

                    </div>

                  </div>

                </a>

                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex align-items-center">

                    <div class="notify text-danger">

                      <ion-icon name="person-outline"></ion-icon>

                    </div>

                    <div class="flex-grow-1">

                      <h6 class="msg-name">New Customers<span class="msg-time float-end">14 Sec

                          ago</span></h6>

                      <p class="msg-info">5 new user registered</p>

                    </div>

                  </div>

                </a>

                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex align-items-center">

                    <div class="notify text-success">

                      <ion-icon name="document-outline"></ion-icon>

                    </div>

                    <div class="flex-grow-1">

                      <h6 class="msg-name">24 PDF File<span class="msg-time float-end">19 min

                          ago</span></h6>

                      <p class="msg-info">The pdf files generated</p>

                    </div>

                  </div>

                </a>



                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex align-items-center">

                    <div class="notify text-info">

                      <ion-icon name="checkmark-done-outline"></ion-icon>

                    </div>

                    <div class="flex-grow-1">

                      <h6 class="msg-name">New Product Approved <span class="msg-time float-end">2 hrs ago</span></h6>

                      <p class="msg-info">Your new product has approved</p>

                    </div>

                  </div>

                </a>

                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex align-items-center">

                    <div class="notify text-warning">

                      <ion-icon name="send-outline"></ion-icon>

                    </div>

                    <div class="flex-grow-1">

                      <h6 class="msg-name">Time Response <span class="msg-time float-end">28 min

                          ago</span></h6>

                      <p class="msg-info">5.1 min avarage time response</p>

                    </div>

                  </div>

                </a>

                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex align-items-center">

                    <div class="notify text-danger">

                      <ion-icon name="chatbox-ellipses-outline"></ion-icon>

                    </div>

                    <div class="flex-grow-1">

                      <h6 class="msg-name">New Comments <span class="msg-time float-end">4 hrs

                          ago</span></h6>

                      <p class="msg-info">New customer comments recived</p>

                    </div>

                  </div>

                </a>

                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex align-items-center">

                    <div class="notify text-primary">

                      <ion-icon name="albums-outline"></ion-icon>

                    </div>

                    <div class="flex-grow-1">

                      <h6 class="msg-name">New 24 authors<span class="msg-time float-end">1 day

                          ago</span></h6>

                      <p class="msg-info">24 new authors joined last week</p>

                    </div>

                  </div>

                </a>

                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex align-items-center">

                    <div class="notify text-success">

                      <ion-icon name="shield-outline"></ion-icon>

                    </div>

                    <div class="flex-grow-1">

                      <h6 class="msg-name">Your item is shipped <span class="msg-time float-end">5 hrs

                          ago</span></h6>

                      <p class="msg-info">Successfully shipped your item</p>

                    </div>

                  </div>

                </a>

                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex align-items-center">

                    <div class="notify text-warning">

                      <ion-icon name="cafe-outline"></ion-icon>

                    </div>

                    <div class="flex-grow-1">

                      <h6 class="msg-name">Defense Alerts <span class="msg-time float-end">2 weeks

                          ago</span></h6>

                      <p class="msg-info">45% less alerts last 4 weeks</p>

                    </div>

                  </div>

                </a>

              </div>

              <a href="javascript:;">

                <div class="text-center msg-footer">View All Notifications</div>

              </a>

            </div>

          </li>

          <li class="nav-item dropdown dropdown-user-setting">

            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">

              <div class="user-setting">

                <img src="<?= ROOT_DIR ?>assets/images/avatars/06.png" class="user-img" alt="">

              </div>

            </a>

            <ul class="dropdown-menu dropdown-menu-end">

              <li>

                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex flex-row align-items-center gap-2">

                    <img src="<?= ROOT_DIR ?>assets/images/avatars/06.png" alt="" class="rounded-circle" width="54"
                      height="54">

                    <div class="">
<?php
if($_SESSION['LOGIN_LEGAL_NAME']){
$login_fullName = substr($_SESSION['LOGIN_LEGAL_NAME'],0,15);
}

?>
  <h6 class="mb-0 dropdown-user-name"><?= htmlspecialchars($login_fullName, ENT_QUOTES, 'UTF-8'); ?></h6>

  <small class="mb-0 dropdown-user-designation text-secondary"><?= $_SESSION['LOGIN_LEGAL_TYPE_NAME'] ?></small>

                    </div>

                  </div>

                </a>

              </li>

              <li>

                <hr class="dropdown-divider">

              </li>

              <li class="d-none">

                <a class="dropdown-item" href="<?= ROOT_DIR ?>settings/profile.html">

                  <div class="d-flex align-items-center">

                    <div class="">

                      <ion-icon name="person-outline"></ion-icon>

                    </div>

                    <div class="ms-3"><span>Profile</span></div>

                  </div>

                </a>

              </li>

              <li>

                <a class="dropdown-item" href="javascript:;">

                  <div class="d-flex align-items-center">

                    <div class="">

                      <ion-icon name="settings-outline"></ion-icon>

                    </div>

                    <div class="ms-3"><span>Setting</span></div>

                  </div>

                </a>

              </li>





              <li>

                <hr class="dropdown-divider">

              </li>

              <li>

                <a class="dropdown-item" href="<?= ROOT_DIR ?>login.php">

                  <div class="d-flex align-items-center">

                    <div class="">

                      <ion-icon name="log-out-outline"></ion-icon>

                    </div>

                    <div class="ms-3"><span>Logout</span></div>

                  </div>

                </a>

              </li>

            </ul>

          </li>



        </ul>



      </div>

    </nav>

  </header>

  <!--end top header-->



  <!-- content area here -->

  <?php include_once("templates/frontend/content_holder.php"); ?>

  <!-- end content area -->



  <!--Start Back To Top Button-->

  <a href="javaScript:;" class="back-to-top"><ion-icon name="arrow-up-outline"></ion-icon></a>

  <!--End Back To Top Button-->



  <!--start switcher-->



  <!--end switcher-->





  <!--start overlay-->

  <div class="overlay nav-toggle-icon"></div>

  <!--end overlay-->



</div>

<!--end wrapper-->



<!-- JS Files-->

<script src="<?= ROOT_DIR ?>assets/js/jquery.min.js"></script>

<script src="<?= ROOT_DIR ?>assets/plugins/simplebar/js/simplebar.min.js"></script>

<script src="<?= ROOT_DIR ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>

<script src="<?= ROOT_DIR ?>assets/js/bootstrap.bundle.min.js"></script>

<!-- <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script> -->


<!--plugins-->

<script src="<?= ROOT_DIR ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="<?= ROOT_DIR ?>assets/plugins/select2/js/select2-custom.js"></script>
<!--notification js -->
<script src="<?= ROOT_DIR ?>assets/plugins/notifications/js/lobibox.min.js"></script>
<script src="<?= ROOT_DIR ?>assets/plugins/notifications/js/notifications.min.js"></script>
<script src="<?= ROOT_DIR ?>assets/plugins/notifications/js/notification-custom-script.js"></script>

<script src="<?= ROOT_DIR ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>

<script src="<?= ROOT_DIR ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?= ROOT_DIR ?>assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= ROOT_DIR ?>assets/js/table-datatable.js"></script>

<script src="<?= ROOT_DIR ?>assets/plugins/bs-stepper/js/main.js"></script>
<!-- Main JS-->
<script src="<?= ROOT_DIR ?>assets/js/main.js"></script>
<script src="<?= ROOT_DIR ?>common/pages.js"></script>
<script type="text/javascript">
  function preventInvalidInput(event) {
    const forbiddenChars = /['"“”‘’~]/g; // Regex to detect quotes and tilde (~)
    if (forbiddenChars.test(event.target.value)) {
      //alert("⚠️ Quotes and ~ are not allowed!");
      error_noti(`Quotation marks (' " “ ” ‘ ’) and the tilde (~) are not allowed .`);

      event.target.value = event.target.value.replace(forbiddenChars, ''); // Remove invalid characters
    }
  }

  // Apply validation to all text inputs and textareas
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll("input[type='text'], textarea").forEach((element) => {
      element.addEventListener("input", preventInvalidInput);
    });
  });


  document.addEventListener("DOMContentLoaded", function() {
    // Select the ion-icon with name="home-outline"
    let homeIcon = document.querySelector('ion-icon[name="home-outline"]');

    if (homeIcon) {
      homeIcon.style.cursor = "pointer"; // Make it look clickable
      homeIcon.setAttribute("title", "Back to Dashboard"); // Set tooltip

      homeIcon.addEventListener("click", function() {
        window.location.href = "<?= ROOT_DIR ?>dashboard/panel.html"; // Change URL as needed
      });
    }
  });
</script>
</body>



</html>