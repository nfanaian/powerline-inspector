<?php
require_once("models/Model.php");

/**
 * Class Upload
 * This takes care of any requests regarding upload to the server
 */
class Upload extends Model
{
	private $uploadDir = '/usr/local/project_dragon/upload/';

	public function __construct()
	{
		parent::__construct();
	}

	public function uploadFile($file)
	{
		// Check for errors
		if($_FILES['file']['error'] > 0){
			$this->output['status'] = 'An error ocurred when uploading.';
		}

		if(!getimagesize($_FILES['file']['tmp_name'])){
			$this->output['status'] = 'Please ensure you are uploading an image.';
		}

		// Check filetype
		if($_FILES['file']['type'] != 'image/jpeg'){
			$this->output['status'] = 'Unsupported filetype uploaded.';
		}

		// Check filesize
		if($_FILES['file']['size'] > 2097152){
			$this->output['status'] = 'File uploaded exceeds maximum upload size.';
		}

		// Check if the file exists
		if(file_exists($this->uploadDir . $_FILES['file']['name'])){
			$this->output['status'] = 'File with that name already exists.';
		}

		// Upload file
		if(!move_uploaded_file($_FILES['file']['tmp_name'], $this->uploadDir . $_FILES['file']['name'])){
			$this->output['status'] = 'Error uploading file - check destination is writeable.';
		}

		$this->output['status'] = 'File uploaded successfully to "' . $this->uploadDir . $_FILES['file']['name'];
		$this->output['success'] = true;
	}
	
	public function uploadOld($file)
	{
		$this->output['success'] = false;
		$this->output['status'] = "We got the file, script started";

		// File Properties
		$target_dir = '/usr/local/project_dragon/upload/';
		$file_name = $file['name'];
		$file_tmp = $file['tmp_name'];
		$file_size = $file['size'];
		$file_error = $file['error'];

		// Working With File Extension
		$file_ext = explode('.', $file_name);
		$file_fname = explode('.', $file_name);

		$file_fname = strtolower(current($file_fname));
		$file_ext = strtolower(end($file_ext));
		$allowed = array('png', 'jpg', 'gif', 'jpeg', 'gif');

		// Add microtime to time file name and reconstruct new Target Filepath
		$file_name_new = $file_fname . uniqid('', true) . '.' . $file_ext;
		$file_name_new = uniqid('', true) . '.' . $file_ext;
		$target_filepath = $target_dir . $file_name_new;

		if (file_exists($target_filepath) && in_array($file_ext, $allowed))
		{
			if ($file_error === 0)
			{
				if ($file_size <= 5000000)
				{
					if (move_uploaded_file($file_tmp, $target_filepath))
					{
						$this->output['success'] = true;
						$this->output['message'] = 'Image Uploaded';
					} else {
						$this->output['success'] = false;
						$this->output['message'] = "Some error in uploading file";
					}
				} else {
					$this->output['success'] = false;
					$this->output['message'] = "Size must one less then 5MB";
				}
			}
		}
		else
		{
			$this->output['success'] = false;
			$this->output['message'] = "Invalid File";
		}
	}
}