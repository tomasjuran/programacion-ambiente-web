<?php

/**
* 
*/
class Persona
{
	private $Documento;
	private $Titulo;
	private $Nombre;
	private $Email;
	private $Edad;
	private $Talla;
	private $Altura;
	private $Fecha_nacimiento;
	private $Color_pelo;
	private $campos = ["Documento", "Titulo", "Nombre", "Email", "Edad", "Talla", "Altura", "Fecha_nacimiento", "Color_pelo"];
	
    /**
     * @return mixed
     */
    public function getDocumento()
    {
        return $this->Documento;
    }

    /**
     * @param mixed $Documento
     *
     * @return self
     */
    public function setDocumento($Documento)
    {
        $this->Documento = $Documento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->Titulo;
    }

    /**
     * @param mixed $Titulo
     *
     * @return self
     */
    public function setTitulo($Titulo)
    {
        $this->Titulo = $Titulo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * @param mixed $Nombre
     *
     * @return self
     */
    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param mixed $Email
     *
     * @return self
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEdad()
    {
        return $this->Edad;
    }

    /**
     * @param mixed $Edad
     *
     * @return self
     */
    public function setEdad($Edad)
    {
        $this->Edad = $Edad;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTalla()
    {
        return $this->Talla;
    }

    /**
     * @param mixed $Talla
     *
     * @return self
     */
    public function setTalla($Talla)
    {
        $this->Talla = $Talla;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAltura()
    {
        return $this->Altura;
    }

    /**
     * @param mixed $Altura
     *
     * @return self
     */
    public function setAltura($Altura)
    {
        $this->Altura = $Altura;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaNacimiento()
    {
        return $this->Fecha_nacimiento;
    }

    /**
     * @param mixed $Fecha_nacimiento
     *
     * @return self
     */
    public function setFechaNacimiento($Fecha_nacimiento)
    {
        $this->Fecha_nacimiento = $Fecha_nacimiento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getColorPelo()
    {
        return $this->Color_pelo;
    }

    /**
     * @param mixed $Color_pelo
     *
     * @return self
     */
    public function setColorPelo($Color_pelo)
    {
        $this->Color_pelo = $Color_pelo;

        return $this;
    }


    public function guardar()
    {
        $campos = $this->getCampos();
        try {
            $pdo = $Conexion::getPDO();
            $valoresParametrizados = $this->getValoresParametrizadosPDO();
            $query = $pdo->prepare("INSERT INTO Turnos ($campos) VALUES ($valoresParametrizados)");
            $query->execute($this->getValues());
            return true;
        } catch (Exception $e) {
            
            
        }
    }

    public function getCampos() {
        return join(',', $this->campos);
    }

    public function getValoresParametrizadosPDO()
    {
        return implode(',', array_fill(0, count($this->campos), '?')); // Retorna el values parametrizado para PDO
    }

    public function getValues()
    {
        $data = [];
        foreach ($this->campos as $campo) {
            $data[] = $this->$campo;
        }
        return $data;
    }
}