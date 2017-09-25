<?php

// Imports
require_once("config.php");
require_once("DB_Handler.php");

// Globals
$db = new DB_Handler();
$filename = null;
$reviewedFile = null;
$message = null;
$submit_desktop = "";
$dets_mobile = "width: 20%; float: left;";
$submit_mobile = "<button name='submit'>Save</button>";

if (0)//!checkMobile())
{
    $dets_img = "float: left;";
    $dets_but = "float: right;";
    $dets_mobile = "";
    $submit_desktop = $submit_mobile; //"<button style='". $dets_but. "' name='submit'>Save</button>";
    $submit_mobile = "";
}

//POST
if (($_SERVER["REQUEST_METHOD"] == "POST"))
{
    if (isset($_POST["delete"]))
    {
        if ($db->deleteImage( $_POST["file"] ))
        {
            $message = "Image Deleted: ". DIR_IMG_RAW. $_POST["file"]. BR;
        }
    }
    elseif (isset($_POST["submit"]))
    {
        $reviewedFile = $_POST["file"];

        $powerline = ((int)$_POST["powerline"]);
        $powerpole = ((int)$_POST["powerpole"]);
        $vegetation = ((int)$_POST["vegetation"]);
        $oversag = ((int)$_POST["oversag"]);

        // HASHING DIRECTORIES (put this in a func and organize your shit ffs)
        $hash = getHashDir($reviewedFile);
        $filepath_src = DIR_IMG_RAW. $reviewedFile;

        //Update DB with reviewed image and move image to hash directory
        if (createDir($hash["dir"]) && copy($filepath_src, $hash["filepath"]))
        {
            if ($db->updateImage($reviewedFile, $hash["dir"], $powerline, $powerpole, $vegetation, $oversag, 1))
            {
                unlink($filepath_src); // delete temp file
                $message = "Image copied & DB updated: ". $hash["filepath"] . BR;
            }
            else
            {
                $message = "Image failed: ". $hash["filepath"] . BR;
                unlink( $hash["filepath"] ); // delete copied file if DB insert fails
            }
        }
        else
        {
            $message = "Image Copy Failed.". BR. "Image marked back as unreviewed". BR; // Copy to hash dir failure
        }
    }
}

$filename = $db->fetch_unreviewed();

// PROCESSED INFO
$info = "<h4 style='text-align: left;'>File: ";
$info .= DIR_IMG_RAW. $filename. "</h4>";

$info .= "<h4 style='text-align: left;'>Last Reviewed File:</h4>";
if (isset($message))
{
    $info .= "Status: " . BR;
    $info .= $message . BR;
}

$info .= "Filename: ". $reviewedFile. BR;
$info .= "Powerline: ". $powerline. BR;
$info .= "Power Pole: ". $powerpole. BR;
$info .= "Vegetation: ". $vegetation. BR;
$info .= "Oversag: ". $oversag. BR;

//HTML CODE
require_once("imageView.php");

$db->close();
