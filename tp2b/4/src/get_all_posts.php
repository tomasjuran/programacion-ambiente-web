<?php

require_once __DIR__ . "/classes/Post.php";
require_once __DIR__ . "/classes/Comentario.php";

$postModel = new Post();
$posts = $postModel->select();

/* Para la próxima, el select devuelve una lista de objetos */
for ($i = 0; $i < count($posts); $i++) {
	$comentarioModel = new Comentario();
    $comentarioModel->setIdpost($posts[$i]["idpost"]);
    $posts[$i]["comentarios"] = $comentarioModel->select();
}

$q_posts = count($posts);