<?php

class Controller_Serie
{

	public function index()
	{

		$db = Database::getInstance();

		$entries = $db->fetch('SELECT * FROM SERIE');

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

			'TITULOORIGINAL' => 'Título Original',
			'ANOLANCAMENTO' => 'Ano de Lançamento',
			'DISTRIBUIDORA' => 'Distribuidora',
			'LICENCA' => 'Licença',
			'TITULOPT' => 'Título Português',
			'GENERO' => 'Gênero',
			'CLASSEETARIA' => 'Classe Etária',
			'DURACAO' => 'Duração',
			'TAMANHO' => 'Tamanho',
			'AVALIACAO' => 'Avaliação',
			'SINOPSE' => 'Sinopse',
			'TRAILER' => 'Trailer',
			'RESOLUCAO' => 'Resolução',
			'AUDIO' => 'Audio',
			'LEGENDA' => 'Legenda',
			'PRECO' => 'Preço',
			'TIPO' => 'Tipo',			

		];

		$success = false;

		if(count($_POST) > 0)
		{

			$query = 'INSERT INTO VIDEO(';

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

			'TITULOORIGINAL' => 'Título Original',
			'ANOLANCAMENTO' => 'Ano de Lançamento',
			'DISTRIBUIDORA' => 'Distribuidora',
			'LICENCA' => 'Licensa',
			'TITULOPT' => 'Título Opcional',
			'GENERO' => 'Gênero',
			'CLASSEETARIA' => 'Classe Etária',
			'DURACAO' => 'Duração',
			'TAMANHO' => 'Tamanho',
			'AVALIACAO' => 'Avaliação',
			'SINOPSE' => 'Sinopse',
			'TRAILER' => 'Trailer',
			'RESOLUCAO' => 'Resolução',
			'AUDIO' => 'Audio',
			'LEGENDA' => 'Legenda',
			'PRECO' => 'Preço',
			'TIPO' => 'Tipo',			

		];

		$id = $_GET['id'];
		$success = false;

		$entry = $db->fetch('SELECT * FROM VIDEO WHERE ID = :id', ['id' => $id]);

		if(count($_POST) > 0)
		{

			$query = 'UPDATE VIDEO SET ';

			foreach($formFields as $name => $label)
				$query .= "$name = :$name, ";
			$query = rtrim($query, ', ');

			$query .= " WHERE ID = $id";

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

		$id = $_GET['id'];

		$success = $db->executeStmt('DELETE FROM SERIE WHERE ID = :id', ['id' => $id]);

		return [];

	}

	public function searchBySerieTitle()
	{

		$db = Database::getInstance();

		$title = $_GET['title'];

		$entry = $db->fetch('SELECT DISTINCT s.*, v.TITULOORIGINAL FROM SERIE s JOIN VIDEO v ON s.VIDEO = v.ID WHERE v.TITULOORIGINAL = :title', ['title' => $title], false);

		return
		[

			'entries' => $entry,

			'_render' => 'index',

		];

	}

}
