<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 9/26/2017
 * Time: 4:28 PM
 */
require_once('views/View.php');
class ticketView extends View
{
	public function ticket()
	{
		http_response_code($this->model->http_response_code);
		require_once('views/pages/ticket/ticket.php');

		require_once('views/pages/ticket/printout.php');
	}
	public function traffic()
	{
		http_response_code($this->model->http_response_code);
		require_once('views/pages/ticket/traffic.php');
	}
}