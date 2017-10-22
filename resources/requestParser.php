<?php

/**
 * Class requestParser
 * ** This class takes care of parsing HTTP POST/GET requests
 */

class requestParser
{
    private static $request = null;
    private static $controller = null;
    private static $action = null;
	private static $apiFunc = null;
	private static $token = null;
    private static $params = [];

    private function __construct() {}
    private function __clone() {}

	/** Parse HTTP $_GET["request"]
	 * Which contains the entire URL ("/controller/action/params/")
	 * @return bool
	 */
	public static function parseURL()
    {
        self::$request = isset($_GET['request']) ? explode('/', $_GET['request']) : null;

        if (self::$request !== null) {
	        $i = 0;
            self::$controller = !empty(self::$request[$i]) ? strtolower(self::$request[$i++]) : null;
            self::$action = !empty(self::$request[$i]) ? strtolower(self::$request[$i++]) : null;

	        // If action 'API', retrieve API Function from POST or 3rd GET parameter
	        if (self::$controller === 'api')
	        {
		        if (is_null(self::$apiFunc = self::getPOST('function')))
		            self::$apiFunc = !empty(self::$request[$i]) ? strtolower(self::$request[$i++]) : null;

		        // Check for JWToken only for non-authentication API requests
		        if (!is_null(self::$apiFunc) && ((self::$apiFunc === 'authpage') || !(self::$action === 'auth')))
		        {
			        // Check POST, if no token, then the next GET must be token
			        if (is_null(self::$token = self::getPOST('token'))) {
				        self::$token = isset(self::$request[$i]) ? self::$request[$i] : null;
				        $i++;
			        }
		        }
	        }

	        // parse the rest of the GET request into params[]
            while ( (self::$params[] = isset(self::$request[$i])? self::$request[$i++]: null) != null );

	        // Return true only if both Controller & Action have been defined
	        if (self::$controller !== null && self::$action !== null)
                return true;
        }
	    // Controller & Action from user input failed; revert to default
        return false;
    }

	public static function getRequest() { return self::$request; }

	/** Retrieve Controller
	 * @return Controller
	 */
	public static function getController() { return self::$controller; }

	/** Set Controller
	 */
	public static function setController($str) { self::$controller = $str; }

	/** Retrieve Action (Controller's method)
	 * @return Action
	 */
	public static function getAction() { return self::$action; }

	/** Set Action
	 */
	public static function setAction($str) { self::$action = $str; }


	/** Retrieve API Function (if API request)
	 * @return null
	 */
	public static function getAPIFunc() { return self::$apiFunc; }

	/** Retrieve Token
	 * @return null
	 */
	public static function getToken() { return self::$token; }

	/** Set Token
	 */
	public static function setToken($str) { self::$token = $str; }

	/** Retrieve $_GET params
	 * @param $i
	 * @return mixed|null
	 */
	public static function getParam($i=0)
    {
        if (isset(self::$params[$i]) && !is_null(self::$params[$i]))
            return self::$params[$i];
        return null;
    }

	/** Retrieve $_POST[$key] value, returning NULL if its not set or empty
	 * @param $key
	 * @return null
	 */
	public static function getPOST($key)
    {
        if (isset($_POST[$key]) && !empty($_POST[$key]))
            return $_POST[$key];
        return null;
    }
}