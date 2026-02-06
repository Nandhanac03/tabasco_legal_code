<?php 
	ob_start();
	session_start();
	unset($_SESSION['LOGIN_SUPERADMIN_ID']);
	unset($_SESSION['LOGIN_SUPERADMIN_NAME']);
	unset($_SESSION['LOGIN_SUPERADMIN']);
	unset($_SESSION['LOGIN_AUTHENTICATION_ID']);
	header("location: ".ROOT_DIR."admin");