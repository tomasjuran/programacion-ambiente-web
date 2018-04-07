<?php

$xml_path = "blog.xml";
$title = "Mi primer blog";

if (file_exists($xml_path)) {
	$blog = simplexml_load_file($xml_path);
} else {
	exit("No se encuentra el archivo con los posts");
}

$resultado_eliminar = "";

# Eliminar un post
if (isset($_POST["eliminar"])) {
	if (!isset($_POST["idpost"])) {
		$resultado_eliminar = "Hubo un error al eliminar el post";
	} else {
		$idpost = $_POST["idpost"];
		$post = $blog->xpath("//post[idpost=$idpost]");
		unlink($post[0]->imagen);
		$dom = dom_import_simplexml($post[0]);
    	$dom->parentNode->removeChild($dom);
    	$blog->asXML($xml_path);
    	$resultado_eliminar = "El post se eliminó correctamente";
	}
}

$q_posts = $blog->count();

$posts = $blog->xpath("//post");

require "cabeza.php";

require "vista_index.php";

require "pie.php";