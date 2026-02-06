<?php
ob_start();
header("Content-Type: text/html; charset=utf-8");
ini_set("default_charset", 'utf-8');
ini_set('memory_limit', '-1');
error_reporting(0);
session_start();


# Configure application settings
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- loader-->
	  <link href="<?= ROOT_DIR ?>assets/css/pace.min.css" rel="stylesheet" />
	  <script src="<?= ROOT_DIR ?>assets/js/pace.min.js"></script>

    <!--plugins-->
    <link href="<?= ROOT_DIR ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="<?= ROOT_DIR ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?= ROOT_DIR ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />

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

    <title>Access denied</title>
  </head>
  <body>


 <!--start wrapper-->
    <div class="wrapper">



        <!-- start page content wrapper-->
        <div class="page-content-wrapper">
          <!-- start page content-->
         <div class="page-content">



              <div class="card radius-10">
                <div class="row g-0">
                  <div class="col-12 col-xl-5">
                    <div class="card-body">
<h1 class="display-1"><span class="text-danger">4</span><span class="text-primary">0</span><span class="text-success">1</span></h1>
                      <h2 class="font-weight-bold display-4">Unauthorized</h2>
                      <p>You have attempted to access a restricted resource.</p>
                      <div class="mt-5"> <a href="javascript:;" class="btn btn-primary btn-lg px-md-5 radius-30" onclick="history.back()">Go Back</a>

                      </div>
                    </div>
                  </div>
                  <!-- <div class="col-12 col-xl-7">
                    <img src="<?= ROOT_DIR ?>401.png" class="img-fluid" alt="">
                  </div> -->
                </div>
                <!--end row-->
              </div>



          </div>
          <!-- end page content-->
         </div>



         <!--Start Back To Top Button-->
		     <a href="javaScript:;" class="back-to-top"><ion-icon name="arrow-up-outline"></ion-icon></a>
         <!--End Back To Top Button-->




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
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <!--plugins-->
    <script src="<?= ROOT_DIR ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>

    <!-- Main JS-->
    <script src="<?= ROOT_DIR ?>assets/js/main.js"></script>


  </body>
</html>