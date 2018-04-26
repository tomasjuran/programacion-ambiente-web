<?php

$error_imagen = "";
$resultado_post = "";

# Se apretó el botón "Publicar"
if (isset($_POST["publicar"])) {
	$title = "Editar post";
	require __DIR__ . "/src/guardar_post.php";
} 
# Se vino desde otra página
else {
	if (!isset($_POST["idpost"])) {
		# Agregar un nuevo post
		$title = "Publicar post";
		require __DIR__ . "/src/agregar_post.php";
	} else {
		# Editar un post existente
		$title = "Editar post";
		require __DIR__ . "/src/editar_post.php";
	}
}


require __DIR__ . "/src/views/cabeza.php";
require __DIR__ . "/src/views/vista_editar.php";
require __DIR__ . "/src/views/post.php";
require __DIR__ . "/src/views/pie.php";
