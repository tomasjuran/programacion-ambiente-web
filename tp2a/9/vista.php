<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ejercicio 9</title>
</head>
<body>
	<header><h1>Ejercicio 9</h1></header>
	<section>
		<article>
			<h5>Formulario con Get</h5>
			<form action="index.php" method="Get">
				<label for="Titulo">Titulo</label>
				<input type="text" id="Titulo" name="tituloG" value="<?=$tituloG?>">
				<br>
				<label for="Nombre">Nombre completo</label>
				<input type="text" id="Nombre" name="nombreG" value="<?=$nombreG?>">
				<br>
				<label for="Email">Email</label>
				<input type="email" id="EMail" name="emailG" value="<?=$emailG?>">
				<br>
				<label for="Telefono">Telefono</label>
				<input type="tel" id="Telefono" name="telefonoG" value="<?=$telefonoG?>">
				<br>
				<label for="Edad">Edad</label>
				<input type="number" id="Edad" name="edadG" value="<?= $edadG?>">
				<br>
				<label for="Talla">Talla</label>
				<input type="number" id="Talla" name="tallaG" min="20" max="56" value="<?= $tallaG?>">
				<br>
				<label for="Altura">Altura (cm)</label>
				<input type="number" id="Altura" name="alturaG" min="0" max="300" value="<?=$alturaG?>">
				<br>
				<label for="Nacimiento">Fecha de Nacimiento</label>
				<input type="date" id="Nacimiento" name="fechaG" value="<?= $fechaG?>">
				<br>
				<label for="pelo">Color de pelo</label>
				<input type="text" id="pelo" name="colG" value="<?=$colG?>">
				<br>
				<label for="turno">Horario del turno</label>
				<input type="time" id="turno" name="horaG" min="08:00:00" max="17:00:00" step="900" value="<?=$horaG?>">
				<br>
				<input type="submit" name="Aceptar" value="Aceptar">
				<input type="reset" name="Limpiar" value="Limpiar"> 
			</form>	
		</article>
		<article>
			<h5>Formulario con post</h5>
			<form action="index.php" method="post">
				<label for="Titulo">Titulo</label>
				<input type="text" id="Titulo" name="tituloP" value="<?=$tituloP?>">
				<br>
				<label for="Nombre">Nombre completo</label>
				<input type="text" id="Nombre" name="nombreP" value="<?=$nombreP?>">
				<br>
				<label for="Email">Email</label>
				<input type="email" id="EMail" name="emailP" value="<?=$emailP?>">
				<br>
				<label for="Telefono">Telefono</label>
				<input type="tel" id="Telefono" name="telefonoP" value="<?= $telefonoP?>">
				<br>
				<label for="Edad">Edad</label>
				<input type="number" id="Edad" name="edadP" value="<?= $edadP?>">
				<br>
				<label for="Talla">Talla</label>
				<input type="number" id="Talla" name="tallaP" min="20" max="56" value="<?= $tallaP?>">
				<br>
				<label for="Altura">Altura (cm)</label>
				<input type="number" id="Altura" name="alturaP" min="0" max="300" value="<?=$alturaP?>">
				<br>
				<label for="Nacimiento">Fecha de Nacimiento</label>
				<input type="date" id="Nacimiento" name="fechaP" value="<?=$fechaP?>">
				<br>
				<label for="Pelo">Color de pelo</label>
				<input type="text" id="Pelo" name="colP" value="<?=$colP?>">
				<br>
				<label for="turno">Horario del turno</label>
				<input type="time" id="turno" name="horaP" min="08:00:00" max="17:00:00" step="900" value="<?=$horaP?>">
				<br>
				<input type="submit" name="Aceptar" value="Aceptar">
				<input type="reset" name="Limpiar" value="Limpiar"> 
			</form>	
		</article>
		
	</section>
</body>
</html>