<?php

$xml_path = "blog.xml";
$title = "Mi primer blog";

if (file_exists($xml_path)) {
	$blog = simplexml_load_file($xml_path);
} else {
	exit("No se encuentra el archivo con los posts.");
}

$q_posts = $blog->count();

require "cabeza.php";

require "header_index.php";

require "pie.php";