<?php


class View
{
    protected $model;

	// Link passed model with this model
    public function __construct($model = null)
    {
        $this->setModel($model);
    }

	/**
	 * @param $model
	 */
	public function setModel($model) { $this->model = $model; }


	// View output function
	// By default, outputs JSON
	// output() is overridden in child Views
	/**
	 *
	 */
	public function output()
    {
	    // Set header type to JSON
	    header('Access-Control-Allow-Origin: *');
	    header("Access-Control-Allow-Credentials: true");
	    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	    header('Access-Control-Max-Age: 1000');
	    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
	    header("Content-Type: application/json");

	    // If view has no model, then there's nothing to render
	    if (is_null($this->model)) {
		    echo json_encode(array("Response" => "No Model Loaded"));
		    return;
	    }

	    // Response code
	    http_response_code($this->model->http_response_code);

	    // Display output
	    if (is_array($this->model->output))
            echo json_encode($this->model->output); // Encode arrays as JSON
        else
            echo json_encode(array("Response" => $this->model->output)); // (token)
    }


	/**
	 * Returns direct image
	 * This function is used within an <img> tag
	 * Example:
	 *  <img src="http://107.170.23.85/api/marker/getimage/59677536bd647_046.jpg">
	 */
	public function image()
	{
		// If view has no model, then there's nothing to render
		if (is_null($this->model))
			return;

		// Set header type to JSON
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Credentials: true");
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Access-Control-Max-Age: 1000');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

		// Response code
		http_response_code($this->model->http_response_code);

		header("Content-type: \"{$this->model->output["type"]}\"; 
			Content-Disposition: inline; 
			filename=\"{$this->model->output["image"]}\"; 
			Content-length: ".(string)(filesize($this->model->output["file"])));

		/* READ FILE
		 * Using the direct filepath of the image (inside /usr/../project_dragon/../)
		 * Reads file and retuns bytes to client (for <img src=''> tag)
		 */
		@readfile($this->model->output["file"]);
		exit();
	}

	public function error()
	{
		require_once('views/layout/error_page.php');
	}


	/** HTML LAYOUT TEMPLATE
	 *  These can be overwritted on child Views
	 */

	// This contains everything up until <body>
	protected function HTMLprefix()
	{
		require_once('views/layout/layout_prefix.php');
	}

	// Header tag (optional)
	protected function HTMLheader()
	{
		require_once('views/layout/layout_header.php');
	}

	// Just the main div
	protected function HTMLmain()
	{
		// Site Main
		echo "<div class=\"site-main\">";
	}

	// Closes main div, footer div, and closes <body> & <html> tags
	protected function HTMLpostfix()
	{
		require_once('views/layout/layout_postfix.php');
	}
}
?>