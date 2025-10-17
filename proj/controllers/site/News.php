<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Site;

	use Base\Controller;
	use Base\Data\Set;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Models\News as Model;
	use Proj\UI\Templates\Site\Template;

	/**
	 * Отвечает за обработку запросов к новостям
	 * @controller
	 */
	class News extends Controller {
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Возвращает все новости
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function index(): void {
			/** @var Model $news */ $news = model('news');

			/** @var Template $template */ $template = template();
			$template->layout->main->push(view('site.news.all', [
				'title' => __('Все новости'),
				'items' => $news->all(),
			]));
		}

		/**
		 * Возвращает новость
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		#[NoReturn] public function show(Set $data, int $id): void {
			/** @var Model $changes */ $changes = model('changes');

			/** @var Template $template */ $template = template();
			if (!$item = $changes->get($id)) redirect()->page404();
			$template->layout->main->push(view('site.changes.show', $item));
		}

	}