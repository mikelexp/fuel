<h1>Productos</h1>

<? if ($productos) { ?>

	<ul>
		<? foreach ($productos as $producto) { ?>
			<li><?=Html::anchor("productos/ver/{$producto->id}", $producto->nombre)?></li>
		<? } ?>
	</ul>

<? } ?>
