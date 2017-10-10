<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 9/26/2017
 * Time: 3:20 PM
 */
require_once('controllers/Controller.php');

class ErrorController extends Controller
{
	public function __construct()
	{
		require_once('models/Model.php');
		require_once('views/View.php');
		parent::__construct(new Model(), new View());
	}

	public function error_auth()
	{
		$this->model->http_response_code = 400;
		$this->model->output["status"] = "Authentication Failed";
		$this->view->output();
	}

	public function error_token()
	{
		$this->model->http_response_code = 400;
		$this->model->output["status"] = "Authorization Failed";
		$this->view->output();
	}
	
	public function error_controller_dne()
	{
		$this->model->http_response_code = 404;
		$this->model->output["status"] = "Error: controller does not exist.";
		$this->view->output();
	}
	
	public function error_action_dne()
	{
		$this->model->http_response_code = 404;
		$this->model->output["status"] = "Error: action does not exist.";
		$this->view->output();
	}

	public function error_api_dne()
	{
		$this->model->http_response_code = 404;
		$this->model->output["status"] = "Error: API Function does not exist.";
		$this->view->output();
	}
}