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
		$this->view->mapView();
	}
}