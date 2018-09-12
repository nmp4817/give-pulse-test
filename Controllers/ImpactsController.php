<?php

require_once 'inc/Controller.php';
require_once 'Repository/ImpactRepository.php';

class ImpactsController extends Controller
{
	public function index()
	{
		$this->view->render('Views/index.html');
	}

	public function show() {

		if (empty($_POST['address'])) {
			$this->view->message = "Field Reuired!";
			$this->view->render('Views/error.html');
		}


		/** Fixing Latitude and Longitude in case google api doesn't work */
		$latitude = 30.19631195;
		$longitude = -97.73080444;

		/* USING file_get_contents */
		// $address = $_POST['address']; // Google HQ
		// $prepAddr = str_replace(' ','+',$address);
		// $response = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');

		/* Using CURL */
		$url = "https://maps.google.com/maps/api/geocode/json?address=".$_POST['address']."&sensor=false";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);

        $output= json_decode($response);
        if ($output) {
	        $latitude = $output->results[0]->geometry->location->lat;
	        $longitude = $output->results[0]->geometry->location->lng;
	    }

        $repository = new ImpactRepository;
        $dataset = $repository->getUsersByDuration($longitude, $latitude);

        $fp = fopen(getcwd()."\Resources\data.json", "w");
		fwrite($fp, $dataset);
		fclose($fp);

		$this->view->render('Views/impacts/show.html');
	}
}
