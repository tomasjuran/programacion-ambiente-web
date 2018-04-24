<?php

require_once __DIR__ . "/Persistible.php";

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

    /**
     * @return mixed
     */
    public function getIdpost()
    {
        return $this->idpost;
    }

    /**
     * @param mixed $idpost
     *
     * @return self
     */
    public function setIdpost($idpost)
    {
        $this->idpost = $idpost;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     *
     * @return self
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCuerpo()
    {
        return $this->cuerpo;
    }

    /**
     * @param mixed $cuerpo
     *
     * @return self
     */
    public function setCuerpo($cuerpo)
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     *
     * @return self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     *
     * @return self
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     *
     * @return self
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * @param mixed $comentarios
     *
     * @return self
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;

        return $this;
    }
}