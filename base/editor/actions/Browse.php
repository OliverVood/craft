<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Editor\Model;
	use Base\Helper\Accumulator;
	use Closure;

	/**
	 * Контроллер-редактор просмотра
	 */
	class Browse {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;

		private Controller $controller;

		public Closure $fnPrepareView;
		public Closure $fnGetLinksNavigate;

		private string $tpl = 'admin.editor.browse';

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'browse';

			$this->fields = new Fields();

			$this->text('title', 'Просмотр');
			$this->text('do', 'Просмотреть');
			$this->text('responseErrorAccess', 'Недостаточно прав');
			$this->text('responseErrorNotFound', 'Элемент не найден');

			$this->fnGetLinksNavigate = fn (array $item) => $this->getLinksNavigate($item);
			$this->fnPrepareView = fn (int $id, array & $item) => $this->prepareView($id, $item);
		}

		/**
		 * Возвращает блок просмотра
		 * @param Set $data - Пользовательские данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		public function get(Set $data, int $id): void {
			if ($id < 1) {
				response()->notFound($this->__('responseErrorNotFound'));
				return;
			}

			if (!$this->inside($id)) return;

			response()->ok();
		}

		/**
		 * Блок просмотра
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		public function inside(int $id): bool {
			if (!$this->allow($id)) {
				response()->forbidden($this->__('responseErrorAccess'));
				return false;
			}

			/** @var Model $model */ $model = $this->controller->model();

			if (!$item = $model->browse($id, ['*'])) {
				response()->unprocessableEntity($this->__('responseErrorNotFound'));
				return false;
			}

			$prepareView = $this->fnPrepareView;
			$prepareView($id, $item);

			$title = $this->__('title') . " #{$id}";
			$fields = $this->fields();
			$editor = $this->controller;

			response()->history($this->controller->linkBrowse, array_merge(['id' => $id], (array)$this->controller->params));
			response()->section('content', view($this->tpl, compact('title', 'fields', 'id', 'item', 'editor')));

			return true;
		}

		/**
		 * Подготовка данных для блока просмотра
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		private function prepareView(int $id, array & $item): void {  }

		/**
		 * Возвращает ссылки навигации
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksNavigate(array $item): Accumulator {
			$links = new Accumulator();

			if ($this->controller->linkSelect->allow()) $links->push($this->controller->linkSelect->hyperlink('<< ' . $this->controller->select->__('title'), array_merge(['page' => old('page')->int(1)], (array)$this->controller->params)));

			return $links;
		}

	}
