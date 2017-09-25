<?php
// Database definitions
define('DB_SERVER', "localhost"); // db server (localhost, MySQL DB is on the same computer bruh)
define('DB_USER', "admin"); // db user
define('DB_PASSWORD', "d1dc93d2b138cb1ff2eb03e6ca1aa77a22930a8f568812b7"); // db password (mention your db password here)
define('DB_DATABASE', "Project_Dragon"); // database name
define('DIR_ROOT', $_SERVER["DOCUMENT_ROOT"] . "/ProjectDragon/");
define("DIR_IMG_RAW", "/var/www/html/img/");
define("DIR_IMG", "/usr/local/project_dragon/training/");
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

function getDir( $dir_img )
{
    $content = array();

    if (is_dir($dir_img)) {
        if ($dh = opendir($dir_img)) {
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
    