<?php
class csrftoken {
	var $error_msg;
	var $token_length;
	var $token;
	function __construct() {
		if (!isset($_SESSION)) {
			session_start();
		}
		$this->token_length = 64;
	}
	function generate_token() {
		$this->token = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $this->token_length);
		$_SESSION['CSRF_TOKEN'] = $this->token;
		$_SESSION['CSRF_TOKEN_EXP'] = time() + 3600;
	}
	function check_csrf_token($current_token) {
		$current_token = $this->filter_token_value($current_token);
		if ($current_token) {
			if ($_SESSION['CSRF_TOKEN'] === $current_token) {
				if (time() >= $_SESSION['CSRF_TOKEN_EXP']) {
					$this->error_msg = "CSRF token expired.";
					return false;
				} else {
					return true;
				}
			} else {
				$this->error_msg = "Invalid CSRF token.";
				return false;
			}
		} else {
			$this->error_msg = "CSRF token required.";
			return false;
		}
	}
	function filter_token_value($val) {
		$val = trim($val);
		$val = stripslashes($val);
		$val = htmlspecialchars($val);
		return $val;
	}
	function alert_msg() {
		return '<div style="border-radius:10px;background: #F8D7DA;color:#721C24;border: #F5C6CB;padding: 15px;font-family: Arial;font-weight: bold;">
		    <span>' . $this->error_msg . '</span><a href="#" onclick="window.location.href=window.location.href" style="color:#000;margin-left: 10px;text-decoration: none;">Click here to reload page.</a>
	    </div>';
	}
}