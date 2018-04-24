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
		$this->campos = [#"idpost",
				"titulo",
				"cuerpo",
				#"fecha",
				"imagen",
				"tags"];
	}

	protected function getCampo($campo) {
		return $this->$campo;
	}

	public function setAll($datos) {
		if (!$datos["titulo"]) {
			throw new Exception("El post debe tener un título", 1);
		}
	
		foreach ($this->campos as $campo) {
			$this->$campo = $datos[$campo];
		}
	}
}