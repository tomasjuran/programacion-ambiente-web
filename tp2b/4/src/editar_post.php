<?php

require_once __DIR__ . "/classes/Post.php";

# Editar un post existente
$title = "Editar post";
$post = new Post();
$post->setIdpost($_POST["idpost"]);

# Cargar los valores del post
foreach ($post->select()[0] as $key => $value) {
	$$key = $value;
}

