<?php

require_once('controllers/Controller.php');

class PagesController extends Controller
{
    public function ticket()
    {
        require_once('models/Ticket.php');
        $this->setModel(new Ticket());

        // POST
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // Log web traffic

            if (isset($_POST["submit"])) {
                $this->model->email_cc = $_POST["cc"];
                $this->model->setTicket(ucwords($_POST["hub_id"]), ucwords($_POST["customer"]),
                    ucwords($_POST["market"]), ucwords($_POST["loc"]), ucwords($_POST["job"]),
                    ucwords($_POST["start_time"]), ucwords($_POST["tech"]),ucwords($_POST["xoc"]));
                $this->model->setCookies();
                //$this->model->logTicket();
                $this->model->email_msg = $this->model->composeMessage();
                $this->model->composeEmail();

            } else if (isset($_POST["delCookies"])) {
                delCookies();
                header("Location: " . $_SERVER["PHP_SELF"]);
            }
        }

        $this->model->loadCookies();
        $this->view->ticket();
    }

    public function traffic()
    {
      require_once('models/Ticket.php');
      $this->setModel(new Ticket());

      $tickets_arr = $this->model->traffic();
      $this->view->traffic();
    }
  
  public function imageViewer()
  {
    require_once('models/Category.php');
    $this->setModel(new Category());

    //POST
    if (($_SERVER["REQUEST_METHOD"] == "POST"))
    {
	    // TO DO sanitize input
	    $this->model->setFields($_POST["file"], ((int)$_POST["powerline"]), ((int)$_POST["powerpole"]),
		    ((int)$_POST["vegetation"]), (int)$_POST["oversag"]);
      if (isset($_POST["delete"]))
      {
        $this->model->deleteImage();
      }
      elseif (isset($_POST["submit"]))
      {
        //Update DB with reviewed image and move image to hash directory
        if ($this->model->copyImage())
        {
          if ($this->model->updateImage())
          {
            $this->model->deleteSrc();
          }
          else
          {
            $this->model->deleteCopy();
          }
        }
        else
        {
          // Copy to hash dir failure
          $this->model->message = "Image Copy Failed. </br> 
                      Image marked back as unreviewed. </br>";
        }
      }
    }
    $this->model->fetch_unreviewed();
    $this->view->imageView();
  }
}