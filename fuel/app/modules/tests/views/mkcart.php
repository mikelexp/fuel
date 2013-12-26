<table>
	<tr>
		<td>Internal ID</td>
		<td>External ID</td>
		<td>Nombre</td>
		<td>Descripcion</td>
		<td>Cantidad</td>
		<td>Precio</td>
		<td>Subtotal</td>
		<td>Metadata</td>
	</tr>
	<? foreach ($cart['items'] as $item) { ?>
		<tr>
			<td><?=$item->internal_id?></td>
			<td><?=$item->external_id?></td>
			<td><?=$item->name?></td>
			<td><?=$item->description?></td>
			<td><?=$item->quantity?></td>
			<td><?=$item->price?></td>
			<td><?=$item->subtotal?></td>
			<td><?=$item->metadata?></td>
		</tr>
	<? } ?>
</table>
<? if ($cart['cupons']) { ?>
	<p>Cupones</p>
	<table>
		<tr>
			<td>Internal ID</td>
			<td>Nombre</td>
			<td>Descripcion</td>
			<td>Porcentaje</td>
			<td>Precio</td>
		</tr>
		<? foreach ($cart['cupons'] as $cupon) { ?>
			<tr>
				<td><?=$cupon->internal_id?></td>
				<td><?=$cupon->name?></td>
				<td><?=$cupon->description?></td>
				<td><?=$cupon->percent?></td>
				<td><?=$cupon->price?></td>
			</tr>
		<? } ?>
	</table>
<? } ?>
<p>Total: $<?=\Mkcart\Mkcart::total()?></p>
<p>Items: <?=\Mkcart\Mkcart::total_items()?></p>
<p>Items Unique: <?=\Mkcart\Mkcart::total_items_unique()?></p>