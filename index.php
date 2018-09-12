<?php

require_once('Controllers/ImpactsController.php');

$impactsController = new ImpactsController;

if (isset($_POST['address'])) {
	$impactsController->show();
} else {
	$impactsController->index();
}