<div class="pagination pagination-centered">

	<ul>

		<? if ($pagina > 1) { ?>
			<li><a href="<?=sprintf($url, 1)?>">&lt;&lt;</a></li>
		<? } ?>

		<? if ($hay_anterior) { ?>
			<li><a href="<?=sprintf($url, $anterior)?>">&lt;</a></li>
		<? } ?>

		<? foreach($paginas_a_mostrar as $pagina_a_mostrar) { ?>
			<li class="<?=($pagina == $pagina_a_mostrar) ? "active" : ""; ?>"><a href="<?=sprintf($url, $pagina_a_mostrar)?>"><?=$pagina_a_mostrar?></a></li>
		<? } ?>

		<? if ($hay_siguiente) { ?>
			<li><a href="<?=sprintf($url, $siguiente)?>">&gt;</a></li>
		<? } ?>

		<? if ($pagina < $paginas) { ?>
			<li><a href="<?=sprintf($url, $paginas)?>">&gt;&gt;</a></li>
		<? } ?>

	</ul>

</div>
