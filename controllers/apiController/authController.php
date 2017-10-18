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
        $user = requestParser::getParam(0); //urlParser::getPOST('user');
        $pass = requestParser::getParam(1); //urlParser::getPOST('pass');
        
        if (is_null($user) || is_null($pass)) {
            return call('error', 'error');
        }

        // Authenticate User
        $this->model->userAuth($user, $pass);
	    
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
	    // fetch user input
	    $user = requestParser::getParam(0); //urlParser::getPOST('user');
	    $pass = requestParser::getParam(1); //urlParser::getPOST('pass');
	    $email = requestParser::getParam(2);

	    if (is_null($user) || is_null($pass)) {// || is_null($email)) {
		    return call('error', 'error_register');
	    }

	    // TO DO Sanitize Input


	    // Authenticate User
	    $this->model->registerUser($user, $pass, $email);

	    // Display results
	    $this->view->output();
    }
	
	// NOTE: This controller has no Action for Token Verification
}