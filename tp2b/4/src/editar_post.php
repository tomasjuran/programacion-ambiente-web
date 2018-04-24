<?php

require __DIR__ . "/classes/Post.php";


$datos = [
		"titulo"=>"Mi otro título",
		"cuerpo"=>"Hola qué tal",
		"imagen"=>"",
		"tags"=>""
		];

$post = new Post();
$post->setAll($datos);
$post->insert();