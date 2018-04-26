<?php

require_once __DIR__ . "/classes/Post.php";
require_once __DIR__ . "/func_upload_img.php";

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
	$post->setAll($post->select()[0]);
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
	$idimg = $post->getIdpost() ? $post->getIdpost() : Post::getMaxId() + 1;
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
	$resultado_post = "El post se publicó correctamente";
} else {
	$resultado_post = "No se pudo publicar el post";
}

