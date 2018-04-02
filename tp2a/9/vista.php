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
			<form action="index.php" method="Get" oninput="valor.value = Altura.valueAsNumber">
				<label for="Titulo">Titulo</label>
				<input type="text" name="Titulo" id="Titulo" value=<?= ${tituloG}?>><br>
				<label for="Nombre">Nombre completo</label>
				<input type="text" id="Nombre" name="Nombre" value=<?= ${nombreG}?>><br>
				<label for="Email">Email</label>
				<input type="email" id="EMail" name="EMail" value=<?= ${emailG}?>><br>
				<label for="Telefono">Telefono</label>
				<input type="tel" id="Telefono" name="Telefono" value=<?= ${telefonoG}?>><br>
				<label for="Edad">Edad</label>
				<input type="number" id="Edad" name="Edad" value=<?= ${edadG}?>><br>
				<label for="Talla">Talla</label>
				<input type="number" id="Talla" name="Talla" min="20" max="45" value=<?= ${tallaG}?>><br>
				<label for="Altura">Altura</label>
				<input type="range" id="Altura" value="100" name="Altura" name="alt" min="100" max="220" step="1" value=<?=$alturaG?>>
				<output for="Altura" name="valor"><?=$alturaG?></output>cm<br>
				<label for="Nacimiento">Fecha de Nacimiento</label>
				<input type="date" id="Nacimiento" name="Nacimiento" value=<?= ${fechaG}?>><br>
				<label for="pelo">Color de pelo</label>
				<input type="text" id="pelo" name="Pelo" value=<?= ${colG}?>><br>
				<label for="turno">Horario del turno</label>
				<input name="turno" id="turno" type="time" min="08:00:00" max="17:00:00" step="900" value=<?= ${horaG} ?>>
				<br>
				<input type="submit" name="Aceptar" value="Aceptar">
				<input type="reset" name="Limpiar" value="Limpiar"> 
			</form>	
		</article>
		<article>
			<h5>Formulario con post</h5>
			<form action="index.php" method="post" oninput="valor.value = Altura.valueAsNumber">
				<label for="Titulo">Titulo</label>
				<input type="text" name="Titulo" id="Titulo" value=<?= ${tituloP}?>><br>
				<label for="Nombre">Nombre completo</label>
				<input type="text" id="Nombre" name="Nombre" value=<?= ${nombreP}?>><br>
				<label for="Email">Email</label>
				<input type="email" id="EMail" name="EMail" value=<?= ${emailP}?>><br>
				<label for="Telefono">Telefono</label>
				<input type="tel" id="Telefono" name="Telefono" value=<?= ${telefonoP}?>><br>
				<label for="Edad">Edad</label>
				<input type="number" id="Edad" name="Edad" value=<?= ${edadP}?>><br>
				<label for="Talla">Talla</label>
				<input type="number" id="Talla" name="Talla" min="20" max="45" value=<?= ${tallaP}?>><br>
				<label for="Altura">Altura</label>
				<input type="range" id="Altura" value="100" name="Altura" name="alt" min="100" max="220" step="1" value=<?=${alturaP}?>>
				<output for="Altura" name="valor"><?= ${alturaP}?></output>cm<br>
				<label for="Nacimiento">Fecha de Nacimiento</label>
				<input type="date" id="Nacimiento" name="Nacimiento" value=<?= ${fechaP}?>><br>
				<label for="pelo">Color de pelo</label>
				<input type="text" id="pelo" name="Pelo" value=<?= ${colP}?>><br>
				<label for="turno">Horario del turno</label>
				<input name="turno" id="turno" type="time" min="08:00:00" max="17:00:00" step="900" value=<?= ${horaP} ?>>
				<br>
				<input type="submit" name="Aceptar" value="Aceptar">
				<input type="reset" name="Limpiar" value="Limpiar"> 
			</form>	
		</article>
		
	</section>
</body>
</html>