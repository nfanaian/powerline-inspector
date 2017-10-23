<?php
require_once('controllers/Controller.php');

/**
 * Class UtilityController
 */

class UtilityController extends Controller
{
	public function __construct()
	{
		require_once('models/Utility.php');
		require_once('views/utilityView.php');
		parent::__construct(new Utility(), new utilityView());
	}

	public function mapViewer()
	{
		if (!$this->model->authenticate())
			return call('error', 'error_authPage');

		$this->view->mapView();
	}

	public function userViewer()
	{
		$this->view->userView();
	}

	public function logout()
	{
		$this->model->clearKeys();
		return call('utility', 'userview');
	}
}