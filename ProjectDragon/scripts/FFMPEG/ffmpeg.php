<?php

define("DIR_VID", "C:\\Users\\nfanaian\\Desktop\\Project Dragon\\raw\\");
define("DIR_IMG", "C:\\Users\\nfanaian\\Desktop\\Project Dragon\\img\\");

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

function ffmpeg($file) {
    $command = "ffmpeg -i \"".DIR_VID.$file."\" -qscale:v 2 -vf fps=1 \"".DIR_IMG.explode(".", $file)[0]."_%03d.jpg\"";
    echo $command . "<br/>";
    if (shell_exec($command)) {
    }
    rename(DIR_VID.$file, DIR_VID."done\\".$file);
}

$files = getDir(DIR_VID);

ffmpeg($files[0]);

echo "NEXT FILE: ". $files[1];

header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]));