<?php
/**
 * A class file to connect to database
 */
class DB_Handler {
    private $conn;

    // constructor
    function __construct() {
        // connecting to database
        $this->connect();
    }

    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }

     // Function to connect with database
    private function connect() {
        // Connecting to mysql database
        require_once("config.php");
        $this->conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

        if (!$this->conn) {
            die( "Connection failure: " . mysqli_connect_error() );
        }
    }

    // Function to close db connection
    // closing db connection & destroy db object
    public function close() {
        mysqli_close($this->conn);
    }

    private function query( $str ) {
        return mysqli_query( $this->conn, $str );
    }

    private function last_id()
    {
        return mysqli_insert_id( $this->conn );
    }

    public function log_Ticket($hub_id, $customer, $market, $loc, $job, $start_time, $tech, $xoc) {
        $str = "INSERT INTO `Ticket`(`hub_id`, `customer`, `market`, `location`, `job`, `start_time`, `date`, `team_members`, `xoc`) 
                VALUES ('".$hub_id."','".$customer."', '".$market."', '".$loc."', '".$job."', '".$start_time."', NULL, '".$tech."', '".$xoc."')";

        if ($this->query($str)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function viewTraffic() {
        $ticket = array();
        $str = "SELECT * FROM `Ticket` ORDER BY `date` ASC;";
        $result = $this->query( $str );
        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0 ) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($ticket, $row);
                }
            }
        }
        return $ticket;
    }
}
