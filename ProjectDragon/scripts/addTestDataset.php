<?php
/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 9/11/2017
 * Time: 7:41 PM
 */

require_once('../config.php');
require_once('../DB_Handler.php');

define("DIR_DEST", "/usr/local/project_dragon/data/testing/");

$files = getDir(DIR_IMG_RAW);

//rename
echo "FILE COUNT: " . count($files) . "<br/>";

$db = new DB_Handler();

$i = 0;
for($i=0; $i<count($files); $i += 25)
{

    $file = $files[$i];
    $hash = getHashDir($file, DIR_DEST); // Get MD5 hash of file
    $oldFilepath = DIR_IMG_RAW. $file;
    $newFilepath = $hash["dir"] . $hash["hash"] . $hash["file_ext"];

    echo "FILE [" . $i . "]: " . $oldFilepath . "--->" . $newFilepath . "<br/>";

    if (createDir($hash["dir"]) && copy($oldFilepath, $newFilepath))
    {
        if ($db->addTest($file, $hash["dir"])) {
            echo "FILE [{$i}] Added & Copied!";
            unlink($oldFilepath);
        } else {
            echo "FILE [{$i}] Failed";
            unlink($newFilepath);
        }
    }
    else
        echo "Failed to copy";
    echo "<br/>";
}