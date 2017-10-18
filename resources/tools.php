<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 10/17/2017
 * Time: 7:10 PM
 */
class Tools
{
	private static $root_data = "/usr/local/project_dragon/data/";

	public static function checkMobile()
	{
		// Check if mobile device
		include 'Mobile_Detect.php';
		$detect = new Mobile_Detect();
		if ($detect->isMobile()){
			return 1;
		}
		return 0;
	}

	public static function getHashDir($file, $folder = "training")
	{
		$ret = array();
		$ret["dir"] = self::$root_data. $folder. "/";
		$ret["filename"] = $file;
		$ret["filename_raw"] = explode(".", $file)[0];
		$ret["file_ext"] = "." . explode(".", $file)[1];
		$ret["hash"] = md5($ret["filename_raw"]);

		$level = 10;
		for($i=0; $i<$level; $i++){
			$ret["dir"] .= $ret["hash"][$i]. "/";
		}

		$ret["filename_hash"] = $ret["hash"] . $ret["file_ext"];
		$ret["filepath"] = $ret["dir"]. $ret["filename_hash"];

		return $ret;
	}

	/**
	 * @param $dir
	 * @return bool|int
	 * Returns true if dir exists or is able to be created, otherwise false
	 */
	private static function createDir($dir)
	{
		if (!is_dir(rtrim($dir, "/")))
			return mkdir(rtrim($dir, "/"), 0777, true);
		return 1;
	}

	public static function copyImage($filepath_src, $filepath_dest, $dir)
	{
		// Ensure source file exists prior to copying
		if (!file_exists($filepath_src) || file_exists($filepath_dest))
			return 0;

		// Obtain the destination directory of file from the complete filepath
		//$dir = explode("/", $filepath_dest); //blow up filepath into array
		//array_pop($dir); // remove filename from array
		//$dir = implode("/", $dir); //stich array back to string

		// Create a directory if none, and copy file
		if (self::createDir($dir) &&
			copy($filepath_src, $filepath_dest))
			return 1;
		return 0;
	}

	/**
	 * @param $dir
	 * @return array
	 * Returns array of filenames from directory
	 */
	public static function getDir($dir)
	{
		$content = array();

		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
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
	
}