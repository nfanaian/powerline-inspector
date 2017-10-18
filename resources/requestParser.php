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

	/**
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
		        if (!is_null(self::$apiFunc) && !(self::$action === 'auth'))
		        {
			        // Check POST, if no token, then the next GET must be token
			        if (is_null(self::$token = self::getPOST('token')))
				        self::$token = isset(self::$request[$i]) ? self::$request[$i++] : null;
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

	/**
	 * @return null
	 */
	public static function getController() { return self::$controller; }

	/**
	 * @return null
	 */
	public static function getAction() { return self::$action; }

	/**
	 * @return null
	 */
	public static function getAPIFunc() { return self::$apiFunc; }

	/**
	 * @return null
	 */
	public static function getToken()
	{
		if (isset(self::$token) && !empty(self::$token))
			return self::$token;
		return null;
	}

	/**
	 * @param $i
	 * @return mixed|null
	 */
	public static function getParam($i)
    {
        if (!empty(self::$params[$i]) && isset(self::$params[$i]))
	        return self::$params[$i];
        return null;
    }

	/**
	 * @param $key
	 * @return null
	 */
	public static function getPOST($key)
    {
        if (isset($_POST[$key]) && !empty($_POST[$key]))
            return $_POST[$key];
        return null;
    }

	/**
	 * @return mixed|null
	 */
	public static function getUsername()
	{
		if (!is_null($ret = self::getPOST('user')))
			return $ret;
		if (!is_null($ret = self::getParam(0)))
			return $ret;
		return null;
	}

	// Get password from POST (check 'password', 'pass', then 'code' POST for passwords)
	/**
	 * @return mixed|null
	 */
	public static function getCode()
	{
		if (!is_null($ret = self::getPOST('password')) || !is_null($ret = self::getPOST('pass')) || !is_null($ret = self::getPOST('code')))
			return $ret;
		if (!is_null($ret = self::getParam(1)))
			return $ret;
		return null;
	}

	/**
	 * @return null
	 */
	public static function getFilename()
    {
	    if (!is_null($ret = self::getPOST('filename')))
		    return $ret;
	    return null;
    }

	/**
	 * @return array|null
	 */
	public static function getCoords()
	{
		if (!is_null($lat = self::getPOST('latitude')) && !is_null($lng = self::getPOST('longitude')))
			return array( 'latitude' => $lat, 'longitude' => $lng );
		return null;
	}
}