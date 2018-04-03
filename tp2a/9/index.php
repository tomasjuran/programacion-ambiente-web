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
	if (isset($_GET[$key])) {
		$$key = $_GET[$key];
	}
}

foreach ($_POST as $key => $value) {
	if (isset($_POST[$key])) {
		$$key = $_POST[$key];
	}
}

/*

if (isset($_GET['Nombre'])){
	$nombreG = $_GET['Nombre'];
}
if (isset($_GET['Titulo'])) {
	$tituloG = $_GET['Titulo'];
}
if (isset($_GET['Email'])){
	$emailG = $_GET['Email'];
}
if (isset($_GET['Telefono'])) {
	$telefonoG = $_GET['Telefono'];
}
if (isset($_GET['Edad'])) {
	$edadG = $_GET['Edad'];
}
if (isset($_GET['Talla'])) {
	$tallaG = $_GET['Talla'];
}
if (isset($_GET['Altura'])) {
	$alturaG = $_GET['Altura'];
}
if (isset($_GET['Fecha'])) {
	$fechaG = $_GET['Fecha'];
}
if (isset($_GET['Pelo'])) {
	$colG = $_GET['Pelo'];
}
if (isset($_GET['Turno'])) {
	$horaG = $_GET['Turno'];
}

if (isset($_POST['Nombre'])){
	$nombreP = $_POST['Nombre'];
}
if (isset($_POST['Titulo'])) {
	$tituloP = $_POST['Titulo'];
}
if (isset($_POST['Email'])){
	$emailP = $_POST['Email'];
}
if (isset($_POST['Telefono'])) {
	$telefonoP = $_POST['Telefono'];
}
if (isset($_POST['Edad'])) {
	$edadP = $_POST['Edad'];
}
if (isset($_POST['Talla'])) {
	$tallaP = $_POST['Talla'];
}
if (isset($_POST['Altura'])) {
	$alturaP = $_POST['Altura'];
}
if (isset($_POST['Fecha'])) {
	$fechaP = $_POST['Fecha'];
}
if (isset($_POST['Pelo'])) {
	$colP = $_POST['Pelo'];
}
if (isset($_POST['Turno'])) {
	$horaP = $_POST['Turno'];
}

*/

require 'vista.php';