<?php
/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 9/11/2017
 * Time: 7:41 PM
 */

require_once('../config.php');
require_once('../DB_Handler.php');

define("DIR_SRC", "/usr/local/project_dragon/training/");
define("DIR_DEST", "/usr/local/project_dragon/data/dummy/");

$files = getDir(DIR_SRC);

//rename
echo "FILE COUNT: " . count($files) . "<br/>";

$db = new DB_Handler();

$i = 0;
foreach($files as $file)
{
    $i++;
    if ($db->checkPowerline($file))
    {
        // Get MD5 hash of file
        $hash = getHashDir($file, DIR_DEST);
        $newFilepath = $hash["dir"] . $hash["hash"] . $hash["file_ext"];

        echo "FILE [" . $i . "]: " . DIR_SRC . $file . "--->" . $newFilepath . "<br/>";

        if ($db->addDummy($file, $hash["dir"])) {
            echo "FILE [{$i}] Added! ";
            if (createDir($hash["dir"]) && copy(DIR_SRC . $file, $newFilepath))
                echo "File Copied! ";
        } else {
            echo "Failed to add to DB";
        }
        echo "<br/>";
    }
}
