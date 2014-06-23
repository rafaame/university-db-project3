<?php

class Controller_Usuario
{
	public function index()
	{
		$db = Database::getInstance();
		$entries = $db->fetch('SELECT * FROM USUARIO');
		return
		[

			'entries' => $entries,

		];

	}

	public function add()
	{
		$db = Database::getInstance();
		$formFields =
		[
			'NOMEUSUARIO' => 'Nome de Usuário',
			'SENHA' => 'Senha',
			'NOMECOMPLETO' => 'Nome Completo',
			'DATANASC' => 'Data de Nascimento',
			'EMAIL' => 'E-mail',
		];

		$success = false;

		if(count($_POST) > 0)
		{

			$query = 'INSERT INTO USUARIO(';

			foreach($formFields as $name => $label)
				$query .= "$name,";
			$query = rtrim($query, ',');

			$query .= ') VALUES(';

			foreach($formFields as $name => $label)
				$query .= ":$name,";
			$query = rtrim($query, ',');

			$query .= ')';

			$success = (bool) $db->executeStmt($query, $_POST);

		}

		return
		[

			'formFields' => $formFields,
			'success' => $success,

		];

	}

	public function edit()
	{

		$db = Database::getInstance();

		$formFields =
		[
			'NOMEUSUARIO' => 'Nome de Usuário',
			'SENHA' => 'Senha',
			'NOMECOMPLETO' => 'Nome Completo',
			'DATANASC' => 'Data de Nascimento',
			'EMAIL' => 'E-mail',
		];

		$nomeusuario = $_GET['nomeusuario'];
		$success = false;

		$entry = $db->fetch('SELECT * FROM USUARIO WHERE NOMEUSUARIO = :nomeusuario', ['nomeusuario' => $nomeusuario]);

		if(count($_POST) > 0)
		{

			$query = 'UPDATE USUARIO SET ';

			foreach($formFields as $name => $label)
				$query .= "$name = :$name, ";
			$query = rtrim($query, ', ');

			$query .= " WHERE NOMEUSUARIO = $nomeusuario";

			$success = $db->executeStmt($query, $_POST);

			var_dump($success);exit;

		}

		return
		[

			'formFields' => $formFields,
			'success' => $success,
			'entry' => $entry,

		];

	}

	public function delete()
	{

		$db = Database::getInstance();

		$nomeusuario = $_GET['nomeusuario'];

		$success = $db->executeStmt('UPDATE FROM USUARIO SET STATUS = \'x\' WHERE NOMEUSUARIO = :nomeusuario', ['nomeusuario' => $nomeusuario]);

		return [];

	}

}
