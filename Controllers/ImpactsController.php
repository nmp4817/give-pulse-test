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

 		$address = $_POST['address']; // Google HQ
        $prepAddr = str_replace(' ','+',$address);
        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        $output= json_decode($geocode);
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;

        $repository = new ImpactRepository;
        $dataset = $repository->getUsersByDuration($longitude, $latitude);

		$this->view->dataset = json_encode($dataset);
		$this->view->render('Views/impacts/show.html');
	}
}
