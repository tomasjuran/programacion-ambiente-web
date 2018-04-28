<header>
	<p>¡Bienvenidos al blog!</p>
</header>
<section class="panel-superior">
	<p class="q-posts">Hay <?= $q_posts ?> posts en el blog actualmente</p>
	<form class="publicar-nuevo" action="editar.php" method="post">
		<input type="submit" name="nuevo" value="Publicar nuevo">
	</form>
</section>
<?php if ($resultado_eliminar) : ?>
<section class="aviso-usuario">
	<p class="aviso"><?= $resultado_eliminar ?></p>
</section>
<?php endif; ?>
<main>
	<section id="view_posts">
	<?php if ($posts) : ?>
		<ul>
		<?php foreach ($posts as $key => $post) : ?>
			<li>
				<article class="article-post">
					<form class="form-mod-del" action="editar.php" method="post">
						<input type="hidden" name="idpost" value="<?= $post["idpost"] ?>">
						<input type="submit" name="modificar" value="Modificar">
						<input type="submit" name="eliminar" value="Eliminar" formaction="index	.php">
					</form>

					<h2 class="post-titulo"><?= $post["titulo"] ?></h2>
					<p class="fecha">Publicado <?= $post["fecha"] ?></p>
					<p class="post-cuerpo"><?= $post["cuerpo"] ?></p>
					<img src="<?= $post["imagen"] ?>" alt="">

					<section class="section-comentarios">
						<div class="div-nuevo-comentario">
							<p>Escriba un comentario</p>
							<div class="arrow-down"></div>
						</div>

						<form class="nuevo-comentario">
							<input type="hidden" name="idpost" value="<?= $post["idpost"] ?>">
							<input type="text" name="com-autor<?= $post["idpost"] ?>" id="com-autor<?= $post["idpost"] ?>" maxlength="60" placeholder="Ingrese su nombre" required>
							<textarea name="com-cuerpo<?= $post["idpost"] ?>" id="com-cuerpo<?= $post["idpost"] ?>" maxlength="1000"></textarea>
							<input type="submit" name="comentar" value="Comentar">
						</form>	
						
						<?php foreach ($post["comentarios"] as $comentario) : ?>
						<div class="div-comentario">
							<p class="comentario-autor"><?= $comentario["autor"] ?></p>
							<p class="fecha"><?= $comentario["fecha"] ?></p>
							<p class="comentario-cuerpo"><?= $comentario["cuerpo"] ?></p>
						</div>
						<?php endforeach; ?>
					</section>

				</article>
			</li>
		<?php endforeach; ?>
		</ul>
	<?php else : ?>
		<p class="aviso">No hay posts para ver</p>
	<?php endif; ?>
	</section>
</main>