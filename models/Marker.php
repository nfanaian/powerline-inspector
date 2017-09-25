<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 8/24/2017
 * Time: 8:36 AM
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
    
    public function set($filename, $filedir, $powerline, $powerpole, $overgrowth, $oversag,
                        $latitude, $longitude, $lastModified)
    {
        $this->filename = $filename;
        $this->filedir = str_replace("\\", '', $filedir);
        $this->powerline = $powerline;
        $this->powerpole = $powerpole;
        $this->overgrowth = $overgrowth;
        $this->oversag = $oversag;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->lastModified = $lastModified;
    }

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

    /**
     * @param $filename | string
     * @return Image
     */
    public function foo($filename = null)
    {
        if (is_null($filename))
            return 0;

        $db = DB::connect();
        $sql = "SELECT * FROM `Dummy` WHERE `filename`='59677536bd647_047.jpg'";
        $result = $db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            if ($r = $result->fetch_row()) {
                $this->set($r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8]);
                $this->addMarker();
                $this->http_response_code = 200;
                return 1;
            }
        } else {
            $this->http_response_code = 400;
            $this->output['status'] = "Image retrieval failure";
        }
        return 0;
    }

    private function addMarker()
    {
        if (is_null($this->output['markers']))
            $this->output['markers'] = array();
        array_push($this->output['markers'], $this->toArray());
    }

    /*
     * Get all rows
     * @return $list|Image array
    */
    public function getAll()
    {
        $db = new DBConnection();

        $sql = "SELECT * FROM `images`";

        $db->query($sql);

        $images = $db->fetch_all();

        if (!$images)
            return false;

        $list = [];
        foreach($images as $img)
        {
            $list[] = new Image($img["image_id"], $img["loc_lat"], $img["loc_long"], $img["img_path"],
                $img["powerline"], $img["powerpole"], $img["overgrowth"], $img["oversag"], $img["damage"]);
        }
        return $list;
    }

    /**
     * @param $loc_lat|double
     * @param $loc_long|double
     * @param $distance|int
     * @return $list|Image array
     */
    public function getNearby($loc_lat, $loc_long, $distance)
    {
        $db = new DBConnection();

        $sql = "
        SELECT
            `image_id`,
            (
                6378100 *
                acos(
                    cos(radians({$loc_lat}))) *
                    cos(radians(`loc_lat`)) *
                    cos(radians(`loc_long`) - radians({$loc_long})) +
                    sin(radians({$loc_lat}) *
                    sin(radians(`loc_lat`))
               )
           ) AS `distance`
        FROM
            `images`
        WHERE
            `distance` < 9000000
        ORDER BY
            `distance` ASC";

        $sql = "SELECT * FROM `images`";

        $db->query($sql);

        $images = $db->fetch_all();

        if (!$images)
            return false;
        
        $list = [];
        foreach($images as $img)
        {
            $list[] = new Image($img["image_id"], $img["loc_lat"], $img["loc_long"], $img["img_path"],
                                $img["powerline"], $img["powerpole"], $img["overgrowth"], $img["oversag"], $img["damage"]);
        }
        return $list;
    }

}