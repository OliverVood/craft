<?php

	declare(strict_types=1);//todo 404 site & admin

	route()->group('/xhr', [
		route()->group('/feedback', [
			route()->get('', 'site.feedback::index'),
			route()->post('', 'site.feedback::create'),
		]),
		route()->get('/donations', 'site.donations::index'),
		route()->post('/statistics/actions', 'site.statistics::actions'),
	])
		->middleware('clients')
		->middleware('statistics');

	route()->group('', [
		route()->get('/', 'site.pages::home'),
		route()->get('/about', 'site.pages::about'),
		route()->get('/contacts', 'site.pages::contacts'),
		route()->get('/privacy_policy', 'site.pages::privacyPolicy'),
		route()->get('/terms_use', 'site.pages::termsUse'),

		route()->get('/404', 'site.pages::error404'),

		route()->group('/news', [
			route()->get('', 'site.news::index'),
			route()->get('/:(num)', 'site.news::show'),
		]),

		route()->group('/changes', [
			route()->get('', 'site.changes::index'),
			route()->get('/:(num)', 'site.changes::show'),
		]),

		route()->group('/docs', [
			route()->get('/estimates', 'site.documents::estimates'),
			route()->get('/certificates', 'site.documents::certificates'),
			route()->get('/price_lists', 'site.documents::priceLists'),
		]),
	])
		->middleware('clients')
		->middleware('statistics')
		->middleware('site.out');

	route()->empty('/:(all)')
		->middleware('clients')
		->middleware('statistics');