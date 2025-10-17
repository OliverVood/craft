<div class = "view feedback form">
	<form action = "<?= linkInternal('feedback_send')->path(); ?>">
		<?= csrfInput(); ?>
		<div data-field = "name">
			<label><span class = "required">Имя</span></label>
			<input name = "name" type = "text" maxlength = "255">
			<div class = "errors"></div>
		</div>
		<div data-field = "contacts">
			<label>Контакты</label>
			<input name = "contacts" type = "text" maxlength = "255">
			<div class = "errors"></div>
		</div>
		<div data-field = "letter">
			<label>Тема</label>
			<input name = "letter" type = "text" maxlength = "255">
			<div class = "errors"></div>
		</div>
		<div data-field = "content">
			<label><span class = "required">Содержание</span></label>
			<textarea name = "content" rows = "4"></textarea>
			<div class = "errors"></div>
		</div>
		<div>
			<input type = "submit" onclick = "<?= linkInternal('feedback_send')->click(); ?>">
		</div>
	</form>
</div>