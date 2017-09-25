<?php
/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 7/14/2017
 * Time: 10:37 AM
 */

//Add to Database
require_once("DB.php");

define('DIR_IMG_RAW', "C:\\Users\\nfanaian\\Desktop\\Project Dragon\\img\\");

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
            die("Couldn't open directory.");
        }
    } else {
        die("Invalid Directory.");
    }
    return $content;
}

$files = getDir( DIR_IMG_RAW );
$db = new DBConnection();

//`filename`, `filedir`, `powerline`, `powerpole`, `vegetation`, `oversag`, `damage`, `reviewed`
$i = 0;
$loc_lat = 28.602439;
$loc_long = -81.200080;
foreach($files as $filename) {

    $sql = "INSERT INTO `images`(`image_id`, `loc_lat`, `loc_long`, `img_path`, `powerline`, `powerpole`, `overgrowth`, `oversag`, `damage`) 
            VALUES ('". $filename. "', '". $loc_lat. "', '". $loc_long. "', '/usr/img/', 0, 0, 0, 0, 0)";

   if ($db->query($sql)) {
        $i++;
        echo "Image Added: ". DIR_IMG_RAW. $filename. "<br/>";
    } else {
        echo "Image already been added: ". $filename. "<br/>";
    }
    $loc_lat += 0.0005;
    $loc_long += 0.0005;
}
echo $i. " FILES". "<br/>";