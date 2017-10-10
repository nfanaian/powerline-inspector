<?php

/**
 * API Request Authentication/Authorization purposes
 */
require_once('models/Model.php');

class Auth extends Model
{
	/**
	 * Authenticate User
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
        $sql = "SELECT * FROM `User` WHERE `username`='{$username}' AND `password`='{$password}'";

	    // Check result
        if ($result = $db->query($sql))
        {
	        // Generate JWT if user is authenticated
            if ($row = $result->fetch_assoc())
	            return $this->generateToken($username);
            $result->free();
       }
        $this->http_response_code = 400;
        $this->output["status"] = "Authentication failure.";
	    return 0;
    }

	/**
	 * Register new user    (Maybe use a special key for
	 *                      only AJAX calls from our client)
	 * @param $username
	 * @param $password
	 * @param $email
	 * @return int: Boolean result
	 */
	public function registerUser($username, $password, $email)
	{
		if (is_null($username) || is_null($password) || is_null($email)) {

			$this->output['status'] = "Missing variables to register user";
			$this->http_response_code = 400;
		}

		$db = DB::connect();

		$sql = "INSERT INTO `User`(`username`, `password`, `email`) 
				VALUES ('{$username}', '{$password}', '{$email}')";

		$db->query($sql);
		if (mysqli_affected_rows($db)){
			$this->output['status'] = $username . " has been added";
			$this->http_response_code = 202; //SUCCESS
			return 1;
		}
		$this->output['status'] = "Failed to register user";
		$this->http_response_code = 400;
		return 0;
	}

	/**
	 * @param $username
	 * Generate a JSON WEB TOKEN
	 * Sets output to token
	 */
	private function generateToken($username)
    {
        $token = array(
            // "iss" => "http://example.org",
            // "aud" => "http://example.com",
            // "iat" => 1356999524,
            // "nbf" => 1357000000,
            "user" => $username
        );

        $this->output = JWT::encode($token, DB::getTokenKey());
        $this->http_response_code = 202; //SUCCESS
	    return 1;
    }

	/**
	 * Verify client's JSON Web Token
	 *
	 * @return int: Boolean
	 */
	public function verifyToken()
    {
	    return 1; // Debug-Mode lol

	    // Retrieve token from POST/GET
        $token = urlParser::getToken();

	    // Check we have a token
        if (!is_null($token))
        {
            try
            {
	            // Attempt to decode JSON Web Token
                $this->output = (array)JWT::decode($token, DB::getTokenKey(), array('HS256'));


                // TODO Check iat (jwt issued time) & if jwt is older than t, return 0
	            // This is additional feature to check if token has expired
                //if (($this->output["iat"] + $t_expire) >= $time)
                  //  return 0;

                //return $this->output["user"];
	            return 1;
            }
            catch (UnexpectedValueException $e)
            {
                $this->http_response_code = 400; // error with token
                $this->output["status"] = $e;
            }
            catch (DomainException $e)
            {
                $this->http_response_code = 400; // error with token
                $this->output["status"] = $e;
            }
        }
        return 0;
    }
}