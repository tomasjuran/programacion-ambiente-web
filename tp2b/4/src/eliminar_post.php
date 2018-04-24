<?php

require_once __DIR__ . "/classes/Post.php";

$resultado_eliminar = "";

# Eliminar un post
if (isset($_POST["eliminar"])) {
	if (!isset($_POST["idpost"])) {
		$resultado_eliminar = "Hubo un error al eliminar el post";
	} else {
		$post = new Post();
		$post->setIdpost($_POST["idpost"]);
		$post->setAll($post->select());
		unlink($post->getImagen());
		$post->delete();
		$resultado_eliminar = "El post se eliminó correctamente";
	}
}