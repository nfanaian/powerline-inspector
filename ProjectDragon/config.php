<?php
// Database definitions
define('DB_SERVER', "localhost"); // db server (localhost, MySQL DB is on the same computer bruh)
define('DB_USER', "admin"); // db user
define('DB_PASSWORD', "d1dc93d2b138cb1ff2eb03e6ca1aa77a22930a8f568812b7"); // db password (mention your db password here)
define('DB_DATABASE', "Project_Dragon"); // database name
define('DIR_ROOT', $_SERVER["DOCUMENT_ROOT"] . "/ProjectDragon/");
define("DIR_IMG_RAW", "/var/www/html/img/");
define("DIR_TRAIN", "/usr/local/project_dragon/data/training/");
define("DIR_DUMMY", "/usr/local/project_dragon/data/dummy/");
define("DIR_TESTING", "/usr/local/project_dragon/data/testing/");
define("NO_PICS", "sadkermit.jpg");
define('BR', "<br/>");

// Functions
//process input data
function trim_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function death( $str ) {
    die($str);
}

function checkMobile()
{
    // Check if mobile device
    include 'Mobile_Detect.php';
    $detect = new Mobile_Detect();
    if ($detect->isMobile()){
        return 1;
    }
    return 0;
}

function getHashDir($reviewedFile, $fileDir = DIR_TRAIN)
{
    $ret = array();
    $ret["filename"] = explode(".", $reviewedFile)[0];
    $ret["file_ext"] = "." . explode(".", $reviewedFile)[1];
    $ret["dir"] = $fileDir;
    $ret["hash"] = md5($ret["filename"]);

    $level = 10;
    for($i=0; $i<$level; $i++){
        $ret["dir"] .= $ret["hash"][$i]. "/";
    }

    $ret["filepath"] = $ret["dir"]. $ret["hash"]. $ret["file_ext"];

    return $ret;
}


/**
 * @param $dir
 * @return bool|int
 * Returns true if dir exists or is able to be created, otherwise false
 */
function createDir($dir)
{
    if (!is_dir(rtrim($dir, "/")))
        return mkdir(rtrim($dir, "/"), 0777, true);
    return 1;
}

/**
 * @param $dir
 * @return array
 * Returns array of filenames from directory
 */
function getDir($dir)
{
    $content = array();

    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if (in_array($file, array(".", "..")))
                    continue;

                if (in_array($file, explode(".", $file)))
                    continue;

                array_push($content, $file);
            }
            closedir($dh);
        } else {
            death("Couldn't open directory.");
        }
    } else {
        death("Invalid Directory.");
    }
    return $content;
}

function ffmpeg($file, $src = DIR_IMG_RAW, $dest = null)
{
    if (is_null($dest))
        return false;

    $command = "ffmpeg -i \"".$src.$file."\" -qscale:v 2 -vf fps=1 \"". $dest. explode(".", $file)[0]."_%03d.jpg\"";
    echo $command . "<br/>";
    if (shell_exec($command)) {
    }
    rename($src.$file, $src."done\\".$file);
}

$footer = "
            <div id='footer'>
                <p>Copyright &copy Team Dragon</p>
            </div>";
