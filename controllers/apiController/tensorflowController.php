<?php
require_once('controllers/Controller.php');

/**
 * Class tensorflowController
 */

class tensorflowController extends Controller
{
	public function __construct()
	{
		require_once('models/api/TensorFlowMassager.php');
		parent::__construct((new TensorFlowMassager()));
	}

	/** This function will fix the file directory for all image files
	 * So that they may reflect how they are physically stored in memory
	 */
	public function fixHashDirs()
	{
		if (!$this->model->fixHashDirs())
			return call('error', 'error');

		if (!$this->model->fixHashDirs("Dummy", "dummy"))
			return call('error', 'error');

		if (!$this->model->fixHashDirs("Testing", "testing"))
			return call('error', 'error');

		$this->view->output();
	}

	/** This function will take care of taking all categorized images
	 * and copying them to a directory format for tensorflow
	 */
	public function massageDataset()
	{
		$this->model->output["status"] = "Made it";
		$this->model->output["images"] = array();
		$this->model->copyCategory('no_powerline');
		//$this->model->copyCategory('powerpole');
		//$this->model->copyCategory('overgrowth');
		//$this->model->copyCategory('oversag');
		//$this->model->copyCategory('powerline');
		$this->view->output();
	}
	
}