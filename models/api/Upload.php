<?php
require_once("models/Model.php");

/**
 * Class Upload
 * This takes care of any requests regarding upload to the server
 */
class Upload extends Model
{
	public function upload()
	{
		$this->output['success'] = false;
		$this->output['status'] = "Script started.";

		if (isset($_FILES['file'])) {
			$file = $_FILES['file'];
			// print_r($file);  just checking File properties

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
}