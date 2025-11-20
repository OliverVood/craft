<?php

	declare(strict_types=1);

	linkRegInternal('home', '');
	linkRegInternal('about', 'about');
	linkRegInternal('contacts', 'contacts');
	linkRegInternal('privacy_policy', 'privacy_policy');
	linkRegInternal('terms_use', 'terms_use');

	linkRegInternal('404', '404');

	linkRegInternal('news', 'news');
	linkRegInternal('news_show', 'news/:[id]');
	linkRegInternal('changes', 'changes');
	linkRegInternal('changes_show', 'changes/:[id]');
	linkRegInternal('estimates', 'docs/estimates');
	linkRegInternal('certificates', 'docs/certificates');
	linkRegInternal('price_lists', 'docs/price_lists');

	linkRegInternal('feedback', 'feedback', /* @lang JavaScript */ "Base.Request.get('feedback').then(result => { Feedback.show(result.data); }); return false;");
	linkRegInternal('feedback_send', 'feedback', /* @lang JavaScript */ "Base.Request.submit(this).then(() => { Feedback.afterSend(); }); return false;");
	linkRegInternal('donations', 'donations', /* @lang JavaScript */ "Base.Request.get('donations').then(result => { Donations.index(result.data); }); return false;");