<?php
class validator {
	function text_num_only($val) {
		$val = trim($val);
		if ($val) {
			if (preg_match("/^[a-zA-Z0-9]*$/", $val)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function text_num_space_only($val) {
		$val = trim($val);
		if ($val) {
			if (preg_match("/^[a-zA-Z0-9 ]*$/", $val)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function text_num_underscore_only($val) {
		$val = trim($val);
		if ($val) {
			if (preg_match("/^[a-zA-Z0-9_]*$/", $val)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
        function text_num_specialchars_only($val) {
		$val = trim($val);
		if ($val) {
			if (preg_match("/^[a-zA-Z0-9!@#$%^&*._\\/]*$/", $val)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function num_only($val) {
		$val = trim($val);
		if ($val) {
			if (preg_match("/^[0-9]*$/", $val)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
        function text_only($val) {
		$val = trim($val);
		if ($val) {
			if (preg_match("/^[a-zA-Z]*$/", $val)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function validate_email($val) {
		$val = trim($val);
		if ($val) {
			if (filter_var($val, FILTER_VALIDATE_EMAIL)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function filter_value($val) {
		$val = trim($val);
		$val = stripslashes($val);
		$val = htmlspecialchars($val);
		return $val;
	}
	function validate_password($val) {
		$val = trim($val);
		if ($val) {
			$pattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,}$/';
			if (preg_match($pattern, $val)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function contains_text($val, $contains) {
		$val = trim($val);
		$contains = trim($contains);
		if ($val) {
			if (strripos($val, $contains) !== false) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function clean_string($val) {
		$val = trim($val);
		$bad_string = array("content-type", "bcc:", "to:", "cc:", "href", "ping", "ping", "eval", "alert", "compile");
		if ($val) {
			return str_replace($bad_string, "", $val);
		}
	}
	function contains_bad_strings($val) {
		$val = trim($val);
		$bad_string = array("content-type", "bcc:", "to:", "cc:", "href", "ping", "ping", "eval", "alert", "compile");
		if ($val) {
			foreach ($bad_string as $bad) {
				if (strripos($val, $bad) !== false) {
					return true;
				}
			}
			return false;
		} else {
			return false;
		}
	}
}