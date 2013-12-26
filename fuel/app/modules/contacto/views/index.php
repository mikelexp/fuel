<h1>Contacto</h1>

<? if ($val->error()) { ?>
	<ul class="errores">
		<? foreach ($val->error() as $error) { ?>
			<li><?=$error?></li>
		<? } ?>
	</ul>
<? } ?>

<?=Form::open()?>

	<fieldset>
		<label>Nombre</label>
		<input type="text" name="nombre" value="<?=Mkforms::set_value($val, "nombre")?>" />
		<?=$val->error("nombre")?>
	</fieldset>

	<fieldset>
		<label>Mensaje</label>
		<textarea name="mensaje"><?=Mkforms::set_value($val, "mensaje")?></textarea>
		<?=$val->error("mensaje")?>
	</fieldset>

	<input type="submit" value="Enviar" />

<?=Form::close()?>