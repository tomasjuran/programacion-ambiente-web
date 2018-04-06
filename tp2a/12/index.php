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

$result = $blog->xpath("//post");
foreach ($result as $key => $post) {
	echo "
<article>
	<h2></h2>
	<p></p>
	<img src=\"" . $post->imagen . "\" alt=\"\">
	<form action=\"\" method=\"post\">
		<input type=\"hidden\">
		<input type=\"submit\">
	</form>
	<form action=\"\" method=\"post\">
		<input type=\"submit\">
</article>
";

}

require "pie.php";