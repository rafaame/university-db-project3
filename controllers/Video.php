<?php

class Controller_Video
{

	public function index()
	{

		$db = Database::getInstance();

		$entries = $db->fetch('SELECT * FROM VIDEO');

		return
		[

			'entries' => $entries,

		];

	}

}