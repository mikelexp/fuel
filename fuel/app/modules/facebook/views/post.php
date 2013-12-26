<?=View::forge("menu")?>

<h1>Post</h1>

<? if (isset($post_id)) { ?>
	<p>Post: <a href="https://facebook.com/<?=$post_id?>" target="_blank"><?=$post_id?></a></p>
<? } ?>

<? if ($val->error()) { ?>
	<ul class="errores">
		<? foreach ($val->error() as $error) { ?>
			<li><?=$error?></li>
		<? } ?>
	</ul>
<? } ?>

<?=Form::open()?>

	<label>Mensaje</label>
	<textarea name="mensaje"><?=\Mkforms\Mkforms::set_value($val, "mensaje")?></textarea>

	<input type="submit" value="Post" />

<?=Form::close()?>
