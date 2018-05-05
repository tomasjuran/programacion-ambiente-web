<?php

require_once __DIR__ . "/../../../base/Conexion.php";

abstract class Persistible {

	protected $tabla = "";
	protected $claves = [];
	protected $campos = [];

	abstract protected function getCampo($campo);

	public function select() {
		$where = $this->getWhere(false);
		$pdo = Conexion::getPDO();
		$query = $pdo->prepare("SELECT * FROM ".$this->tabla." $where");
		$query->execute($this->getValues());
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
		$where = $this->getWhere(true);

		$pdo = Conexion::getPDO();
		$query = $pdo->prepare("UPDATE " .$this->tabla." $set $where");
		$query->execute(array_merge($this->getValues(),$this->getKeys()));
	}

	public function delete() {
		$where = $this->getWhere(true);
		$pdo = Conexion::getPDO();
		$query = $pdo->prepare("DELETE FROM ".$this->tabla." $where");
		$query->execute($this->getKeys());
	}

	/**
	  * Devuelve el string "SET campo1 = :campo1, campo2 = campo2"
	  * @return type
	  */
	protected function getSet() {
		return $this->fieldIterator("SET ", ", ", false);
	}

	/**
	 * Devuelve el string "WHERE campo1 = :campo1, campo2 = :campo2"
	 * @return type
	 */
	protected function getWhere($keysonly) {
		return $this->fieldIterator("WHERE ", " AND ", $keysonly);
	}

	/**
	 * Arma un string iterando sobre los campos que contienen datos.
	 * Utilizado para armar WHERE y SET
	 * @return string El string armado
	 */
	protected function fieldIterator($first, $separator, $keysonly) {
		if ($keysonly) {
			$camposConDatos = $this->getClavesConDatos();
		} else {
			$camposConDatos = $this->getCamposConDatos();
		}
		$string = "";
		$b = true;
		foreach ($camposConDatos as $campo) {
			if ($b) {
				$string = $first;
				$b = false;
			} else {
				$string .= $separator;
			}
			$string .= $campo . " = :" . $campo;
		}
		return $string;
	}

	/**
	 * Devuelve un Array con los nombres de los campos que contienen datos
	 * para las funciones getWhere y getSet
	 * @return Array
	 */
	protected function getCamposConDatos() {
		$camposConDatos = [];
		foreach ($this->campos as $campo) {
			if ($this->getCampo($campo)) {
				$camposConDatos[] = $campo;
			}
		}
		return $camposConDatos;
	}

		/**
	 * Devuelve un Array con los nombres de las claves que contienen datos
	 * para la función getWhere
	 * @return Array
	 */
	protected function getClavesConDatos() {
		$clavesConDatos = [];
		foreach ($this->claves as $clave) {
			if ($this->getCampo($clave)) {
				$clavesConDatos[] = $clave;
			}
		}
		return $clavesConDatos;
	}

	/**
	 * Devuelve los campos en un String separados por coma 
	 * @return String
	 */
	protected function getCols() {
		return implode(", ", $this->getCamposConDatos());
	}

	/**
	 * Devuelve un String listo para ser usado en una query PDO
	 * ":campo1, :campo2, :campo3"
	 * @return type
	 */
	protected function getVals() {
		return ":".implode(", :", $this->getCamposConDatos());
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
	 * Devuelve un array asociativo, tal que $data[":id" => id]
	 * @return type
	 */
	protected function getKeys() {
		$data = [];
		foreach ($this->claves as $clave) {
			if ($this->getCampo($clave)) {
				$data[":".$clave] = $this->getCampo($clave);
			}
		}
		return $data;
	}
}