<?php

require_once('controllers/Controller.php');

class MarkerController extends Controller
{
	// Initiate Marker Model
	public function __construct()
    {
        require_once('models/Marker.php');
        parent::__construct(new Marker());
    }

	/**
	 * API/Marker/foo/
	 * User Input: filename
	 * Sanitize user input, retrieve resources, and display results
	 * Return JSON marker if file exists
	 */
	public function foo()
    {
        $this->model->foo();
        $this->view->output();
    }

	/**
	 * API/Marker/getMarker/filename
	 * User Input: filename
	 * Sanitize user input, retrieve resources, and display results
	 * Return JSON marker if file exists
	 */
	public function getMarker()
    {
        $filename = urlParser::getParam(0);//getPOST('filename');

        $this->model->getMarker($filename);
        $this->view->output();
    }

    /**
     * API/Marker/getNearby/latitude/longitude/distance/
     * User Input: latitude, longitude, distance
     * Sanitize user input, retrieve resources, and display results
     * Return JSON array of markers nearby (if any)
     */
    public function getNearby()
    {
        /*
        if (($latitude = urlParser::getParam(1)) !=null) {
        $latitude = urlParser::getParam(1);
        $longitude = urlParser::getParam(2);
        $distance = urlParser::getParam(3);*/

        $latitude = 28.605163389828;
        $longitude = -81.191489942556;
        $distance = 2000000000;

        $this->model->getNearby($latitude, $longitude, $distance);
        $this->view->output();
    }

	/**
	 * API/Marker/getAll/
	 * User Input: void
	 * Sanitize user input, retrieve resources, and display results
	 * Return JSON of all markers in DB
	 */
	public function getAll()
    {
        $this->model->getAll();
        $this->view->output();
    }

}
