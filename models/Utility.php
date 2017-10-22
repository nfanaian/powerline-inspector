<?php
require_once 'models/Model.php';

/**
 * Class Utility
 */

class Utility extends Model
{
	private $API_ROOT = "http://107.170.23.85/api/";
	private $filename = "596a0d35eec05_143.jpg";

	public function __construct()
	{
		// Construct Model
		parent::__construct();
	}

	public function getImage()
	{
		return  $this->API_ROOT.
				"marker/getimage/".
				"API_KEY/".
				$this->getFile(). "/";
	}

	public function getFile()
	{
		return $this->filename;
	}

	public function setFile($filename)
	{
		$this->filename = $filename;
	}


	/* Here we can check for the client's cookie holding the TOKEN
	 * We could authenticate the user before even rendering him the HTML PAGE
	 * MUCH BETTER
	 * Current Solution: User is authenticated on page load BY Javascript
	 */
	/**
	 *
	 */
	public function authenticate()
	{
		if (!isset($_COOKIE["token"]))
			return 0;

		/* This is pointless, BUT this would let us do this locally/offline
		 * But if that is the need we can re-enable the getCookie() from JavaScript
		$url = "http://107.170.23.85/api/auth/authpage/";
		$postIt = "token=" + $_COOKIE['token'];


		require_once('/resources/tools.php');
		$json = Tools::apiCall($url, $postIt);


		return 1;
		if ($json->success == true)
			return 1;
		else
			return 0;
		*/

		/** With this method, we must receive a POST request with JWT token
		 * and then we authenticate JWT
		 *
		 */

		// SetToken from Cookie TODO bad design style
		requestParser::setToken($_COOKIE["token"]);

		require_once('models/Auth.php');
		if ((new Auth())->verifyToken())
			return 1;
		return 0;
	}

	/**
	 *
	 */
	public function clearKeys()
	{
		if (isset($_COOKIE["token"]))
		{
			$this->deleteCookie("token");
		}
	}

	public function setCookie($cookie, $value)
	{
		if (is_null($cookie))
			return 0;
		setcookie($cookie, $value, time() + (86400 * 30), "/");
		return 1;
	}

	/** Delete cookie
	 * It actually just sets the cookie's
	 * expiration date to the past and render it unusable
	 * @param $cookie
	 */
	public function deleteCookie($cookie)
	{
		if (isset($_COOKIE[$cookie]))
		{
			// set the expiration date to one hour ago
			setcookie($cookie, "", time() - 3600);
		}
	}

	/** Check if cookies are enabled on the client
	 * It just sets a test cookie and checks if it saved
	 * @return int
	 */
	public function isCookiesEnabled()
	{
		setcookie("test_cookie", "test", time() + 3600, '/');

		if (count($_COOKIE) > 0)
			return 1; // "Cookies are enabled
		else
			return 0; // Cookies are disabled
	}
}