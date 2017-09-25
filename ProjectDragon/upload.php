<?php

require_once("config.php");

define('MAX_SIZE', 500000);
$allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");

if(count($_FILES['file']['name']) > 0) {
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
        echo "<div style='border: double;'>";

        $extension = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
        if ((($_FILES["file"]["type"][$i] == "video/mp4")
                || ($_FILES["file"]["type"][$i] == "audio/mp3")
                || ($_FILES["file"]["type"][$i] == "audio/wma")
                || ($_FILES["file"]["type"][$i] == "image/gif")
                || ($_FILES["file"]["type"][$i] == "image/jpg")
                || ($_FILES["file"]["type"][$i] == "image/jpeg"))
            && ($_FILES["file"]["size"][$i] < MAX_SIZE)
            && in_array($extension, $allowedExts)
        ) {
            if ($_FILES["file"]["error"][$i] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"][$i] . "<br />";
            } else {
                //Get the temp file path
                $tmpFile = $_FILES["file"]['tmp_name'][$i];
                $filename = $_FILES["file"]["name"][$i];

                echo "Upload: " . $filename . "<br />";
                echo "Type: " . $_FILES["file"]["type"][$i] . "<br />";
                echo "Size: " . ($_FILES["file"]["size"][$i] / 1024) . " Kb<br />";
                echo "Temp file: " . $tmpFile . "<br />";

                // Generate Unique Filename
                $filename = uniqid() . "." . $extension;//explode(".", $filename)[1];

                // Move file to final destination
                if (move_uploaded_file($tmpFile, DIR_IMG_RAW . $filename)) {

                   // SUCCESS: UPLOADED TO DIR_IMG_RAW!
                    
                } else {
                    echo "Failed to move: " . $filename . BR;
                }
            }
        } else {
            echo "Invalid file: " . $_FILES["file"]["name"][$i] . BR;
        }
        echo "</div>";
    }
} else {
    echo "No Files Uploaded." . BR;
}
?>