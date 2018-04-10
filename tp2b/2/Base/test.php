<?php

require 'Conexion.php';

try{

	$pdo = Conexion::getPDO();

}catch (PDOException $e){
	echo $e->getMessage();
}catch (Throwable $e){
	echo $e->getMessage();
}


$sentencia = $pdo->query("Select * from Turnos");

while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
	print_r($row);
}
