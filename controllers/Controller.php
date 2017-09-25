<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 8/30/2017
 * Time: 9:30 PM
 */
require_once('views/View.php');

class Controller
{
    protected $model;
    protected $view;

    public function __construct($model = null)
    {
        $this->model = $model;
        $this->view = new View($model);
    }

    protected function setModel($model)
    {
      $this->model = $model;
      $this->view->setModel($model);
    }

    public function error()
    {
        $this->model->http_response_code = 400;
        $this->model->output["status"] = "Error";
        $this->view->output();
    }
}