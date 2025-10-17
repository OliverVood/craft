<?php

	declare(strict_types=1);

	app()->links->internal('home', '');
	app()->links->internal('about', 'about');
	app()->links->internal('contacts', 'contacts');
	app()->links->internal('privacy_policy', 'privacy_policy');
	app()->links->internal('terms_use', 'terms_use');

	app()->links->internal('404', '404');

	app()->links->internal('news', 'news');
	app()->links->internal('news_show', 'news/:[id]');
	app()->links->internal('changes', 'changes');
	app()->links->internal('changes_show', 'changes/:[id]');
	app()->links->internal('estimates', 'docs/estimates');
	app()->links->internal('certificates', 'docs/certificates');
	app()->links->internal('price_lists', 'docs/price_lists');

	app()->links->internal('feedback', 'feedback', /* @lang JavaScript */ "Base.Request.get('feedback').then(result => { Feedback.show(result.data); }); return false;");
	app()->links->internal('feedback_send', 'feedback', /* @lang JavaScript */ "Base.Request.submit(this).then(() => { Feedback.afterSend(); }); return false;");
	app()->links->internal('donations', 'donations', /* @lang JavaScript */ "Base.Request.get('donations').then(result => { Donations.index(result.data); }); return false;");