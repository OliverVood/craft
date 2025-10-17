<div class = "view general footer">
	<div>
		<div class = "agency">
			<div class = "logo"><?= linkInternal('home')->hyperlink(''); ?></div>
			<div class = "info">
				<div class = "name"><?= app()->params->name; ?></div>
				<div class = "slogan"><?= __(app()->params->slogan); ?></div>
			</div>
		</div>
		<div class = "menu">
			<div><?= linkInternal('feedback')->hyperlink(__('Обратная связь')); ?></div>
			<div><?= linkInternal('donations')->hyperlink(__('Поддержать проект')); ?></div>
			<div><?= linkInternal('privacy_policy')->hyperlink(__('Политика конфиденциальности')); ?></div>
			<div><?= linkInternal('terms_use')->hyperlink(__('Пользовательское соглашение')); ?></div>
		</div>
	</div>
</div>