<?php

	// This is where the route of an HTTP request is determined
	// depending on the controller & actions passed

	// Authorize token if making restricted call
	function authRequest($controller, $action)
	{
		// Only authorization required is for 'API' calls, and not required for 'auth' function
		if (($controller === 'api') && !($action === 'auth')) {
			require_once('models/Auth.php');
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
	        case 'tiktik':
		        $controller = new TikTikController();
		        break;
	        case 'category':
		        $controller = new CategoryController();
		        break;
            case 'test':
                $controller = new TestController();
                break;
	        case 'error':
		        $controller = new ErrorController();
		        break;
        }
	    
        // call the action
        $controller->{ $action }();
    }

    //                    CONTROLLERS                ACTIONS
    $controllers = array(   'api'       =>  ['auth', 'marker'],
                            'tiktik'    =>  ['ticket', 'traffic'],
	                        'category'  =>  ['imageViewer'],
                            'test'      =>  ['hello', 'decode'],
	                        'error'     =>  ['error_auth', 'error_token', 'error_controller_dne', 'error_action_dne']
    );

    // CALL CONTROLLER
    // Check controller & action are valid and call it
    // Otherwise, redirect to corresponding error
    if (array_key_exists($controller, $controllers))
    {
        if (in_array($action, $controllers[$controller]))
            call($controller, $action);
        else
            call('error', 'error_action_dne');
    }
    else
        call('error', 'error_controller_dne');
