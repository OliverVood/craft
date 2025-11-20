<div class = "view user form_authorization">
	<form action = "<?= linkInternal('users_auth')->path(); ?>">
		<?= csrfInput(); ?>
		<div data-field = "login">
			<label><input type = "text" name = "login" placeholder = "<?= __('Логин'); ?>"></label>
			<div class = "errors"></div>
		</div>
		<div data-field = "password">
			<label><input type = "password" name = "password" placeholder = "<?= __('Пароль'); ?>"></label>
			<div class = "errors"></div>
		</div>
		<div><label><input type = "submit" value = "<?= __('Войти') ?>" onclick = "<?= linkInternal('users_auth')->click(); ?>"></label></div>
	</form>
</div>