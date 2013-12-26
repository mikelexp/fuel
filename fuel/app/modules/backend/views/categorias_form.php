<h4><?=$titulo?></h4>

<?=Form::open(array("class" => "form-horizontal"))?>

	<div class="control-group <? if ($val->error("nombre")) { ?>error<? } ?>">
		<label class="control-label">Nombre</label>
		<div class="controls">
			<input type="text" name="nombre" value="<?=Mkforms::set_value($val, "nombre", $item->nombre)?>" />
		</div>
	</div>

	<label class="checkbox">
		<input type="checkbox" name="activo" value="1" <?=Mkforms::set_checkbox($val, "activo", "1", $item->activo == "1")?> /> Activo
	</label>

	<div class="form-actions">
		<a href="<?=Uri::create("backend/categorias")?>" class="btn confirm_me" data-titulo="Cancelar" data-texto="¿Realmente desea cancelar?">Cancelar</a>
		<input type="submit" name="submit" value="Continuar" class="btn btn-primary" />
	</div>

<?=Form::close()?>
