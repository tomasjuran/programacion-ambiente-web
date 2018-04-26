<nav>
	<a href="index.php">Volver a la página principal</a>
</nav>
<section class="aviso_usuario">
	<?php if ($resultado_post) : ?>
	<p class="resultado"><?=$resultado_post?></p>
	<?php
		endif; 
		if ($error_imagen) : ?>
	<p class="resultado"><?=$error_imagen?></p>
	<?php endif; ?>
</section>