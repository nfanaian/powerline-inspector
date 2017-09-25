<?php

require_once('controllers/Controller.php');

class UserController extends Controller
{
    public function foo()
    {
        $this->model->output["status"] = "WE DID IT!";
        $this->view->output();
    }
    public function getUser()
    {
        if (!$this->model->verifyToken())
        {
            $this->model->http_response_code = 400;
            $this->model->output = array (
                "status" => "Authorization failed."
            );

        } else {
            $this->model->http_response_code = 202; //success
            $this->model->output = array("user" => $token["user"]);
        }
        $this->view->output();
    }

}