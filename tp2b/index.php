<?php
$params = [
	"host" => "localhost",
	"user" => "root",
	"pwd"  => "",
	"db"   => "movies"
];

try {
	$dsn = "mysql:host=" . $params["host"] . ";dbname=" . $params["db"];

	$pdo = new PDO($dsn, $params["user"], $params["pwd"]);

} catch (PDOException $e) {
	echo $e->getMessage();
} catch (Throwable $e) {
	echo $e->getMessage();
}

$sentencia = $pdo->query("SELECT * FROM peliculas");

#while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
#	print_r($row);
#}