<div class = "view general header">
	<div class = "agency">
		<div class = "logo"><?= linkInternal('home')->hyperlink(''); ?></div>
		<div class = "info">
			<div class = "name"><?= app()->params->name; ?></div>
			<div class = "slogan"><?= __(app()->params->slogan); ?></div>
		</div>
	</div>
	<div class = "menu">
		<div>
			<div><?= linkInternal('home')->hyperlink('Главная'); ?></div>
			<div><?= linkInternal('about')->hyperlink('О проекте'); ?></div>
			<div><?= linkInternal('contacts')->hyperlink('Контакты'); ?></div>
		</div>
	</div>
</div>