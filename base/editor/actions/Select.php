<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\DB\Response;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Editor\Model;
	use Base\Helper\Pagination;
	use JetBrains\PhpStorm\NoReturn;

	class Select {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;

		private Controller $controller;

		private string $tpl = 'admin.editor.select';

		private int $page_entries = 10;

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'select';

			$this->fields = new Fields();

			$this->text('title', 'Выборка');
			$this->text('responseErrorAccess', 'Не достаточно прав');

		}

		/**
		 * Возвращает блок выборки
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function get(Set $data): void {
			$page = $data->defined('page')->int(1);

			$this->inside($page);

			response()->ok();
		}

		/**
		 * Блок выборки
		 * @param int $page - Номер страницы
		 * @return void
		 */
		public function inside(int $page): void {
			if (!$this->allow()) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			[$items, $ext] = $model->select(['*'], $page, $this->page_entries);

			$this->prepareView($items);

			$title = $this->__('title');
			$fields = $this->fields();
			$pagination = $this->page_entries ? new Pagination($this->controller->select, $ext['page']['current'], $ext['page']['count']) : null;
			$editor = $this->controller;

			response()->history($this->controller->select, ['page' => $page]);
			response()->section('content', view($this->tpl, compact('title', 'fields', 'items' ,'pagination', 'editor')));
		}

		/**
		 * Подготовка данных для блока выборки
		 * @param Response $items
		 * @return void
		 */
		private function prepareView(Response & $items): void {  }

	}