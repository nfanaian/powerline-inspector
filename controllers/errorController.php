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

	public function error_controller_dne()
	{
		$this->model->http_response_code = 400;
		$this->model->output["status"] = "Controller does not exist";
		$this->view->error();
	}

	public function error_action_dne()
	{
		$this->model->http_response_code = 400;
		$this->model->output["status"] = "Action does not exist";
		$this->view->error();
	}

	public function error_authPage()
	{
		$this->model->http_response_code = 200;
		$this->model->output["status"] = "JSON Web Token invalid or missing";
		$this->model->output["redirect"] = true;
		$this->view->error();
	}

	/** API Errors */
	public function error()
	{
		$this->model->http_response_code = 200;
		$this->model->output["status"] = "Unexpected Error";
		$this->view->output();
	}

	public function error_auth()
	{
		$this->model->http_response_code = 200;
		$this->model->output["status"] = "Authentication Failed";
		$this->view->output();
	}

	public function error_token()
	{
		$this->model->http_response_code = 200;
		$this->model->output["status"] = "Authorization Failed";
		$this->view->output();
	}

	public function error_api_controller_dne()
	{
		$this->model->http_response_code = 200;
		$this->model->output["status"] = "Error: API controller does not exist";
		$this->view->output();
	}

	public function error_api_function_dne()
	{
		$this->model->http_response_code = 200;
		$this->model->output["status"] = "Error: action does not exist";
		$this->view->output();
	}

	public function error_api_dne()
	{
		$this->model->http_response_code = 200;
		$this->model->output["status"] = "Error: API Function does not exist";
		$this->view->output();
	}

	public function error_register()
	{
		$this->model->http_response_code = 200;
		$this->model->output["status"] = "Error: Missing some registration variables";
		$this->view->output();
	}

	public function error_login()
	{
		$this->model->http_response_code = 200;
		$this->model->output["status"] = "Missing username|password parameters";
		$this->view->output();
	}

	public function error_nearbyMarkers()
	{
		$this->model->http_response_code = 200;
		$this->model->output["status"] = "Missing latitude, longitude parameters";
		$this->view->output();
	}
}