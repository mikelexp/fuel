<h4><?=$titulo?></h4>

<?=Form::open_multipart(array("class" => "form-horizontal"))?>

	<div class="control-group <? if ($val->error("categoria")) { ?>error<? } ?>">
		<label class="control-label">Categoría</label>
		<div class="controls">
			<select name="categoria" data-placeholder="Seleccione una categoría">
				<option value=""></option>
				<? foreach ($categorias as $categoria) { ?>
					<option value="<?=$categoria->id?>" <?=Mkforms\Mkforms::set_select($val, "categoria", $categoria->id, $categoria->id == $item->categoria_id)?>><?=$categoria->nombre?></option>
				<? } ?>
			</select>
		</div>
	</div>

	<div class="control-group <? if ($val->error("nombre")) { ?>error<? } ?>">
		<label class="control-label">Nombre</label>
		<div class="controls">
			<input type="text" name="nombre" value="<?=Mkforms::set_value($val, "nombre", $item->nombre)?>" />
		</div>
	</div>

	<div class="control-group <? if ($val->error("descripcion")) { ?>error<? } ?>">
		<label class="control-label">Descripción</label>
		<div class="controls">
			<textarea name="descripcion" class="html"><?=Mkforms::set_value($val, "descripcion", $item->descripcion)?></textarea>
		</div>
	</div>

	<div class="control-group <? if ($val->error("fecha")) { ?>error<? } ?>">
		<label class="control-label">Fecha</label>
		<div class="controls">
			<div class="input-append">
				<input type="text" name="fecha" class="datepick_me" value="<?=Mkforms::set_value($val, "fecha", $item->fecha)?>" style="width: 80px" readonly="readonly" />
				<button class="btn datepick_trigger" data-datepicker="fecha"><i class="icon icon-calendar"></i></button>
			</div>
			<input type="text" name="fecha_hora" value="<?=Mkforms::set_value($val, "fecha_hora", $item->fecha_hora)?>" style="width: 24px" placeholder="H" />
			:
			<input type="text" name="fecha_minuto" value="<?=Mkforms::set_value($val, "fecha_minuto", $item->fecha_minuto)?>" style="width: 24px" placeholder="M" />
			:
			<input type="text" name="fecha_segundo" value="<?=Mkforms::set_value($val, "fecha_segundo", $item->fecha_segundo)?>" style="width: 24px" placeholder="S" />
		</div>
	</div>

	<div class="control-group <? if ($val->error("foto")) { ?>error<? } ?>">
		<label class="control-label">Foto</label>
		<div class="controls">
			<? if ($item->foto) { ?>
				<p><img src="<?=Asset::upload("small_".$item->foto)?>" /></p>
			<? } ?>
			<input type="file" name="foto" />
		</div>
	</div>

	<label class="checkbox">
		<input type="checkbox" name="activo" value="1" <?=Mkforms::set_checkbox($val, "activo", "1", $item->activo == "1")?> /> Activo
	</label>

	<div class="form-actions">
		<a href="<?=Uri::create("backend/productos")?>" class="btn confirm_me" data-titulo="Cancelar" data-texto="¿Realmente desea cancelar?">Cancelar</a>
		<input type="submit" name="submit" value="Continuar" class="btn btn-primary" />
	</div>

<?=Form::close()?>
