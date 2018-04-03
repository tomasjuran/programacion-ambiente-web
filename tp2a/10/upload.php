<?php
	$archivo = $_FILES['foto']['name'];
	$filename = "imagenes/thumbs/" . $archivo;
	copy($_FILES['foto']['tmp_name'],"imagenes/".$archivo);
	copy("imagenes/".$archivo, $filename);
	$info = getimagesize($filename);
	$extension = image_type_to_extension($info[2]);
	$res = false;
    switch ($extension) {
        case '.jpeg':
        	$image = imagecreatefromjpeg($filename);
            $newimage = imagescale($image, 100, 75);
    		imagejpeg($newimage, $filename);
            $res = true;
    	break;

        case '.jpg':
            $image = imagecreatefromjpeg($filename);
            $newimage = imagescale($image, 100, 75);
    		imagejpeg($newimage, $filename);
            $res = true;
        break;

        case '.png':
            $image = imagecreatefrompng($filename);
            $newimage = imagescale($image, 100, 75);
            imagepng($newimage, $filename);
            $res = true;
        break;

        case '.gif':
            $image = imagecreatefromgif($filename);
            $newimage = imagescale($image, 100, 75);
            imagegif($newimage, $filename);
            $res = true;
        break;
    };

    require 'vista.php';
    
    