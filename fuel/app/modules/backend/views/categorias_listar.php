<h4>Categorías</h4>

<div class="btn-group">
	<a class="btn btn-success" href="<?=Uri::create("backend/categorias/procesar")?>"><i class="icon-plus icon-white"></i> Nueva categoría</a>
</div>

<p></p>

<? if (count($items) > 0) { ?>

	<table class="table table-striped table-hover">

		<tbody>

		<tr>
			<th>Nombre</th>
			<th></th>
			<th></th>
			<th>Activo</th>
			<th> </th>
		</tr>

		<? $ubicacion_actual = 1; ?>

		<? foreach ($items as $item) { ?>

			<tr>
				<td><?=$item->nombre?></td>
				<td>
					<? if ($ubicacion_actual > 1) { ?>
						<a class="btn btn-success tooltip_me" title="Subir" href="<?=Uri::create("backend/categorias/mover/subir/{$item->id}/{$ubicacion_actual}")?>"><i class="icon icon-chevron-up icon-white"></i></a>
					<? } ?>
				</td>
				<td>
					<? if ($ubicacion_actual < count($items)) { ?>
						<a class="btn btn-success tooltip_me" title="Bajar" href="<?=Uri::create("backend/categorias/mover/bajar/{$item->id}/{$ubicacion_actual}")?>"><i class="icon icon-chevron-down icon-white"></i></a>
					<? } ?>
				</td>
				<td>
					<input type="checkbox" class="update_me" name="categoria_activar_<?=$item->id?>" value="<?=$item->activo ? 1 : 0?>" <? if ($item->activo) echo "checked=\"checked\""; ?> />
				</td>
				<td>
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a class="btn btn-warning tooltip_me" title="Modificar" href="<?=Uri::create("backend/categorias/procesar/{$item->id}")?>"><i class="icon icon-edit icon-white"></i></a>
							<a class="btn btn-danger tooltip_me confirm_me" data-titulo="¡Atención!" data-texto="¿Realmente desea eliminar esta categoría y todos sus productos?" title="Eliminar" href="<?=Uri::create("backend/categorias/borrar/{$item->id}")?>"><i class="icon icon-remove icon-white"></i></a>
						</div>
					</div>
				</td>
			</tr>

			<? $ubicacion_actual++; ?>

		<? } ?>

		</tbody>

	</table>

<? } else { ?>

	<div class="well">No se encontraron resultados.</div>

<? } ?>