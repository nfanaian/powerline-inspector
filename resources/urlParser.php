<?php

class urlParser
{
    private static $request = null;
    private static $controller = null;
    private static $action = null;
	private static $apiFunc = null;
	private static $token = null;
    private static $params = [];

    private function __construct() {}
    private function __clone() {}

    public static function parseURL()
    {
        urlParser::$request = isset($_GET['request']) ? explode('/', $_GET['request']) : null;

        if (urlParser::$request !== null) {
	        $i = 0;
            urlParser::$controller = !empty(urlParser::$request[$i]) ? urlParser::$request[$i++] : null;
            urlParser::$action = !empty(urlParser::$request[$i]) ? urlParser::$request[$i++] : null;

	        // If action 'API', retrieve API Function from POST or 3rd GET parameter
	        if (urlParser::$controller === 'api') {
		        if (is_null(urlParser::$apiFunc = self::getPOST('function')))
		            urlParser::$apiFunc = !empty(urlParser::$request[$i]) ? urlParser::$request[$i++] : null;

		        // Only API 'auth' doesn't require API authorization
		        if (!is_null(urlParser::$apiFunc) && !(urlParser::$action === 'auth')) {
			        if (is_null(urlParser::$token = self::getPOST('token')))
				        urlParser::$token = isset(urlParser::$request[$i]) ? urlParser::$request[$i++] : null;
		        }
	        }

	        // parse the rest of the GET request into params[]
            while ( (urlParser::$params[] = isset(urlParser::$request[$i])? urlParser::$request[$i++]: null) != null );

	        // Return true only if both Controller & Action have been defined
	        if (urlParser::$controller !== null && urlParser::$action !== null)
                return true;
        }
	    // Controller & Action from user input failed; revert to default
        return false;
    }

    public static function getController() { return urlParser::$controller; }

    public static function getAction() { return urlParser::$action; }

	public static function getAPIFunc() { return self::$apiFunc; }

	public static function getToken()
	{
		if (isset(self::$token) && !empty(self::$token))
			return self::$token;
		return null;
	}

    public static function getParam($i)
    {
        if (!empty(urlParser::$params[$i]) && isset(urlParser::$params[$i]))
	        return urlParser::$params[$i];
        return null;
    }

    public static function getPOST($key)
    {
        if (isset($_POST[$key]) && !empty($_POST[$key]))
            return $_POST[$key];
        return null;
    }

	public static function getUsername()
	{
		if (!is_null($ret = self::getPOST('user')))
			return $ret;
		if (!is_null($ret = self::getParam(0)))
			return $ret;
		return null;
	}

	// Get password from POST (check 'password', 'pass', then 'code' POST for passwords)
	public static function getCode()
	{
		if (!is_null($ret = self::getPOST('password')) || !is_null($ret = self::getPOST('pass')) || !is_null($ret = self::getPOST('code')))
			return $ret;
		if (!is_null($ret = self::getParam(1)))
			return $ret;
		return null;
	}

    public static function getFilename()
    {
	    if (!is_null($ret = self::getPOST('filename')))
		    return $ret;
	    return null;
    }

	public static function getCoords()
	{
		if (!is_null($lat = self::getPOST('latitude')) && !is_null($lng = self::getPOST('longitude')))
			return array( 'latitude' => $lat, 'longitude' => $lng );
		return null;
	}
}