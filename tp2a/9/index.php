<?php
//A continuacion se definen las variables para metodo get y sus valores por defecto
$tituloG = "";
$nombreG = "";
$emailG = "";
$telefonoG = "";
$edadG = 10;
$tallaG = 20;
$alturaG = 100;
$fechaG = date("Y-m-d");
$colG = "";
$horaG = "08:00";

//A continuacion se definen las variables para metodo post y sus valores por defecto
$tituloP = "";
$nombreP = "";
$emailP = "";
$telefonoP = "";
$edadP = 10;
$tallaP = 20;
$alturaP = 100;
$fechaP = date("Y-m-d");
$colP = "";
$horaP = "08:00";

foreach ($_GET as $key => $value) {
	$$key = htmlspecialchars($_GET[$key]);
}

foreach ($_POST as $key => $value) {
	$$key = htmlspecialchars($_POST[$key]);
}

require 'vista.php';