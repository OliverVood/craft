<?php

	declare(strict_types=1);

	const DIR_ROOT = __DIR__ . '/';

	require_once DIR_ROOT . 'consts/dirs.php';

	require_once DIR_ENTRY_SITE . 'require.php';

	config()->load('app');
	config()->load('db');
	config()->load('site');

	app('/', '/xhr/');

	require_once DIR_ENTRY_SITE . 'route.php';
	require_once DIR_ENTRY_SITE . 'links.php';

	app()->params->name = 'DocRoom.site';
	app()->params->slogan = 'управляй своими документами';
	app()->params->email = 'support@docroom.pro';

	route()->run();