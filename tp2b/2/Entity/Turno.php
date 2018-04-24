<?php
require '../../base/Conexion.php';
require '../Util/Util.php';
/**
* 
*/
class Turno                                                                                             
{
	private $Numero;
	private $Persona;
	private $fecha_hora;
	private $campos = ["Persona", "Fecha_hora"];
    /**
     * @return mixed
     */
    public function getNro()
    {
        return $this->Numero;
    }
    /**
     * @param mixed $nro
     *
     * @return self
     */
    public function setNro($nro)
    {
        $this->Numero = $nro;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getPersona()
    {
        return $this->Persona;
    }
    /**
     * @param mixed $persona
     *
     * @return self
     */
    public function setPersona($persona)
    {
        $this->Persona = $persona;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getFechaHora()
    {
        return $this->Fecha_hora;
    }
    /**
     * @param mixed $fecha_hora
     *
     * @return self
     */
    public function setFechaHora($fecha, $hora)
    {
        $this->Fecha_hora = Util::format_date_Y_mm_dd($fecha) . " " . $hora;
        return $this;
    }
    public function guardar()
    {
    	$campos = $this->getCampos();
    	try {
    		//$this->persona->guardar();
    		$pdo = Conexion::getPDO();
    		$st = "INSERT INTO Turnos ($campos) VALUES ('".$this->Persona->getDocumento()."', '".$this->Fecha_hora."')";
    		echo $st . "\n";
    		$query = $pdo->prepare($st);
    		if($query->execute()){
    			return true;
    		}else{
    			echo $query->errorCode();
    			throw new Exception("Error Processing Request", 1);
    			
    		}
    	} catch (Exception $e) {
    		return false;
    		
    	}
    }
    public function getCampos() {
        return join(',', $this->campos);
    }
}