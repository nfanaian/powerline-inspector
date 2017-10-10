<?php

/**
* Created by PhpStorm.
* User: nfanaian
* Date: 8/30/2017
* Time: 9:30 PM
*/
require_once('views/View.php');

class Controller
{
	protected $model;
	protected $view;

	public function __construct($model = null, $view = null)
	{
		$this->model = $model;
		$this->setView($view);
	}

	protected function setModel($model)
	{
		$this->model = $model;
		if (!is_null($this->view))
			$this->view->setModel($model);
	}

	protected function setView($view)
	{
		$this->view = $view;

		// Initiate default View if no view provided
		if (is_null($view)) {
			require_once('views/View.php');
			$this->view = new View();
		}

		$this->view->setModel($this->model);
	}

	public function error()
	{
		$this->model->http_response_code = 400;
		$this->model->output["status"] = "Unexpected Error";
		$this->view->output();
	}
}