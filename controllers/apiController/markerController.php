<?php
require_once('controllers/Controller.php');

/*
 * API: Marker Controller
 * This controller takes care of sanitize user input, respond to request
 * Then gather resources and render results
 * Return JSON containing marker objects
 */

class MarkerController extends Controller
{
	// Initiate Marker Model
	public function __construct()
    {
        require_once('models/api/Marker.php');
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
        $filename = requestParser::getParam(0);//getPOST('filename');

        $this->model->getMarker($filename);
        $this->view->output();
    }

    /**
     * API/Marker/getNearby/<latitude>/<longitude>/<distance>/
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

	/**
	 * API/Marker/getImage/<filename>/
	 * User Input: filename
	 * Returns: Direct URL to image
	 */
	public function getImage()
	{
		$file = requestParser::getParam();

		//$file = "596a0d35eec05_143.jpg";
		$this->model->getImage($file);
		//$this->view->output();
		$this->view->image();
	}

	// TODO: The following functions are in development; functions above are complete
	/**
	 * API/Marker/updateMarker/<filename>/
	 * User Input: filename
	 * Returns: JSON stating DB Update result
	 */
	public function updateMarker()
	{
		$file = requestParser::getParam(0);
		$values = array();
		$values[] = (int)requestParser::getParam(1);
		$values[] = (int)requestParser::getParam(2);
		$values[] = (int)requestParser::getParam(3);
		$values[] = (int)requestParser::getParam(4);


		$this->model->updateMarker($file, $values);
		$this->view->output();
	}

	/**
	 * API/Marker/addComment/<filename>/<comment>/
	 * User Input: filename, comment
	 * Sanitize user input, add comment, and display results
	 * Return JSON of success of the comment insertion
	 */
	public function addComment()
	{
		$filename = requestParser::getParam(0);
		$comment = requestParser::getParam(1);

		$this->model->addComment($filename, $comment);
		$this->view->output();
	}

	/**
	 * API/Marker/getComment/<filename>/
	 * User Input: filename
	 * Sanitize user input, add comment, and display results
	 * Return JSON of success of the comment insertion
	 */
	public function getComment()
	{
		$filename = requestParser::getParam(0);

		$this->model->getComment($filename);
		$this->view->output();
	}
}
