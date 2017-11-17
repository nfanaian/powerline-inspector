<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 9/26/2017
 * Time: 4:28 PM
 */
require_once('views/View.php');
class TicketView extends View
{
	public function ticket()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLmain();
		require_once('views/ticket/ticket.php');
		$this->HTMLpostfix();

		require_once('views/ticket/printout.php');
	}
	public function traffic()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLmain();
		require_once('views/ticket/traffic.php');
		$this->HTMLpostfix();
	}
}