<div id="login">

	<? if ($val->error()) { ?>
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<? foreach ($val->error() as $error) { ?>
				<div><?=$error?></div>
			<? } ?>
		</div>
	<? } ?>

	<h4><i class="icon icon-lock"></i> Login</h4>

	<?=Form::open()?>

		<label>Usuario</label>
		<input type="text" name="usuario" class="autofocus_me input-xlarge" />
		<label>Password</label>
		<input type="password" name="password" class="input-xlarge" />

		<input type="submit" value="Ingresar" class="btn btn-primary" />

	<?=Form::close()?>

</div>
