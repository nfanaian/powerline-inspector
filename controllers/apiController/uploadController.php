<?php

require_once("controllers/Controller.php");

class UploadController extends Controller
{
	public function __construct()
	{
		require_once("models/api/Upload.php");
		parent::__construct(new Upload());
	}

	/**
	 * API/Upload/
	 * User Input: filename, image-byte-stream
	 * Sanitize user input, upload image
	 * Return JSON of success of the image upload
	 */
	public function upload()
	{

	}
}

