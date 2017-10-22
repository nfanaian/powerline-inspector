<?php
require_once('controllers/Controller.php');

/**
 * API: Auth Controller
 * This controller takes care of authenticating users,
 * registering users, and verifying JSON Web Tokens
 */

class AuthController extends Controller
{
    public function __construct()
    {
        require_once('models/Auth.php');
        parent::__construct(new Auth());
    }

	/**
	 * API/Auth/<username>/<password>/
	 * User Input: username, password
	 * ** MUST UPDATE TO POST **
	 */
	public function login()
    {
        // fetch user input
	    $user = requestParser::getPOST('user');
	    $pass = requestParser::getPOST('pw');

        if (is_null($user) || is_null($pass)) {
            return call('error', 'error_login');
        }

        // Authenticate User
	    if (!$this->model->userAuth($user, $pass))
	    {
		    // Handle failure
	    }
	    
        // Display results
        $this->view->output();
    }

	/**
	 * API/Auth/<username>/<password>/
	 * User Input: username, password
	 * ** MUST UPDATE TO POST **
	 */
    public function register()
    {
	    // Fetch user input
	    $user = requestParser::getPOST('user');
	    $pass = requestParser::getPOST('pw');
	    $email = "";//requestParser::getParam(2);

	    // TODO Sanitize Input

	    if (is_null($user) || is_null($pass)) {// || is_null($email)) {
		    return call('error', 'error_register');
	    }

	    // Authenticate User
	    $this->model->registerUser($user, $pass, $email);

	    // Display results
	    $this->view->output();
    }
	
	// NOTE: This controller has no Action for Token Verification
	// IT DOES NOW FOR PAGES
	public function authPage()
	{
		if ($this->model->verifyToken()) {
			$this->model->output["status"] = "Valid Token";
			$this->model->output["success"] = true;
		} else {
			$this->model->output["status"] = "Invalid Token";
			$this->model->output["success"] = false;
		}
		$this->view->output();
	}
}