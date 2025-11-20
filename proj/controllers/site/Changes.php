<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Site;

	use Base\Controller;
	use Base\Data\Set;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Models\Changes as Model;
	use Proj\UI\Templates\Site;

	/**
	 * Отвечает за обработку запросов к изменениям на сайте
	 * @controller
	 */
	class Changes extends Controller {
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Возвращает все изменения на сайте
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function index(): void {
			/** @var Model $changes */ $changes = model('changes');

			/** @var Site $template */ $template = template();
			$template->layout->main->push(view('site.changes.all', [
				'title' => __('Все изменения'),
				'items' => $changes->all(),
			]));
		}

		/**
		 * Возвращает изменение на сайте
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		#[NoReturn] public function show(Set $data, int $id): void {
			/** @var Model $changes */ $changes = model('changes');

			/** @var Site $template */ $template = template();
			if (!$item = $changes->get($id)) redirect()->page404();
			$item['content'] = $changes->content($id);
			$template->layout->main->push(view('site.changes.show', $item));
		}

	}