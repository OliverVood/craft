<?php
	use Proj\Links\Admin as Action;
?>
<div class = "view user form_authorization">
	<form action = "<?= Action\User::$auth->path(); ?>">
		<input type = "text" name = "login" placeholder = "<?= __('Логин'); ?>">
		<input type = "password" name = "password" placeholder = "<?= __('Пароль'); ?>">
		<input type = "submit" value = "<?= __('Войти') ?>" onclick = "<?= Action\User::$auth->click(); ?>">
	</form>
</div>