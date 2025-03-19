<?php

	declare(strict_types=1);

	require_once DIR_PROJ_FEATURES . 'DBs.php';
	require_once DIR_PROJ_FEATURES . 'Users.php';
	require_once DIR_PROJ_FEATURES . 'Authentication.php';
	require_once DIR_PROJ_FEATURES . 'Out.php';
	require_once DIR_PROJ_FEATURES . 'statistics/IPs.php';

	app()->features->registration(Proj\Features\DBs::class, 2, 'dbs', 'Базы данных');
	app()->features->registration(Proj\Features\Users::class, 10, 'users', 'Пользователи');
	app()->features->registration(Proj\Features\Authentication::class, 11, 'authentication', 'Аутентификация');
	app()->features->registration(Proj\Features\Out::class, 20, 'out', 'Вывод');
	app()->features->registration(Proj\Features\Statistics\IPs::class, 1001, 'statistics_ips', 'Статистика запросов');
