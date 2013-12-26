<?=\Fuel\Core\View::forge("menu")?>

<p>Facebook User ID: <strong><?=$facebook_user_id?></strong></p>

<p><strong>Facebook Profile:</strong></p>

<?=\Fuel\Core\Debug::dump($facebook_user)?>

<a href="<?=$logout_url?>">Logout</a>