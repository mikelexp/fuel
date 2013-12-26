<?=$doctype?>
<html>
<head>
	<title><?=$title?></title>
	<?=Asset::render()?>
	<?=$meta_keywords?>
	<?=$meta_description?>
</head>
<body>

	<div id="todo">

		<div id="scroll_to_top"></div>
		<div id="ajax"></div>
		<div class="navbar">
			<div class="navbar-inner">
				<a class="brand" href="<?=Uri::base()?>">The Ultimate FuelPHP Setup</a>
				<ul class="nav pull-right">
					<? $usuario = Mkauth::get_user(); ?>
					<li><a>Usuario logueado: <strong><?=$usuario->nombre?></strong> (<?=$usuario->email?>)</a></li>
					<li><?=Html::anchor("backend/logout", "Desconectarse")?></li>
				</ul>
			</div>
		</div>

		<section>

			<div class="row-fluid">

				<div class="span2">

					<!-- menu -->
					<ul class="nav nav-list">
						<li class="nav-header">CONTENIDOS</li>
						<li><?=Html::anchor("backend/productos", "Productos")?></li>
						<li class="nav-header">CONFIGURACIÓN</li>
						<li><?=Html::anchor("backend/categorias", "Categorías")?></li>
						<li><?=Html::anchor("backend/admins", "Administradores")?></li>
						<li class="nav-header">HERRAMIENTAS</li>
						<li><?=Html::anchor("backend/emails", "Emails")?></li>
						<li><?=Html::anchor("backend/backup", "Backup de base de datos")?></li>
					</ul>

				</div>

				<div class="span10">

					<!-- mensajes -->
					<? $messages = Mkmessages::get(); ?>
					<? if ($messages) { ?>
						<? foreach ($messages as $message) { ?>
							<div class="alert alert-<?=$message['type']?>">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<div><?=$message['message']?></div>
							</div>
						<? } ?>
					<? } ?>

					<!-- validation errors -->
					<? $val = Validation::instance(); ?>
					<? if ($val->error()) { ?>
						<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<? foreach ($val->error() as $error) { ?>
								<div><?=$error?></div>
							<? } ?>
						</div>
					<? } ?>

					<!-- contenido -->
					<?=$body?>

				</div>

			</div>

		</section>

		<div class="navbar">
			<div class="navbar-inner">
				<?
				$pro = \Fuel\Core\Profiler::app_total();
				$time = round($pro[0], 2);
				$ram = round($pro[1] / 1024 / 1024, 2);
				?>
				<p class="navbar-text pull-right">FuelPHP <?=Fuel::VERSION?> - Environment: <?=\Fuel::$env?> - Time: <?=$time?>ms. - RAM: <?=$ram?>Mb.</p>
			</div>
		</div>

	</div>

	<!-- Dialogo Confirm -->
	<div id="modal_confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modal_confirm_label" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="modal_confirm_label"></h3>
		</div>
		<div class="modal-body" id="modal_confirm_body"></div>
		<div class="modal-footer">
			<a class="btn" data-dismiss="modal" aria-hidden="true">No</a>
			<a class="btn btn-danger" id="modal_confirm_ok">Si</a>
		</div>
	</div>

	<!-- Dialogo Info -->
	<div id="modal_info" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modal_info_label" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="modal_info_label"></h3>
		</div>
		<div class="modal-body" id="modal_info_body"></div>
		<div class="modal-footer">
			<a class="btn" data-dismiss="modal" aria-hidden="true">Ok</a>
		</div>
	</div>

</body>
</html>
