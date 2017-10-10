<?php

// Global Resources
require_once('resources/jwt.php');
require_once('resources/DB.php');
require_once('resources/urlParser.php');

$controller = $action = null;

// Parse request
if (urlParser::parseURL()) {
    $controller = urlParser::getController();
    $action     = urlParser::getAction();
} else {
	// Default (this is something old for work)
    $controller = 'tiktik';
    $action = 'ticket';
}

// API Requests skip the HTML layout
if ($controller === 'api')
	require_once('routes.php');
else
	require_once('views/pages/layout.php');

?>

