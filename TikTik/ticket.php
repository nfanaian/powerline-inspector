<?php
require_once("config.php");

//checkMobile();

function composeEmail($cc, $msg) {
    $to = TICKET_EMAIL;
    $subject = "Daily%20Work%20".date("m")."/".date("d");
    str_replace(" ", "%20", $msg);
    $mailto = "mailto:".$to."?subject=".$subject."&cc=".$cc."&body=".$msg;
    header("Location: ". $mailto);
}

function composeMessage() {
    $msg = "";
    $msg .= "Customer: ".ucwords($_POST["customer"])."\r\n";
    $msg .= "Market: ".ucwords($_POST["market"])."\r\n";
    $msg .= "Location: ".ucwords($_POST["loc"])."\r\n";
    $msg .= "Work Being Performed: ".ucwords($_POST["job"])."\r\n";
    $msg .= "Hub Entry Ticket #: ".ucwords($_POST["hub_id"])."\r\n";
    $msg .= "Start Time: ".convertHourMode(1, $_POST["start_time"])."\r\n";
    $msg .= "Tech: ".ucwords($_POST["tech"])."\r\n";
    $msg .= "XOC: ".ucwords($_POST["xoc"])."\r\n";
    return $msg;
}

function setCookies() {
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

function delCookies() {
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

// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Log web traffic

    if (isset($_POST["submit"])) {
        $email_cc = $_POST["cc"];
        $email_msg = composeMessage();
        log_Ticket(ucwords($_POST["hub_id"]), ucwords($_POST["customer"]), ucwords($_POST["market"]), ucwords($_POST["loc"]), ucwords($_POST["job"]),
            ucwords($_POST["start_time"]), ucwords($_POST["tech"]),ucwords($_POST["xoc"]));
        setCookies();
        composeEmail($email_cc, $email_msg);

    } else if (isset($_POST["delCookies"])) {
        delCookies();
        header("Location: " . $_SERVER["PHP_SELF"]);
    }
}

//Load Cookies
if (count($_COOKIE) > 0) {
    $user_id = 1;
    if (isset($_COOKIE["cc"])) {
        $email_cc = $_COOKIE["cc"];
    }
    if (isset($_COOKIE["customer"])) {
        $customer = $_COOKIE["customer"];
    }
    if (isset($_COOKIE["market"])) {
        $market = $_COOKIE["market"];
    }
    if (isset($_COOKIE["loc"])) {
        $loc = $_COOKIE["loc"];
    }
    if (isset($_COOKIE["hub_id"])) {
        $hub_id = $_COOKIE["hub_id"];
    }
    if (isset($_COOKIE["job"])) {
        $job = $_COOKIE["job"];
    }
    if (isset($_COOKIE["start_time"])) {
        $start_time = $_COOKIE["start_time"];
    }
    if (isset($_COOKIE["tech"])) {
        $tech = $_COOKIE["tech"];
    }
    if (isset($_COOKIE["xoc"])) {
        $xoc = $_COOKIE["xoc"];
    }
//Defaults
} else {
    $hub_id = "Hub Entry Ticket#";
    $start_time = "08:30";
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="TikTik">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <link rel = "stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="container">
        <h2> Send Hub Ticket </h2>
        <div class="container form-signin">
            <form class="form-signin" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="on">

                <input class="form-control" type="text" name="cc" placeholder="Carbon Copy (CC)" value="<?= $email_cc ?>"/><br />
                <select class="form-control" name="customer" width="">
                            <?php
                            for($i=0; $i < count($customerArr); $i++){
                                echo "<option value=\"".$customerArr[$i]."\">";
                                echo $customerArr[$i];
                                echo "</option>";
                            }
                            ?>
                </select><br />

                <input class="form-control" type="text" name="market" placeholder="Market" value="<?= $market ?>" required/><br />
                <input class="form-control" type="text" name="loc" placeholder="Location" value="<?= $loc ?>" required/><br />
                <input class="form-control" type="text" name="job" placeholder="Work being performed" value="<?= $job ?>" required/><br />

                <input class="form-control" type="number" pattern="[0-9]*" mode="numeric" name="hub_id" placeholder="<?= $hub_id; ?>" value="<?= $hub_id; ?>" required autofocus/><br />

                <input class="form-control" type="time" name="start_time" style="width:200px;" value="<?= $start_time ?>"/><br />

                <input class="form-control" type="text" name="tech" placeholder="List team members"value="<?= $tech ?>" required/><br />

                <input class="form-control" type="text" name="xoc" placeholder="XOC" value="<?= $xoc ?>"/><br />

                <button class="btn btn-lg btn-primary btn-block" style="width:100%;background-color:yellow;bborder-color:yellow;color:black;" type="submit" name="submit">Submit</button></button>
                <br />
                <button class="btn btn-lg btn-primary btn-block" style="width:100%;background-color:yellow;bborder-color:yellow;color:black;" type="submit" name="delCookies">Clear Memory</button></button>
            </form>
        </div>
        <div id="footer">
            <label id="navid">Copyright &copy Navid Fanaian</label>
        </div>
    </div>
</body>
</html>
