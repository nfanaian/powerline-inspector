<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 9/23/2017
 * Time: 2:33 PM
 */

require_once('controllers/Controller.php');

class CategoryController extends Controller
{
	public function imageViewer()
	{
		//POST
		if (($_SERVER["REQUEST_METHOD"] == "POST"))
		{
			if (isset($_POST["delete"]))
			{
				if ($this->model->deleteImage( $_POST["file"] ))
				{
					$message = "Image Deleted: ". $this->model->dir_img. $_POST["file"]. "</br>";
				}
			}
			elseif (isset($_POST["submit"]))
			{
			  // TO DO sanitize input
				$this->model->setFields($_POST["file"], ((int)$_POST["powerline"]), ((int)$_POST["powerpole"]),
					((int)$_POST["vegetation"]), (int)$_POST["oversag"]);


				//Update DB with reviewed image and move image to hash directory
				if ($this->model->copyImage())
				{
					if ($this->model->updateImage())
					{
						$this->model->deleteSrc();
					}
					else
					{
					  $this->model->deleteCopy();
					}
				}
				else
				{
          // Copy to hash dir failure
					$this->model->message = "Image Copy Failed. </br> 
                      Image marked back as unreviewed. </br>";
				}
			}
		}
    $this->model->fetch_unreviewed();
		$this->view->imageView();
	}
}