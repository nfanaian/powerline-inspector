<?php

/**
 * Marker resources
 * This class takes care of manipulating DB for Markers
 */

require_once('models/Model.php');

class Marker extends Model
{
    public $filename;
    public $latitude;
    public $longitude;
    public $filedir;
    public $powerline;
    public $powerpole;
    public $overgrowth;
    public $oversag;
    public $lastModified;

    // Set fields to null
    public function __construct()
    {
        parent::__construct();
        $this->filename = null;
        $this->filedir = null;
        $this->powerline = null;
        $this->powerpole = null;
        $this->overgrowth = null;
        $this->oversag = null;
        $this->latitude = null;
        $this->longitude = null;
        $this->lastModified = null;
    }

    // Set Marker's field for this model
    public function set($filename, $filedir, $powerline, $powerpole, $overgrowth, $oversag,
                        $latitude, $longitude, $lastModified)
    {
        $this->filename = $filename;
        $this->filedir = $filedir;
        $this->powerline = $powerline;
        $this->powerpole = $powerpole;
        $this->overgrowth = $overgrowth;
        $this->oversag = $oversag;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->lastModified = $lastModified;
    }

    // Returns an array of the current marker set to the model
    public function toArray()
    {
        return array(   'filename'      =>  $this->filename,
                        'filedir'       =>  $this->filedir,
                        'powerline'     =>  $this->powerline,
                        'powerpole'     =>  $this->powerpole,
                        'overgrowth'    =>  $this->overgrowth,
                        'oversag'       =>  $this->oversag,
                        'latitude'      =>  $this->latitude,
                        'longitude'     =>  $this->longitude,
                        'lastModified'  =>  $this->lastModified
        );
    }

    // Push marker to markers list
    // If this is the first marker, create an array for output['markers']
    private function addMarker()
    {
        if (is_null($this->output['markers']))
            $this->output['markers'] = array();
        array_push($this->output['markers'], $this->toArray());
    }

    /**
     * First testing search function
     * @param $filename | string
     * @return Image
     */
    public function foo()
    {
        $db = DB::connect();
        $sql = "SELECT * FROM `Dummy` LIMIT 10";
        $result = $db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while($r = $result->fetch_row())
            {
                $this->set($r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8]);
                $this->addMarker();
            }
            $this->http_response_code = 200;
            return 1;
        }
        $this->http_response_code = 400;
        $this->output['status'] = "Image retrieval failure";
        return 0;
    }

    /**
     * Get marker by filename
     * @param $filename | string
     * @return Image
     */
    public function getMarker($filename)
    {
        $db = DB::connect();
        $sql = "SELECT * FROM `Dummy` WHERE `filename`='{$filename}'";
        $result = $db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            if ($r = $result->fetch_row())
            {
                $this->set($r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8]);
                $this->addMarker();
            }
            $this->http_response_code = 200;
            return 1;
        }
        $this->http_response_code = 400;
        $this->output['status'] = "Failure to retrieve '{$filename}'";
        return 0;
    }

    /**
     * Get all images located within the distance of the given lat/long
     * @param $latitude|double
     * @param $longitude|double
     * @param $distance|int - in miles
     * @return $list|Image array
     */
    public function getNearby($latitude, $longitude, $distance, $limit = 500)
    {
        $db = DB::connect();

        $sql = "SELECT *,
                    (3959 * acos(cos(radians({$latitude}))) * cos(radians(`latitude`)) * cos(radians(`longitude`) - 
                    radians({$longitude})) + sin(radians({$latitude}) * sin(radians(`latitude`)))) 
                    AS `distance` 
                FROM `Dummy` 
                HAVING `distance` < {$distance} 
                ORDER BY `distance` ASC
                LIMIT {$limit}";

        $result = $db->query($sql);

        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0) {
                while ($r = $result->fetch_row()) {
                    $this->set($r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8]);
                    $this->addMarker();
                }
                $this->http_response_code = 200;
                $this->output['status'] = "Nearby markers retrieved";
                return 1;
            }
        }
        $this->http_response_code = 400;
        $this->output['status'] = "Failure to retrieve";
        return 0;
    }

    public function getAll()
    {
        $db = DB::connect();

        $sql = "SELECT * FROM `Dummy` WHERE 1";
        $result = $db->query($sql);

        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0) {
                while ($r = $result->fetch_row()) {
                    $this->set($r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8]);
                    $this->addMarker();
                }
                $this->http_response_code = 200;
                $this->output['status'] = "Nearby markers retrieved";
                return 1;
            }
        }
        $this->http_response_code = 400;
        $this->output['status'] = "Failure to retrieve";
        return 0;
    }

}