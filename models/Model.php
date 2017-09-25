<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 8/30/2017
 * Time: 9:15 PM
 */
class Model
{
    public $http_response_code;
    public $output;

    public function __construct()
    {
        $this->http_response_code = 200;
        $this->output = array();
    }
}
