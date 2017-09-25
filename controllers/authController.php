<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 8/28/2017
 * Time: 11:55 PM
 */
require_once('controllers/Controller.php');

class AuthController extends Controller
{
    public function __construct()
    {
        require_once('models/Auth.php');
        parent::__construct(new Auth());
    }

    public function login()
    {
        // fetch user input
        $user = urlParser::getParam(0); //urlParser::getPOST('user');
        $pass = urlParser::getParam(1); //urlParser::getPOST('pass');
        
        if (is_null($user) || is_null($pass)) {
            return call('auth', 'error');
        }

        // Authenticate User
        $this->model->userAuth($user, $pass);

        // Display results
        $this->view->output();
    }

    public function register()
    {
	    // fetch user input
	    $user = urlParser::getParam(0); //urlParser::getPOST('user');
	    $pass = urlParser::getParam(1); //urlParser::getPOST('pass');
	    $email = urlParser::getParam(2);

	    if (is_null($user) || is_null($pass) || is_null($email)) {
		    return call('auth', 'error');
	    }

	    // TO DO Sanitize Input


	    // Authenticate User
	    $this->model->registerUser($user, $pass, $email);

	    // Display results
	    $this->view->output();
    }

    public function error_auth()
    {
        $this->model->http_response_code = 400;
        $this->model->output["status"] = "Authentication Failed";
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

    public function error_token()
    {
        $this->model->http_response_code = 400;
        $this->model->output["status"] = "Authorization Failed";
        $this->view->output();
    }
}