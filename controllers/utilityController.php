<?php


/**
 * Class SeniorDesignController
 */

require_once('controllers/Controller.php');

class UtilityController extends Controller
{
	public function __construct()
	{
		require_once('models/utility/Utility.php');
		require_once('views/UtilityView.php');
		parent::__construct(new Utility(), new UtilityView());
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
	public function login()
	{
		$this->view->loginView();
	}

	/**
	 *
	 */
	public function log()
	{
		$this->view->logView();

	}

	/**
	 * @return int
	 */
	public function logout()
	{
		$this->model->clearKeys();
		return call('seniordesign', 'userview');
	}
}

?>

