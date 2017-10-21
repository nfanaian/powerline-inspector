<?php

/**
 * Model
 */
class Model
{
    public $http_response_code;
    public $output;
	public $token = null;

    public function __construct()
    {
        $this->http_response_code = 200;
        $this->output = array();

	    // HTTP Request Made
	    $request = implode("/", requestParser::getRequest());

        $this->output["request"] = array(   "request"   => $request,
	                                        "time"   =>   date("h:i:s A",time()),
											"date"  =>   date("m/d/Y",time()));

	    $this->output["token"] = requestParser::getToken();
	    $this->output["status"] = requestParser::getParam();
        //$this->output["clientIP"] = $this->getRealIpAddr();
    }

	protected function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		$details = file_get_contents("http://ipinfo.io/{$ip}/json");
		$details = json_decode($details);
		return $details;
	}
}
