<?php

/** This is Database connection class
 * We can specify the database here
 * and use connect() to return a mysqli object
 * Detects if request is local (XAMP)
 * and connects to local DB
 **/

class DB
{
	// Remote DB
    private static $server = "localhost";
    private static $user = "admin"; //remote
    private static $pass = "d1dc93d2b138cb1ff2eb03e6ca1aa77a22930a8f568812b7";
    private static $db = 'Project_Dragon';

	//
	private static $imageTable = 'Dummy';

	public static function getTable() { return self::$imageTable; }

    // Disable object instantiation of this class
    private function __construct() {}

	/**
	 * @return int
	 */
	private static function is_localhost()
    {
      $whitelist = array( '127.0.0.1', '::1' );
      if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) )
        return 1;
      return 0;
    }

	/**
	 * If localhost: connect to local DB
	 * If no parameter: connect to default DB
	 * If DB parameter passed: connect to that DB on default server
	 * Return MyQLi connection to Database
	 * @param null $db
	 * @return mysqli
	 */
	public static function connect($db = null)
    {
	    // Check if localhost
	    if (self::is_localhost())
		    return new mysqli('localhost', 'root', '', 'project_dragon');

        // Default DB: Project_Dragon (if no DB passed)
        if (is_null($db)) $db = self::$db;

        return new mysqli(self::$server, self::$user, self::$pass, $db);
    }

	/**
	 * I might move these but the following functions are
	 * for the Server's Secret Key for JSON Web Tokens
	 * @return string: Secret Token Key
	 */
	public static function getTokenKey()
    {
        $key = "mishu";
/*
        // get token from DB
        $db = self::connect();
        $sql = "SELECT `token_key` FROM `Auth`";
        $result = $db->query($sql);

        if ($result) {
             if ($row = $result->fetch_row())
                $key = $row[0];
        }
*/
       return md5($key);
    }

	/**
	 * Generate a new Secret Key and add to database
	 *
	 */
	public static function genTokenKey()
    {
        $key = self::generateKey();

        //Add to DB
        $db = self::connect();
        $sql = "INSERT INTO `Auth`(`token_key`) VALUES ({$key})";
        $db->query($sql);
    }

	/**
	 * Generate a very unique and secure string 
	 * @param int $len
	 * @return mixed|string|void
	 */
	private static function generateKey($len = 16)
    {
        $data = openssl_random_pseudo_bytes($len);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0010
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4));
    }
}
