<?php


/**
 * Class SeniorDesignController
 */

require_once('controllers/Controller.php');

class DemoController extends Controller
{
	public function __construct()
	{
		require_once('models/seniordesign/SeniorDesign.php');
		require_once('views/seniorDesignView.php');
		parent::__construct(new SeniorDesign(), new SeniorDesignView());
	}

	/**
	 * @return int
	 */
	public function mapViewer()
	{
		//if (!$this->model->authenticate())
		//return call('error', 'error_authPage');

		$this->view->mapView();
	}

	/**
	 *
	 */
	public function userViewer()
	{
		$this->view->userView();
	}

	/**
	 * @return int
	 */
	public function logout()
	{
		$this->model->clearKeys();
		return call('seniordesign', 'userview');
	}

	/**
	 *
	 */
	public function imageViewer()
	{
		// Replace Utility Model with Category Model for this case
		require_once('models/Category.php');
		$this->setModel(new Category());

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
					$this->model->message = "Image {$this->model->reviewedFile} Copy Failed. </br> 
                      Image marked back as unreviewed. </br>";
				}
			}
		}
		$this->model->fetch_unreviewed();
		$this->view->imageView();
	}
}

?>

