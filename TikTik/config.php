<?php
// Database definitions
define('DB_SERVER', "localhost"); // db server (localhost, MySQL DB is on the same computer bruh)
define('DB_USER', "admin"); // db user
define('DB_PASSWORD', "d1dc93d2b138cb1ff2eb03e6ca1aa77a22930a8f568812b7"); // db password (mention your db password here)
define('DB_DATABASE', "tiktik"); // database name
//define('DIR_ROOT', "http://www.NCOTicket.cf/tiktik/");
define('DIR_ROOT', "/var/www/html/tiktik/");

define("TICKET_EMAIL", "lrush@nco-corp.com");
define("TEAM_EMAIL", "abracero.ab@gmail.com");

// Customers
$customerArr = array("Comcast", "Xfinity", "Charter");

// Functions
//process input data
function trim_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function checkMobile() {
    // Check if not mobile device
    include 'Mobile_Detect.php';
    $detect = new Mobile_Detect();
    if (!$detect->isMobile()){
        header("Location: ".DIR_ROOT."mobile_only.html");
    }
}

function convertHourMode($to12, $time) {
    if ($to12) {
        if ($time > 12) {
            $hr = $time % 12;
            $time = $hr.substr($time, strpos($time, ":"));
            $time .= " PM";
        } else {
            $time .= " AM";
        }
    } else {
        if (strpos($time, "PM") !== false) {
            $time = str_replace("PM", "", $time);
            $hr = $time + 12;
            $time = $hr.substr($time, strpos($time, ":"));
        } else {
            $time = str_replace("AM", "", $time);
        }
    }
    return $time;
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    return $details;
}

function log_Ticket($hub_id, $customer, $market, $loc, $job, $start_time, $tech, $xoc) {
    require_once("DB_Handler.php");
    $db = new DB_Handler();
    if ($db->log_Ticket($hub_id, $customer, $market, $loc, $job, $start_time, $tech, $xoc)) {
        return 1;
    }
    return 0;
}
