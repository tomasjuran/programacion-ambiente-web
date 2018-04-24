<?php

require __DIR__ . "/Persistible.php";

class Post extends Persistible {
	private $idpost;
	private $titulo;
	private $cuerpo;
	private $fecha;
	private $imagen;
	private $tags;
	private $comentarios;

	function __construct() {
		$this->tabla = "posts";
		$this->claves = ["idpost"];
		$this->campos = ["idpost", "titulo", "cuerpo", "fecha", "imagen", "tags"];
	}

	public function setAll($datos) {
		if (!$datos["idpost"]) {
			throw new Exception("El post debe tener un ID", 1);
		}
		parent::setAll($datos);
	}
}