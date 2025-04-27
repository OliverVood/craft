<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\DB\Response;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Editor\Model;
	use Base\Helper\Accumulator;
	use Base\Helper\Pagination;
	use Closure;
	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Контроллер-редактор выборки
	 */
	class Select {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;

		private Controller $controller;

		public Closure $fnGetLinksNavigate;
		public Closure $fnPrepareView;
		public Closure $fnGetLinksManage;

		private string $tpl = 'admin.editor.select';

		private int $page_entries = 10;

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'select';

			$this->fnGetLinksNavigate = fn () => $this->getLinksNavigate();
			$this->fnPrepareView = fn (Response & $item) => $this->prepareView($item);
			$this->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);

			$this->fields = new Fields();

			$this->text('title', 'Выборка');
			$this->text('responseErrorAccess', 'Не достаточно прав');
			$this->text('responseErrorNotFound', 'Элемент не найден');
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

			[$items, $ext] = $model->select(['*'], $page, $this->page_entries, $this->controller->params);
			$prepareView = $this->fnPrepareView;
			$prepareView($items);

			$title = $this->__('title');
			$fields = $this->fields();
			$pagination = $this->page_entries ? new Pagination($this->controller->linkSelect, $ext['page']['current'], $ext['page']['count']) : null;
			$editor = $this->controller;

			response()->history($this->controller->linkSelect, array_merge(['page' => $page], (array)$this->controller->params));
			response()->section('content', view($this->tpl, compact('title', 'fields', 'items' ,'pagination', 'editor')));
		}

		/**
		 * Подготовка данных для блока выборки
		 * @param Response $items
		 * @return void
		 */
		private function prepareView(Response & $items): void {  }

		/**
		 * Возвращает ссылки навигации
		 * @return Accumulator
		 */
		public function getLinksNavigate(): Accumulator {
			return new Accumulator();
		}

		/**
		 * Возвращает ссылки для управления
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		private function getLinksManage(array $item): Accumulator {
			$links = new Accumulator();

			$id = isset($item['id']) ? (int)$item['id'] : 0;

			$links->push($this->controller->linkBrowse->linkHrefID($id, $this->controller->browse->__('do'), array_merge($item, (array)$this->controller->params)));
			$links->push($this->controller->linkUpdate->linkHrefID($id, $this->controller->update->__('do'), array_merge($item, (array)$this->controller->params)));
			$links->push($this->controller->linkDoDelete->linkHrefID($id, $this->controller->delete->__('do'), array_merge($item, (array)$this->controller->params)));

			return $links;
		}

	}