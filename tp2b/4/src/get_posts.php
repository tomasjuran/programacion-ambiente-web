<?php

require_once __DIR__ . "/classes/Post.php";

$postModel = new Post();
$posts = $postModel->selectAll();
$q_posts = count($posts);