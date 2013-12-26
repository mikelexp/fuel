<h4>Emails</h4>

<div class="btn-group">
	<a class="btn btn-success" href="<?=Uri::create("backend/emails/enviar")?>"><i class="icon-envelope icon-white"></i> Enviar mails pendientes</a>
</div>

<form class="form-search pull-right" action="<?=Uri::create("backend/emails/listar")?>" method="get">
	<input type="text" name="q" value="<?=$q?>" class="search-query" />
	<input type="submit" value="Buscar" class="btn" />
</form>

<div class="clearfix"></div>

<? if (count($items) > 0) { ?>

	<table class="table table-striped table-hover">

		<tbody>

			<tr>
				<th>Email</th>
				<th>Creación</th>
				<th>Estado</th>
				<th> </th>
			</tr>

			<? foreach ($items as $item) { ?>

				<?
				$from = unserialize($item->from) ?: array();
				$tos = unserialize($item->tos) ?: array();
				$ccs = unserialize($item->ccs) ?: array();
				$bccs = unserialize($item->bccs) ?: array();
				?>

				<tr>
					<td>
						<div>De: <?=$from['name']?> &lt;<?=$from['email']?>&gt;</div>
						<? if ($tos) { ?>
							<? foreach ($tos as $to) { ?>
								<div>
									Para:
									<? if ($to['name'] && $to['email']) { ?>
										<?=$to['name']?> &lt;<?=$to['email']?>&gt;
									<? } ?>
									<? if ($to['email']) { ?>
										<?=$to['email']?>
									<? } ?>
								</div>
							<? } ?>
						<? } ?>
						<? if ($item->subject) { ?>
							<div>Subject: <?=$item->subject?></div>
						<? } ?>
					</td>
					<td><?=$item->fecha_creacion?></td>
					<td>
						<? if ($item->procesado && $item->ok) { ?>
							<strong>Enviado</strong><br />
							<?=$item->fecha_procesado?>
						<? } else if ($item->procesado && !$item->ok) { ?>
							<strong>Error de envío</strong><br />
							<?=$item->fecha_procesado?>
						<? } else { ?>
							<strong>En espera</strong>
						<? } ?>
					</td>
					<td>
						<div class="btn-group pull-right">
							<a class="ver_trigger btn btn-success tooltip_me" title="Ver el email" data-id="<?=$item->id?>"><i class="icon icon-zoom-in icon-white"></i></a>
						</div>
					</td>
				</tr>
				<tr style="display: none"></tr>
				<tr style="display: none" id="ver_<?=$item->id?>">
					<td colspan="4">
						<iframe id="ver_iframe_<?=$item->id?>" class="email_iframe"></iframe>
					</td>
				</tr>

			<? } ?>

		</tbody>

	</table>

	<?=$paginador?>

	<script type="text/javascript">
		$(".ver_trigger").click(function() {
			var id = $(this).data("id");
			$("#ver_iframe_" + id).attr("src", "<?=Uri::create("backend/emails/ver")?>" + "/" + id);
			$("#ver_" + id).toggle();
		});
	</script>

<? } else { ?>

	<div class="well">No se encontraron resultados.</div>

<? } ?>