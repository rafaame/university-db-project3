<?php
class Controller_Cartaocredito
{
	public function index()
	{
		$db = Database::getInstance();
		$entries = $db->fetch('SELECT * FROM CARTAOCREDITO');
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
			'NUMERO' => 'Número',
			'EMPRESA' => 'Empresa',
			'NOME' => 'Nome Completo',
			'VALIDADE' => 'Data de Validade',
			'USUARIO' => 'Usuário deste Cartão',
		];

		$success = false;

		if(count($_POST) > 0)
		{

			$query = 'INSERT INTO CARTAOCREDITO(';

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
			'NUMERO' => 'Número',
			'EMPRESA' => 'Empresa',
			'NOME' => 'Nome Completo',
			'VALIDADE' => 'Data de Validade',
			'USUARIO' => 'Usuário deste Cartão',
		];

		$numero = $_GET['numero'];
		$success = false;

		$entry = $db->fetch('SELECT * FROM CARTAOCREDITO WHERE NUMERO = :numero', ['numero' => $numero]);

		if(count($_POST) > 0)
		{

			$query = 'UPDATE CARTAOCREDITO SET ';

			foreach($formFields as $name => $label)
				$query .= "$name = :$name, ";
			$query = rtrim($query, ', ');

			$query .= " WHERE NUMERO = $numero";

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

		$numero = $_GET['numero'];

		$success = $db->executeStmt('DELETE FROM CARTAOCREDITO WHERE NUMERO = :numero', ['numero' => $numero]);

		return [];

	}

}
