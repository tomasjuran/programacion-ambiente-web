<article>
	<form action="<?=${accion}?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="idpost" value="<?=${idpost}?>">
		<label for="titulo">Título</label>
		<input type="text" name="titulo" id="titulo" value="<?=${titulo}?>" maxlength="200">
		<input type="text" name="cuerpo" value="<?=${cuerpo}?>" maxlength="1000">
		<label for="imagen_up">Subir una imagen</label>
		<input type="file" name="imagen_up" id="imagen_up">
		<input type="submit" name="publicar" value="Publicar">
	</form>
	<img src="<?=${imagen}?>" alt="Imagen">
</article>