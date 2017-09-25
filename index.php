<?php

// Global Resources
require_once('resources/jwt.php');
require_once('resources/DB.php');
require_once('resources/urlParser.php');

$controller = $action = null;

// Parse request
if (urlParser::parseURL() && (urlParser::getController()!== null) &&  (urlParser::getAction())!== null) {
    $controller = urlParser::getController();
    $action     = urlParser::getAction();
} else {
    $controller = 'pages';
    $action = 'ticket';
}

require_once('routes.php');



?>