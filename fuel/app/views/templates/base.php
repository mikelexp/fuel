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
		<div id="pagina">
			<div id="header">The Ultimate FuelPHP Setup</div>
			<div id="menu">
				<ul>
					<li><?=Html::anchor("home", "Home")?></li>
					<li><?=Html::anchor("productos", "Productos")?></li>
					<li><a href="<?=Uri::create("contacto")?>">Contacto</a></li>
				</ul>
			</div>
			<div id="contenido">
				<div class="row">
					<div class="span9">
						<?=$body?>
					</div>
					<div class="span3">
						<?
						try {
							echo Request::forge("widgets/encuestas/get")->execute();
						} catch (HttpNotFoundException $ex) {
							echo "";
						}
						?>
						<?
						try {
							echo Request::forge("widgets/encuestas/get")->execute();
						} catch (HttpNotFoundException $ex) {
							echo "";
						}
						?>
					</div>
				</div>
			</div>
			<div id="footer">
				FuelPHP <?=Fuel::VERSION?> - Environment: <?=\Fuel::$env?>
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
