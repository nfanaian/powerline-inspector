<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 9/26/2017
 * Time: 2:10 PM
 */

require_once('controllers/Controller.php');

class APIController extends Controller
{

	// This checks if the API function is valid
	// Remember: API Has its own controller, therefore its $action is a controller of the API
	private function validRequest($action)
	{
		$api = array(   'auth'      =>  ['login'],
						'marker'    =>  ['foo', 'getMarker', 'getNearby', 'getAll']
		);

		$func = urlParser::getAPIFunc();

		// CALL API
		// Check controller & action are valid and call it
		// Otherwise, redirect to error
		if (array_key_exists($action, $api))
		{
			if (in_array($func, $api[$action]))
				return 1;
			else
				return 0;
		}
		else
			return 0;

	}

	public function auth()
	{
		require_once('controllers/apiController/authController.php');
		$func = urlParser::getAPIFunc();

		if (!$this->validRequest('auth')) return call('error', 'error_api_dne');

		(new AuthController())->{ $func }();

		return 0;
	}

	public function marker()
	{
		require_once('controllers/apiController/markerController.php');

		$func = urlParser::getAPIFunc();

		if (!$this->validRequest('marker')) return call('error', 'error_api_dne');

		(new MarkerController())->{ $func }();

		return 0;
	}

	public function user()
	{

	}
}