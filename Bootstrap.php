<?php

require 'ViewRenderer.php';

class Bootstrap
{

	private function initDatabase()
	{

		require 'Database.php';

		Database::getInstance();

	}

	private function doRouting()
	{

		$controller = isset($_GET['controller']) ? $_GET['controller'] : 'index';
		$action = isset($_GET['action']) ? $_GET['action'] : 'index';

		return
		[

			'controller' => $controller,
			'action' => $action,

		];

	}

	private function dispatch($route)
	{

		$controllerName = $route['controller'];
		$controllerClass = 'Controller_' . ucfirst($controllerName);
		$actionName = $route['action'];

		require 'controllers/' . ucfirst($controllerName) . '.php';
		$controller = new $controllerClass();
		
		$viewParams = $controller->$actionName();

		if($viewParams['_render'])
			$viewFilename = 'views/' . $controllerName . '/' . $viewParams['_render'] . '.phtml';
		else
			$viewFilename = 'views/' . $controllerName . '/' . $actionName . '.phtml';

		$viewRenderer = new ViewRenderer($viewParams);
		$viewRenderer->render($viewFilename, 'views/layout/standard.phtml');

	}

	private function routeAndDispatch()
	{

		$route = $this->doRouting();
		$this->dispatch($route);

	}

	public function init()
	{

		$this->initDatabase();
		$this->routeAndDispatch();

	}

}