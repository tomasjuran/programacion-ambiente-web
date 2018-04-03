<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ejercicio 8</title>
</head>
<body>
	<header><h1>Ejercicio 8</h1></header>
	<section>
		<form action="index.php" method="post" oninput="valor.value = Altura.valueAsNumber">
			<label for="Titulo">Titulo</label>
			<input type="text" name="Titulo" id="Titulo"><br>
			<label for="Nombre">Nombre completo</label>
			<input type="text" id="Nombre" name="Nombre"><br>
			<label for="Email">Email</label>
			<input type="email" id="EMail" name="EMail"><br>
			<label for="Telefono">Telefono</label>
			<input type="text" id="Telefono" name="Telefono"><br>
			<label for="Edad">Edad</label>
			<input type="number" id="Edad" name="Edad"><br>
			<label for="Talla">Talla</label>
			<input type="number" id="Talla" name="Talla" min="20" max="45"><br>
			<label for="Altura">Altura</label>
			<input type="range" id="Altura" value="100" name="Altura" name="alt" min="100" max="220" step="1">
			<output for="Altura" name="valor">100</output>cm<br>
			<label for="Nacimiento">Fecha de Nacimiento</label>
			<input type="date" id="Nacimiento" name="Nacimiento"><br>
			<label for="pelo">Color de pelo</label>
			<input type="text" id="pelo" name="Pelo"><br>
			<label for="turno">Horio del turno</label>
			<input name="turno" id="turno" type="time" min="08:00:00" max="17:00:00" step="900" value=<?= ${horap}?>>
			<br>
			<input type="submit" name="Aceptar" value="Aceptar">
			<input type="reset" name="Limpiar" value="Limpiar"> 
		</form>
	</section>
</body>
</html>