<style>
	ul li {
		padding-left: 20px;
	}
</style>

<h1>Usuarios</h1>

<ul>
	<? foreach ($usuarios as $usuario) { ?>
		<li>
			<?=$usuario->nombre?> <?=$usuario->apellido?>
			<ul>
				<? foreach ($usuario->posts as $post) { ?>
					<li>
						<?=$post->titulo?>
						<ul>
							<? foreach ($post->tags as $tag) { ?>
								<li><?=$tag->tag?></li>
							<? } ?>
						</ul>
						<ul>
							<? foreach ($post->comentarios as $comentario) { ?>
								<li><?=$comentario->usuario->nombre?> <?=$comentario->usuario->apellido?>: <?=$comentario->texto?></li>
							<? } ?>
						</ul>
					</li>
				<? } ?>
			</ul>
		</li>
	<? } ?>
</ul>