<?php
require_once('controllers/Controller.php');

/**
 * Class SeniorDesignController
 */



class UtilityController extends Controller
{
	public function __construct()
	{
		require_once('models/utility/Utility.php');
		require_once('views/utilityView.php');
		parent::__construct(new Utility(), new UtilityView());
	}

	public function home()
	{
		$this->model->output['status'] = "Hello World";
		$this->view->output();
	}

	/**
	 *
	 */
	public function login()
	{
		$this->view->loginView();
	}

	/**
	 *
	 */
	public function logout()
	{
		$this->model->clearKeys();
		header("Location: http://squibotics.com/utility/login/");
	}

	/**
	 * @return int
	 */
	public function mapViewer()
	{
		/*
		if (!$this->model->authenticate())
			return call('error', 'error_authPage');*/

		$this->view->mapView();
	}

	/**
	 *
	 */
	public function log()
	{
		if (!$this->model->authenticate())
			return call('error', 'error_authPage');

		$this->view->logView();

	}

	public function upload()
	{
		if (!$this->model->authenticate())
			return call('error', 'error_authPage');

		$this->view->uploadView();

	}
}

?>

