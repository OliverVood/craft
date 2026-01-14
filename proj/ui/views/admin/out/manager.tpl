<?php
	/**
	 * @var array $user
	 */
?>
<div class = "view out manager">
	<div class = "icon avatar"></div>
	<div class = "info">
		<div class = "name"><?= implode(' ', [$user['first_name'], $user['last_name']]); ?></div>
		<div class = "group">Developer</div>
	</div>
	<div class = "additionally">
		<div>
			<div>
				<div><?= $user['id']; ?></div>
				<div><?= __('ID'); ?></div>
			</div>
		</div>
		<div>
			<div>
				<div><?= $user['gid']; ?></div>
				<div><?= __('GID'); ?></div>
			</div>
		</div>
		<div>
			<div>
				<div><?= date('Y.m.d', strtotime($user['datecr'])); ?></div>
				<div><?= __('Зарегистрирован'); ?></div>
			</div>
		</div>
	</div>
	<?= links()->get('users_update')->hyperlink('', ['id' => $user['id']], ['class' => 'icon settings']); ?>
</div>