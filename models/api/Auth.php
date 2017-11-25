<?php

/**
 * API Request Authentication/Authorization purposes
 */
require_once('models/Model.php');

class Auth extends Model
{
	/** Authenticate User
	 * If user/pass are correct: generate JSON Web Token
	 * Otherwise, return 0
	 * @param $username
	 * @param $password
	 * @return int|void
	 */
	public function userAuth($username, $password)
    {
	    $db = DB::connect(); //New MySQLi Object

	    // Authenticate proposed user with database
        $sql = "SELECT * FROM `User` WHERE `username`='{$username}'";// AND `password`='{$password}'";

	    // Check result
        $result = $db->query($sql);

        if ($result->num_rows > 0)
        {
	        // Generate JWT if user is authenticated
            if ($row = $result->fetch_row())
	            return $this->generateJWT($row[0]);
            $result->free();
       }
        $this->output["status"] = "Authentication failure.";
	    return 0;
    }

	/** Register new user   (Maybe use a special key for
	 *                          only AJAX calls from our client)
	 * @param $username
	 * @param $password
	 * @param $email
	 * @return int: Boolean result
	 */
	public function registerUser($username, $password, $email)
	{
		if (is_null($username) || is_null($password) || is_null($email)) {

			$this->output['status'] = "Missing variables to register user";
		}

		$db = DB::connect();

		$sql = "INSERT INTO `User`(`username`, `password`, `email`) 
				VALUES ('{$username}', '{$password}', '{$email}')";

		if ($db->query($sql) === TRUE){
			$this->output['status'] = $username . " has been added";
			$this->output["success"] = true;
			return 1;
		}
		$this->output['status'] = "Failed to register user";
		return 0;
	}

	/** Generate a new JSON Web Token
	 * @param $username
	 * Generate a JSON WEB TOKEN
	 * Sets output to token
	 * @return bool: success/failure
	 */
	private function generateJWT($user_id)
    {
        $token = array(
            // "iss" => "http://example.org",
            // "aud" => "http://example.com",
            // "iat" => 1356999524,     // idk the format, but its issued time of token
            // "nbf" => 1357000000,     // and this is life of token
            "user" => $user_id,
	        "request" => $this->output["request"],
	        "clientIP" => $this->getRealIpAddr()
        );

	    require_once('resources/jwt.php');
        $this->output["jwt"] = JWT::encode($token, DB::getTokenKey());

	    $this->output["success"] = true;
	    return 1;
    }

	/** Verify client's JSON Web Token
	 * @return int: Boolean
	 */
	public function verifyToken()
    {
	    // Retrieve token from POST/GET
	    $jwt = requestParser::getToken();

	    if (!is_null($jwt)) {
		    try
		    {
			    $key = DB::getTokenKey();
			    require_once('resources/jwt.php');
			    $jwt_decoded = (array)JWT::decode($jwt, $key, array('HS256')); // We just need the function to not throw errors
			    $this->output["success"] = true;

			    // TODO Check iat (jwt issued time) & if jwt is older than t, return 0
			    // This is additional feature to check if token has expired
			    //if (($this->output["iat"] + $t_expire) >= $time)
			    //  return 0;

			    return true;
		    }
		    catch (UnexpectedValueException $e)
		    {
			    $this->model->output["status"] = $e->getMessage();
		    }
		    catch (DomainException $e)
		    {
			    $this->model->output["status"] = $e->getMessage();
		    }
	    } else {
		    return call('error', 'error_token');
	    }
	    $this->output["success"] = false;
	    return false;
    }

	public function decode()
	{
		// Retrieve token from POST/GET
		$jwt = requestParser::getParam(0);

		$this->output["jwt"] = $jwt;
		if (!is_null($jwt)) {
			try
			{
				$key = DB::getTokenKey();
				require_once('resources/jwt.php');
				$jwt_decoded = (array)JWT::decode($jwt, $key, array('HS256')); // We just need the function to not throw errors

				$this->output["jwt decoded"] = $jwt_decoded;
				$this->output["success"] = true;
			}
			catch (UnexpectedValueException $e) {}
			catch (DomainException $e) {}
		}
	}
}