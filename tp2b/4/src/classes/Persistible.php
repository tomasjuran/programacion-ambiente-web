<?php

require_once __DIR__ . "/../../../base/Conexion.php";

abstract class Persistible {

	protected $tabla = "";
	protected $claves = [];
	protected $campos = [];

	abstract protected function getCampo($campo);

	public function select() {
		$where = $this->getWhere();
		$pdo = Conexion::getPDO();
		$query = $pdo->prepare("SELECT * FROM ".$this->tabla." $where");
		$query->execute($this->getKeys());
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert() {
		$cols = $this->getCols();
		$vals = $this->getVals();

		$pdo = Conexion::getPDO();
		$query = $pdo->prepare("INSERT INTO ".$this->tabla." ($cols) VALUES ($vals)");
		$query->execute($this->getValues());
	}

	public function update() {
		$set = $this->getSet();
		$where = $this->getWhere();

		$pdo = Conexion::getPDO();
		$query = $pdo->prepare("UPDATE " .$this->tabla." $set $where");
		$query->execute(array_merge($this->getValues(),$this->getKeys()));
	}

	public function delete() {
		$where = $this->getWhere();
		$pdo = Conexion::getPDO();
		$query = $pdo->prepare("DELETE FROM ".$this->tabla." $where");
		$query->execute($this->getKeys());
	}

	/**
	  * Devuelve el string "SET campo1 = :campo1, campo2 = campo2"
	  * @return type
	  */
	protected function getSet() {
		$campoConDatos = [];
		foreach ($this->campos as $campo) {
			if ($this->getCampo($campo)) {
				$campoConDatos[] = $campo;
			}
		}
		$set = "";
		if ($campoConDatos) {
			$set = "SET " . $campoConDatos[0] . " = :" . $campoConDatos[0];
			for ($i = 1; $i < count($campoConDatos); $i++) {
				$set .= ", " . $campoConDatos[$i] . "= :" . $campoConDatos[$i];
			}
		}
		return $set;
	}

	/**
	 * Devuelve el string "WHERE id1 = :id1, id2 = :id2"
	 * @return type
	 */
	protected function getWhere() {
		$claveConDatos = [];
		foreach ($this->claves as $clave) {
			if ($this->getCampo($clave)) {
				$claveConDatos[] = $clave;
			}
		}
		$where = "";
		if ($claveConDatos) {
			$where = "WHERE " . $claveConDatos[0] . " = :" . $claveConDatos[0];
			for ($i = 1; $i < count($claveConDatos); $i++) {
				$where .= "AND " . $claveConDatos[$i] . " = :" . $claveConDatos[$i];
			}	
		}
		
		return $where;
	}

	/**
	 * Devuelve los campos en un String separados por coma 
	 * @return String
	 */
	protected function getCols() {
		$campoConDatos = [];
		foreach ($this->campos as $campo) {
			if ($this->getCampo($campo)) {
				$campoConDatos[] = $campo;
			}
		}
		return implode(",", $campoConDatos);
	}

	/**
	 * Devuelve un String listo para ser usado en una query PDO
	 * ":campo1, :campo2, :campo3"
	 * @return type
	 */
	protected function getVals() {
		$campoConDatos = [];
		foreach ($this->campos as $campo) {
			if ($this->getCampo($campo)) {
				$campoConDatos[] = $campo;
			}
		}
		return ":".implode(", :", $campoConDatos);
	}

	/**
	 * Devuelve un array asociativo, tal que $data[":campo" => campo]
	 * @return type
	 */
	protected function getValues() {
		$data = [];
		foreach ($this->campos as $campo) {
			if ($this->getCampo($campo)) {
				$data[":".$campo] = $this->getCampo($campo);
			}
		}
		return $data;
	}

	/**
	 * Devuelve un array asociativo, tal que $keys[":key" => key]
	 * @return type
	 */
	protected function getKeys() {
		$keys = [];
		foreach ($this->claves as $clave) {
			if ($this->getCampo($clave)) {
				$keys[":".$clave] = $this->getCampo($clave);
			}
		}
		return $keys;
	}
}