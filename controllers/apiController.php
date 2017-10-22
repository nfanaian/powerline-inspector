<?php
require_once('controllers/Controller.php');

/**
 * Class APIController
 */

class APIController extends Controller
{

	// This checks if the API function is valid
	// Remember: API Has its own controller, therefore its $action is a controller of the API
	private function validRequest($action)
	{
		$api = array(   'auth'      =>  ['login', 'register', 'authpage'],
						'marker'    =>  ['foo', 'getmarker', 'getnearby', 'getall', 'getimage', 'updatemarker'],
						'user'      =>  ['foo'],
						'tf'        =>  ['foo', 'fixhashdirs', 'massagedataset'],
						'test'      =>  ['hello', 'decode']
		);

		$func = requestParser::getAPIFunc();

		// CALL API
		// Check controller & action are valid and call it
		// Otherwise, redirect to error
		if (array_key_exists($action, $api))
		{
			if (in_array($func, $api[$action]))
				return $func;
			else
				return call('error', 'error_api_function_dne');
		}
		else
			return call('error', 'error_api_function_dne');
	}

	public function auth()
	{
		require_once('controllers/apiController/authController.php');
		$func = requestParser::getAPIFunc();

		if (!($func = $this->validRequest('auth'))) return 0;

		(new AuthController())->{ $func }();

		return 0;
	}

	public function marker()
	{
		require_once('controllers/apiController/markerController.php');

		$func = requestParser::getAPIFunc();

		if (!($func = $this->validRequest('marker'))) return 0;

		(new MarkerController())->{ $func }();

		return 0;
	}

	public function test()
	{
		require_once('controllers/apiController/testController.php');

		if (!($func = $this->validRequest('test'))) return 0;

		(new TestController())->{ $func }();

		return 0;
	}

	public function user()
	{
		require_once('controllers/apiController/userController.php');

		if (!($func = $this->validRequest('user'))) return 0;

		(new UserController())->{ $func }();

		return 0;
	}

	public function tf()
	{
		require_once('controllers/apiController/tensorflowController.php');

		if (!($func = $this->validRequest('tf'))) return 0;

		(new tensorflowController())->{ $func }();

		return 0;
	}
}