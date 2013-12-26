<h4>Productos</h4>

<div class="btn-group">
	<a class="btn btn-success" href="<?=Uri::create("backend/productos/procesar")?>"><i class="icon-plus icon-white"></i> Nuevo producto</a>
</div>

<form class="form-search pull-right" action="<?=Uri::current()?>" method="get">
	<input type="text" name="q" value="<?=$q?>" class="input-medium search-query" />
	<input type="submit" value="Buscar" class="btn" />
</form>

<div class="clearfix"></div>

<? if (count($items) > 0) { ?>

	<table class="table table-striped table-hover">

		<tbody>

			<tr>
				<th>Categoría</th>
				<th>Nombre</th>
				<th>Activo</th>
				<th> </th>
			</tr>

			<? foreach ($items as $item) { ?>

				<tr>
					<td><?=@$item->categoria->nombre?></td>
					<td><?=$item->nombre?></td>
					<td>
						<input type="checkbox" class="update_me" name="producto_activar_<?=$item->id?>" value="<?=$item->activo ? 1 : 0?>" <? if ($item->activo) echo "checked=\"checked\""; ?> />
					</td>
					<td>
						<div class="btn-toolbar pull-right">
							<div class="btn-group">
								<a class="btn btn-warning tooltip_me" title="Modificar" href="<?=Uri::create("backend/productos/procesar/{$item->id}")?>"><i class="icon icon-edit icon-white"></i></a>
								<a class="btn btn-danger tooltip_me confirm_me" data-titulo="¡Atención!" data-texto="¿Realmente desea eliminar este producto?" title="Eliminar" href="<?=Uri::create("backend/productos/borrar/{$item->id}")?>"><i class="icon icon-remove icon-white"></i></a>
							</div>
						</div>
					</td>
				</tr>

			<? } ?>

		</tbody>

	</table>

	<?=$paginador?>

<? } else { ?>

	<div class="well">No se encontraron resultados.</div>

<? } ?>