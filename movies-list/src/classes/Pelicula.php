<?php
require __DIR__ . '/../core/PdoFactory.php';

/**
* Representa una pelicula
*/
class Pelicula
{

    private $nombre;
    private $anio_estreno;
    private $reparto;
    private $cartel;
    private $campos = ['nombre', 'anio_estreno', 'reparto', 'cartel'];

    public function selectAll()
    {
        $pdo = PdoFactory::build();
        $query = $pdo->prepare("SELECT * FROM peliculas");
        $query->execute();
        return $query->fetchAll();
    }

    public function setDatos($datos)
    {
        //$nombre, $anio_estreno, $reparto = null, $cartel = null
        if (is_null($datos['nombre']) || is_null($datos['anio_estreno'])) {
            throw new Exception("Nombre y Fecha de Estreno son obligatorios", 1);
        }

        foreach ($this->campos as $campo) {
            $this->$campo = $datos[$campo];
        }
    }

    public function insert()
    {
        $campos = $this->getCampos();
        $pdoString = $this->getValoresParametrizadosPDO();
        $pdo = PdoFactory::build();
        $query = $pdo->prepare("INSERT INTO peliculas ($campos) VALUES ($pdoString)");
        $query->execute($this->getValues());
    }

    public function update()
    {
        $campos = $this->getCampos();
        $pdoString = $this->getValoresParametrizadosPDO();
        $pdo = PdoFactory::build();
        $string = 
        $query = $pdo->prepare("UPDATE peliculas SET $campos) VALUES ($pdoString)");
        $query->execute($this->getValues());
    }

    public function getCampos() {
        return join(',', $this->campos);
    }

    /**
     * Retorna un string '?, ?, ?...' listo para ser usado en una query PDO
     *
     * @return [type] [description]
     */
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
