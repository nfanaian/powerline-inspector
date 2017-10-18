<?php


class View
{
    protected $model;

	// Link passed model with this model
    public function __construct($model = null)
    {
        $this->setModel($model);
    }

    public function setModel($model) { $this->model = $model; }


	// View output function
	// By default, outputs JSON
	// output() is overridden in child Views
    public function output()
    {
	    // If view has no model, then there's nothing to render
	    if (is_null($this->model))
		    return;

	    // Set header type to JSON
        header("Content-Type: application/json; charset=UTF-8");

	    // Response code
	    http_response_code($this->model->http_response_code);

	    // Display output
	    if (is_array($this->model->output))
            echo json_encode($this->model->output); // Encode arrays as JSON
        else
            echo $this->model->output; // (token)
    }
}
?>