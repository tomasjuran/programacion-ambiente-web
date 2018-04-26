<?php

require_once __DIR__ . "/Persistible.php";

class Comentario extends Persistible {
	private $idpost;
	private $idcomm;
	private $autor;
	private $cuerpo;
	private $fecha;

	protected function getCampo($campo) {
		return $this->$campo;
	}
	
}