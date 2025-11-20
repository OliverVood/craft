<?php

	declare(strict_types=1);

	require_once DIR_PROJ_FEATURES . 'DBs.php';
	require_once DIR_PROJ_FEATURES . 'Users.php';
	require_once DIR_PROJ_FEATURES . 'Groups.php';
	require_once DIR_PROJ_FEATURES . 'Authentication.php';
	require_once DIR_PROJ_FEATURES . 'Out.php';
	require_once DIR_PROJ_FEATURES . 'Craft.php';
	require_once DIR_PROJ_FEATURES . 'statistics/IPs.php';
	require_once DIR_PROJ_FEATURES . 'statistics/Actions.php';
	require_once DIR_PROJ_FEATURES . 'site/News.php';
	require_once DIR_PROJ_FEATURES . 'site/Changes.php';
	require_once DIR_PROJ_FEATURES . 'site/Feedback.php';

	features()->registration(Proj\Features\DBs::class, 1, 'dbs', 'Базы данных');
	features()->registration(Proj\Features\Users::class, 2, 'users', 'Пользователи');
	features()->registration(Proj\Features\Groups::class, 3, 'groups', 'Группы');
	features()->registration(Proj\Features\Authentication::class, 4, 'authentication', 'Аутентификация');
	features()->registration(Proj\Features\Out::class, 5, 'out', 'Вывод');
	features()->registration(Proj\Features\Craft::class, 6, 'craft', 'Ремесло');
	features()->registration(Proj\Features\Statistics\IPs::class, 10, 'statistics_ips', 'Статистика запросов');
	features()->registration(Proj\Features\Statistics\Actions::class, 11, 'statistics_actions', 'Статистика действий');
	features()->registration(Proj\Features\Site\News::class, 20, 'news', 'Новости');
	features()->registration(Proj\Features\Site\Changes::class, 21, 'changes', 'Изменения');
	features()->registration(Proj\Features\Site\Feedback::class, 22, 'feedback', 'Обратная связь');