<header>
	<p>¡Bienvenidos al blog!</p>
</header>
<section class="panel_superior">
	<p class="q_posts">Hay <?= $q_posts ?> posts en el blog actualmente</p>
	<form class="publicar_nuevo" action="editar.php" method="post">
		<input type="submit" name="nuevo" value="Publicar nuevo">
	</form>
</section>
<section class="aviso_usuario">
	<?php if ($resultado_eliminar) : ?>
	<p class="resultado"><?= $resultado_eliminar ?></p>
	<?php endif; ?>
</section>
<main>
	<section id="view_posts">
	<?php if ($posts) : ?>
		<ul>
		<?php foreach ($posts as $key => $post) : ?>
			<li>
				<article class="article_post">
					<h2><?= $post["titulo"] ?></h2>
					<p><em><?= $post["fecha"] ?></em></p>
					<p><?= $post["cuerpo"] ?></p>
					<img src="<?= $post["imagen"] ?>" alt="">
					<form action="editar.php" method="post">
						<input type="hidden" name="idpost" value="<?= $post["idpost"] ?>">
						<input type="submit" name="modificar" value="Modificar">
					</form>
					<form action="index.php" method="post">
						<input type="hidden" name="idpost" value="<?= $post["idpost"] ?>">
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