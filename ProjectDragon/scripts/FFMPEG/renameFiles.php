<?php

define("DIR_VID", "C:\\Users\\nfanaian\\Desktop\\Project Dragon\\raw\\");

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

$files = getDir(DIR_VID);
$i = 1;

echo "FILE COUNT: " . count($files) . "<br/>";
foreach($files as $file) {
    if ($file[0] != 'G' )
        continue;
    $newFile = uniqid() . explode(".", $file)[1];
    rename( DIR_VID . $file, DIR_VID . $newFile . ".MP4");
    echo "FILE [".$i++."]: " . $file . " RENAMED TO: ". $newFile . "<br/>";
}
