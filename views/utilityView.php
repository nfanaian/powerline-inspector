<?php

/**
 * This is the front end of our Utility Inspection System
 */

require_once('views/View.php');

class utilityView extends View
{
	public function mapView()
	{
		require_once('views/utility/mapViewer.php');
	}

	public function userView()
	{
		require_once('views/utility/userViewer.php');
	}
	
}