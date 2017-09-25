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
        $image_id = '59677536bd647_001.jpg';

        $this->model->foo($image_id);

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

        $latitude = 28.602439;
        $longitude = -81.200080;
        $distance = 50000000000000000;
        if (isset($latitude) && isset($longitude) && isset($distance) ) {
            $markers = Marker::getNearby($latitude, $longitude, $distance);

            //Check failure
            if (!$markers) {
                return call('pages', 'error');
            }

            //Set up Output
            $output = [];
            foreach($markers as $marker)
               $output[] = $marker->toArray();
            require_once('views/api/View.php');
        } else {
            return call('pages', 'error');
        }
    }

}


