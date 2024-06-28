<?php
	use Proj\Actions\Admin as Action;
?>

<div class = "view user form_authorization">
	<form action = "<?= Action\User::$auth->path(); ?>">
		<input type = "text" name = "login">
		<input type = "password" name = "password">
		<input type = "submit" value = "Войти" onclick = "<?= Action\User::$auth->path(); ?>">
	</form>
</div>