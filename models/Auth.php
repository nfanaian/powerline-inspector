<?php

/**
 * Created by PhpStorm.
 * User: nfanaian
 * Date: 8/28/2017
 * Time: 8:54 AM
 */
require_once('models/Model.php');

class Auth extends Model
{
    public function userAuth($username, $password)
    {
        $db = DB::connect();

        $sql = "SELECT * FROM `User` WHERE `username`='{$username}' AND `password`='{$password}'";

        if ($result = $db->query($sql))
        {
            if ($row = $result->fetch_assoc())
            {
	            return $this->generateToken($username);
            }
            $result->free();
       }
        $this->http_response_code = 400;
        $this->output["status"] = "Authentication failure.";
	    return 0;
    }

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
    }

    public function verifyToken()
    {
	    return 1;
        $token = urlParser::getToken();

        if (!is_null($token))
        {
            try
            {
                $this->output = (array)JWT::decode($token, DB::getTokenKey(), array('HS256'));

                // TODO Check iat (jwt issued time) & if jwt is older than t, return 0
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