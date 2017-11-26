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
		/* //DEBUG (JS console.log() of cookie
		?>
		<script type="application/javascript">
			console.log("<?= $this->isCookiesEnabled(). "COOKIE: |". $_COOKIE["token"]. "|"; ?>");
		</script>
		<?php
		return 1; */

		if (!isset($_COOKIE["token"]) || ($_COOKIE["token"] === ""))
			return false;

		// SetToken from Cookie
		requestParser::setToken($_COOKIE["token"]);

		require_once('models/Auth.php');
		if ((new Auth())->verifyToken())
			return true;
		return false;
	}

	/** Delete cookie
	 * It actually just sets the cookie's
	 * expiration date to the past and render it unusable
	 * @param $cookie
	 */
	public function clearKeys()
	{
		if (isset($_COOKIE["token"]))
			setcookie("token", "", time() - 3600);
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