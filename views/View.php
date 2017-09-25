<?php


class View
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function setModel($model)
    {
      $this->model = $model;
    }

    public function output()
    {
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($this->model->http_response_code);
        if (is_array($this->model->output))
        {
            echo json_encode($this->model->output);
        } else {
            echo $this->model->output;
        }
    }

    public function outputXML() {}
    public function ticket() { require_once('views/pages/ticket/ticket.php'); }
    public function traffic() { require_once('views/pages/ticket/traffic.php'); }
    public function imageView() { require_once('views/pages/imageViewer/imageView.php'); }

}
?>