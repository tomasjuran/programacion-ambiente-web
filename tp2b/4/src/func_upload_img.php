<?php

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