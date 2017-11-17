<?php

/* This is where the route of an HTTP request is determined
 * depending on the controller & actions passed
 */


/** Authorize token if making restricted call
 * @param $controller - only
 * @param $action
 * @return int
 */
function authRequest($controller, $action)
{
	// Only authorization required is for 'API' calls, and not required for 'auth' function
	if (($controller === 'api') && !($action === 'auth')) {
		require_once('models/api/Auth.php');
		if ((new Auth())->verifyToken())
			return 1;
		return 0;
	}
	return 1;
}

function call($controller, $action)
{
    // Verify Token for API requests
    if (!authRequest($controller, $action)) return call('error', 'error_token');

    // Require controller class
    require_once('controllers/'. $controller. 'Controller.php');

    // create a new instance of the needed controller
    switch($controller)
    {
        case 'api':
            $controller = new APIController();
            break;
        case 'seniordesign':
	        $controller = new SeniorDesignController();
	        break;
        case 'tiktik':
	        $controller = new TikTikController();
	        break;
        case 'error':
	        $controller = new ErrorController();
	        break;
    }

    // call the action
    $controller->{ $action }();
    return 0;
}

//                    CONTROLLERS                ACTIONS
$controllers = array(   'api'           =>  ['auth', 'marker', 'upload', 'tf', 'user', 'test'],
                        'seniordesign'  =>  ['mapviewer', 'userviewer', 'imageviewer'],
						'utility'       =>  ['mapviewer', 'login', 'log'],
                        'tiktik'        =>  ['ticket', 'traffic'],
						'navid'         =>  ['home', 'about', 'contact', 'projects']
);

// Retrieve Controller/Action from requestParser
$controller = requestParser::getController();
$action = requestParser::getAction();

// CALL CONTROLLER
// Check controller & action are valid and call it
// Otherwise, redirect to corresponding error
if (array_key_exists($controller, $controllers))
{
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } elseif ($controller === 'api') {
        call('error', 'error_api_controller_dne');
    } else {
        call('error', 'error_action_dne');
    }
}
else
{
    call('error', 'error_controller_dne');
}