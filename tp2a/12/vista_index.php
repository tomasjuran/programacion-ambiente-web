<header>
	<p>¡Bienvenidos al blog!</p>
</header>
<section>
	<p>Hay <?= ${q_posts} ?> posts en el blog actualmente</p>
	<form action="editar_post.php">
		<input type="submit" name="nuevo" value="Publicar nuevo">
	</form>
	<p><?= ${resultado_eliminar} ?></p>
</section>
<main>
	<section id="view_posts">
	<?php if($posts) : ?>
		<ul>
		<?php foreach ($posts as $key => $post) : ?>
			<li>
				<article>
					<h2><?= $post->titulo ?></h2>
					<p><em><?= $post->fecha ?></em></p>
					<p><?= $post->cuerpo ?></p>
					<img src="<?= $post->imagen ?>" alt="">
					<form action="editar_post.php" method="post">
						<input type="hidden" name="idpost" value="<?= $post->idpost ?>">
						<input type="submit" name="modificar" value="Modificar">
					</form>
					<form action="index.php" method="post">
						<input type="hidden" name="idpost" value="<?= $post->idpost ?>">
						<input type="submit" name="eliminar" value="Eliminar">
					</form>
				</article>
			</li>
		<?php endforeach; ?>
		</ul>
	<?php else : ?>
		<p>No hay posts para ver</p>
	<?php endif; ?>
	</section>
</main>