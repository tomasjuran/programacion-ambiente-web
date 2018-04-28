<nav>
	<section class="panel-superior">
		<a href="index.php">Volver a la página principal</a>
	</section>
</nav>
<section class="aviso-usuario">
	<?php if ($resultado_post) : ?>
	<p class="aviso"><?=$resultado_post?></p>
	<?php
		endif; 
		if ($error_imagen) : ?>
	<p class="aviso"><?=$error_imagen?></p>
	<?php endif; ?>
</section>