<?php

class ViewRenderer
{

	public function __construct($params)
	{

		foreach($params as $key => $value)
			$this->$key = $value;

	}

	public function render($viewFilename, $layoutFilename)
	{

		$this->_viewFilename = $viewFilename;

		return require $layoutFilename;

	}

	public function url($controller = null, $action = null, $params = [])
	{

		$url = '/?controller=' . $controller . '&action=' . $action;

		foreach($params as $key => $value)
			$url .= '&' . $key . '=' . $value;

		return $url;

	}

}