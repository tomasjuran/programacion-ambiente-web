<?php
/*
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/

$xml_path = "blog.xml";

$accion = "editar_post.php";

$error_imagen = "";
$resultado_post = "";

if (file_exists($xml_path)) {
	$blog = simplexml_load_file($xml_path);
} else {
	exit("No se encuentra el archivo con los posts.");
}

# Se apretó el botón "Publicar"
if (isset($_POST["publicar"])) {
	$title = "Editar post";
	# Guardar el post
	foreach ($_POST as $key => $value)
		if (isset($_POST[$key])) {
			$$key = htmlspecialchars($value);
		}

	# Buscar el ID para saber si modificar o agregar
	$post = $blog->xpath("//post[idpost=$idpost]");
	if (empty($post)) {
		$post = $blog->addchild("post");
		$post->addchild("idpost", $idpost);
		$post->addchild("titulo", $titulo);
		$post->addchild("cuerpo", $cuerpo);
	} else {
		$post[0]->idpost = $idpost;
		$post[0]->titulo = $titulo;
		$post[0]->cuerpo = $cuerpo;
	}

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
			
			if (empty($post[0]->xpath("//imagen"))) {
				# Si no tenía una imagen asociada, se agrega
				$post[0]->addchild("imagen", $imagen);
			} else {
				# De otra forma, se elimina la anterior
				unlink($post[0]->imagen);
				$post[0]->imagen = $imagen;
			}
		}
	}

	# Lo único que puede dar error es la subida de la imagen
	if ($error_imagen == "") {
		$blog->asXML($xml_path);
		$resultado_post = "El post se publicó correctamente";
	} else {
		$resultado_post = "No se pudo publicar el post";
	}

# Se vino desde otra página
} else {

	if (!isset($_POST["idpost"])) {
		# Agregar un nuevo post
		$title = "Publicar post";
		# El último ID + 1
		if ($blog->count() < 1) {
			$idpost = 0;
		} else {
			$idpost = $blog->post[$blog->count()-1]->idpost + 1;
		}

		$titulo = "";
		$cuerpo = "";
		$imagen = "";

	} else {
		# Editar un post existente
		$title = "Editar post";
		$idpost = $_POST["idpost"];
		$idpost = 1;
		
		$post = $blog->xpath("//post[idpost=$idpost]");

		# Cargar los valores del post
		foreach ($post[0]->children() as $elemento) {
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

echo "<section>";

if ($resultado_post != "") {
	echo "<p>" . $resultado_post . "</p>";
}

if ($error_imagen != "") {
	echo "<p>Error al subir la imagen</p>";
	echo "<p>" . $error_imagen . "</p>";
}


echo "</section>";

require "post.php";

require "pie.php";
