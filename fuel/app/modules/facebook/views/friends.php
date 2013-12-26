<?=\Fuel\Core\View::forge("menu")?>

<h1>Friends</h1>

<table>

	<? foreach ($friends['data'] as $friend) { ?>

		<tr>
			<td><?=$friend['name']?></td>
			<td><img src="https://graph.facebook.com/<?=$friend['id']?>/picture" /></td>
		</tr>

	<? } ?>

</table>

<?=\Fuel\Core\Debug::dump($friends)?>