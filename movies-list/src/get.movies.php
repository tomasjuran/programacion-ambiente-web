<?php
require __DIR__ . '/classes/Pelicula.php';

$peliculaModel = new Pelicula();
$peliculas = $peliculaModel->selectAll();