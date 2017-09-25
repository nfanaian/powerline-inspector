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
define("DIR_DEST", "/usr/local/project_dragon/data/training/");

$files = getDir(DIR_SRC);

//rename
echo "FILE COUNT: " . count($files) . "<br/>";

$db = new DB_Handler();

$i = 1;
foreach($files as $file) {

// Get MD5 hash of file
$hash = getHashDir($file, DIR_DEST);
$newFilepath = $hash["dir"]. $hash["hash"]. $hash["file_ext"];
if (createDir($hash["dir"]) && copy( DIR_SRC.$file, $newFilepath ))
    echo "FILE [".$i++."]: " . DIR_SRC. $file . " copied TO: ". $newFilepath . "<br/>";

}
