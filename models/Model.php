<?php

/**
 * Model
 */
class Model
{
    public $http_response_code;
    public $output;

    public function __construct()
    {
        $this->http_response_code = 400;
        $this->output = array();
    }
}
