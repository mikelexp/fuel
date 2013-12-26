<?=\Fuel\Core\View::forge("menu")?>

<h1>Friends FQL</h1>

<table>

	<? foreach ($friends as $friend) { ?>

		<img src="https://graph.facebook.com/<?=$friend['uid2']?>/picture" />

	<? } ?>

</table>

<?=\Fuel\Core\Debug::dump($friends)?>