<?php

require_once('controllers/Controller.php');

class TestController extends Controller
{
    public function __construct()
    {
	    require_once('models/Test.php');
	    parent::__construct(new Test());
    }

  public function hello()
    {
        $this->model->output["status"] = "Hello World";
        $this->model->output["token"] = urlParser::getToken();

        $i = 1;
        while (urlParser::getParam($i) != null) {
            $this->model->output["param".$i] = urlParser::getParam($i++);
        }
        $this->view->output();
    }

    public function decode()
    {
        //TODO  $token = urlParser::getPOST('token');
        $token = urlParser::getParam(0);

        if (!is_null($token)) {
            try
            {
                $this->model->output = (array)JWT::decode($token, DB::getTokenKey(), array('HS256'));
                $this->http_response_code = 200; // error with token
            }
            catch (UnexpectedValueException $e)
            {
                $this->http_response_code = 400; // error with token
                $this->model->output["status"] = $e;
            }
            catch (DomainException $e)
            {
                $this->http_response_code = 400; // error with token
                $this->model->output["status"] = $e;
            }
        } else {
            return call('auth', 'error');
        }
        $this->view->output();
    }

}