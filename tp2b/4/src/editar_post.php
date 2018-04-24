<?php

require_once __DIR__ . "/classes/Post.php";

$idpost = "";
$error_imagen = "";
$resultado_post = "";

# Se apretó el botón "Publicar"
if (isset($_POST["publicar"])) {
	$title = "Editar post";
	
	# Guardar los datos
	$datos = [];
	foreach ($_POST as $key => $value) {
		$datos[$key] = $value;
		# Guardar el post
		$$key = htmlspecialchars($value);
	}

	$post = new Post();
	# Editar un post existente
	if (!empty($idpost)) {
		$post->setIdpost($idpost);
		$post->setAll($post->select());
	} else {
		$post->setIdpost(Post::getMaxId());
	}
	# Reemplazar con los datos ingresados
	$post->setAll($datos);
	
	$tempname = $_FILES["imagen_up"]["tmp_name"];
	
	if (!is_uploaded_file($tempname)) {
		# Si no se subió una imagen, mantener la anterior
		$imagen = $post->getImagen();
	} else {	
		# Si se subió una imagen
		
		# Numerar 001...999
		$idimg = $post->getIdpost();
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
		if (upload_img($filename, $tempname, $imagen, $imgtype, $error_imagen)) {
			if (empty($post->getImagen())) {
				# Si no tenía una imagen asociada, se agrega
				$post->setImagen($imagen);
			} else {
				# De otra forma, se elimina la anterior
				unlink($post->getImagen());
				$post->setImagen($imagen);
			}
		}
	}

	# Lo único que puede dar error es la subida de la imagen
	if ($error_imagen == "") {
		if (!empty($idpost)) {
			# Se está modificando un post
			$post->update();
		} else {
			# Se está agregando un post
			$post->insert();
		}
	} else {
		$resultado_post = "No se pudo publicar el post";
	}


# Se vino desde otra página
} else {

	if (!isset($_POST["idpost"])) {
		# Agregar un nuevo post
		$title = "Publicar post";
		$titulo = "";
		$cuerpo = "";
		$imagen = "";

	} else {
		# Editar un post existente
		$title = "Editar post";

		$post = new Post();
		$post->setIdpost($_POST["idpost"]);
		# Cargar los valores del post
		foreach ($post->select() as $key => $value) {
			$$key = $value;
		}
	}
}


function upload_img($filename, $tempname, $imagen, $imgtype, &$error_imagen) {

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

/*
$datos = [
		"titulo"=>"Mi otro título",
		"cuerpo"=>"Hola qué tal",
		"imagen"=>"",
		"tags"=>""
		];

$post = new Post();
$post->setAll($datos);
$post->insert();

*/