<?php

// DEFAULT TIMEZONE
date_default_timezone_set('America/New_York');

// Global Resources
require_once('resources/DB.php');
require_once('resources/requestParser.php');

$controller = $action = null;

function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// Parse request
if (!requestParser::parseURL()) {
	requestParser::setController("utility");
	requestParser::setAction("userviewer");
}

// API Requests skip the HTML layout
if (requestParser::getController() === 'api')
	require_once('routes.php');
else
	require_once('views/pages/layout.php');
?>