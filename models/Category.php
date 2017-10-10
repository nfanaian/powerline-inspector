<?php

/**
 * This is for the Image Categorizer 
 */

require_once('models/Model.php');

class Category extends Model
{
	public $filename = null;
	public $reviewedFile = null;
	public $message = null;
	public $submit_desktop = "";
	public $dets_mobile = "width: 20%; float: left;";
	public $submit_mobile = "<button name='submit'>Save</button>";
  public $info = null;
  public $footer = "
            <div id='footer'>
                <p>Copyright &copy Team Dragon</p>
            </div>";

	// DIR
	private $no_pics = "sadkermit.jpg";
	public $dir_img = "/var/www/html/img/";

	//
	private $powerline = 0;
	private $powerpole = 0;
	private $overgrowth = 0;
	private $oversag = 0;
	private $hash = null;
	private $filepath_src = null;

  public function setFields($file, $powerline, $powerpole, $overgrowth, $oversag)
  {
    $this->reviewedFile = $file;
    $this->powerline = $powerline;
    $this->powerpole = $powerpole;
    $this->overgrowth = $overgrowth;
    $this->oversag = $oversag;

    // HASHING DIRECTORIES (put this in a func and organize your shit ffs)
    $this->hash = $this->getHashDir();
    $this->filepath_src = $this->dir_img. $file;

    $this->setInfo();
  }

  public function setInfo()
  {
    // PROCESSED INFO
    $this->info = "<h4 style='text-align: left;'>File: ";
    $this->info .= $this->dir_img. $this->filename . "</h4>";

    $this->info .= "<h4 style='text-align: left;'>Last Reviewed File:</h4>";
    if (isset($this->message))
    {
      $this->info .= "Status: " . "</br>";
      $this->info .= $this->message . "</br>";
    }

    $this->info .= "Filename: " . $this->reviewedFile . "</br>";
    $this->info .= "Powerline: " . $this->powerline . "</br>";
    $this->info .= "Power Pole: " . $this->powerpole . "</br>";
    $this->info .= "Vegetation: " . $this->overgrowth . "</br>";
    $this->info .= "Oversag: " . $this->oversag . "</br>";
  }

	public function fetch_unreviewed()
	{
		$db = DB::connect();

		$sql = "SELECT * FROM `Images` WHERE `reviewed`='0' ORDER BY RAND() LIMIT 1";
		$result = $db->query($sql);

		if (!empty($result))
    {
			if (mysqli_num_rows($result) > 0)
      {
				if ($row = mysqli_fetch_row($result))
					$this->filename = $row[0];
        else
          $this->filename = $this->no_pics;
			}
		}
    $this->setInfo();
	}

	public function updateImage()
	{
    if ($this->filename == null) return 0;

		$db = DB::connect();

		$sql = "UPDATE `Images` SET `filedir`='". $this->dir. "',`powerline`='". $this->powerline. "', `powerpole`='". $this->powerpole. "',
                `overgrowth`='". $this->overgrowth. "',`oversag`='". $this->oversag. "',
                `reviewed`=1 WHERE `filename`='". $this->reviewedFile. "'";

		$db->query($sql);
		if ($db->affected_rows() > 0)
			return 1;
		return 0;
	}
  
  public function deleteSrc()
  {
    if (unlink($this->filepath_src)) {
      $this->message = "Image copied & DB updated: " . $this->hash["filepath"] . "</br>";
      return 1;
    }
    return 0;
  }

  public function deleteCopy()
  {
    // delete copied file if DB insert fails
    if (unlink( $this->hash["filepath"]))
    {
      $this->message = "Image failed: ". $this->hash["filepath"] . "</br>";
      return 1;
    }
    return 0;
  }

	public function deleteImage()
	{
		if (is_null($this->filename))
			return 0;
		
		$db = DB::connect();

		$sql = "DELETE FROM `Images` WHERE `filename`='". $this->filename. "'";

		$db->query($sql);
		if ($db->affected_rows() > 0)
		{
			if(unlink( $this->dir_img . $this->filename ))
			{
				$this->message = "Image Deleted: ". $this->model->dir_img. $this->filename. "</br>";
				return 1;
			}
		}
		return 0;
	}

	public function checkMobile()
	{
		// Check if mobile device
		include 'Mobile_Detect.php';
		$detect = new Mobile_Detect();
		if ($detect->isMobile()){
			return 1;
		}
		return 0;
	}

	public function getHashDir($reviewedFile = null, $fileDir = "/usr/local/project_dragon/data/training/")
	{
    if ($reviewedFile == null)
      $reviewedFile = $this->reviewedFile;

		$ret = array();
		$ret["filename"] = explode(".", $reviewedFile)[0];
		$ret["file_ext"] = "." . explode(".", $reviewedFile)[1];
		$ret["dir"] = $fileDir;
		$ret["hash"] = md5($ret["filename"]);

		$level = 10;
		for($i=0; $i<$level; $i++){
			$ret["dir"] .= $ret["hash"][$i]. "/";
		}

		$ret["filepath"] = $ret["dir"]. $ret["hash"]. $ret["file_ext"];

    return $this->hash = $ret;
	}

	/**
	 * @param $dir
	 * @return bool|int
	 * Returns true if dir exists or is able to be created, otherwise false
	 */
	private function createDir($dir)
	{
		if (!is_dir(rtrim($dir, "/")))
			return mkdir(rtrim($dir, "/"), 0777, true);
		return 1;
	}

  public function copyImage()
  {
    //if (is_null($this->reviewedFile)) return 0;

    if ($this->createDir($this->hash["dir"]) &&
      copy($this->filepath_src, $this->hash["filepath"]))
      return 1;
    return 0;
  }

	/**
	 * @param $dir
	 * @return array
	 * Returns array of filenames from directory
	 */
	public function getDir($dir)
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
				death("Couldn't open directory.");
			}
		} else {
			death("Invalid Directory.");
		}
		return $content;
	}
	
	
}