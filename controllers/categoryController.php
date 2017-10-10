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
	public function __construct()
	{
		require_once('models/Category.php');
		require_once('views/categoryView.php');
		parent::__construct(new Category(), new categoryView());
	}

	public function imageViewer()
	{
		//POST
		if (($_SERVER["REQUEST_METHOD"] == "POST"))
		{
			// TO DO sanitize input
			$this->model->setFields($_POST["file"], ((int)$_POST["powerline"]), ((int)$_POST["powerpole"]),
				((int)$_POST["vegetation"]), (int)$_POST["oversag"]);
			
			if (isset($_POST["delete"]))
			{
				$this->model->deleteImage();
			}
			elseif (isset($_POST["submit"]))
			{
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