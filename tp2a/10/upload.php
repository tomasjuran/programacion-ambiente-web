<?php
if (isset($_POST["enviar"])) {

    $width = 100;
    $height = 75;

    $filename = $_FILES["imagen_up"]["name"];
    $tempname = $_FILES["imagen_up"]["tmp_name"];

    $imgdir = "images/";
    $thumbdir = $imgdir . "thumbs/";

    $imagen = $imgdir . basename($filename);
    $thumbnail = $thumbdir . basename($filename);

    # Verificar si ya existe
    if (file_exists($imagen)) {

    }

    # Verificar el formato
    $imgtype = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
    if ($imgtype != "jpg" &&
        $imgtype != "jpeg" &&
        $imgtype != "png" &&
        $imgtype != "gif")
    {
        
    }

    # Verificar si es imagen
    if (!getimagesize($tempname)) {
        
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

}

require "index.php";