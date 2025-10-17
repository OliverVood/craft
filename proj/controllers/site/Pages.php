<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Site;

	use Base\Controller;
	use Proj\UI\Templates\Site\Template;
	use Proj\Models as Models;

	/**
	 * Отвечает за простые страницы
	 * @controller
	 */
	class Pages extends Controller {
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Главная страница
		 * @controllerMethod
		 * @return void
		 */
		public function home(): void {
			/** @var Template $template */ $template = template();

			$template->seo->setTitle(app()->params->name . ' | Главная');
			$template->seo->setDescription(app()->params->name . ' - ресурс в помощь ИП, самозанятым с документами и отчётами');
			$template->seo->setKeywords('прайс-лист онлайн, составить акт выполненных работ, смета бесплатно, документы для ИП, отчёты самозанятые');

			/** @var Models\News $news */ $news = model('news');
			/** @var Models\Changes $changes */ $changes = model('changes');

			$countNews = 3;
			$countChanges = 4;

			$template->layout->main->push(view('site.catalogs.buttons'));
			$template->layout->main->push(view('site.news.last', [
				'title' => __('Последние новости'),
				'items' => $news->all($countNews),
			]));
			$template->layout->main->push(view('site.changes.last', [
				'title' => __('Последние изменения на сайте'),
				'items' => $changes->all($countChanges),
			]));
		}

		/**
		 * Страница с описанием проекта
		 * @controllerMethod
		 * @return void
		 */
		public function about(): void {
			/** @var Template $template */ $template = template();

			$template->seo->setTitle(app()->params->name . ' | О проекте');
			$template->seo->setDescription('О проекте ' . app()->params->name);
			$template->seo->setKeywords('проект ' . app()->params->name);

			$template->layout->main->push(view('site.pages.about'));
		}

		/**
		 * Страница контактов
		 * @controllerMethod
		 * @return void
		 */
		public function contacts(): void {
			/** @var Template $template */ $template = template();

			$template->seo->setTitle(app()->params->name . ' | Контакты');
			$template->seo->setDescription('Контакты');
			$template->seo->setKeywords('контакты');

			$template->layout->main->push(view('site.pages.contacts'));
		}

		/**
		 * Страница политики конфиденциальности
		 * @controllerMethod
		 * @return void
		 */
		public function privacyPolicy(): void {
			/** @var Template $template */ $template = template();

			$template->seo->setTitle(app()->params->name . ' | Политика конфиденциальности');
			$template->seo->setDescription('Политика конфиденциальности ' . app()->params->name);
			$template->seo->setKeywords('политика конфиденциальности');

			$template->layout->main->push(view('site.pages.privacy_policy'));
		}

		/**
		 * Страница пользовательского соглашения
		 * @controllerMethod
		 * @return void
		 */
		public function termsUse(): void {
			/** @var Template $template */ $template = template();

			$template->seo->setTitle(app()->params->name . ' | Пользовательское соглашение');
			$template->seo->setDescription('Пользовательское соглашение ' . app()->params->name);
			$template->seo->setKeywords('пользовательское соглашение');

			$template->layout->main->push(view('site.pages.terms_use'));
		}

		/**
		 * Страница с ошибкой 404
		 * @controllerMethod
		 * @return void
		 */
		public function error404(): void {
			/** @var Template $template */ $template = template();

			$template->layout->main->push('<h1>Страница не найдена!<h1>');
		}

	}