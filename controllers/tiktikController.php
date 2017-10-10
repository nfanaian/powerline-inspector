<?php

require_once('controllers/Controller.php');

class TikTikController extends Controller
{
	public function __construct()
	{
		require_once('models/Ticket.php');
		require_once('views/ticketView.php');
		parent::__construct(new Ticket(), new ticketView());
	}

	public function ticket()
    {
        require_once('models/Ticket.php');
	    require_once('views/ticketView.php');
        $this->setModel(new Ticket());
	    $this->setView(new ticketView());

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
                $this->model->composeEmail();

            } else if (isset($_POST["delCookies"])) {
                $this->model->delCookies();
                header("Location: ");
            }
        }

        $this->model->loadCookies();
        $this->view->ticket();
    }

    public function traffic()
    {
      $tickets_arr = $this->model->traffic();
      $this->view->traffic();
    }
}