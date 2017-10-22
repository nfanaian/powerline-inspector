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
        $this->model->http_response_code = 200;
        $this->model->output["token"] = requestParser::getToken();

        $i = 1;
        while (requestParser::getParam($i) != null) {
            $this->model->output["param".$i] = requestParser::getParam($i++);
        }
        $this->view->output();
    }

    public function decode()
    {
	    $key = DB::getTokenKey();

	    $jwt = requestParser::getToken();
        if (!is_null($jwt)) {
            try
            {
                $this->model->output["token"] = (array)JWT::decode($jwt, $key, array('HS256'));
                $this->output["success"] = true;
            }
            catch (UnexpectedValueException $e)
            {
                $this->model->output["status"] = $e->getMessage();
            }
            catch (DomainException $e)
            {
                $this->model->output["status"] = $e->getMessage();
            }
        } else {
            return call('error', 'error_token');
        }
        $this->view->output();
    }

}