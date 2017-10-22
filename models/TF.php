<?php
require_once('models/Model.php');
class TF extends Model
{
	private $root_src = "/usr/local/project_dragon/data/";
	private $root_dest = "/usr/local/project_dragon/tensorflow/data/powerlines/powerline_photos/";
	private $dataset_table;
	private $dataset_folder;

	public function __construct()
	{
		// Construct Model
		parent::__construct();
		$this->setDB();
	}

	public function setDB($table = "Images", $folder = "training")
	{
		// Sanitize input variables
		$table = trim(ucwords(strtolower($table)));
		$folder = trim(strtolower($folder));

		$this->dataset_table = $table;
		$this->dataset_folder = $folder;
	}

	/** Helper: generate hash directory from MD5() of filename
	 *
	 */
	private function getHashDir($file)
	{
		$ret = array();
		$ret["dir"] = $this->root_src. $this->dataset_folder;
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

		return $this->hash = $ret;
	}

	/** Get list of all images
	 * @return array|int: [full_filepath, filename, filedir]
	 */
	private function getTrainingFiles()
	{
		// Database connection
		$db = DB::connect();

		// pull list of {filename, filedir}
		// from all image records from DB
		$sql = "";
		if ($this->dataset_table === 'Images') {
			$sql = "
			SELECT `filename`, `filedir` 
			FROM `Images`
			WHERE `reviewed`=1";
		} else {
			$sql = "
			SELECT `filename`, `filedir` 
			FROM `Dummy`";
		}

		$result = $db->query($sql);
		// Retrieve file list
		$files = 0; // returns 0 in case SELECT sql fails
		if ($result->num_rows > 0)
		{
			$files = array();
			while ($r = $result->fetch_row())
				array_push($files, array("filename" => $r[0], "dir" => $r[1]));
		}
		return $files;
	}

	/** This function will fix the file directory for all image files
	 * So that they may reflect how they are physically stored in memory
	 */
	public function fixHashDirs()
	{
		// Get list of all images
		if (!($files = $this->getTrainingFiles()))
			return 0;

		$this->output["files"] = array();
		$this->output["failed"] = array();
		$this->output["passed"] = array();
		$this->output["deleted"] = array();

		// Iterate through list, checking if filedir+filename exists
		// Otherwise, update filedir from DB with correct MD5 Directory Hash
		// Refer to getHashDir () from TF Model
		foreach ($files as $file)
		{
			// Get correct Hash Directory
			require_once('resources/tools.php');
			$hash = Tools::getHashDir($file["filename"], $this->dataset_folder);


			// Only update directory if DB Dir does not contain correct hash dir
			if (!file_exists($file["dir"]. $hash["filename_hash"]))
			{
				array_push($this->output["files"], $file["dir"].$file["filename"]);

				// Check file with correct fileDir exists
				if (!file_exists($hash["filepath"])) {
					// This shouldn't happen, we must have lost the image
					// So lets remove it from DB
					$db = DB::connect();

					// Update image's file directory
					$sql = "
					DELETE FROM `{$this->dataset_table}`
					WHERE `filename`='{$hash["filename"]}'";

					// JSON Output
					//$this->output["status"] = "Passed and Failed lists all filenames that passed/failed their file dir update.";

					// Check DB Update was successful
					if ($db->query($sql) === TRUE){
						array_push($this->output["deleted"], $hash["filename"]);
					}
					continue;
				}

				$db = DB::connect();

				// Update image's file directory
				$sql = "
				UPDATE `{$this->dataset_table}`
				SET `filedir`='{$hash["dir"]}'
				WHERE `filename`='{$hash["filename"]}'";

				// JSON Output
				//$this->output["status"] = "Passed and Failed lists all filenames that passed/failed their file dir update.";

				// Check DB Update was successful
				if ($db->query($sql) === TRUE){
					array_push($this->output["passed"], $hash["filepath"]);
				} else {
					array_push($this->output["failed"], $file["dir"]. $hash["filename_hash"]);
				}
			}
		}

		// return false if all files didn't pass
		if (!empty($this->output["failed"]) && sizeof($this->output["failed"]) > 0)
			return 0;
		return 1;
	}

	private function getCategoryFiles($category = 'powerline')
	{
		$category = strtolower($category);
		$this->output["images"][$category] = array();
		$db = DB::connect();

		// SQL Statement: SELECT All images of the requested category
		if ($category === 'no_powerline') {
			$sql = "
			SELECT `filename`, `filedir`
			FROM `Images`
			WHERE `reviewed`=1 AND `powerline`=0 AND `powerpole`=0 AND `overgrowth`=0 AND `oversag`=0";
		} else {
			$sql = "
			SELECT `filename`
			FROM `Images`
			WHERE `reviewed`=1 AND `{$category}`=1";
		}

		$result = $db->query($sql);

		if ($result->num_rows > 0){
			$this->output["images"][$category] = array();
			while ($row = $result->fetch_row()) {
				array_push($this->output["images"][$category], $row[0]);
			}
		} else {
			$this->output["images"][$category] = "fail";
		}
	}

	public function copyCategory($category = 'powerline')
	{
		$this->getCategoryFiles($category);

		$this->output["files"] = array();
		foreach(($this->output["images"][$category]) as $file)
		{
			$hash = Tools::getHashDir($file, $this->dataset_folder);
			$file_src = $hash["filepath"];
			$dir = $this->root_dest. $category. "/";
			$file_dest = $dir. $file;

			require_once('resources/tools.php');
			if (Tools::copyImage($file_src, $file_dest, $dir))
				array_push($this->output["files"], $file_dest);
		}
	}


}