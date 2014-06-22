<?php

class Database
{

	private $_pdo;

	private function connect($host, $username, $password, $dbname)
	{

		$dsn = "mysql:host=$host;dbname=$dbname";
		$options =
		[

		    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

		]; 

		$this->_pdo = new PDO($dsn, $username, $password, $options);

	}

	public function __construct()
	{

		$config = require 'config.php';
		$host = $config['host'];
		$username = $config['username'];
		$password = $config['password'];
		$dbname = $config['dbname'];

		$this->connect($host, $username, $password, $dbname);

	}

	public function query($query)
	{

		try
		{

			return $this->_pdo->query($query);

		}
		catch(PDOException $e)
		{

			throw $e;

		}

	}

	public function getData()
	{

		$stmt = $this->query('SELECT * FROM USUARIO');

		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

}