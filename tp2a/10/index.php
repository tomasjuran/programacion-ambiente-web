<!DOCTYPE html>
<html>
<head>
	<title>Ejercicio 10</title>
</head>
<body>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<label for="imagen_up">Seleccionar una foto:</label>
		<input type="file" id="imagen_up" name="imagen_up">
		<input type="submit" name="enviar" value="Enviar">
	</form>
	<img src="<?=${imagen}?>" alt="Imagen">
	<img src="<?=${thumbnail}?>" alt="Thumbnail">
</body>
</html>