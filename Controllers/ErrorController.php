<?php
require_once 'inc/Controller.php';

class ErrorController extends Controller
{
	public function index($message = "404!")
	{
		$this->view->message = $message;
		$this->view->render('Views/error.html');
	}
}
