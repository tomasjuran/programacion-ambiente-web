<?php

require __DIR__ . "/classes/Post.php";

$postModel = new Post();
$posts = $postModel->selectAll();

print_r($posts);