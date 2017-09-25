<?php
/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 7/14/2017
 * Time: 10:37 AM
 */

//Add to Database
require_once("DB_Handler.php");
require_once("config.php");

$files = getDir( DIR_IMG_RAW );
$db = new DB_Handler();

$i = 0;
foreach( $files as $filename) {

    if ($db->addImage($filename)) {
        $i++;
        echo "Image Added: ". DIR_IMG_RAW. $filename. BR;
    } else {
        echo "Image already been added: ". $filename. BR;
    }
}
echo $i. " FILES". BR;