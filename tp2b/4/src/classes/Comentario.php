<?php

require_once __DIR__ . "/Persistible.php";
require_once __DIR__ . "/../../../base/Conexion.php";

class Comentario extends Persistible {
	private $idpost;
	private $idcomm;
	private $autor;
	private $cuerpo;
	private $fecha;

	function __construct() {
        $this->tabla = "comentarios";
		$this->claves = ["idpost", "idcomm"];
		$this->campos = [#"idpost",
				"idcomm",
				"autor",
				#"fecha",
				"cuerpo"];
	}

	protected function getCampo($campo) {
		return $this->$campo;
	}
	
	public function setAll($datos) {
		if (!$datos["autor"]) {
			throw new Exception("El comentario debe tener un autor", 1);	
		}
        if (!$datos["idcomm"]) {
            throw new Exception("El comentario debe tener un id", 1);
        }
	
		foreach ($this->campos as $campo) {
            if (isset($datos[$campo])) {
                $this->$campo = $datos[$campo];
            }
		}
	}

	public function getMaxId() {
        $pdo = Conexion::getPDO();
        $query = $pdo->prepare("SELECT MAX(idcomm) FROM comentarios WHERE idpost = :idpost");
        $query->execute($this->idpost);
        return $query->fetch()[0];
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
    public function getIdcomm()
    {
        return $this->idcomm;
    }

    /**
     * @param mixed $idcomm
     *
     * @return self
     */
    public function setIdcomm($idcomm)
    {
        $this->idcomm = $idcomm;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     *
     * @return self
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

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
}