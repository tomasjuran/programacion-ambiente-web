<?php

require __DIR__ . "/classes/Post.php";

$datos = ["idpost"=>1,
		"titulo"=>"Mi título",
		"cuerpo"=>"Hola qué tal",
		"fecha"=>date("r"),
		"imagen"=>"",
		"tags"=>""
		];

$post = new Post();
$post->setAll($datos);
$post->insert();
