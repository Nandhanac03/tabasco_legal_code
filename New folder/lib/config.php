<?php
error_reporting(E_ERROR);
date_default_timezone_set("Asia/Dubai");
$clientName = "TABASCO";
define("LNS_DPL_NAME", $clientName);
define("CLIENT_NAME", $clientName);
/*LOCAL*/
define("IP", "localhost");
define("DB", "tabasco_legal");
// define("DB", "test");

define("USER", "root");
define("DBPWD", "");
/*LIVE*/
// define("IP", "localhost");
// define("DB", "demouser_talegal");
// define("USER", "demouser_talegal");
// define("DBPWD", "mevda5GM4SDD");

define("LEGAL_PAGES_AUTH",TRUE);

define("AJAX_ROOT_DIR", "http://localhost/tabasco_legal_code/");
define("ROOT_DIR", "http://localhost/tabasco_legal_code/");
define("SHARE_LINK_FOR_LOGIN", "http://localhost/tabasco_legal_code/login.php");
/**
 * Please do not change the following codes . This used in MYSQL Triggers , if any changes made , update the same in MYSQL Triggers
 */
define("CLIENT_CODE", "TABL/CL/");
define("THIRD_PARTY_CODE", "TABL/TP/");
define("LEGAL_FIRM_CODE", "TABL/LF/");
define("DEBT_COLLECTOR_CODE", "TABL/DC/");
define("ACTIVE_LEGAL_CODE", "TABL/AL/");

/**
 * These are categories select option values in Active legal modules
 */
define("THIRD_PARTY_C_ID", "1");
define("LEGAL_FIRM_C_ID", "2");
define("DEBT_COLLECTOR_C_ID", "3");
define("LEGAL_TEAM_C_ID", "4");


define("SITE_NAME", "TABASCO LEGAL MANAGEMENT SYSTEM");
define("ADMIN_NAME", "TABASCO");
define("ADMIN_TEAM_NAME", "TABASCO Team");
define("ADMIN_EMAIL", "info@vstbiz.com");
define("PAGINATION_PERPAGE", 15);

define("SMTP_DEBUG_MODE", 0);
define("PDO_DEBUG", "2");

define("VALIDATION_MSG", "Please fill all required fields marked with an asterisk (*)");

define("VALIDATION_UPLOAD_VISITING_CARD", "Only files in JPG, PNG, or PDF formats are permitted, with a size limit of 1MB");
define("SUCCESS_NOTIFICATION_IMAGE", ROOT_DIR."assets/plugins/notifications/img/5.jpg");

$module = $_REQUEST['module'] ?? '';
$page = $_REQUEST['page'] ?? '';

// Secret key for encryption (store securely in config or environment variable)
//$secretKey = 'uNj0Nq5Hu9OzCsFKnoFAlrUKsZx76XfF'; // Replace with your own secure key
define("secretKey", 'uNj0Nq5Hu9OzCsFKnoFAlrUKsZx76XfF');

function decryptPassword($data, $key) {
    // Decode the data
    list($encryptedData, $iv) = explode('::', base64_decode($data), 2);

    // Decrypt the password using AES-256-CBC
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}
function getOS($userAgent)
{
    // Create list of operating systems with operating system name as array key
    $oses = array(

        'iPhone' => '(iPhone)',

        'Windows 3.11' => 'Win16',

        'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', // Use regular expressions as value to identify operating system

        'Windows 98' => '(Windows 98)|(Win98)',

        'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',

        'Windows XP' => '(Windows NT 5.1)|(Windows XP)',

        'Windows 2003' => '(Windows NT 5.2)',

        'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',

        'Windows 7' => '(Windows NT 6.1)|(Windows 7)',

        'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',

        'Windows ME' => 'Windows ME',

        'Open BSD' => 'OpenBSD',

        'Sun OS' => 'SunOS',

        'Linux' => '(Linux)|(X11)',

        'Safari' => '(Safari)',

        'Macintosh' => '(Mac_PowerPC)|(Macintosh)',

        'QNX' => 'QNX',

        'BeOS' => 'BeOS',

        'OS/2' => 'OS/2',

        'Search Bot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'

    );


    foreach ($oses as $os => $pattern) { // Loop through $oses array

        // Use regular expressions to check operating system type

        if (eregi($pattern, $userAgent)) { // Check if a value in $oses array matches current user agent.

            return $os; // Operating system was matched so return $oses key

        }

    }

    return 'Unknown'; // Cannot find operating system so return Unknown

}//end function

function percentile_rank($arr, $val)
{

    $lower_count = 0;

    $upper_count = 0;

    $equal_count = 0;

    if ($arr) {

        foreach ($arr as $rc) {

            if ($val > $rc) {

                $lower_count++;

            }

            if ($val < $rc) {

                $upper_count++;

            }

            if ($val == $rc) {

                $equal_count++;

                if ($equal_count > 1)

                    $upper_count++;

            }

        }

        $percentile_rank = $lower_count / ($lower_count + $upper_count);

        if ($percentile_rank > 0) {

            return $percentile_rank * 100;

        } else {

            return 0;

        }

    }

}


function fetch_variable_value($key = '')
{

    global $language_values_selected;

    global $language_values_default;

    if ($key) {

        $selected_val = $language_values_selected[$key];

        if ($selected_val)

            echo $selected_val;
        else

            echo $language_values_default[$key];

    }

}//end function


function fetch_header_value($key = '')
{

    global $language_header_selected;

    global $language_header_default;

    if ($key) {

        $selected_val = $language_header_selected[$key];

        if ($selected_val)

            echo $selected_val;
        else

            echo $language_header_default[$key];

    }

}//end function


function fetch_variable_return($key = '')
{

    global $language_values_selected;

    global $language_values_default;

    if ($key) {

        $selected_val = $language_values_selected[$key];

        if ($selected_val)

            return $selected_val;
        else

            return $language_values_default[$key];

    }

}//end function



function generateRandomString($length = 9)
{

    // Define the alphabetic characters (both uppercase and lowercase)

    $characters = date('s') . 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';



    // Calculate the total number of characters available

    $charactersLength = strlen($characters);



    // Initialize an empty string to hold the random result

    $randomString = '';



    // Loop through the length to generate random characters

    for ($i = 0; $i < $length; $i++) {

        $randomString .= date('s') . rand(0, 99) . $characters[rand(0, $charactersLength - 1)];

    }

    $randomString = str_replace(".", "", $randomString);

    return $randomString;

}