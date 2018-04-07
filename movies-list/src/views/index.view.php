<!DOCTYPE html>
<html lang="es">
<head>
  <title>Peliculas</title>
</head>
<body>
  <nav>
    <ul>
      <li><a href="src/views/new.movie.view.php">Agregar Pelicula</a></li>
    </ul>
  </nav>
  <main>
    <section id="listado_peliculas">
      <h1>Lista de Peliculas</h1>
      <?php if ($peliculas) : ?>
        <ul>
            <?php foreach ($peliculas as $pelicula) : ?>
            <li><?= $pelicula['nombre'] ?> (<?= $pelicula['anio_estreno'] ?>)</li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
        <p>No hay peliculas cargadas</p>
        <?php endif; ?>
    </section>
  </main>
</body>
</html>
