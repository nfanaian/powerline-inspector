<?php

// Global Resources
require_once('resources/jwt.php');
require_once('resources/DB.php');
require_once('resources/requestParser.php');

$controller = $action = null;

function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// Parse request
if (requestParser::parseURL()) {
    $controller = requestParser::getController();
    $action     = requestParser::getAction();
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