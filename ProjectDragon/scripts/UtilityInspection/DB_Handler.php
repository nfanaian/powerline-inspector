<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 7/1/2017
 * Time: 2:11 PM
 */
class DB_Handler
{

    private $conn;

    // constructor
    function __construct()
    {
        // connecting to database
        $this->connect();
    }

    // destructor
    function __destruct()
    {
        // closing db connection
        $this->close();
    }

    // Function to connect with database
    private function connect()
    {
        // Connecting to mysql database
        require_once("config.php");
        $this->conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

        if (!$this->conn) {
            die("Connection failure: " . mysqli_connect_error());
        }
    }

    // Function to close db connection
    // closing db connection & destroy db object
    public function close()
    {
        mysqli_close($this->conn);
    }

    private function query($str)
    {
        return mysqli_query($this->conn, $str);
    }

    private function last_id()
    {
        return mysqli_insert_id($this->conn);
    }

    public function affected_rows()
    {
        if (!empty(mysqli_affected_rows($this->conn))) {
            return 1;
        } else {
            return 0;
        }
    }

    // CRUD FUNCTIONS
    public function CREATE()
    {
        require_once("config.php");
        $str = "INSERT INTO `Images` (`filename`, `filedir`, `powerline`, `vegetation`, `oversag`, `damage`, `reviewed`) 
                VALUES ('" . $filename . "', '" . DIR_IMG_RAW . "', 0, 0, 0, 0, 0)";

        if ($this->query($str))
            return 1;
        else
            return 0;
    }


    public function createImage()
    {
        require_once("config.php");
        $str = "INSERT INTO `Images` (`filename`, `filedir`, `powerline`, `vegetation`, `oversag`, `damage`, `reviewed`) 
                VALUES ('" . $filename . "', '" . DIR_IMG_RAW . "', 0, 0, 0, 0, 0)";

        if ($this->query($str))
            return 1;
        else
            return 0;
    }

    public function READ()
    {
        $sql = "SELECT * FROM `Images` WHERE `reviewed`='0' LIMIT 1";
        $result = $this->query($sql);

        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0) {
                if ($row = mysqli_fetch_row($result)) {
                    $return = $row[0];
                    return $return;
                }
            }
        }
        return null;
    }

    public function UPDATE()
    {
        require_once("config.php");
        $str = "UPDATE `Images` SET `filedir`='" . $dir . "',`powerline`='" . $powerline . "',
                `vegetation`='" . $vegetation . "',`oversag`='" . $oversag . "',`damage`='" . $damage . "', 
                `reviewed`='".$reviewed."' WHERE `filename`='" . $filename . "'";

        $this->query($str);
        return $this->affected_rows();
    }

    public function DELETE()
    {

    }
}
