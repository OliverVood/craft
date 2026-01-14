<div class = "view out head">
	<div>
		<a href = "<?= linkInternal('home')->address(); ?>" class = "icon logo"></a>
		<div class = "icon switch"></div>
	</div>
	<div>
		<div></div>
		<div>
			<?= linkInternal('users_exit')->hyperlinkXHR('<span class = "icon"></span><span>' . __('Выход') . '</span>', [], ['class' => 'logout']); ?>
		</div>
	</div>
</div>