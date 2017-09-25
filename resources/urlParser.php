<?php

class urlParser
{
    private static $request = null;
    private static $controller = null;
    private static $action = null;
    private static $params = [];

    private function __construct() {}
    private function __clone() {}

    public static function parseURL()
    {
        urlParser::$request = isset($_GET['request']) ? explode('/', $_GET['request']) : null;

        if (urlParser::$request !== null) {
            urlParser::$controller = isset(urlParser::$request[0]) ? urlParser::$request[0] : null;
            urlParser::$action = isset(urlParser::$request[1]) ? urlParser::$request[1] : null;

            $i = 2;
            while ( (urlParser::$params[] = isset(urlParser::$request[$i])? urlParser::$request[$i++]: null) != null );
            return true;
        }
        return false;
    }

    public static function getController() { return urlParser::$controller; }

    public static function getAction() { return urlParser::$action; }

    public static function getParam($i = 1)
    {
        if (isset(urlParser::$params[$i]) && !empty(urlParser::$params[$i]))
            return urlParser::$params[$i];
        return null;
    }

    public static function getPOST($key)
    {
        if (isset($_POST[$key]) && !empty($_POST[$key]))
            return $_POST[$key];
        return null;
    }

    public static function getToken()
    {
        if (!is_null(self::getPOST('token')))
            return self::getPOST('token');
        return self::getParam(0);
    }
}