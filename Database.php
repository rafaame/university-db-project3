<?php

require 'SingletonTrait.php';

class Database
{

	use SingletonTrait;

	private $_pdo;
	private $lastStmt;

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

		$config = require 'common/config.php';
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

	public function fetch($query, $data = [], $reduce = true)
	{

		$preparedData = [];
		foreach($data as $key => $value)
			$preparedData[':' . $key] = $value;

		$stmt = $this->_pdo->prepare($query);

		if($stmt)
			$this->lastStmt = $stmt;

		if(!$stmt->execute($preparedData))
			return false;

		$entries = $stmt->fetchAll(PDO::FETCH_OBJ);

		if(!$reduce)
			return $entries;

		if(count($entries) == 1)
			return $entries[0];
		else
			return $entries;

	}

	public function executeStmt($query, $data)
	{

		$preparedData = [];
		foreach($data as $key => $value)
			$preparedData[':' . $key] = $value;

		try
		{

			$stmt = $this->_pdo->prepare($query);

			if($stmt)
				$this->lastStmt = $stmt;

			if(!$stmt->execute($preparedData))
				return false;

		}
		catch(PDOException $e)
		{

			throw $e;

		}

		return $stmt->rowCount();

	}

	public function getErrorInfo()
	{

		return array_merge($this->_pdo->errorInfo(), $this->lastStmt->errorInfo());

	}

}