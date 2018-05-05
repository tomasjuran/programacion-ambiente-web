<article class="article-post article-post-edit">
	<form action="editar.php" method="post" enctype="multipart/form-data">
		<input type="submit" name="publicar" value="Publicar">
		<input type="hidden" name="idpost" value="<?= $idpost ?>">
		<label for="titulo">Título</label>
		<input type="text" name="titulo" id="titulo" value="<?= $titulo ?>" maxlength="200" placeholder="Ingrese el título" required>
		<label for="cuerpo">Mensaje</label>
		<textarea name="cuerpo" id="cuerpo" maxlength="1000"><?= $cuerpo ?></textarea>
		<label for="imagen_up">Subir una imagen</label>
		<input type="file" name="imagen_up" id="imagen_up">
	</form>
	<?php if ($imagen) : ?>
	<img src="<?= $imagen ?>" alt="Imagen">
	<?php endif; ?>
</article>