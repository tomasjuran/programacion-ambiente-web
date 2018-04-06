<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = "Modificar post";
$accion = "modificar_post.php";
$titulo = "";
$cuerpo = "";
$fecha = date("r");

require "cabeza.html";



require "post.html";

echo "<p>" . $fecha . "</p>";

$blog = simplexml_load_file("blog.xml");

echo $blog->asXML();

require "pie.html";
