<?php

//Old ticket thing I don't even use anymore but some co-workers still do
//IGNORE

require_once('models/Model.php');

class Ticket extends Model
{
    // Email Data
    public $email_ticket = "lrush@nco-corp.com";
    public $email_cc;
    public $email_msg;

    // Hub Ticket Data
    public $hub_id;
    public $customer;
    public $market;
    public $loc;
    public $job;
    public $start_time;
    public $date;
    public $tech;
    public $xoc;

    // Customers
    public $customerArr = array("Comcast", "Xfinity", "Charter");
    public $ticketsArr = null;

    public function setTicket($hub_id, $customer, $market, $loc, $job, $start_time, $tech, $xoc)
    {
        $this->hub_id = $hub_id;
        $this->customer = $customer;
        $this->market = $market;
        $this->loc = $loc;
        $this->job = $job;
        $this->start_time = $start_time;
        $this->date = date('mm/dd');
        $this->tech = $tech;
        $this->xoc = $xoc;
    }

    public function convertHourMode($to12, $time) {
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

    public function getRealIpAddr()
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

    public function logTicket()
    {
        if (!isset($this->hub_id))
            return 0;

        $db = DB::connect('tiktik');

        $sql = "INSERT INTO `Ticket`(`hub_id`, `customer`, `market`, `location`, `job`, `start_time`, `date`, `team_members`, `xoc`) 
                VALUES ('".$this->hub_id."','".$this->customer."', '".$this->market."', '".$this->loc."', '".$this->job."', '".$this->start_time."', NULL, '".$this->tech."', '".$this->xoc."')";

        if ($db->query($sql))
        {
            if ($db->affected_rows() > 0)
                return 1;
        }
        return 0;
    }

    public function viewTraffic()
    {
        $ticket = array();

        // Query DB
        $db = DB::connect('tiktik');
        $sql = "SELECT * FROM `Ticket` ORDER BY `date` ASC;";
        $result = $db->query($sql);

        // Check Results
        if (!empty($result))
        {
            if (mysqli_num_rows($result) > 0 )
            {
                while ($row = mysqli_fetch_assoc($result))
                    array_push($ticket, $row);
            }
        }
        return $ticket;
    }

    public function composeEmail()
    {
        $to = $this->email_ticket;
        $subject = "Daily%20Work%20".date("m")."/".date("d");
        $this->composeMessage();
        $mailto = "mailto:".$to."?subject=".$subject."&cc=".$this->email_cc."&body=".$this->email_msg;
        //echo $mailto;
        //header("Location: ". $mailto);
    }

    public function composeMessage()
    {
        $msg = "";
        $msg .= "Customer: ".$this->customer."\r\n";
        $msg .= "Market: ".$this->market."\r\n";
        $msg .= "Location: ".$this->loc."\r\n";
        $msg .= "Work Being Performed: ".$this->job."\r\n";
        $msg .= "Hub Entry Ticket #: ".$this->hub_id."\r\n";
        $msg .= "Start Time: ". $this->convertHourMode(1,$this->start_time)."\r\n";
        $msg .= "Tech: ".$this->tech."\r   n";
        $msg .= "XOC: ".$this->xoc."\r\n";
        $msg = str_replace(" ", "%20", $msg);
        return ($this->email_msg = $msg);
    }

    public function setCookies()
    {
        $expire = time() + (86400 * 150);
        setcookie("cc", ucwords($_POST["cc"]), $expire, "/");
        setcookie("customer", ucwords($_POST["customer"]), $expire, "/");
        setcookie("market", ucwords($_POST["market"]), $expire, "/");
        setcookie("loc", ucwords($_POST["loc"]), $expire, "/");
        setcookie("job", ucwords($_POST["job"]), $expire, "/");
        setcookie("hub_id", ucwords($_POST["hub_id"]), $expire, "/");
        setcookie("start_time", ucwords($_POST["start_time"]), $expire, "/");
        setcookie("tech", ucwords($_POST["tech"]), $expire, "/");
        setcookie("xoc", ucwords($_POST["xoc"]), $expire, "/");

    }

    public function delCookies() {
        $expire = time() - (86400 * 150);
        setcookie("cc", "", $expire, "/");
        setcookie("start_time", "", $expire, "/");
        setcookie("customer", "", $expire, "/");
        setcookie("market", "", $expire, "/");
        setcookie("loc", "", $expire, "/");
        setcookie("hub_id", "", $expire, "/");
        setcookie("job", "", $expire, "/");
        setcookie("tech", "", $expire, "/");
        setcookie("xoc", "", $expire, "/");
    }

    public function loadCookies()
    {
        //Load Cookies
        if (count($_COOKIE) > 0) {
            if (isset($_COOKIE["cc"])) {
                $this->email_cc = $_COOKIE["cc"];
            }
            if (isset($_COOKIE["customer"])) {
                $this->customer = $_COOKIE["customer"];
            }
            if (isset($_COOKIE["market"])) {
                $this->market = $_COOKIE["market"];
            }
            if (isset($_COOKIE["loc"])) {
                $this->loc = $_COOKIE["loc"];
            }
            if (isset($_COOKIE["hub_id"])) {
                $this->hub_id = $_COOKIE["hub_id"];
            }
            if (isset($_COOKIE["job"])) {
                $this->job = $_COOKIE["job"];
            }
            if (isset($_COOKIE["start_time"])) {
                $this->start_time = $_COOKIE["start_time"];
            }
            if (isset($_COOKIE["tech"])) {
                $this->tech = $_COOKIE["tech"];
            }
            if (isset($_COOKIE["xoc"])) {
                $this->xoc = $_COOKIE["xoc"];
            }
            //Defaults
        } else {
            $this->hub_id = "Hub Entry Ticket#";
            $this->start_time = "08:30";
        }
    }

    public function traffic()
    {
        $db = DB::connect('tiktik');
        $ticket = array();
        $sql = "SELECT * FROM `Ticket` ORDER BY `date` ASC;";
        $result = $db->query( $sql );
        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0 ) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($ticket, $row);
                }
                $this->ticketsArr = array_reverse($ticket);
                return 1;
            }
        }
        return 0;
    }
}