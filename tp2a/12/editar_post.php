<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

$accion = "editar_post.php";

$blog = simplexml_load_file("blog.xml");

if (isset($_POST["publicar"])) {
	# Guardar el post
	foreach ($_POST as $key => $value)
		if (isset($_POST[$key])) {
			$$key = htmlspecialchars($value);
		}

	$post = $blog->addchild("post");
	$post->addchild("idpost", $idpost);
	$post->addchild("titulo", $titulo);
	$post->addchild("cuerpo", $cuerpo);
	
	$error_imagen = "";
	$tempname = $_FILES["imagen_up"]["tmp_name"];
	# Si se subió una imagen
	if (is_uploaded_file($tempname)) {
		
		# Numerar 001...999
		$idimg = $idpost;
		if ((int) $idimg < 100) {
			$idimg = "0" . $idimg;
			if ((int) $idimg < 10) {
				$idimg = "0" . $idimg;
			}
		}

		$filename = $_FILES["imagen_up"]["name"];
		$imgtype = pathinfo($filename, PATHINFO_EXTENSION);
		$imagen = "images/img" . $idimg . "." . $imgtype;
		
		# Si se guardó correctamente
		if (upload_img($filename, $tempname, $imagen, $imgtype)){
			$post->addchild("imagen", $imagen);
		}
	} else {
		# No se subió ninguna imagen
		$post->addchild("imagen", "");
	}

	if ($error_imagen != "") {
		$blog->asXML("blog.xml");
	}

} else {

	if (!isset($_POST["idpost"])) {
		# Agregar un nuevo post
		$title = "Publicar post";
		# El último ID + 1
		if ($blog->count() < 1) {
			$idpost = 0;
		} else {
			$idpost = $blog->post[$blog->count()-1]->id + 1;
		}

		$titulo = "";
		$cuerpo = "";
		$imagen = "";

	} else {
		# Editar un post existente
		$title = "Editar post";
		$idpost = $_POST["idpost"];
		$idpost = 1;
		
		$result = $blog->xpath("//post[idpost=$idpost]");

		foreach ($result[0]->children() as $elemento) {
			${$elemento->getname()} = $elemento;
		}

	}

}

function upload_img($filename, $tempname, $imagen, $imgtype) {

	global $error_imagen;

    # Verificar el formato
    if ($imgtype != "jpg" &&
        $imgtype != "jpeg" &&
        $imgtype != "png" &&
        $imgtype != "gif")
    {
    	$error_imagen = "El archivo debe tener formato de imagen (.jpg, .jpeg, .png o .gif)";
        return false;
    }

    # Verificar si es imagen
    if (!getimagesize($tempname)) {
    	$error_imagen = "El archivo no es una imagen";
        return false;
    }

    # Guardar la imagen
    move_uploaded_file($tempname, $imagen);

    return true;
}


require "cabeza.php";

require "post.php";

require "pie.php";
