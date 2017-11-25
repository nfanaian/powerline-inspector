<?php

/**
 * This is the front end of our Utility Inspection System
 */

require_once('views/View.php');

class UtilityView extends View
{

	protected function HTMLheader()
	{
		require_once 'views/utility/navbar.php';
	}
	
	public function mapView()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLheader();
		$this->HTMLmain();
		require_once('views/utility/mapView.php');
		$this->HTMLpostfix();
	}

	public function loginView()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLmain();
		require_once('views/utility/loginView.php');
		$this->HTMLpostfix();
	}

	public function logView()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLheader();
		$this->HTMLmain();
		require_once('views/utility/logView.php');
		$this->HTMLpostfix();
	}

	public function uploadView()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLmain();
		require_once('views/utility/uploadView.php');
		$this->HTMLpostfix();
	}
}