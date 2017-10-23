<?php

/**
 * Marker resources
 * This class takes care of manipulating DB for Markers
 */

require_once('models/Model.php');

class Marker extends Model
{
	// Marker's Properties
	// This model will hold properties of one marker at a time
	// Therefore, if the retrieved marker is good, we push it to our $output["markers"] array
    public $filename;
    public $latitude;
    public $longitude;
    public $filedir;
    public $powerline;
    public $powerpole;
    public $overgrowth;
    public $oversag;
    public $lastModified;

    // Set fields to null on model construction
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

	/** Set Marker's field for this model
	 * @param $filename
	 * @param $filedir
	 * @param $powerline
	 * @param $powerpole
	 * @param $overgrowth
	 * @param $oversag
	 * @param $latitude
	 * @param $longitude
	 * @param $lastModified
	 */
	public function set($filename, $filedir, $powerline, $powerpole, $overgrowth, $oversag,
	                    $longitude, $latitude, $lastModified)
    {
        $this->filename = $filename;
        $this->filedir = $filedir;
        $this->powerline = ($powerline)? true: false;
        $this->powerpole = ($powerpole)? true: false;
        $this->overgrowth = ($overgrowth)? true: false;
        $this->oversag = ($oversag)? true: false;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->lastModified = $lastModified;
    }

	/** Returns an array of the current marker set to the model
	 * @return array
	 */
	public function toArray()
    {
        return array(   'filename'      =>  $this->filename,
                        'powerline'     =>  $this->powerline,
                        'powerpole'     =>  $this->powerpole,
                        'overgrowth'    =>  $this->overgrowth,
                        'oversag'       =>  $this->oversag,
                        'latitude'      =>  $this->latitude,
                        'longitude'     =>  $this->longitude,
                        'lastModified'  =>  $this->lastModified
        );
    }

	/** Push marker to markers list
	 * If this is the first marker, create an array for output['markers']
	 */
	private function addMarker()
    {
        if (is_null($this->output['markers']))
            $this->output['markers'] = array();
        array_push($this->output['markers'], $this->toArray());
    }

    /** First testing search function
     * @param $filename | string
     * @return Image
     */
    public function foo()
    {
        $db = DB::connect();
	    $tbl = DB::getTable();
        $sql = "SELECT * FROM `{$tbl}` LIMIT 10";

	    $result = $db->query($sql);
	    if ($result->num_rows > 0)
	    {
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
	    $tbl = DB::getTable();

        $sql = "SELECT * FROM `{$tbl}` WHERE `filename`='{$filename}'";

	    $result = $db->query($sql);
	    if ($result->num_rows > 0)
	    {
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

    /** Get all images located within the distance of the given lat/long
     * @param $latitude|double
     * @param $longitude|double
     * @param $distance|int - in miles
     * @return $list|Image array
     */
    public function getNearby($latitude, $longitude, $distance, $limit = 500)
    {
        $db = DB::connect();
	    $tbl = DB::getTable();

        $sql = "SELECT *,
                    (3959 * acos(cos(radians({$latitude}))) * cos(radians(`latitude`)) * cos(radians(`longitude`) - 
                    radians({$longitude})) + sin(radians({$latitude}) * sin(radians(`latitude`)))) 
                    AS `distance` 
                FROM `{$tbl}` 
                HAVING `distance` < {$distance} 
                ORDER BY `distance` ASC
                LIMIT {$limit}";

	    $result = $db->query($sql);
	    if ($result->num_rows > 0)
	    {
                while ($r = $result->fetch_row())
                {
                    $this->set($r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8]);
                    $this->addMarker();
                }
                $this->http_response_code = 200;
                $this->output['status'] = "Nearby markers retrieved";
	            $this->output["success"] = true;
                return 1;
	    }
        $this->http_response_code = 400;
        $this->output['status'] = "Failure to retrieve";
        return 0;
    }

	/** Retrieve all markers stored in the DB
	 * @return int
	 */
	public function getAll()
    {
        $db = DB::connect();
	    $tbl = DB::getTable();

        $sql = "SELECT * FROM `{$tbl}` WHERE 1";
	    $result = $db->query($sql);
	    if ($result->num_rows > 0)
	    {
                while ($r = $result->fetch_row())
                {
                    $this->set($r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8]);
                    $this->addMarker();
                }
                $this->http_response_code = 200;
                $this->output['status'] = "All markers retrieved";
	            $this->output["success"] = true;
                return 1;
        }
        $this->http_response_code = 400;
        $this->output['status'] = "Failure to retrieve";
        return 0;
    }

	/** Updates filename's category values 
	 * @param $filename
	 */
	public function updateMarker($filename, $values = [-1,-1,-1,-1])
    {
	    //TODO Actually update marker in DB

	    $this->output["status"] = "Hello World!";
	    $this->output["success"] = true;
	    $this->output["filename"] = $filename;
	    $this->output["values"] = array("powerline"     =>  $values[0],
		                                "powerpole"     =>  $values[1],
	                                    "overgrowth"    =>  $values[2],
		                                "oversag"       =>  $values[3]);
    }

	/** Retrieve physical location of requested filename
	 *  Ensuring image exists and is correct format, otherwise providing fallback image
	 *  Set up array with image filename, type, and full filepath for the View
	 * @param $filename
	 */
	public function getImage($filename)
    {
	    require_once 'resources/tools.php';
	    $hash = Tools::getHashDir($filename, 'dummy');
	    $file = $hash["filepath"];

	    // Fallback/Error Image
	    $fallback = "/usr/local/project_dragon/data/sadkermit.jpg";


//	    $file = "/usr/local/project_dragon/data/dummy/5/d/3/7/b/5/5/5/6/d/5d37b5556d3f7d3e491693b1983b4140.jpg";

		//DETERMINE TYPE
		//$ext = array_pop(explode ('.', $file));
	    $ext = $hash["file_ext"];
		$allowed['gif'] = 'image/gif';
		$allowed['png'] = 'image/png';
		$allowed['jpg'] = 'image/jpeg';
		$allowed['jpeg'] = 'image/jpeg';
		
		if(file_exists($file) && $ext != '' && isset($allowed[strtolower($ext)])) {
			$type = $allowed[strtolower($ext)];
		} else {
			$file = $fallback;
			$type = 'image/jpeg';
		}
	    $this->output["type"] = $type;
	    $this->output["image"] = end(explode("/", $file));
	    $this->output["file"] = $file;
    }
}

