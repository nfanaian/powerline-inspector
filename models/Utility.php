<?php
require_once 'models/Model.php';

/**
 * Class Utility
 */

class Utility extends Model
{
	private $API_ROOT = "http://107.170.23.85/api/";
	private $filename = "596a0d35eec05_143.jpg";

	public function __construct()
	{
		// Construct Model
		parent::__construct();
	}

	public function getImage()
	{
		return  $this->API_ROOT.
				"marker/getimage/".
				"API_KEY/".
				$this->getFile(). "/";
	}

	public function getFile()
	{
		return $this->filename;
	}

	public function setFile($filename)
	{
		$this->filename = $filename;
	}
}