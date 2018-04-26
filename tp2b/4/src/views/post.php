<article class="article_post">
	<form action="editar.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="idpost" value="<?= $idpost ?>">
		<label for="titulo">Título</label>
		<input type="text" name="titulo" id="titulo" value="<?= $titulo ?>" maxlength="200" placeholder="Ingrese el título">
		<label for="cuerpo">Mensaje</label>
		<textarea name="cuerpo" id="cuerpo" maxlength="1000"><?= $cuerpo ?></textarea>
		<label for="imagen_up">Subir una imagen</label>
		<input type="file" name="imagen_up" id="imagen_up">
		<input type="submit" name="publicar" value="Publicar">
	</form>
	<img src="<?= $imagen ?>" alt="Imagen">
</article>