<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Site;

	use Base\Controller;
	use Proj\UI\Templates\Site\Template;
	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Отвечает за обработку запросов к документам
	 * @controller
	 */
	class Documents extends Controller {
		public function __construct() {
			parent::__construct();
		}

		/**
		 *Возвращает страницу со сметами
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function estimates(): void {
			/** @var Template $template */ $template = template();

			$template->seo->setTitle(app()->params->name . ' | Сметы');
			$template->seo->setDescription('Составление сметы на оказание услуг и продажу товаров');
			$template->seo->setKeywords('смета онлайн бесплатно, документы для самозанятых');

			$template->layout->main->push(view('site.documents.estimates'));
		}

		/**
		 * Возвращает страницу с актами выполненных работ
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function certificates(): void {
			/** @var Template $template */ $template = template();

			$template->seo->setTitle(app()->params->name . ' | Акты выполненных работ');
			$template->seo->setDescription('Составление актов выполненных работ');
			$template->seo->setKeywords('акт выполненных работ, для ИП, отчёты');

			$template->layout->main->push(view('site.documents.certificates'));
		}

		/**
		 * Возвращает страницу с прайс-листами
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function priceLists(): void {
			/** @var Template $template */ $template = template();

			$template->seo->setTitle(app()->params->name . ' | Прайс-листы');
			$template->seo->setDescription('Составление прайс-листа на оказание услуг, проведение работ и продажу товаров');
			$template->seo->setKeywords('прайс-лист онлайн, отчет оказание услуг, перечень цен на товары');

			$template->layout->main->push(view('site.documents.price_lists'));
		}

	}