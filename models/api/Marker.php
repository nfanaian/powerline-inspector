<?php

/**
 * Marker resources
 * This class takes care of manipulating DB for Markers
 */

require_once('models/Model.php');

class Marker extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

	/** SQL result sanitization
	 * @param $sql_arr
	 * @param $key
	 * @return bool|string
	 */
	private function getSQL($sql_arr, $key)
	{
		$result = (isset($sql_arr[$key])? $sql_arr[$key]: "sql_error");

		if ($result === 1) $result = true;
		elseif ($result === 0) $result = false;

		return $result;
	}

	/** Push marker to markers list
	 * If this is the first marker, create an array for output['markers']
	 */
	private function addMarker($row)
	{
		$marker = array(    'filename'      =>  $this->getSQL($row, "filename"),
							'powerline'     =>  $this->getSQL($row, "powerline"),
							'powerpole'     =>  $this->getSQL($row, "powerpole"),
							'overgrowth'    =>  $this->getSQL($row, "overgrowth"),
							'oversag'       =>  $this->getSQL($row, "oversag"),
							'latitude'      =>  $this->getSQL($row, "latitude"),
							'longitude'     =>  $this->getSQL($row, "longitude"),
							'lastModified'  =>  $this->getSQL($row, "lastModified"),
							'timeAdded'     =>  $this->getSQL($row, "timeAdded"),
							'log'           =>  $this->getComments($this->getSQL($row, "filename"))
		);

		if (empty($this->output["markers"]))
			$this->output["markers"] = array();

		array_push($this->output["markers"], $marker);
	}
	
	/** Get user_id from passed jwt
	 * @return int | $user_id
	 */
	private function getUserId()
	{
		// Retrieve token from POST/GET
		$jwt = requestParser::getToken();

		if (!is_null($jwt)) {
			try
			{
				$key = DB::getTokenKey();
				require_once('resources/jwt.php');
				$jwt_decoded = (array)JWT::decode($jwt, $key, array('HS256')); // We just need the function to not throw errors

				return $jwt_decoded["user"];
			}
			catch (UnexpectedValueException $e) {}
			catch (DomainException $e) {}
		}
		return false;
	}

	/** Gets username from DB using user_id (Auto-Incrementing Primary key)
	 * @param $user_id | int
	 * @return bool | string
	 */
	private function getUser($user_id)
	{
		$db = DB::connect();
		$sql = "SELECT *
				FROM User
				WHERE `user_id`='{$user_id}'";

		$result = $db->query($sql);
		if ($result->num_rows > 0)
		{
			if ($row = $result->fetch_assoc())
				return $this->getSQL($row, "username");
		}
		return false;
	}

	/** Checks if file exists in DB
	 * @param $filename | string
	 * @return boolean
	 */
	private function checkFile($filename)
	{
		$db = DB::connect();
		$tbl = DB::getTable();
		$sql = "SELECT `filename`
				FROM `{$tbl}`
				WHERE `filename`='{$filename}'";

		$result = $db->query($sql);
		if ($result->num_rows > 0)
			return true;
		else
			return false;
	}

	/** Gets and builds log from filename
	 * @param $filename | string
	 * @return $log | string
	 */
	private function getComments($filename)
	{
		$db = DB::connect();
		$sql = "SELECT * 
				FROM Comments
				WHERE `filename`='{$filename}'";

		$comments = "Log for ". $filename. "\n";
		$comments .= "-------------------------------\n\n";

		$result = $db->query($sql);
		if ($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
				$comments = $this->commentBuilder($comments, $row);
		}
		else
		{
			$comments .= "Log Empty.\n\n-------------------------------\n\n";
		}
		return $comments;
	}

	/** Helper function for getComments
	 *  Appends comment to string containing entire log
	 * @param $str | string
	 * @param $comment | string
	 * @return $str| string
	 */
	private function commentBuilder($str, $comment)
	{
		$str .= "User: ". $this->getUser( $this->getSQL($comment, "user_id") ). "\n";
		$str .= "Date: ". $this->getSQL($comment, "timeAdded"). "\n";
		$str .= "Log: \n";
		$str .= $this->getSQL($comment, "comment");
		$str .= "\n\n-------------------------------\n\n";
		return $str;
	}

	/** Adds comment to specified filename
	 * @param $filename
	 * @param $comment
	 */
	private function addComment($filename, $comment)
	{
		// Get user_id
		if (!($user_id = $this->getUserId())) return false;

		$db = DB::connect();
		$sql = "INSERT INTO `Comments`
				(comment, filename, user_id)
				VALUES ('{$comment}', '{$filename}', {$user_id})";

		if ($db->query($sql) === TRUE)
			return true;
		return false;
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
		    if ($row = $result->fetch_assoc())
			    $this->addMarker($row);

		    $this->output['status'] = "Marker '{$filename}' retrieved";
		    $this->output["success"] = true;
	    }
        $this->output['status'] = "Failure to retrieve '{$filename}'";
    }

    /** Get all images located within the distance of the given lat/long
     * @param $latitude|double
     * @param $longitude|double
     * @param $distance|int - in miles
     * @return $list|image array
     */
    public function getNearby($latitude, $longitude, $distance, $limit = 10000)
    {
        $db = DB::connect();
	    $tbl = DB::getTable();

        $sql = "SELECT *, ( 3959 * acos( cos( radians({$latitude}) ) * cos( radians( `latitude` ) )
 							* cos( radians( `longitude` ) - radians({$longitude}) ) + sin( radians({$latitude}) )
 							* sin(radians(`latitude`)) ) ) AS `distance` 
                FROM `Dummy` 
                HAVING `distance` < {$distance} 
                ORDER BY `distance` ASC
                LIMIT {$limit}";

	    $result = $db->query($sql);
	    if ($result->num_rows > 0)
	    {
		    while ($row = $result->fetch_assoc())
			    $this->addMarker($row);

		    $this->output['status'] = "{$result->num_rows} Markers within '{$distance}' miles of coordinates ({$latitude}, {$longitude}) have been retrieved";
		    $this->output['success'] = true;
	    } else {
		    $this->output['status'] = "Failure to retrieve markers within '{$distance}' miles of coordinates ({$latitude}, {$longitude})";
	    }
    }

	/** Retrieve all markers stored in the DB
	 */
	public function getAll()
    {
        $db = DB::connect();
	    $tbl = DB::getTable();

        $sql = "SELECT * FROM `{$tbl}` WHERE 1";
	    $result = $db->query($sql);
	    if ($result->num_rows > 0)
	    {
                while ($row = $result->fetch_assoc())
                    $this->addMarker($row);

                $this->output['status'] = "All {$result->num_rows} markers retrieved";
	            $this->output["success"] = true;
        } else {
		    $this->output['status'] = "Failure to retrieve";
	    }
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


	    //$file = "/usr/local/project_dragon/data/dummy/5/d/3/7/b/5/5/5/6/d/5d37b5556d3f7d3e491693b1983b4140.jpg";

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
	public function updateMarker($filename, $values, $comment)
	{
		$this->output["filename"] = $filename;

		// Check if file exists
		if (!$this->checkFile($filename))
		{
			$this->output["status"] = "File does not exist";
			return;
		}

		// Check all values were passed
		for($i=0; $i<4; $i++)
		{
			if (is_null($values[$i]))
			{
				$this->output["status"] = "Missing boolean parameters";
				return;
			}
			$values[$i] = (int)$values[$i];
		}

		// Update Values
		$db = DB::connect();
		$tbl = DB::getTable();

		$sql = "UPDATE `{$tbl}`
		        SET `powerline`={$values[0]}, `powerpole`={$values[1]}, `overgrowth`={$values[2]}, `oversag`={$values[3]}
		        WHERE `filename`='{$filename}'";

		if ($db->query($sql) === TRUE) {
			//success
			$this->output["status"] = "Marker updated. ";
		} else {
			//failure
			$this->output["status"] = "Marker update failed. ";
			return;
		}

		// Add Comment
		if (!is_null($comment) && !empty($comment))
		{
			if ($this->addComment($filename, $comment))
				$this->output['status'] .= " Comment added. ";
			else
				$this->output['status'] .= " Comment insert failed. ";
		} else {
			$this->output['status'] .= " No comment passed. ";
		}

		$this->output["values"] = array("powerline"     =>  $values[0],
										"powerpole"     =>  $values[1],
										"overgrowth"    =>  $values[2],
										"oversag"       =>  $values[3]);
		$this->output['log'] = $this->getComments($filename);
		$this->output['status'] .= "Log Retrieved. ";
		$this->output['success'] = true;
	}

	/** Retrieve Log (Not being used)
	 * @param $filename
	 */
	public function getLog($filename)
	{
		$this->output["filename"] = $filename;

		// Checks if file exists first
		if ($this->checkFile($filename))
		{
			// Retrieve comments
			$this->output['log'] = $this->getComments($filename);
			$this->output["success"] = true;
			$this->output["status"] = "comments retrieved";
		} else {
			$this->output['log'] = null;
			$this->output["success"] = false;
			$this->output["status"] = "File does not exist";
		}
	}
}

/*

SELECT *, ( 3959 * acos( cos( radians(28.463136662111) ) * cos( radians( `latitude` ) )
		* cos( radians( `longitude` ) - radians(-81.196438427454) ) + sin( radians(28.463136662111) ) * sin(radians(`latitude`)) ) )
AS `distance`
FROM `Dummy`
HAVING `distance` < 25
ORDER BY `distance` ASC


SELECT *, ( 3959 * acos( cos( radians({$latitude}) ) * cos( radians( `latitude` ) )
			* cos( radians( `longitude` ) - radians({$longitude}) ) + sin( radians({$latitude}) )
			* sin(radians(`latitude`)) ) ) AS `distance`
FROM `Dummy`
HAVING `distance` < 5
ORDER BY `distance` ASC

*/