<?php

	declare(strict_types=1);

	const DIR_ROOT = __DIR__ . '/';

	require_once DIR_ROOT . 'consts/dirs.php';

	require_once DIR_ENTRY_SITE . 'require.php';

	app('/', '/xhr');

	app()->config()->load('app');
	app()->config()->load('db');

	app()->params->defaultTemplate = 'site.template';

	route()->run();

	template()->browse();//todo переделать шаблоны на сайтовой стороне
	die('end!');
//	use Base\Route;
//	use Base\Template\Template as BaseTemplate;
//	use Proj\Templates\Site\Template as SiteTemplate;
//
//	const DIR_ROOT = __DIR__ . '/';
//
//	require_once DIR_ROOT . 'consts/base.php';
//	require_once DIR_ROOT . 'consts/assembly.php';
//	require_once DIR_ROOT . 'consts/dirs.php';
//
//	require_once DIR_ENTRY_SITE . 'consts.php';
//	require_once DIR_ENTRY_SITE . 'require.php';
//	require_once DIR_ENTRY_SITE . 'route.php';
//
//	require_once DIR_PROJ_CONFIG . 'site.php';
//
//	BaseTemplate::load('site');
//
//	SiteTemplate::init();
//
//	Route::prepare($_REQUEST['__url'] ?? '');
//	Route::run();
//
//	SiteTemplate::browse();