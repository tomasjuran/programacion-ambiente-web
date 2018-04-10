<?php

require 'Turno.php';


$t = new Turno();
$t->setnro(1);
$t->setPersona('40455634');
$t->setFechaHora('11-04-2018', '16:00');
if($t->guardar()){
	echo "ok";
}else{
	echo "no ok";
}

