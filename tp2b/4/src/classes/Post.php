<?php

require __DIR__ . "../../../base/Conexion.php";

class Post {
	private $idpost;
	private $titulo;
	private $cuerpo;
	private $fecha;
	private $imagen;
	private $tags;
	private $comentarios;

	private $tabla = "posts";
	private $claves = ["idpost"];
	private $campos = ["idpost", "titulo", "cuerpo", "fecha", "imagen", "tags", "comentarios"];

	public function setAll($datos) {
		if (!$datos["idpost"]) {
			throw new Exception("El post debe tener un ID", 1);
		}
		parent::setAll();
	}