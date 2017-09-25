<?php

define("DIR_DEST", "C:\\Users\\nfanaian\\Desktop\\Project Dragon\\raw\\");
define("DRIVE_SRC", "D");
define("DIR_SRC1", DRIVE_SRC . ":\\DCIM\\100EVENT\\");
define("DIR_SRC2", DRIVE_SRC . ":\\DCIM\\102SAVED\\");
define("DIR_SRC3", DRIVE_SRC . ":\\DCIM\\103UNSVD\\");

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

function copyFiles($DIR_SRC)
{
    $i = 0;
    $files = getDir($DIR_SRC);
    echo "FILE COUNT: " . count($files) . "<br/>";
    foreach ($files as $file) {
        $newFile = uniqid() . "." . end(explode(".", $file));
        copy($DIR_SRC . $file, DIR_DEST . $newFile);
        echo "FILE [" . $i++ . "]: " . $file . " COPIED TO: " . DIR_DEST . $newFile . "<br/>";
    }
    return 1;
}

if (copyFiles(DIR_SRC1)) {
    echo DIR_SRC1 . "has been copied" . "<br/>";
}

if (copyFiles(DIR_SRC2)) {
    echo DIR_SRC2 . "has been copied" . "<br/>";
}

if (copyFiles(DIR_SRC3)) {
    echo DIR_SRC3 . "has been copied" . "<br/>";
}



