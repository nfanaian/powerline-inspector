<?php

    function authRequest($controller)
    {
        if (($controller === 'pages') || ($controller === 'auth'))
            return 1;

        require_once('models/Auth.php');
        if ((new Auth())->verifyToken())
            return 1;

        return 0;
    }

    function call($controller, $action)
    {
        // Verify Token
        if (!authRequest($controller)) return call('auth', 'error_token');

        // Require controller class
        require_once('controllers/'. $controller. 'Controller.php');

        // create a new instance of the needed controller
        switch($controller)
        {
            case 'auth':
                $controller = new AuthController();
                break;
            case 'user':
                $controller = new UserController();
                break;
            case 'marker':
                $controller = new MarkerController();
                break;
	        case 'pages':
		        $controller = new PagesController();
		        break;
            case 'test':
                $controller = new TestController();
                break;
        }
        // call the action
        $controller->{ $action }();
    }
    //                    CONTROLLERS                ACTIONS
    $controllers = array(   'auth'      =>  ['login', 'register', 'verifyToken'],
                            'marker'    =>  ['foo', 'getAll', 'getNearby'],
                            'user'      =>  ['foo'],
                            'pages'     =>  ['ticket', 'traffic', 'imageViewer'],
                            'test'      =>  ['hello', 'decode']
    );

    // CALL CONTROLLER
    // Check controller & action are valid and call it
    // Otherwise, redirect to error
    if (array_key_exists($controller, $controllers))
    {
        if (in_array($action, $controllers[$controller]))
            call($controller, $action);
        else
            call('auth', 'error_action_dne');
    }
    else
        call('auth', 'error_controller_dne');
