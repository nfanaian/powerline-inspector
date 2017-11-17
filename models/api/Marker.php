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
	public $timeAdded;
	public $comment;

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
	    $this->timeAdded = null;
	    $this->comment = "TEST";
    }

	/** Set Marker's field for this model
	 *
	 */
	public function set($sql_arr)
	{
	    // Please refer to MySQL/PhpMyAdmin for the order of variables
        $this->filename = isset($sql_arr[0])? $sql_arr[0]: "sql_error";
        $this->filedir = isset($sql_arr[1])? $sql_arr[1]: "sql_error";
		$this->powerline = isset($sql_arr[2])? ($sql_arr[2]? true: false): "sql_error";
		$this->powerpole = isset($sql_arr[3])? ($sql_arr[3]? true: false): "sql_error";
		$this->overgrowth = isset($sql_arr[4])? ($sql_arr[4]? true: false): "sql_error";
		$this->oversag = isset($sql_arr[5])? ($sql_arr[5]? true: false): "sql_error";
        $this->latitude = isset($sql_arr[6])? $sql_arr[6]: "sql_error";
        $this->longitude = isset($sql_arr[7])? $sql_arr[7]: "sql_error";
        $this->lastModified = isset($sql_arr[8])? $sql_arr[8]: "sql_error";
		$this->timeAdded = isset($sql_arr[9])? $sql_arr[9]: "sql_error";
		//$this->comment =
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
        if (is_null($this->output["markers"])) {
	        $this->output["markers"] = array();
        }
        array_push($this->output["markers"], $this->toArray());
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
            while($row = $result->fetch_row())
            {
                $this->set($row);
                $this->addMarker();
            }
            $this->http_response_code = 200;
            return 1;
        }
        //$this->http_response_code = 400;
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
            if ($row = $result->fetch_row())
            {
                $this->set($row);
                $this->addMarker();
            }
            $this->http_response_code = 200;
            return 1;
        }
        //$this->http_response_code = 400;
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
                while ($row = $result->fetch_row())
                {
                    $this->set($row);
                    $this->addMarker();
                }
                $this->http_response_code = 200;
                $this->output['status'] = "Nearby markers retrieved";
	            $this->output["success"] = true;
                return 1;
	    }
        //$this->http_response_code = 400;
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
                while ($row = $result->fetch_row())
                {
                    $this->set($row);
                    $this->addMarker();
                }
                $this->http_response_code = 200;
                $this->output['status'] = "All markers retrieved";
	            $this->output["success"] = true;
                return 1;
        }
        //$this->http_response_code = 400;
        $this->output['status'] = "Failure to retrieve";
        return 0;
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

	/** Updates filename's category values
	 * @param $filename
	 */
	public function updateMarker($filename, $values = [-1,-1,-1,-1])
	{
		//TODO Actually update marker in DB

		$this->output["status"] = "Marker Updated";
		$this->output["success"] = true;
		$this->output["filename"] = $filename;
		$this->output["values"] = array("powerline"     =>  $values[0],
			"powerpole"     =>  $values[1],
			"overgrowth"    =>  $values[2],
			"oversag"       =>  $values[3]);
	}

	/**
	 * @param $filename
	 * @param $comment
	 */
	public function addComment($filename, $comment)
	{
		// TODO Add comment to comments table

		$this->output["status"] = "Comment added";
		$this->output["success"] = true;
		$this->output["filename"] = $filename;
		$this->output["comment"] = $comment;

	}

	/**
	 * @param $filename
	 */
	public function getComment($filename)
	{
		// TODO Get the latest comment
		// TODO 2: Make a second function getComments() to retrieve all comments of marker

		$comment = "empty";

		$this->output["status"] = "Comment added";
		$this->output["success"] = true;
		$this->output["filename"] = $filename;
		$this->output["comment"] = $comment;
	}
}

