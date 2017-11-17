<?php

/**
 * This is the front end of our Utility Inspection System
 */

require_once('views/View.php');

class UtilityView extends View
{
	public function mapView()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLheader();
		$this->HTMLmain();
		//require_once('views/utility/mapViewer.php');
		$this->HTMLpostfix();
	}

	public function loginView()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLmain();
		//require_once('views/seniordesign/userViewer.php');
		$this->HTMLpostfix();
	}

	public function logView()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLheader();
		$this->HTMLmain();
		//require_once('views/utility/.php');
		$this->HTMLpostfix();
	}
}