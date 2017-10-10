<?php

require_once('controllers/Controller.php');
class MarkerController extends Controller
{
    public function __construct()
    {
        require_once('models/Marker.php');
        parent::__construct(new Marker());
    }
    
    public function foo()
    {
        $this->model->foo();
        $this->view->output();
    }

    public function getMarker()
    {
        $filename = urlParser::getParam(0);//getPOST('filename');

        $this->model->getMarker($filename);
        $this->view->output();
    }

    /**
     *
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

    public function getAll()
    {
        $this->model->getAll();
        $this->view->output();
    }

}


