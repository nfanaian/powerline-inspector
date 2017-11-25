<?php
// Global Resources
require_once('resources/DB.php');
require_once('resources/requestParser.php');

$controller = $action = null;

function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// Parse request
if (!requestParser::parseURL())
{
	requestParser::setController('utility');
	requestParser::setAction('home');
}

// ROUTE THE REQUEST
require_once('routes.php');