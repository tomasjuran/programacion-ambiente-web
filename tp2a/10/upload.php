<?php

# Devuelve un String con el resultado de lo ocurrido
function upload($filename, $tempname, $imagen, $thumbnail) {

    $width = 100;
    $height = 75;

    # Verificar el formato
    $imgtype = pathinfo($filename, PATHINFO_EXTENSION);
    if ($imgtype != "jpg" &&
        $imgtype != "jpeg" &&
        $imgtype != "png" &&
        $imgtype != "gif")
    {
        return "El archivo debe tener formato de imagen (.jpg, .jpeg, .png o .gif)";
    }

    # Verificar si es imagen
    if (!getimagesize($tempname)) {
        return "El archivo no es una imagen";
    }

    # Verificar si ya existe
    if (file_exists($imagen)) {
        return "El archivo ya existe";
    } 

    # Guardar la imagen
    move_uploaded_file($tempname, $imagen);

    # Crear el Thumbnail
    switch ($imgtype) {
        case "png":
            $res_img = imagecreatefrompng($imagen);
            $newimage = imagescale($res_img, $width, $height);
            imagepng($newimage, $thumbnail);
        break;

        case "gif":
            $res_img = imagecreatefromgif($imagen);
            $newimage = imagescale($res_img, $width, $height);
            imagegif($newimage, $thumbnail);
        break;

        default:
            $res_img = imagecreatefromjpeg($imagen);
            $newimage = imagescale($res_img, $width, $height);
            imagejpeg($newimage, $thumbnail);
        break;
    }

    return "La imagen se subió correctamente";
}

$mostrar_error = "";

if (isset($_FILES["imagen_up"])) {
    $filename = $_FILES["imagen_up"]["name"];
    $tempname = $_FILES["imagen_up"]["tmp_name"];

    $imgdir = "images/";
    $thumbdir = $imgdir . "thumbs/";

    $imagen = $imgdir . basename($filename);
    $thumbnail = $thumbdir . basename($filename);

    if (isset($_POST["enviar"])) {
        $mostrar_error = upload($filename, $tempname, $imagen, $thumbnail);
    }
}


require "index.php";