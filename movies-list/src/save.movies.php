<?php
require __DIR__ . '/classes/Pelicula.php';

if (empty($_POST)) {
    throw new Exception("Operacion no permitida", 1);
}

$datosPersona = [
    "nombre" => $_POST['nombre'],
    "anio_estreno" => $_POST['anio_estreno'],
    "reparto" => isset($_POST['reparto']) && ! empty($_POST['reparto']) ? $_POST['reparto'] : null,
    "cartel" => isset($_FILES['cartel']) ? $_FILES['cartel']['tmp_name'] : null
];

$pelicula = new Pelicula();
$pelicula->setDatos($datosPersona);
$pelicula->insert();

header('Location: /index.php');
