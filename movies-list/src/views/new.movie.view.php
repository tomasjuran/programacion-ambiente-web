<!DOCTYPE html>
<html lang="es">
<head>
  <title>Nueva Pelicula</title>
</head>
<body>
  <head>
    <h1>Agregar Pelicula</h1>
  </head>
  <main>
    <form action="/src/save.movies.php" method="post" enctype="multipart/form-data">
      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" placeholder="Nombre de la pelicula" required="required">
      <label for="anio_estreno">Año de Estreno</label>
      <input type="year" name="anio_estreno" placeholder="Año de Estreno" required="required">
      <label for="reparto">Reparto</label>
      <textarea name="reparto" placeholder="Reparto"></textarea>
      <label for="cartel">Cartelera</label>
      <input type="file" name="cartel" placeholder="Cartel">
      <input type="submit" name="guardar" value="Guardar">
      <input type="reset" value="Restablecer">
    </form>
  </main>
</body>
</html>
