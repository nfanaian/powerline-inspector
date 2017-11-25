<?php

/**
 * This is the front end of our Utility Inspection System
 */

require_once('views/View.php');

class SeniorDesignView extends View
{
	public function mapView()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLheader();
		$this->HTMLmain();
		require_once('views/seniordesign/mapView.php');
		$this->HTMLpostfix();
	}

	public function userView()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLmain();
		require_once('views/seniordesign/userViewer.php');
		$this->HTMLpostfix();
	}

	public function imageView()
	{
		http_response_code($this->model->http_response_code);
		$this->HTMLprefix();
		$this->HTMLheader();
		$this->HTMLmain();
		require_once('views/seniordesign/imageViewer.php');
		$this->HTMLpostfix();
	}
}