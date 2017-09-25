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

    private function affected_rows()
    {
        if (mysqli_affected_rows($this->conn) > 0) {
            return 1;
        } else {
            return 0;
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

    //used during image upload
    public function addImage($filename)
    {
        require_once("config.php");
        $str = "INSERT INTO `Images`(`filename`, `filedir`, `powerline`, `powerpole`, `overgrowth`, `oversag`, `reviewed`)
                VALUES ('". $filename. "','". DIR_IMG_RAW. "', 0, 0, 0, 0, 0, 0)";

        return $this->query($str);
    }

    private function addDummyHelper($filename, $filedir = DIR_DUMMY, $powerline, $powerpole, $overgrowth, $oversag)
    {
        require_once('Resources/generate_random_point.php');
        $point = generate_random_point(28.602427, -81.200060, 10);
        $latitude = $point[0];
        $longitude = $point[1];

        $str = "INSERT INTO `Dummy`(`filename`, `filedir`, `powerline`, `powerpole`, `overgrowth`, `oversag`, `longitude`, `latitude`, `lastModified`)
                VALUES ('{$filename}', '{$filedir}', {$powerline}, {$powerpole}, {$overgrowth}, 
                {$oversag}, {$longitude}, {$latitude}, CURRENT_TIMESTAMP)";
        $this->query($str);

        return $this->affected_rows();
    }

    public function addDummy($filename, $filedir)
    {
        $str = "SELECT * FROM `Images` WHERE `filename` = '{$filename}'";
        $result = $this->query($str);

        if (mysqli_num_rows($result) > 0) {
            $r = mysqli_fetch_assoc($result);
            if ($this->addDummyHelper($filename, $filedir, $r["powerline"], $r["powerpole"], $r["overgrowth"], $r["oversag"]))
            {
                echo "[". $filename. "] [". $filedir. "] [". $r['powerline']. "] [". $r['powerpole']. "] [". $r['overgrowth']. "] [". $r['oversag']. "]<br/>";
                return true; //SUCCESS
            }
        }
        return false;
    }

    public function checkPowerline($filename)
    {
        $sql = "SELECT * FROM `Images` WHERE `filename` = '{$filename}' AND `powerline`=1";
        $result = $this->query($sql);

        if (mysqli_num_rows($result) > 0)
            return 1;
        return 0;
    }

    public function addTest($filename, $filedir)
    {
        $sql = "INSERT INTO `Testing`(`filename`, `filedir`, `powerline`, `powerpole`, `overgrowth`, `oversag`) 
                VALUES ('{$filename}', '{$filedir}', 0, 0, 0, 0, 0)";

        $result = $this->query($sql);

        return $this->affected_rows();
    }



    public function fetch_unreviewed() {
        $sql = "SELECT * FROM `Images` WHERE `reviewed`='0' ORDER BY RAND() LIMIT 1";
        $result = $this->query($sql);

        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0) {
                if ($row = mysqli_fetch_row($result)) {
                    $return = $row[0];
                    return $return;
                }
            }
        }
        return NO_PICS;
    }
    //used during image viewer
    public function updateImage($filename, $dir, $powerline, $powerpole, $overgrowth, $oversag, $reviewed)
    {
        $str = "UPDATE `Images` SET `filedir`='". $dir. "',`powerline`='". $powerline. "', `powerpole`='". $powerpole. "',
                `overgrowth`='". $overgrowth. "',`oversag`='". $oversag. "',
                `reviewed`='". $reviewed. "' WHERE `filename`='". $filename. "'";

        $this->query($str);
        return $this->affected_rows();
    }

    //used during image viewer
    public function updateDir($filename, $dir)
    {
        $str = "UPDATE `Images` SET `filedir`='". $dir. "' WHERE `filename`='". $filename. "'";

        $this->query($str);
        return $this->affected_rows();
    }

    public function deleteImage($filename)
    {
        require_once("config.php");

        unlink( DIR_IMG . $filename );

        $str = "DELETE FROM `Images` WHERE `filename`='". $filename. "'";

        $this->query($str);
        return $this->affected_rows();
    }


    public function in_DB($filename)
    {
        require_once("config.php");
        $str = "SELECT * FROM `Images` WHERE `filename`='". $filename. "'";

        $result = $this->query($str);

        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_row($result);
                echo $filename . ":[" . $row[3] . "]";
                if ((int)$row[3]) {
                    return 1;
                }
            }
        }
        return 0;
    }
}
