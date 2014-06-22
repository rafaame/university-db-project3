<?php

class Bootstrap
{

	private function initDatabase()
	{

		require 'common/Database.php';

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
		$controller->$actionName();

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