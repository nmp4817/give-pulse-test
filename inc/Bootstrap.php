<?php

class Bootstrap
{
	public function __construct() 
	{

		$tokens = explode('/',rtrim($_SERVER['REQUEST_URI'], '/'));

		if (isset($tokens[1])) {
			$controllerName = ucfirst($tokens[1]).'Controller';

			if (file_exists('Controllers/'.$controllerName.'.php')) {
				require_once('Controllers/'.$controllerName.'.php');
				$controller = new $controllerName;

				if (isset($tokens[2])) {
					$actionName = $tokens[2];

					if(isset($tokens[3])) {
						$controller->{$actionName}($tokens[3]);	
					} else {
						$controller->{$actionName}();
					}
				} else {
					$controller->index();
				}				
			} else {
				require_once('Controllers/ErrorController.php');
				$errorController = new ErrorController;
				$errorController->index();
			}
		} else {
			require_once('Controllers/ImpactsController.php');
			$errorController = new ImpactsController;
			$errorController->index();
		}		
	}
}
